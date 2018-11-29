<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leads_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //added by Danni
    public function get_lead_by_staff($staff_id) {

        $this->db->where(array('salesperson_id' => $staff_id));
        $this->db->order_by("id", "asc");
        $this->db->from('leads');
        return $this->db->get()->result();
    }

    //end added by Danni

    function exists_email($email, $tabel) {
        if ($tabel == 'company') {
            $email_count = $this->db->get_where('company', array('email' => $email))->num_rows();
        } else {
            $email_count = $this->db->get_where('leads', array('email' => $email))->num_rows();
        }
        return $email_count;
    }

    function exists_website($website, $tabel) {
        if ($tabel == 'company') {
            $exists_website = $this->db->get_where('company', array('website' => $website, 'website !=' => ''))->num_rows();
        } else {
            $exists_website = $this->db->get_where('leads', array('website' => $website, 'website !=' => ''))->num_rows();
        }
        return $exists_website;
    }

    function exists_name($name) {
        $name_count = $this->db->get_where('company', array('TRIM(name)' => TRIM($name)))->num_rows();
        return $name_count;
    }

    function exists_leads($lead) {
        $exists_leads = $this->db->get_where('opportunities', array('lead_id' => $lead))->num_rows();
        return $exists_leads;
    }

    function get_id($lead) {
        $get_id = $this->db->get_where('leads', array('customer_id' => $lead))->num_rows();
        return $get_id;
    }

    function stat_convert($lead) {
        $get_id = $this->db->get_where('leads', array('id' => $lead, 'customer_id !=' => 0))->num_rows();
        return $get_id;
    }

    function add_leads() {

        $leads_details = array(
            'lead_name' => $this->input->post('lead_name'),
            'campaign_id' => $this->input->post('campaign_id'),
            'annual_revenue' => $this->input->post('annual_revenue'),
            'lead_status_id' => $this->input->post('lead_status_id'),
            'company_name' => $this->input->post('company_name'),
            'customer_id' => 0,
            'address' => $this->input->post('address'),
            'country_id' => $this->input->post('country_id'),
            'state_id' => $this->input->post('state_id'),
            'city_id' => $this->input->post('city_id'),
            'zip_code' => $this->input->post('zip_code'),
            'salesperson_id' => $this->input->post('salesperson_id'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            'contact_name' => $this->input->post('contact_name'),
            'title_id' => $this->input->post('title_id'),
            'tags_id' => implode(',', $this->input->post('tags_id')),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'mobile' => $this->input->post('mobile'),
            'fax' => $this->input->post('fax'),
            'website' => $this->input->post('website'),
            'no_of_employees' => $this->input->post('no_of_employees'),
            'priority_id' => $this->input->post('priority_id'),
            'rating_id' => $this->input->post('rating_id'),
            'description' => $this->input->post('description'),
            'skype_id' => $this->input->post('skype_id'),
            'industry_id' => $this->input->post('industry_id'),
            'secondary_email' => $this->input->post('secondary_email'),
            'twitter' => $this->input->post('twitter'),
            'active_status' => 0,
            'email_opt_out' => $this->input->post('email_opt_out'),
            'register_time' => strtotime(date('Y-m-d')),
            'ip_address' => $this->input->server('REMOTE_ADDR'),
            'archive' => $this->input->post('archive'),
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date("Y-m-d H:i:s"),
            'contact_owner' => $this->input->post('contact_owner')
        );
        return $this->db->insert('leads', $leads_details);
    }

    function get_color($clr) {
        $this->db->select('status');
        $this->db->where('system_type', 'TAGS');
        $this->db->where('system_code', $clr);
        $this->db->from('tb_m_system');

        $res = $this->db->get()->result();
        return $res[0]->status;
    }

    function update_leads() {
        $leads_details = array(
            'lead_name' => $this->input->post('lead_name'),
            'campaign_id' => $this->input->post('campaign_id'),
            'annual_revenue' => $this->input->post('annual_revenue'),
            'lead_status_id' => $this->input->post('lead_status_id'),
            'company_name' => $this->input->post('company_name'),
            'customer_id' => 0,
            'address' => $this->input->post('address'),
            'country_id' => $this->input->post('country_id'),
            'state_id' => $this->input->post('state_id'),
            'city_id' => $this->input->post('city_id'),
            'zip_code' => $this->input->post('zip_code'),
            'salesperson_id' => $this->input->post('salesperson_id'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            'contact_name' => $this->input->post('contact_name'),
            'title_id' => $this->input->post('title_id'),
            'tags_id' => implode(',', $this->input->post('tags_id')),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'mobile' => $this->input->post('mobile'),
            'fax' => $this->input->post('fax'),
            'website' => $this->input->post('website'),
            'no_of_employees' => $this->input->post('no_of_employees'),
            'priority_id' => $this->input->post('priority_id'),
            'rating_id' => $this->input->post('rating_id'),
            'description' => $this->input->post('description'),
            'skype_id' => $this->input->post('skype_id'),
            'industry_id' => $this->input->post('industry_id'),
            'secondary_email' => $this->input->post('secondary_email'),
            'twitter' => $this->input->post('twitter'),
            'email_opt_out' => $this->input->post('email_opt_out'),
            'archive' => $this->input->post('archive'),
            'changed_by' => userdata('first_name') . " " . userdata('last_name'),
            'changed_date' => date('Y-m-d'),
            'contact_owner'=>$this->input->post('contact_owner')
        );

        return $this->db->update('leads', $leads_details, array('id' => $this->input->post('lead_id')));
    }

    function get_sum_by_group_account($min, $max, $join) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        }

        if ($join == 'converted') {
            $this->db->select('a.lead_name, a.company_name, c.name, a.lead_source_id, b.opportunity, a.salesperson_id');
            $this->db->join('opportunities b', 'a.id=b.lead_id', 'inner');
            $this->db->join('company c', 'a.id=c.lead_id', 'inner');
        }

        $this->db->select("SUM(a.annual_revenue) as samt");
        $this->db->from('leads a');

        return $this->db->get()->row()->samt;
    }

    function get_count_by_group_account($group_id, $min, $max, $join) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        }

        if ($join == 'converted') {
            $this->db->select('a.lead_name, a.company_name, c.name, a.lead_source_id, b.opportunity, a.salesperson_id');
            $this->db->join('opportunities b', 'a.id=b.lead_id', 'inner');
            $this->db->join('company c', 'a.id=c.lead_id', 'inner');
        }

        if ($group_id) {
            $this->db->group_by($group_id);
        }

        $this->db->select(' a.*, COUNT(a.id) as cnt, SUM(a.annual_revenue) as amt');
        $this->db->order_by("a.id", "asc");
        $this->db->from('leads a');

        return $this->db->get()->result();
    }

    function get_list_by_group_account($group_id, $min, $max, $join) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        }

        if ($join == 'converted') {
            $this->db->select('a.lead_name, a.company_name, c.name, a.lead_source_id, b.opportunity, a.salesperson_id');
            $this->db->join('opportunities b', 'a.id=b.lead_id', 'inner');
            $this->db->join('company c', 'a.id=c.lead_id', 'inner');
        } else if ($join == 'accross_owners') {

            $this->db->where('a.lead_source_id  >', '0');
            $this->db->where('a.lead_source_id > ', '00');
        } else if ($join == 'today') {
            $this->db->where("register_time", strtotime(date('Y-m-d')));
        }

        if ($group_id) {
            $this->db->where($group_id);
        }


        $this->db->order_by("a.id", "asc");
        $this->db->from('leads a');

        return $this->db->get()->result();
    }

    function leads_list($staff_id) {
        if ($staff_id != '1') {
            $this->db->where(array('salesperson_id' => $staff_id, 'active_status' => '0'));
        } else {
            $this->db->where('active_status', '0');
        }

        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';
        // if($times=='month'){
        $this->db->where('register_time >=', strtotime($startDate));
        $this->db->where('register_time <', strtotime($endDate));
        // }


        $this->db->order_by("id", "desc");
        $this->db->from('leads');

        return $this->db->get()->result();
    }

    function get_lead_single($lead_id) {
        return $this->db->get_where('leads', array('id' => $lead_id))->row();
    }

	// edit by nanin mulyani 20160831 1446
    function get_lead($lead_id, $staff_id, $check_leader_lead) {
        if ($staff_id == '1' || ($check_leader_lead != "" && $check_leader_lead != null)) {
            return $this->db->get_where('leads', array('id' => $lead_id))->row();
        } else {
			return $this->db->get_where('leads', array('id' => $lead_id, 'salesperson_id' => $staff_id))->row();
        }
    }
	//end

    function get_lead_owner($lead_id) {

        $this->db->order_by("first_name", "asc");
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('id', $lead_id);

        return $this->db->get()->result();
    }

    function delete($lead_id) {
        //$this->db->delete('calls',array('call_type_id' => $lead_id));

        if ($this->db->delete('leads', array('id' => $lead_id))) {  // Delete customer
            return true;
        }
    }

    function leads_getfilter_type($staff_id, $filter, $times) {

        // if($staff_id!='1')
        // {
        // $this->db->where(array('salesperson_id' => $staff_id, 'active_status' => '0'));
        // }else{
        // $this->db->where('active_status', '0');
        // }
        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';


        if ($filter == "Attempted to Contact") {
            $this->db->where(array('lead_status_id' => '01'));
        } else if ($filter == "Contact in Future") {
            $this->db->where(array('lead_status_id' => '02'));
        } else if ($filter == "Contacted") {
            $this->db->where(array('lead_status_id' => '03'));
        } else if ($filter == "Junk Lead") {
            $this->db->where(array('lead_status_id' => '04'));
        } else if ($filter == "Lost Lead") {
            $this->db->where(array('lead_status_id' => '05'));
        } else if ($filter == "Not Contacted") {
            $this->db->where(array('lead_status_id' => '06'));
        } else if ($filter == "Pre Qualified") {
            $this->db->where(array('lead_status_id' => '07'));
        }




        if ($times == "todays") {
            $this->db->where("register_time", strtotime(date('Y-m-d')));
        } else if ($times == "month") {
            $this->db->where('register_time >=', strtotime($startDate));
            $this->db->where('register_time <', strtotime($endDate));
            // $this->db->where("DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m') = '".date('Y-m')."'");
        } else if ($times == "weeks") {
            $this->db->where("YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m-%d'))=YEARWEEK(DATE (NOW()))");
        } else if ($times == "year") {
            $this->db->where("YEAR(DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m-%d'))=YEAR(DATE (NOW()))");
        } else if ($times == "quarter") {

            if (date('Y-m') >= date('Y-') . '01' && date('Y-m') <= date('Y-') . '03') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-01') and DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-03')");
            } else if (date('Y-m') >= date('Y-') . '04' && date('Y-m') <= date('Y-') . '06') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-04') and DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-06')");
            } else if (date('Y-m') >= date('Y-') . '07' && date('Y-m') <= date('Y-') . '09') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-07') and DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-09')");
            } else if (date('Y-m') >= date('Y-') . '10' && date('Y-m') <= date('Y-') . '12') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-10') and DATE_FORMAT(FROM_UNIXTIME(register_time),'%Y-12')");
            }
        } else if ($times == "all") {
            $this->db->select("*");
        }


        $this->db->order_by("lead_name", "asc");
        $this->db->from('leads');
        //modified by  yusuf
        //	return $this->db->get()->result();
    }

    function get_opportunity($opp_id) {
        return $this->db->get_where('opportunities', array('lead_id' => $opp_id))->row();
    }

    function get_country($country_id) {
        return $this->db->get_where('countries', array('id' => $country_id))->row();
    }

    function get_state($state_id, $country_id) {
        return $this->db->get_where('states', array('id' => $state_id, 'country_id' => $country_id))->row();
    }

    function get_city($city_id, $state_id) {
        return $this->db->get_where('cities', array('id' => $city_id, 'state_id' => $state_id))->row();
    }

    function country_list() {
        $this->db->order_by("name", "asc");
        $this->db->from('countries');

        return $this->db->get()->result();
    }

    function state_list($country_id) {

        $this->db->order_by("name", "asc");
        $this->db->select('states.*');
        $this->db->from('states');
        $this->db->where('country_id', $country_id);

        return $this->db->get()->result();
    }

    function city_list($state_id) {

        $this->db->order_by("name", "asc");
        $this->db->select('cities.*');
        $this->db->from('cities');
        $this->db->where('state_id', $state_id);

        return $this->db->get()->result();
    }

    function add_convert_to_opportunity() {
        $lead_id = $this->input->post('convert_opport_lead_id');

        $data['lead'] = $this->leads_model->get_lead($lead_id, userdata('id'));
        $data['account'] = $this->customers_model->get_company($data['lead']->customer_id);

        if ($this->input->post('next_action') != '' && $this->input->post('next_action') != null) {
            $actionDate = date('Y-m-d', strtotime($this->input->post('next_action')));
        } else {
            $actionDate = date('Y-m-d', strtotime($this->input->post('expected_closing')));
        }

        $opportunity_details = array(
            'lead_id' => $lead_id,
            'opportunity' => $this->input->post('opportunity'),
            'stages_id' => $this->input->post('stages_id'),
            'customer_id' => $data['lead']->customer_id,
            'amount' => $this->input->post('amount'),
            'expected_revenue' => $this->input->post('expected_revenue'),
            'probability' => $this->input->post('probability'),
            'salesperson_id' => $this->input->post('salesperson_id'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            //'lead_source_id' => $data['lead']->lead_source_id,
            'campaign_source_id' => $this->input->post('campaign_source_id'),
            'type_id' => $this->input->post('type_id'),
            'contact_id' => $data['account']->main_contact_person,
            'next_action' => $actionDate,
            'next_action_title' => $this->input->post('next_action_title'),
            'expected_closing' => date('Y-m-d', strtotime($this->input->post('expected_closing'))),
            'priority_id' => $data['lead']->priority_id,
            'description' => $data['lead']->description,
            'register_time' => strtotime(date('Y-m-d')),
            'ip_address' => $this->input->server('REMOTE_ADDR'),
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d')
        );

        $this->db->update('leads', array('active_status' => '1'), array('id' => $lead_id));

        return $this->db->insert('opportunities', $opportunity_details);
    }

    function random_password($length = 8) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    function add_convert_to_customer($lead_id) {

        $data['lead'] = $this->leads_model->get_lead($lead_id, userdata('id'));

        //Customer add  
        $customer_details = array(
            'lead_id' => $lead_id,
            'name' => $data['lead']->company_name,
            'email' => $data['lead']->email,
            'address' => $data['lead']->address,
            'phone' => $data['lead']->phone,
            'mobile' => $data['lead']->mobile,
            'website' => $data['lead']->website,
            'fax' => $data['lead']->fax,
            'salesperson_id' => $data['lead']->salesperson_id,
            'sales_team_id' => $data['lead']->sales_team_id,
            'register_time' => strtotime(date('d F Y g:i a')),
            'ip_address' => $this->input->server('REMOTE_ADDR'),
            'status' => '1',
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d')
        );

        $create_customer = $this->db->insert('company', $customer_details);

        $customer_id = $this->db->insert_id();

        $new_password = $this->leads_model->random_password(8);

        //Contact person password email sent

        $subject = 'Contact person login details';
        $message = 'Hello, <br>Please follow the link below to login: <br> <a href="' . base_url('/') . '">Login</a><br/><br/>Email: ' . $data['lead']->email . '<br/>Password: ' . $new_password . '';

        send_notice($data['lead']->email, $subject, $message);

        $contact_name = explode(' ', $data['lead']->contact_name);
        $contact_person_details = array(
            'first_name' => $contact_name[0],
            'last_name' => ($contact_name[1]) ? $contact_name[1] : '',
            'address' => $data['lead']->address,
            'phone' => $data['lead']->phone,
            'mobile' => $data['lead']->mobile,
            'website' => $data['lead']->website,
            'fax' => $data['lead']->fax,
            'main_contact_person' => '1',
            'company_id' => $customer_id,
            'email' => $data['lead']->email,
            'register_time' => strtotime(date('d F Y g:i a')),
            'ip_address' => $this->input->server('REMOTE_ADDR'),
            'status' => '1',
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d'),
            'contact_owner'=> $data['lead']->contact_owner
        );

        //Contact person add
        // $contact_person_res = $this->db->insert('customer',array('first_name' => 'Ken', 'last_name' => 'Dedes') );
        $contact_person_res = $this->db->insert('customer', $contact_person_details);
        $contact_person_id = $this->db->insert_id();

        // Main contact person set
        $company_details = array(
            'main_contact_person' => $contact_person_id,
        );


        $this->db->update('company', $company_details, array('id' => $customer_id));

        // Lead remove
        // $this->db->delete('leads',array('id' => $lead_id));
        $this->db->update('leads', array('customer_id' => $customer_id), array('id' => $lead_id));

        return $customer_id;
    }

    //added by achmad@arkamaya.co.id
    //date : 2016.08.24 13.28
    public function get_salesteam_incharge($staff_id) {
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

    //added by yusuf

    function get_leads($staff_id, $filter, $times, $archive) {
        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';

        $lead_status_id = '';
        $sales_team_pic = $this->get_salesteam_incharge($staff_id);

        $q = "
            SELECT t.id, t.lead_name, t.company_name, t.email, t.campaign_name, t.sales, t.create_date, t.create_by from (
            SELECT
            l.id,
            l.lead_name,
            l.company_name,
            l.email,
            cpg.campaign_name as campaign_name,
            CONCAT(u.first_name,' ',u.last_name) AS sales,
            l.create_date,
            l.create_by,
			tms.system_value_txt as lead_status, l.contact_owner
          FROM leads l
          LEFT JOIN campaign cpg ON cpg.id = l.campaign_id 
          LEFT JOIN users u ON u.id = l.salesperson_id
          LEFT JOIN salesteams s ON s.id = l.sales_team_id
          LEFT JOIN tb_m_system tms ON tms.system_type = 'LEAD_STATUS' AND tms.system_code = l.lead_status_id
          where 1 = 1 AND (l.customer_id = 0 OR l.customer_id = '') 
          ";

        if ($staff_id != '1') {
//             $q .=" and (l.salesperson_id=$staff_id or l.create_by=$staff_id)";

            if ($sales_team_pic != "") {
                $qd = " or l.sales_team_id in ($sales_team_pic)";
            } else {
                $qd = " or l.sales_team_id in ('')";
            }
            $q .=" and (l.salesperson_id=$staff_id or l.create_by='" . userdata('first_name') . " " . userdata('last_name') . "'$qd)";
        }
        if ($archive != '') {
            $q .=" and l.archive='$archive'";
        }

        // if ($filter == "Attempted to Contact") {
        // $lead_status_id = '01';
        // } else if ($filter == "Contact in Future") {
        // $lead_status_id = '02';
        // } else if ($filter == "Contacted") {
        // $lead_status_id = '03';
        // } else if ($filter == "Junk Lead") {
        // $lead_status_id = '04';
        // } else if ($filter == "Lost Lead") {
        // $lead_status_id = '05';
        // } else if ($filter == "Not Contacted") {
        // $lead_status_id = '06';
        // } else if ($filter == "Pre Qualified") {
        // $lead_status_id = '07';
        // }

        if ($filter != '') {
            $q .=" and l.lead_status_id=$filter";
        }

        if ($lead_status_id != "") {
            $q .= " AND l.lead_status_id = '$lead_status_id'";
        }

		/*
        if ($times == "todays") {
            $q .= " AND l.register_time = " . strtotime(date('Y-m-d'));
        } else if ($times == "month") {
            $q .= " AND l.register_time > " . strtotime($startDate) . " AND l.register_time < " . strtotime($endDate);
        } else if ($times == "weeks") {
            $q.=" AND YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d'))=YEARWEEK(DATE (NOW()))";
        } else if ($times == "year") {
            $q.=" AND YEAR(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d'))=YEAR(DATE (NOW()))";
        } else if ($times == "quarter") {

            if (date('Y-m') >= date('Y-') . '01' && date('Y-m') <= date('Y-') . '03') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-01') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-03')";
            } else if (date('Y-m') >= date('Y-') . '04' && date('Y-m') <= date('Y-') . '06') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-04') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-06')";
            } else if (date('Y-m') >= date('Y-') . '07' && date('Y-m') <= date('Y-') . '09') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-07') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-09')";
            } else if (date('Y-m') >= date('Y-') . '10' && date('Y-m') <= date('Y-') . '12') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-10') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-12')";
            }
        }
		*/
		
		if ($times == "todays") {
            $q .= " AND l.register_time = " . strtotime(date('Y-m-d'));
        } else if ($times == "month") {
            $q .= " AND l.create_date between '" . $startDate . "' AND '" . $endDate . "'";
        } else if ($times == "weeks") {
            $q.=" AND YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d'))=YEARWEEK(DATE (NOW()))";
        } else if ($times == "year") {
            $q.=" AND YEAR(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d'))=YEAR(DATE (NOW()))";
        } else if ($times == "quarter") {

            if (date('Y-m') >= date('Y-') . '01' && date('Y-m') <= date('Y-') . '03') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-01') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-03')";
            } else if (date('Y-m') >= date('Y-') . '04' && date('Y-m') <= date('Y-') . '06') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-04') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-06')";
            } else if (date('Y-m') >= date('Y-') . '07' && date('Y-m') <= date('Y-') . '09') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-07') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-09')";
            } else if (date('Y-m') >= date('Y-') . '10' && date('Y-m') <= date('Y-') . '12') {
                $q.=" AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') between DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-10') and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-12')";
            }
        }
        return $q;
    }

    function leads_data($staff_id, $filter = '', $times = '', $order = '', $order_dir = '', $search_value = '', $archive = '') {//added by yusuf
        $q = $this->get_leads($staff_id, $filter, $times, $archive);
        if ($search_value != "") {
            $q.=" AND (l.lead_name LIKE '%$search_value%' OR l.company_name LIKE '%$search_value%' OR l.email LIKE '%$search_value%' OR cpg.campaign_name LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%' OR l.create_date LIKE '%$search_value%' OR l.create_by LIKE '%$search_value%' ) ";
        }
        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }
        $q.= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

        $q.= " )t";
		//echo $q;
        return $this->db->query($q)->result();
    }

    function leads_datax($staff_id, $filter = '', $times = '', $order = '', $order_dir = '', $search_value = '', $archive = '') {//added by yusuf
        $q = $this->get_leads($staff_id, $filter, $times, $archive);
        if ($search_value != "") {
            $q.=" AND (l.lead_name LIKE '%$search_value%' OR l.company_name LIKE '%$search_value%' OR l.email LIKE '%$search_value%' OR cpg.campaign_name LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%' OR l.create_date LIKE '%$search_value%' OR l.create_by LIKE '%$search_value%' ) ";
        }
        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }
        //$q.= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

        $q.= ' )t';
        // echo $q;
        return $this->db->query($q)->result();
    }

    function count_filtered($staff_id, $filter = '', $times = '', $order = '', $order_dir = '', $search_value = '', $archive = '') {
        $q = $this->get_leads($staff_id, $filter, $times, $archive);
        if ($search_value != "") {
            $q.=" AND (l.lead_name LIKE '%$search_value%' OR l.company_name LIKE '%$search_value%' OR l.email LIKE '%$search_value%' OR cpg.campaign_name LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%' OR l.create_date LIKE '%$search_value%' OR l.create_by LIKE '%$search_value%' ) ";
        }
        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }
        $q.= " )t";

        return $this->db->query($q)->num_rows();
    }

    public function count_all($staff_id, $filter = '', $times = '', $order = '', $order_dir = '', $search_value = '', $archive = '') {
        $this->db->from("leads");
        return $this->db->count_all_results();
    }

    public function getCountryIDBySortname($param = "") {
        $q = "select id from countries where sortname = '" . $param . "'";
        return $this->db->query($q)->row()->id;
    }

    public function getStateIDByName($param = "") {
        $q = "SELECT id FROM states s WHERE `s`.`name` = '" . $param . "'";
        return $this->db->query($q)->row()->id;
    }

    public function checkCompany($param = "", $field = "") {
        $q = "SELECT * FROM (
        (SELECT company_name, email, 'l' AS indicator FROM leads l)
        UNION DISTINCT
        (SELECT c.name AS company_name, email, 'c' AS indicator FROM company c)
        )t  WHERE t.$field = '$param' ORDER BY t.indicator ASC LIMIT 0,1;";
        return $this->db->query($q);
    }

    public function setProcessId($process_name = "") {
        $email = $this->session->userdata('username');
        $q0 = "select first_name, last_name FROM users WHERE email = '$email'";
        $r = $this->db->query($q0)->row();
        $digits = "0000000000";
        $date = date("Ymd");
        $new_pid = "";
        $q1 = "SELECT process_id FROM log_h ORDER BY PROCESS_ID DESC LIMIT 0,1";
        $curr_pid = $this->db->query($q1)->row()->process_id;
        if ($date == substr($curr_pid, 0, 8)) {
            $new_pid = substr($curr_pid, 8, strlen($curr_pid)) + 1;
            $new_pid = substr($digits, 0, 10 - strlen($new_pid)) . $new_pid;
            $new_pid = $date . $new_pid;
            $new_pid;
        } else {
            $new_pid = $date . "0000000001";
        }
        $q2 = "INSERT INTO log_h (process_id, process_name, created_by)VALUES('$new_pid', '$process_name', '$r->first_name')";
        $this->db->query($q2);
        return $new_pid;
    }

    public function setLog($process_id = "", $type = "", $message = "") {
        $q = "SELECT seq_no FROM log_d WHERE process_id = '$process_id' ORDER BY seq_no DESC LIMIT 0,1";
        $last_seq = $this->db->query($q)->row()->seq_no;
        $email = $this->session->userdata('username');
        $q0 = "select first_name, last_name FROM users WHERE email = '$email'";
        $r = $this->db->query($q0)->row();
        if ($last_seq == "" || $last_seq == null) {
            $last_seq = 0;
        }
        $new_seq = $last_seq + 1;
        $q1 = "INSERT INTO log_d (process_id, seq_no, type, message, created_by) VALUES('$process_id', '$new_seq', '$type', '$message', '$r->first_name')";
        $this->db->query($q1);
    }

    function csvtosql($filename, $process_id) {
        /* $q = "LOAD DATA INFILE '$filename'
          INTO TABLE t_leads
          FIELDS TERMINATED BY ','
          OPTIONALLY ENCLOSED BY '\"'
          LINES TERMINATED BY '\n'
          IGNORE 1 LINES
          (@no, @lead_name, @annual_revenue, @company_name, @address, @contact_name, @email, @phone, @mobile, @fax, @website, @no_of_employees, @description, @skype_id, @secondary_email, @twitter)
          set
          lead_name = @lead_name,
          annual_revenue = @annual_revenue,
          company_name = @company_name,
          address = @address,
          contact_name = @contact_name,
          email = @email,
          phone = @phone,
          mobile = @mobile,
          fax = @fax,
          website = @website,
          no_of_employees = @no_of_employees,
          description = @description,
          skype_id = @skype_id,
          secondary_email = @secondary_email,
          twitter = @twitter,
          process_id='$process_id';
          ";

          $this->db->query($q);
         */
        $file = fopen($filename, "r");
        while (!feof($file)) {
            $r = fgetcsv($file);
            if ($r[0] != "no") {
                if (count($r) > 1) {
                    $q = "INSERT INTO t_leads (lead_name,annual_revenue,company_name,address,contact_name,email,phone,mobile,fax,website,no_of_employees,description,skype_id,secondary_email,twitter, process_id)"
                            . "VALUES('$r[1]','$r[2]','$r[3]','$r[4]','$r[5]','$r[6]','$r[7]','$r[8]','$r[9]','$r[10]','$r[11]','$r[12]','$r[13]','$r[14]','$r[15]', '$process_id');";
                    $this->db->query($q);
                }
            }
        }
        fclose($file);
    }

    function temptoleads($process_id) {
        $q = "SELECT * FROM t_leads WHERE process_id = '$process_id'";
        $r = $this->db->query($q)->result();
        foreach ($r as $l) {

            $r2 = $this->checkCompany($l->company_name, "company_name");
            $r3 = $this->checkCompany($l->email, "email");

            if ($r2->num_rows() > 0 || $r3->num_rows() > 0) {
                $message = "";
                if ($r2->num_rows() > 0) {
                    $dr2 = $r2->result();
                    $location = "";
                    if ($dr2[0]->indicator == 'c') {
                        $loc = " company data";
                    } else {
                        $loc = " leads data";
                    }
                    $message .= "Company name already exist in $loc, ";
                }

                if ($r3->num_rows() > 0) {
                    $dr3 = $r3->result();
                    $location = "";
                    if ($dr3[0]->indicator == 'c') {
                        $loc = " company data";
                    } else {
                        $loc = " leads data";
                    }
                    $message .= "email already in use in $loc, ";
                }

                if ($message != "") {
                    $message = substr($message, 0, strlen($message) - 2);
                    $this->setLog($process_id, "E", $message);
                }
            } else {
                $email = $this->session->userdata('username');
                $q0 = "select first_name, last_name FROM users WHERE email = '$email'";
                $r = $this->db->query($q0)->row();
                $q1 = "INSERT INTO leads (lead_name,annual_revenue,company_name,address,contact_name,email,phone,mobile,fax,website,no_of_employees,description,skype_id,secondary_email,twitter, register_time, archive, create_date, create_by)
                SELECT lead_name,annual_revenue,company_name,address,contact_name,email,phone,mobile,fax,website,no_of_employees,description,skype_id,secondary_email,twitter, '".strtotime(date('Y-m-d'))."', 0, '".date('Y-m-d')."', '".$r->first_name."' FROM t_leads WHERE process_id = '$process_id' AND id = '$l->id'";
                $this->db->query($q1);
                $message = "leads data successfuly saved";
                $this->setLog($process_id, "I", $message);
            }
        }

        $rs = $this->db->query("SELECT * FROM log_d WHERE process_id = '$process_id'")->result();
        $data = array(
            "result" => "Upload Finished",
            "data" => $rs
        );
        $qd = "delete from t_leads WHERE process_id = '$process_id'";
        $this->db->query($qd);
        echo json_encode($data);
    }

    //end added by yusuf
}
?>