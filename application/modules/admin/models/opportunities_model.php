<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Opportunities_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    //added by achmad@arkamaya.co.id
    //date : 2016.09.09 16.00
    private function populate_salesteam_incharge($staff_id) {
        $sql = "select id,team_leader,team_members from salesteams;";
        $data = $this->db->query($sql)->result();
        $arr = array();
        try {
            foreach ($data as $r) {
                $id = $r->id;

                $tls = explode(",", $r->team_leader);
                foreach ($tls as $tl) {
                    if ($tl == $staff_id) {
                        array_push($arr, $id);
                    }
                }
                $tms = explode(",", $r->team_members);
                foreach ($tms as $tm) {
                    if ($tm == $staff_id) {
                        array_push($arr, $id);
                    }
                }
            }
            $arr = array_unique($arr);
            $arr = implode(",", $arr);
        } catch (Exception $e) {
            $arr = $e->getMessage();
        }
        return $arr;
    }

    private function populate_member_incharge($staff_id) {
        $sql = "select id,team_leader,team_members from salesteams;";
        $data = $this->db->query($sql)->result();
        $arr = array();
        try {
            foreach ($data as $r) {
                $tls = explode(",", $r->team_leader);
                foreach ($tls as $tl) {
                    if ($tl == $staff_id) {
                        array_push($arr, $tl);
                        $tms = explode(",", $r->team_members);
                        foreach ($tms as $tm) {
                            array_push($arr, $tm);
                        }
                    }
                }
            }
            $arr = array_unique($arr);
            $arr = implode(",", $arr);
        } catch (Exception $e) {
            $arr = $e->getMessage();
        }
        return $arr;
    }
    public function test($staff_id){
        return $this->populate_member_incharge($staff_id);
    }
    public function get_sales_incharge($staff_id){
        $ids = $this->populate_member_incharge($staff_id);
        if($ids ==  ""){
            $ids = 0;
        }
        $data = $this->db->query("select id,first_name,last_name from users where id in ($ids)")->result();
        return $data;
    }
    public function get_salesteam_incharge($staff_id){
        $ids = $this->populate_salesteam_incharge($staff_id);
        if($ids ==  ""){
            $ids = 0;
        }
        $data = $this->db->query("select id,salesteam from salesteams where id in ($ids)")->result();
        return $data;
    }
    public function get_company_handling($staff_id){
        $ids = $this->populate_salesteam_incharge($staff_id);
        if($ids ==  ""){
            $ids = 0;
        }
        $data = $this->db->query("select id,name from company where id in ($ids)")->result();
        return $data;
    }
    
    function add_opportunities() {
        $closed = 0;
        if ($this->input->post('stages_id') == '07') {
            $closed = 1;
        } elseif ($this->input->post('stages_id') == '08' || $this->input->post('stages_id') == '09') {
            $closed = 2;
        }

        if ($this->input->post('next_action') != '' && $this->input->post('next_action') != null) {
            $actionDate = date('Y-m-d', strtotime($this->input->post('next_action')));
        } else {
            $actionDate = date('Y-m-d', strtotime($this->input->post('expected_closing')));
        }

        $lead_update = array('tags_id' => implode(',', $this->input->post('tags_id')));
        $this->db->update('leads', $lead_update, array('id' => $this->input->post('lead_id')));

        $opportunity_details = array(
            'salesperson_id' => $this->input->post('salesperson_id'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            'opportunity' => $this->input->post('opportunity'),
            'amount' => $this->input->post('amount'),
            'stages_id' => $this->input->post('stages_id'),
            'customer_id' => $this->input->post('customer_id'),
            'type_id' => $this->input->post('type_id'),
            'probability' => $this->input->post('probability'),
            'next_action' => $actionDate,
            'next_action_title' => $this->input->post('next_action_title'),
            'expected_revenue' => $this->input->post('expected_revenue'),
            'expected_closing' => date('Y-m-d', strtotime($this->input->post('expected_closing'))),
            'lead_source_id' => $this->input->post('lead_source_id'),
            'priority_id' => $this->input->post('priority_id'),
            'campaign_source_id' => $this->input->post('campaign_source_id'),
            'contact_id' => $this->input->post('contact_id'),
            'description' => $this->input->post('description'),
            'closed_status' => $closed,
            'register_time' => strtotime(date('d F Y g:i a')),
            'ip_address' => $this->input->server('REMOTE_ADDR'),
            'tags_id' => implode(',', $this->input->post('tags_id')),
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('opportunities', $opportunity_details);
    }

    function get_salesteams_user($user_id) {
        $sql = "
			SELECT *, SUBSTRING_INDEX(SUBSTRING_INDEX(t.team_members, ',', n.n), ',', -1) value
			FROM salesteams t CROSS JOIN 
			(
			   SELECT a.N + b.N * 10 + 1 n
				 FROM 
				(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
			   ,(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
				ORDER BY n
			) n
			 WHERE n.n <= 1 + (LENGTH(t.team_members) - LENGTH(REPLACE(t.team_members, ',', '')))
			 and SUBSTRING_INDEX(SUBSTRING_INDEX(t.team_members, ',', n.n), ',', -1) = '" . $user_id . "' limit 1
		";
        //echo $sql;
        return $this->db->query($sql)->row();
    }

    function get_lead($lead_id) {
        return $this->db->get_where('leads', array('id' => $lead_id))->row();
    }

    function update_opportunities() {
        $closed = 0;
        if ($this->input->post('stages_id') == '07') {
            $closed = 1;
        } elseif ($this->input->post('stages_id') == '08' || $this->input->post('stages_id') == '09') {
            $closed = 2;
        }

        if ($this->input->post('next_action') != '' && $this->input->post('next_action') != null) {
            $actionDate = date('Y-m-d', strtotime($this->input->post('next_action')));
        } else {
            $actionDate = date('Y-m-d', strtotime($this->input->post('expected_closing')));
        }

        $lead_update = array('tags_id' => implode(',', $this->input->post('tags_id')));
        $this->db->update('leads', $lead_update, array('id' => $this->input->post('lead_id')));

        $opportunity_details = array(
            'salesperson_id' => $this->input->post('salesperson_id'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            'opportunity' => $this->input->post('opportunity'),
            'amount' => $this->input->post('amount'),
            'stages_id' => $this->input->post('stages_id'),
            'customer_id' => $this->input->post('customer_id'),
            'type_id' => $this->input->post('type_id'),
            'probability' => $this->input->post('probability'),
            'next_action' => $actionDate,
            'next_action_title' => $this->input->post('next_action_title'),
            'expected_revenue' => $this->input->post('expected_revenue'),
            'expected_closing' => date('Y-m-d', strtotime($this->input->post('expected_closing'))),
            'lead_source_id' => $this->input->post('lead_source_id'),
            'priority_id' => $this->input->post('priority_id'),
            'campaign_source_id' => $this->input->post('campaign_source_id'),
            'contact_id' => $this->input->post('contact_id'),
            'description' => $this->input->post('description'),
            'closed_status' => $closed,
            'register_time' => strtotime(date('d F Y g:i a')),
            'ip_address' => $this->input->server('REMOTE_ADDR'),
            'tags_id' => implode(',', $this->input->post('tags_id')),
            'changed_by' => userdata('first_name') . " " . userdata('last_name'),
            'changed_date' => date('Y-m-d')
        );

        return $this->db->update('opportunities', $opportunity_details, array('id' => $this->input->post('opportunity_id')));
    }

    function opportunities_list($staff_id, $times) {
        if ($staff_id != '1') {
            $this->db->where('salesperson_id', $staff_id);
        }

        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';
        $this->db->order_by("opportunity", "asc");
        $this->db->from('opportunities');
        return $this->db->get()->result();
    }

    function opportunities_getfilter($staff_id, $filter, $min, $max) {
        if ($staff_id != '1') {
            $this->db->where('salesperson_id', $staff_id);
        }

        if ($filter == "open") {
            $this->db->where("stages_id BETWEEN 01 AND 06");
        } else if ($filter == "lost") {
            $this->db->where("stages_id BETWEEN 08 AND 09");
        }

        if ($min && $max) {
            // $this->db->where("expected_closing BETWEEN '".date('Y-m-d', strtotime($min))."' AND '".date('Y-m-d', strtotime($max))."'");	
            $this->db->where("DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
        }

        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');

        return $this->db->get()->result();
    }

    function get_opportunities($opportunity_id) {
        return $this->db->get_where('opportunities', array('id' => $opportunity_id))->row();
    }

    function delete($opportunity_id) {

        $this->db->delete('calls', array('call_type_id' => $opportunity_id));

        $this->db->delete('meetings', array('meeting_type_id' => $opportunity_id));

        if ($this->db->delete('opportunities', array('id' => $opportunity_id))) {  // Delete customer
            return true;
        }
    }

    function get_sum_amount($min, $max, $join) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        }

        if ($join == 'quotations_salesorder') {

            $this->db->from('tb_m_system b');
            $this->db->where('a.stages_id = b.system_code AND b.system_type="OPPORTUNITIES_STAGES" ');

            $this->db->join('quotations_salesorder c', 'a.id=c.opportunities_id', 'inner');
            $this->db->where('c.quot_or_order = "o" ');
        } else if ($join == 'stages') {
            $this->db->from('tb_m_system b');
            $this->db->where('a.stages_id = b.system_code AND b.system_type="OPPORTUNITIES_STAGES" ');
        } else if ($join == 'leads') {
            // $this->db->from('leads l');
            // $this->db->where('a.lead_id = l.id');
            $this->db->where('a.lead_id > 0');
        } else if ($join == 'customer') {
            $this->db->where('a.customer_id > 0');
        } else if ($join == 'business') {
            $this->db->where('a.stages_id > 0');
            $this->db->where('a.type_id > 0');
        } else if ($join == 'typeone') {
            $this->db->where('a.type_id', '01');
            $this->db->where('a.stages_id > 0');
        } else if ($join == 'typetwo') {
            $this->db->where('a.type_id', '02');
            $this->db->where('a.stages_id > 0');
        }


        $this->db->select("SUM(a.amount) as samt");
        $this->db->from('opportunities a ');
        // $this->db->from('tb_m_system b');
        // $this->db->where('a.stages_id = b.system_code AND b.system_type="OPPORTUNITIES_STAGES" ');

        return $this->db->get()->row()->samt;
    }

    function get_list_by_group($group_id, $min, $max, $join) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        }

        if ($join == 'quotations_salesorder') {
            $this->db->from('tb_m_system b');
            $this->db->where('a.stages_id = b.system_code AND b.system_type="OPPORTUNITIES_STAGES" ');

            $this->db->join('quotations_salesorder c', 'a.id=c.opportunities_id', 'inner');
            $this->db->where('c.quot_or_order = "o" ');
        } else if ($join == 'stages') {
            $this->db->from('tb_m_system b');
            $this->db->where('a.stages_id = b.system_code AND b.system_type="OPPORTUNITIES_STAGES" ');
        } else if ($join == 'leads') {
            // $this->db->from('leads l');
            // $this->db->where('a.lead_id = l.id');
            $this->db->where('a.lead_id > 0');
        } else if ($join == 'customer') {
            $this->db->where('a.customer_id > 0');
        } else if ($join == 'business') {
            $this->db->where('a.stages_id > 0');
            $this->db->group_by('a.stages_id > 0');
        }
        $this->db->join('users u', 'a.salesperson_id=u.id');
        $this->db->order_by("a.id", "asc");
        $this->db->from('opportunities a');
        $this->db->where($group_id);

        return $this->db->get()->result();
    }

    // tambahan
    function get_list_by_group_b($group_id){
        $this->db->select('*');
        // $this->db->select('a.*, b.system_code, b.system_type, c.name, c.id as cid, u.firts_name, u.last_name, u,id');
        $this->db->from('opportunities as a');
        $this->db->join('tb_m_system as b', 'a.stages_id=b.system_code');
        $this->db->join('company as c', 'a.customer_id=c.id', 'inner');
        $this->db->join('users as u', 'a.salesperson_id=u.id');
        $this->db->where(array('a.stages_id'=>$group_id, 'b.system_type'=>"OPPORTUNITIES_STAGES"));
        // $this->db->where($group_id);
        $this->db->order_by("a.id", "asc");

        return $this->db->get()->result();
    }
    // end tambahan


    function get_count_by_group($group_id=null, $min=null, $max=null, $join=null) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        }

        if ($join == 'quotations_salesorder') {
            $this->db->from('tb_m_system b');
            $this->db->where('a.stages_id = b.system_code AND b.system_type="OPPORTUNITIES_STAGES" ');

            $this->db->join('quotations_salesorder c', 'a.id=c.opportunities_id', 'inner');
            $this->db->where('c.quot_or_order = "o" ');
        } else if ($join == 'stages') {
            $this->db->from('tb_m_system b');
            $this->db->where('a.stages_id = b.system_code AND b.system_type="OPPORTUNITIES_STAGES" ');
        } else if ($join == 'leads') {
            // $this->db->from('leads l');
            // $this->db->where('a.lead_id = l.id');
            $this->db->where('a.lead_id > 0');
        } else if ($join == 'customer') {
            $this->db->where('a.customer_id > 0');
        }
        $this->db->select(' *, COUNT(a.id) as cnt , SUM(a.amount) as amt');
        $this->db->group_by($group_id);
        $this->db->order_by("a.id", "asc");
        $this->db->from('opportunities a');

        return $this->db->get()->result();
    }

    // tambahan
    function get_count_by_group_b($group_id=null){
        $this->db->select(' a.*, COUNT(a.id) as cnt , SUM(a.amount) as amt');
        $this->db->from('opportunities as a');
        $this->db->join('company as c', 'c.customer_id=c.id');
        $this->db->group_by($group_id);
        $this->db->order_by("a.id", "asc");
        return $this->db->get()->result();
    }

    function get_count_by_group_c($group_id=null){
        $this->db->select(' a.*, COUNT(a.id) as cnt , SUM(a.amount) as amt');
        $this->db->from('opportunities as a');
        $this->db->join('tb_m_system as b', 'a.stages_id=b.system_code');
        $this->db->join('company as c', 'a.customer_id=c.id');
        $this->db->where(array('b.system_type'=>"OPPORTUNITIES_STAGES"));
        $this->db->group_by($group_id);
        return $this->db->get()->result();
    }

    function get_sum_amount_b(){
        $this->db->select('SUM(a.amount) as samt');
        $this->db->from('opportunities as a');
        $this->db->join('tb_m_system as b', 'a.stages_id=b.system_code');
        $this->db->join('company as c', 'a.customer_id=c.id');
        $this->db->where(array('b.system_type'=>"OPPORTUNITIES_STAGES"));
        // $this->db->group_by('a.stages_id');
        return $this->db->get()->row()->samt;
    }
    // end tambahan

    function get_count_by_bussines($group_id, $min, $max, $join) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        } else if ($join == 'business') {

            $this->db->where('a.stages_id >', '0');
            $this->db->where('a.type_id >', '0');
            $this->db->group_by('type_id');
        } else {
            // $this->db->where('a.stages_id >','0');
        }

        // $this->db->select("	a.*, COUNT(a.id) as cnt , SUM(IF(a.type_id = '01', a.amount, '0')) AS newbussines,
        // SUM(IF(a.type_id = '02', a.amount, '0')) AS existingbussines,
        // SUM(a.amount) as amt");
        $this->db->select("a.*, COUNT(a.id) as cnt , SUM(a.amount) as amt,
						(CASE WHEN a.type_id = '01' THEN sum(a.amount) ELSE '0' END) AS new_bussines , 
						(CASE WHEN a.type_id = '02' THEN sum(a.amount) ELSE '0' END) AS existing_bussines");

        $this->db->from('opportunities a');
        $this->db->group_by($group_id);
        $this->db->order_by("a.id", "asc");
        return $this->db->get()->result();
    }

    function stages_getfilter($staff_id, $filter, $times) {
        if ($staff_id != '1') {
            $this->db->where(array('o.salesperson_id' => $staff_id));
        }


        if ($filter != '') {
            $this->db->where(array('o.stages_id' => $filter));
        }
        // else if($filter=="Needs Analysis"){
        // $this->db->where(array('stages_id' => '02') );	
        // }else if($filter=="Value Proposition"){
        // $this->db->where(array('stages_id' => '03') );	
        // }else if($filter=="Id. Decision Makers"){
        // $this->db->where(array('stages_id' => '04') );	
        // }else if($filter=="Proposal/Price Quote"){
        // $this->db->where(array('stages_id' => '05') );	
        // }else if($filter=="Negotiation/Review"){
        // $this->db->where(array('stages_id' => '06') );	
        // }else if($filter=="Closed Won"){
        // $this->db->where(array('stages_id' => '07') );	
        // }else if($filter=="Closed Lost"){
        // $this->db->where(array('stages_id' => '08') );	
        // }else if($filter=="Closed Lost to Competition"){
        // $this->db->where(array('stages_id' => '09') );	
        // }


        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';

        if ($times == "todays") {
            $this->db->where("DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d')", date('Y-m-d'));
        } else if ($times == "month") {
            $this->db->where('o.register_time >=', strtotime($startDate));
            $this->db->where('o.register_time <', strtotime($endDate));
        } else if ($times == "weeks") {
            $this->db->where("YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d'))=YEARWEEK(DATE (NOW()))");
        } else if ($times == "year") {
            $this->db->where("YEAR(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d'))=YEAR(DATE (NOW()))");
        } else if ($times == "quarter") {

            if (date('Y-m') >= date('Y-') . '01' && date('Y-m') <= date('Y-') . '03') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-01') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-03')");
            } else if (date('Y-m') >= date('Y-') . '04' && date('Y-m') <= date('Y-') . '06') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-04') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-06')");
            } else if (date('Y-m') >= date('Y-') . '07' && date('Y-m') <= date('Y-') . '09') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-07') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-09')");
            } else if (date('Y-m') >= date('Y-') . '10' && date('Y-m') <= date('Y-') . '12') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-10') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-12')");
            }
        }


        $this->db->order_by("opportunity", "asc");
        $this->db->from('opportunities o');

        return $this->db->get()->result();
    }

    function contact_list($company_id) {

        $this->db->order_by("first_name", "asc");
        $this->db->select('customer.*');
        $this->db->from('customer');
        if ($company_id != "") {
            $this->db->where('company_id', $company_id);
        }

        return $this->db->get()->result();
    }

    function get_opportunity_list($staff_id, $company_id) {
        $this->db->order_by("opportunity", "asc");
        $this->db->select('opportunities.*');
        $this->db->from('opportunities');
        $this->db->where('customer_id', $company_id);
        //$this->db->where('salesperson_id', $staff_id);

        return $this->db->get()->result();
    }

    //Get last row
    function get_quotations_last_id() {
        $query = "select * from quotations_salesorder order by id DESC limit 1";

        $res = $this->db->query($query);

        if ($res->num_rows() > 0) {
            return $res->result("array");
        }
        return array();
    }

    function convert_to_quotation($opportunity_id) {
        $opportunity_data = $this->opportunities_model->get_opportunities($opportunity_id);
        $total_fields = $this->opportunities_model->get_quotations_last_id();
        $last_id = $total_fields[0]['id'];
        $quotation_no = "SO00" . ($last_id + 1);
        $exp_date = date('m/d/Y', strtotime(' + ' . config('payment_term1') . ' days'));

        $quotation_details = array(
            'opportunities_id' => $opportunity_id,
            'quotations_number' => $quotation_no,
            'customer_id' => $opportunity_data->customer_id,
            'qtemplate_id' => '2',
            'date' => strtotime(date('m/d/Y h:i')),
            'exp_date' => strtotime($exp_date),
            'payment_term' => config('payment_term1'),
            'sales_person' => $opportunity_data->salesperson_id,
            'sales_team_id' => $opportunity_data->sales_team_id,
            'status' => 'Draft Quotation',
            'register_time' => strtotime(date('d F Y g:i a')),
            'quot_or_order' => 'q',
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d')
        );


        $quotations_res = $this->db->insert('quotations_salesorder', $quotation_details);

        return $quotations_res;
    }

    /*
      function add_convert_to_customer($opportunity_id)
      {

      $data['opportunities'] = $this->opportunities_model->get_opportunities($_POST['convert_opport_id']);


      $customer_details = array(
      'name' => $_POST['customer_name'],
      'email' => $data['opportunities']->email,
      'phone' => $data['opportunities']->phone,
      'sales_team_id' => $data['opportunities']->sales_team_id,
      'register_time' => strtotime( date('d F Y g:i a') ),
      'ip_address' => $this->input->server('REMOTE_ADDR'),
      'status' => '1'
      );

      return $this->db->insert('company',$customer_details);

      } */

    function get_campaign($campaign_id) {
        return $this->db->get_where('campaign', array('id' => $campaign_id))->row();
    }

    function name_list() {

        $this->db->where(array('id <>' => '1'));
        $this->db->order_by("first_name", "asc");
        $this->db->order_by("last_name", "asc");
        $this->db->from('users');
        return $this->db->get()->result();
    }

    function salesteams_list() {
        $this->db->order_by("salesteam", "asc");
        $this->db->from('salesteams');
        return $this->db->get()->result();
    }

    function company_list() {
        $this->db->order_by("name", "asc");
        $this->db->from('company');
        return $this->db->get()->result();
    }

    //added by Danni
    public function get_opportunity_by_staff($staff_id) {

        $this->db->where(array('salesperson_id' => $staff_id));
        $this->db->order_by("id", "asc");
        $this->db->from('opportunities');
        return $this->db->get()->result();
    }

    public function get_sel_opportunities_by_company($company_id) {//uses by logged_calls and meetings
        $q = "SELECT o.id, o.opportunity FROM opportunities o WHERE o.customer_id='$company_id'";
        return $this->db->query($q)->result();
    }

    //end added by Danni
    //add by ijal
    public function get_sel_contacts_by_company($company_id) {//uses by logged_calls and meetings
        $q = "SELECT c.id, c.first_name, c.last_name FROM customer c WHERE c.company_id='$company_id'";
        return $this->db->query($q)->result();
    }

    //end added by ijal
    //add by yusuf

    function getActivities($opportunity_id) {
        $q = "SELECT t.id, c.name, t.opportunity_id, t.activity_type, t.activity, t.remarks, case when u.role_id = '1' THEN r.role_name ELSE CONCAT(u.first_name,' ',u.last_name) END as created_by, t.created_dt FROM (
        select id, company_id, opportunity_id, 1 AS activity_type, 'Logged Calls' as activity, call_summary as remarks, created_by, created_dt from calls
        UNION ALL
        select id, company_id, opportunity_id, 2 AS activity_type, 'Meetings' as activity, meeting_subject as remarks, created_by, created_dt from meetings
        UNION ALL
        select id,company_id,opportunity_id,3 as activity_type,'E-Mail' as activity,`subject`, created_by, created_dt  from emails
        )t 
        LEFT JOIN users u ON u.id = t.created_by 
        LEFT JOIN company c ON c.id = t.company_id
        LEFT JOIN role r ON u.role_id = r.role_id
        WHERE t.opportunity_id = '$opportunity_id' ";
        return $q;
    }

    function activitiesData($opportunity_id, $order = '', $order_dir = '', $search_value = '', $activity_type = '0') {//added by yusuf
        $q = $this->getActivities($opportunity_id);
        if ($search_value != "") {
            $q.=" AND (c.name LIKE = '%$search_value%' OR t.activity LIKE '%$search_value%' OR t.remarks LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%') ";
        }
        if ($activity_type != '0') {
            $q.=" AND t.activity_type = '$activity_type' ";
        }

        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }

        $q.= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        return $this->db->query($q)->result();
    }

    function count_filtered($opportunity_id, $order = '', $order_dir = '', $search_value = '', $activity_type = '0') {
        $q = $this->getActivities($opportunity_id);
        if ($search_value != "") {
            $q.=" AND (c.name LIKE = '%$search_value%' OR t.activity LIKE '%$search_value%' OR t.remarks LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%') ";
        }

        if ($activity_type != '0') {
            $q.=" AND t.activity_type = '$activity_type' ";
        }

        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }

        return $this->db->query($q)->num_rows();
    }

    // end by yusuf

    /* Ega 01 Aug 2016 : Opportunities dashboard */
    function stages_column() {
        $this->db->select('*');
        $this->db->from('tb_m_system');
        $this->db->where(array('system_type' => 'OPPORTUNITIES_STAGES'));
        $this->db->order_by("system_value_num", "asc");
        return $this->db->get()->result();
    }

    function get_data_by_stage($role_id, $system_code, $salesperson_id, $tags, $sales, $company_id, $steams) {
        /* $sql="
          select
          o.*, c.name
          from
          opportunities o
          left join
          company c on o.customer_id = c.id
          left join
          leads l on o.lead_id = l.id
          where
          o.stages_id <> '00'
          ";

          if($salesperson_id != '1'){
          $sql= $sql." and o.salesperson_id = '".$salesperson_id."'";
          }

          foreach(explode('_', $tags) as $t){
          $a = $a.$t.',';
          }
          $tag = str_replace(",","','",trim($a,","))."'".","."'".trim($a,",");

          if($tags != ''){
          $sql= $sql." and l.tags_id in ('".$tag."')";
          }

          if($sales != ''){
          $sql= $sql." and o.salesperson_id = '".$sales."'";
          }
          if($company_id != ''){
          $sql= $sql." and c.id = '".$company_id."'";
          }

          return $this->db->query($sql)->result(); */

        $this->db->select('o.*, c.name,s.salesteam');
        $this->db->from('opportunities o');
        $this->db->join('company c', 'o.customer_id = c.id', 'left');
        $this->db->join('leads l', 'o.lead_id = l.id', 'left');
        $this->db->join('salesteams s', 'o.sales_team_id = s.id', 'left');

        if ($system_code == '00') {
            $this->db->or_where('stages_id', '');
            $this->db->or_where('stages_id', '0');
        } else {
            $this->db->where('stages_id', $system_code);
        }

        if ($role_id != '1') {
            $role = array();
            array_push($role, $salesperson_id);
            $team = $this->get_team($salesperson_id);
            foreach (explode(',', $team) as $m) {
                array_push($role, $m);
            }
            $this->db->where_in('o.salesperson_id', $role);
        }

        $stack = array();
        foreach (explode('_', $tags) as $t) {
            $a = $a . $t . ',';
            array_push($stack, $t);
        }
        array_push($stack, trim($a, ","));

        if ($tags != '' && $tags != '00') {
            //MM
            //$this->db->where_in('l.tags_id', $stack);
            $this->db->where_in('o.tags_id', $stack);
            //MM
        }

        if ($sales != '' && $sales != '00') {
            $this->db->where('o.salesperson_id', $sales);
        }
        if ($company_id != '' && $company_id != '00') {
            $this->db->where('c.id', $company_id);
        }

        if ($steams != '' && $steams != '00') {
            $this->db->where('o.sales_team_id', $steams);
        }

        $this->db->order_by("o.opportunity", "asc");

        return $this->db->get()->result();
        // $this->output->enable_profiler(true);
        // echo "<br/>";
        // print_r($sales);
        // echo "<br/>";
        // print_r($company_id);
        // die();
    }

    function get_team($id) {
        $sql = "select team_members from salesteams where (team_leader = " . $id . "
                OR team_leader LIKE CONCAT(" . $id . ", ',%')
                OR team_leader LIKE CONCAT('%,', " . $id . ", ',%')
                OR team_leader LIKE CONCAT('%,', " . $id . "))";
        return $this->db->query($sql)->row()->team_members;
    }

    function get_member($id) {
        $sql = "select * from salesteams where (team_members = " . $id . "
                OR team_members LIKE CONCAT(" . $id . ", ',%')
                OR team_members LIKE CONCAT('%,', " . $id . ", ',%')
                OR team_members LIKE CONCAT('%,', " . $id . "))";
        return $this->db->query($sql)->row()->team_members;
    }

    function update_stage_by_id() {
        $id = $this->input->post('id');
        $stages_id = $this->input->post('stages_id');
        $data = array('stages_id' => $stages_id);

        return $this->db->update('opportunities', $data, array('id' => $id));
    }

    /* end Ega 01 Aug 2016 : Opportunities dashboard */



    /* yusuf new get opportunities */

    function getOpportunities() {
        $q = "SELECT o.next_action, o.closed_status, o.id, o.lead_id, o.opportunity, l.lead_name, c.name AS company_name, CONCAT(u.first_name,' ', u.last_name) AS sales_person, o.amount, tms.system_value_txt, o.create_by FROM opportunities o
        LEFT JOIN company c ON c.id = o.customer_id
        LEFT JOIN leads l ON l.id = o.lead_id
        LEFT JOIN users u ON u.id = o.salesperson_id
        LEFT JOIN tb_m_system tms ON tms.system_type = 'OPPORTUNITIES_STAGES' AND tms.system_code = o.stages_id
        WHERE 1 = 1 ";


        return $q;
    }

    function opportunitiesdata($start, $length, $order = '', $order_dir = '', $search_value = '', $times = '', $stage_id = '') {//added by yusuf
        $q = $this->getOpportunities();

        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';


        if ($times == "todays") {
            $q .= " AND o.register_time = " . strtotime(date('Y-m-d'));
        } else if ($times == "month") {
            $q .= " AND o.register_time > " . strtotime($startDate) . " AND o.register_time < " . strtotime($endDate);
        } else if ($times == "weeks") {
            $q.=" AND YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d'))=YEARWEEK(DATE (NOW()))";
        } else if ($times == "year") {
            $q.=" AND YEAR(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d'))=YEAR(DATE (NOW()))";
        } else if ($times == "quarter") {

            if (date('Y-m') >= date('Y-') . '01' && date('Y-m') <= date('Y-') . '03') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-01') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-03')";
            } else if (date('Y-m') >= date('Y-') . '04' && date('Y-m') <= date('Y-') . '06') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-04') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-06')";
            } else if (date('Y-m') >= date('Y-') . '07' && date('Y-m') <= date('Y-') . '09') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-07') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-09')";
            } else if (date('Y-m') >= date('Y-') . '10' && date('Y-m') <= date('Y-') . '12') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-10') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-12')";
            }
        }

        if ($search_value != "") {
            $q.=" AND (o.opportunity LIKE '%$search_value%' OR l.lead_name LIKE '%$search_value%' OR c.name LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%' OR tms.system_value_txt LIKE '%$search_value%' OR o.create_by LIKE '%$search_value%' ) ";
        }

        if ($stage_id != "") {
            $q.= " AND o.stages_id = '" . $stage_id . "'";
        }

        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }
        $q.= " LIMIT " . $start . ", " . $length;
        return $this->db->query($q)->result();
    }

    function opportunitiescount($order = '', $order_dir = '', $search_value = '', $times = '', $stage_id = '') {
        $q = $this->getOpportunities();
        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';


        if ($times == "todays") {
            $q .= " AND o.register_time = " . strtotime(date('Y-m-d'));
        } else if ($times == "month") {
            $q .= " AND o.register_time > " . strtotime($startDate) . " AND o.register_time < " . strtotime($endDate);
        } else if ($times == "weeks") {
            $q.=" AND YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d'))=YEARWEEK(DATE (NOW()))";
        } else if ($times == "year") {
            $q.=" AND YEAR(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d'))=YEAR(DATE (NOW()))";
        } else if ($times == "quarter") {

            if (date('Y-m') >= date('Y-') . '01' && date('Y-m') <= date('Y-') . '03') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-01') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-03')";
            } else if (date('Y-m') >= date('Y-') . '04' && date('Y-m') <= date('Y-') . '06') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-04') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-06')";
            } else if (date('Y-m') >= date('Y-') . '07' && date('Y-m') <= date('Y-') . '09') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-07') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-09')";
            } else if (date('Y-m') >= date('Y-') . '10' && date('Y-m') <= date('Y-') . '12') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-10') and DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-12')";
            }
        }

        if ($search_value != "") {
            $q.=" AND (o.opportunity LIKE '%$search_value%' OR l.lead_name LIKE '%$search_value%' OR c.name LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%' OR tms.system_value_txt LIKE '%$search_value%' OR o.create_by LIKE '%$search_value%' ) ";
        }

        if ($stage_id != "") {
            $q.= " AND o.stages_id = '" . $stage_id . "'";
        }
        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }
        return $this->db->query($q)->num_rows();
    }

    /* end by yusuf */
}

?>