<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Opportunities extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("opportunities_model");
        $this->load->model("customers_model");
        $this->load->model("contact_persons_model");
        $this->load->model("leads_model");
        $this->load->model("staff_model");
        $this->load->model("salesteams_model");
        $this->load->model("calls_model");
        $this->load->model("meetings_model");
        $this->load->model("campaign_model");
        $this->load->model("system_model");
        $this->load->library('form_validation');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        check_login();
    }

    function index() {
        //checking permission for staff
        if (!check_staff_permission('opportunities_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $times = 'month';


        $data['opportunities'] = $this->opportunities_model->opportunities_list(userdata('id'), $times);
        $data['allstatus'] = $this->system_model->system_list('OPPORTUNITIES_STAGES');

        $this->load->view('header');
        $this->load->view('opportunities/index', $data);
        $this->load->view('footer');
    }

    function add() {
        //checking permission for staff
        if (!check_staff_permission('opportunities_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        echo $this->uri->segment(4);
        $data['processState'] = 'Create';
        $data['processButton'] = 'Create';
        $data['companies'] = $this->customers_model->company_list();
        $data['contacts'] = $this->opportunities_model->contact_list("");
        $data['staffs'] = $this->staff_model->staff_list();
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['sources'] = $this->system_model->system_list('LEAD');
        $data['priorities'] = $this->system_model->system_list('PRIORITY');
        $data['types'] = $this->system_model->system_list('OPPORTUNITIES_TYPE');
        $data['stages'] = $this->system_model->system_list('OPPORTUNITIES_STAGES');
        $data['tags'] = $this->system_model->system_list_tags('TAGS', 'ASC');
        $data['campaigns'] = $this->campaign_model->campaign_list('');
        $data['lead'] = $this->leads_model->get_lead($this->uri->segment(4), userdata('id'));
        $data['stat'] = 'add';
		//added by nanin mulyani 20160903
		$data['salesteams_user'] = $this->opportunities_model->get_salesteams_user(userdata('id'));
		//and
		
		$acc['salesteams'] = $this->salesteams_model->salesteams_list();
        $acc['contact_persons'] = $this->customers_model->contact_persons_list();
        $acc['staffs'] = $this->staff_model->staff_list();
        $acc['countries'] = $this->contact_persons_model->country_list();
        $acc['titles'] = $this->system_model->system_list('TITLE_NAME');
        $acc['companies'] = $this->customers_model->company_list();
        $acc['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $acc['leads'] = $this->contact_persons_model->sys_account_list('LEAD');
		
		$cus['salesteams'] = $this->salesteams_model->salesteams_list();
        $cus['contact_persons'] = $this->customers_model->contact_persons_list();
        $cus['staffs'] = $this->staff_model->staff_list();
        $cus['countries'] = $this->contact_persons_model->country_list();
        $cus['titles'] = $this->system_model->system_list('TITLE_NAME');
        $cus['companies'] = $this->customers_model->company_list();
        $cus['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $cus['leads'] = $this->contact_persons_model->sys_account_list('LEAD');
        
        $this->load->view('header');
        $this->load->view('opportunities/form', $data);
		$this->load->view('opportunities/add_account', $acc);
		$this->load->view('opportunities/add_customer', $cus);
        $this->load->view('footer');
    }

    function add_process() {
        //checking permission for staff
        if (!check_staff_permission('opportunities_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('salesperson_id', 'Sales Person on Opportunity owner', 'required');
        $this->form_validation->set_rules('sales_team_id', 'Sales Team on Opportunity owner', 'required');
        // $this->form_validation->set_rules('opportunity', 'Opportunity', 'required');
        // $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('expected_closing', 'Expected closing', 'required');
        $this->form_validation->set_rules('stages_id', 'Stages', 'required');
        $this->form_validation->set_rules('expected_revenue', 'Expected revenue', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {

            if ($this->opportunities_model->add_opportunities()) {

                $opportunity_id = $this->db->insert_id();

                add_notifications($this->input->post('salesperson_id'), 'New Opportunities Added', $opportunity_id, 'opportunities');

                echo 'yes_' . $opportunity_id . '_add';
                //echo '<div class="alert ok">'.$this->lang->line('create_succesful').'</div>';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function view($opportunity_id) {
        //checking permission for staff
        if (!check_staff_permission('opportunities_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['meeting_type'] = $this->meetings_model->meeting_type();
        $data['companies'] = $this->customers_model->company_list();
        $data['contacts'] = $this->opportunities_model->contact_list("");
        $data['staffs'] = $this->staff_model->staff_list();
        $data['calls'] = $this->calls_model->calls_list($opportunity_id, $type = 'opportunities');
        $data['meetings'] = $this->meetings_model->meetings_list($opportunity_id, $type = 'opportunities');
        $data['opportunity'] = $this->opportunities_model->get_opportunities($opportunity_id);
        $data['sources'] = $this->system_model->system_list('LEAD');
        $data['tags'] = $this->system_model->system_list('TAGS');
        $data['priorities'] = $this->system_model->system_list('PRIORITY');
        $data['types'] = $this->system_model->system_list('OPPORTUNITIES_TYPE');
        $data['stages'] = $this->system_model->system_list('OPPORTUNITIES_STAGES');
        $data['campaigns'] = $this->campaign_model->campaign_list('');
        $data['contact_persons'] = $this->opportunities_model->contact_list();

        $this->load->view('header');
        $this->load->view('opportunities/view', $data);
        $this->load->view('footer');
    }

    function update($opportunity_id, $lead_id) {
        //checking permission for staff
        /* if (!check_staff_permission('opportunities_write'))	
          {
          redirect(base_url('admin/access_denied'), 'refresh');
          } */
        // print_r($opportunity_id)

        $data['processState'] = 'Edit';
        $data['processButton'] = 'Update';
        $data['companies'] = $this->customers_model->company_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['calls'] = $this->calls_model->calls_list($opportunity_id, $type = 'opportunities');
        $data['meetings'] = $this->meetings_model->meetings_list($opportunity_id, $type = 'opportunities');
        $data['opportunity'] = $this->opportunities_model->get_opportunities($opportunity_id);
        $data['sources'] = $this->system_model->system_list('LEAD');
        $data['priorities'] = $this->system_model->system_list('PRIORITY');
        $data['types'] = $this->system_model->system_list('OPPORTUNITIES_TYPE');
        $data['stages'] = $this->system_model->system_list('OPPORTUNITIES_STAGES');
        $data['campaigns'] = $this->campaign_model->campaign_list('');
        $data['tags'] = $this->system_model->system_list_tags('TAGS', 'ASC');
        $data['lead'] = $this->leads_model->get_lead($lead_id, userdata('id'));
        $company_id = $this->opportunities_model->get_opportunities($opportunity_id)->customer_id;
        $data['contacts'] = $this->opportunities_model->contact_list($company_id);

        $this->load->view('header');
        $this->load->view('opportunities/form', $data);
        $this->load->view('footer');
    }

    function update_process() {
        //checking permission for staff
        if (!check_staff_permission('opportunities_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('salesperson_id', 'Sales Person', 'required');
        $this->form_validation->set_rules('sales_team_id', 'Sales Team', 'required');
        // $this->form_validation->set_rules('opportunity', 'Opportunity', 'required');
        // $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('expected_closing', 'Expected closing', 'required');
        $this->form_validation->set_rules('stages_id', 'Stages', 'required');
        $this->form_validation->set_rules('expected_revenue', 'Expected revenue', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {

            if ($this->opportunities_model->update_opportunities()) {
                $opportunity_id = $this->input->post('opportunity_id');
                echo 'yes_' . $opportunity_id . '_update';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function get_filter() {
        //checking permission for staff
        if (!check_staff_permission('leads_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $opportunities = $this->input->post("type");
        $times = $this->input->post("time");
        // if ( $times){
        $data['opportunities'] = $this->opportunities_model->stages_getfilter(userdata('id'), $opportunities, $times);
        // }

        $this->load->view('opportunities/opportunities_data', $data);
    }

    function ajax_get_contact($company_id) {
        $data['contact_persons'] = $this->opportunities_model->contact_list($company_id);
        $this->load->view('ajax_get_contact', $data);
    }
	
	//add by nanin mulyani 20160901 1734
	function ajax_get_company() {
        $data['companies'] = $this->customers_model->company_list();
        $this->load->view('ajax_get_company', $data);
    }
	//end

    /*
     * deletes opportunity     *  
     */

    function delete($opportunity_id) {
        //checking permission for staff
        if (!check_staff_permission('opportunities_delete')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        if ($this->opportunities_model->delete($opportunity_id)) {
            echo 'deleted';
        }
    }

    //Add Call
    function add_call() {

        check_login();

        $this->form_validation->set_rules('call_summary', 'Call Summary', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo '<div style="color:red;margin-left:15px;">' . validation_errors() . '</div>';
        } else {

            if ($this->calls_model->add_calls()) {
                $opportunity_id = $this->db->insert_id();
                echo 'yes_' . $opportunity_id;
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    /*
     * deletes call     *  
     */

    function call_delete($call_id) {
        check_login();

        if ($this->calls_model->delete($call_id)) {
            echo 'deleted';
        }
    }

    //Add Meetings
    function add_meeting() {


        $this->form_validation->set_rules('meeting_subject', 'Meeting Subject', 'required');
        $this->form_validation->set_rules('starting_date', 'Starting date', 'required');
        $this->form_validation->set_rules('ending_date', 'Ending date', 'required');

        $startDate = strtotime($_POST['starting_date']);
        $endDate = strtotime($_POST['ending_date']);



        if ($this->form_validation->run() == FALSE) {
            echo '<div style="color:red;margin-left:15px;">' . validation_errors() . '</div>';
        } elseif ($startDate > $endDate) {
            echo '<div style="color:red;margin-left:15px;">Should be greater than Start Date</div>';
            exit;
        } else {

            if ($this->meetings_model->add_meetings()) {
                $opportunity_id = $this->db->insert_id();
                echo 'yes_' . $opportunity_id;
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    /*
     * deletes Meetings     *  
     */

    function meeting_delete($meeting_id) {
        check_login();

        if ($this->meetings_model->delete($meeting_id)) {
            echo 'deleted';
        }
    }

    /*
     * confirm sale*  
     */

    function convert_to_quotation($opportunity_id) {
        if ($this->opportunities_model->convert_to_quotation($opportunity_id)) {
            $quotation_id = $this->db->insert_id();
            redirect('admin/quotations/update_from_opportunities/' . $quotation_id);
        }
    }

    function convert_to_customer() {
        if ($this->opportunities_model->add_convert_to_customer()) {
            redirect("admin/customers/update/" . $this->db->insert_id());
        } else {
            redirect("admin/opportunities/view/" . $_POST['convert_opport_id']);
        }
    }

    public function get_activities() {
        $data = array();
        $no = $_POST['start'];
        $o = $this->input->post('order');
        $s = $this->input->post('search');
        $order = $o[0]['column'];
        $order_dir = $o[0]['dir'];
        $search_value = $s['value'];
        $opportunity_id = $this->input->post('opportunity_id');
        $activity_type = $this->input->post('activity_type');

        switch ($order) {
            default:
            case 0:
                $order = "t.activity";
                break;
            case 1:
                $order = "t.created_dt";
                break;
            case 2:
                $order = "t.remarks";
                break;
            case 3:
                $order = "u.first_name";
                break;
        }
        $r = $this->opportunities_model->activitiesData($opportunity_id, $order, $order_dir, $search_value, $activity_type);

        foreach ($r as $l) {
            $url = "";
            if ($l->activity_type == 1) {
                $url = base_url('admin/logged_calls/view/' . $l->id . '/' . $company_id);
            } else {
                $url = base_url('admin/meetings/view/' . $l->id . '/' . $company_id);
            }
            $row = array(
                'activity' => '<a href="' . $url . '">' . $l->activity . '</a>',
                'created_dt' => $l->created_dt,
                'remarks' => $l->remarks,
                'created_by' => $l->created_by
            );
            $data[] = $row;
        }
        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->opportunities_model->count_filtered($opportunity_id, $order, $order_dir, $search_value, $activity_type),
            'recordsFiltered' => $this->opportunities_model->count_filtered($opportunity_id, $order, $order_dir, $search_value, $activity_type),
            'data' => $data
        );

        echo json_encode($output);
    }

    //sementara
    function test() {
//        $this->load->view('header');
//        echo userdata('id');
        
        $data = $this->opportunities_model->test(userdata('id'));
        echo $data;
//        print_r($data);
//        echo userdata('id');
//        $this->load->view('opportunities/test', $data);
//        $this->load->view('footer');
    }

    /* Ega 01 Aug 2016 : Opportunities dashboard */

    function dashboard($tags, $sales, $company_id, $steams) {
        //checking permission for staff
        if (!check_staff_permission('opportunities_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['stages_column'] = $this->opportunities_model->stages_column();
        $data['tags_list'] = $this->system_model->system_list('TAGS');
        if(userdata('id') == 1){
            $data['name_list'] = $this->opportunities_model->name_list();
            $data['salesteams_list'] = $this->opportunities_model->salesteams_list();
            $data['company_list'] = $this->opportunities_model->company_list();
            $data['sales'] = $sales;
        }else{
            $data['name_list'] = $this->opportunities_model->get_sales_incharge(userdata('id'));
            $data['salesteams_list'] = $this->opportunities_model->get_salesteam_incharge(userdata('id'));
            $data['company_list'] = $this->opportunities_model->get_company_handling(userdata('id'));
            $data['sales'] = (($sales!="")?$sales:userdata('id'));
        }
        $data['tags'] = $tags;
        $data['steams'] = $steams;
        $data['company_id'] = $company_id;
        $this->load->view('header');
        $this->load->view('opportunities/dashboard', $data);
        $this->load->view('footer');
    }

    function update_stage_by_id() {
        $result = "GAGAL";
        if ($this->opportunities_model->update_stage_by_id()) {
            $result = "BERHASIL";
        }

        header('Content-Type: application/json');
        echo json_encode(array('message' => $result));
    }

    /* end Ega 01 Aug 2016 : Opportunities dashboard */


    /* yusuf mod paging */

    function getfilter() {//modified by yusuf
        if (!check_staff_permission('opportunities_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        /*
          $leads = $this->input->post("type");
          $times = $this->input->post("time");
          $ar = $this->input->post("archived");
          if ($ar != '' || $ar == 'archive_leads') {
          $archive = "1";
          } else {
          $archive = "0";
          }
         */
        //if ($times) {
        $times = $this->input->post("time");
        $stage_id = $this->input->post("stage_id");
        $data = array();
        $no = $_POST['start'];
        $o = $this->input->post('order');
        $s = $this->input->post('search');
        $order = $o[0]['column'];
        $order_dir = $o[0]['dir'];
        $search_value = $s['value'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        /*
          $order = 0;
          $order_dir = 'asc';
          $search_value = '';
          $start = 0;
          $length = 10;
         */
        switch ($order) {
            default:
            case 0:
                $order = "o.opportunity";
                break;
            /*case 1:
                $order = "l.lead_name";
                break;*/
            case 1:
                $order = "o.amount";
                break;
            case 2:
                $order = "tms.system_value_txt";
                break;
            case 3:
                $order = "u.first_name";
                break;
            case 4:
                $order = "c.name";
                break;
            case 5:
                $order = "o.create_by";
                break;
        }

        $r = $this->opportunities_model->opportunitiesdata($start, $length, $order, $order_dir, $search_value, $times, $stage_id);

        foreach ($r as $l) {
            $no++;

            $act = "";
            $next_week = strtotime(date('m/d/Y', strtotime('+' . config('opportunities_reminder_days') . ' days')));
            $expiration_date = strtotime($l->next_action);
            $today = strtotime(date('m/d/Y'));
            if ($expiration_date < $today && $l->closed_status == 0) {
                $act.='<a href="#" class="edit btn btn-sm btn-warning dlt_sm_table" data-rel="tooltip" data-toggle="tooltip" data-placement="top" title="Opportunities has been expired"><i class="icon-info"></i></a>';
            }else if($expiration_date <= $next_week && $l->closed_status == 0){
                $act.='<a href="#" class="edit btn btn-sm btn-dark dlt_sm_table" data-rel="tooltip" data-toggle="tooltip" data-placement="top" title="Opportunities will expire within the few days"><i class="icon-info"></i></a>';
            }else if($l->closed_status != 0){
                $act.='<a href="#" class="edit btn btn-sm btn-success dlt_sm_table" data-rel="tooltip" data-toggle="tooltip" data-placement="top" title="Opportunities Closed"><i class="fa fa-check"></i></a>';
            }
            
            if (check_staff_permission('opportunities_write') && $l->closed_status == 0) {
                $act.='<a href="'.base_url('admin/opportunities/update/' . $l->id).'" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a>';
            }
            
            if (check_staff_permission('opportunities_delete')) {
                $act.='<a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic" onclick="setid('.$l->id.')"><i class="glyphicon glyphicon-trash"></i></a>';
            }
            /* if ($l->customer_id !== 0 && $this->leads_model->exists_leads($l->id) !== 0) {
              $act.='   <a  style="background-color:#4B4E4D;margin-left: 4px;" title="Leads has been converted to Account and Opportunity" class="btn btn-sm btn-success"><i class="fa fa-check-circle-o"></i></a>';
              } else if ($this->leads_model->stat_convert($l->id)) {
              $act.='   <a  class="edit btn btn-sm btn-warning dlt_sm_table" style="background-color: rgb(132, 74, 15);" title="Leads has been converted to Account"><i class="fa fa-user" disabled></i></a>';
              } */

            /* if ($l->customer_id == 0 && $this->leads_model->exists_leads($l->id) == 0) {
              if ($this->leads_model->exists_leads($l->id) == 0) {
              if (check_staff_permission('lead_write')) {
              $act.='<a href="' . base_url('admin/leads/update/' . $l->id) . '" class=" btn btn-sm btn-w btn-default btn-embossed dlt_sm_table"><i class="icon-note"></i></a>';
              }
              }

              if (check_staff_permission('lead_delete')) {
              $act.='<a href="javascript:void(0)" onClick="setLeadId(\'' . $l->id . '\')" class="btn btn-sm btn-danger btn-embossed dlt_sm_table" data-toggle="modal" data-target="#modal-basic"><i class="glyphicon glyphicon-trash"></i></a>';
              }
             */
            $row = array(
                'opportunity' => '<a href="' . base_url('admin/opportunities/view/' . $l->id) . '">' . $l->opportunity . '</a>',
                //'lead_name' => '<a href="' . base_url('admin/leads/view/' . $l->lead_id) . '">' . $l->lead_name . '</a>',
                'amount' => number_format($l->amount, 2, '.', ','),
                'stage' => $l->system_value_txt,
                'sales_person' => $l->sales_person,
                'company_name' => $l->company_name,
                'create_by' => $l->create_by,
                'act' => $act
            );
            $data[] = $row;
            //}
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->opportunities_model->opportunitiescount($order, $order_dir, $search_value, $times, $stage_id),
            'recordsFiltered' => $this->opportunities_model->opportunitiescount($order, $order_dir, $search_value, $times, $stage_id),
            'data' => $data
        );
        echo json_encode($output);
    }

    /* end by yusuf */
	
	/*
	// add by nanin mulyani 20160831 1624
	function add_account(){
		$data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['contact_persons'] = $this->customers_model->contact_persons_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['countries'] = $this->contact_persons_model->country_list();
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['companies'] = $this->customers_model->company_list();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_persons_model->sys_account_list('LEAD');

        $this->load->view('header');
        $this->load->view('opportunities/add_account', $data);
        $this->load->view('footer');
	}
	// end
	*/
	
	/*
	function add_customer(){
		$data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['contact_persons'] = $this->customers_model->contact_persons_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['countries'] = $this->contact_persons_model->country_list();
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['companies'] = $this->customers_model->company_list();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_persons_model->sys_account_list('LEAD');

        $this->load->view('header');
        $this->load->view('opportunities/add_customer', $data);
        $this->load->view('footer');
	}
	*/
	
	// add by nanin mulyani 20160831 1647
	function add_account_process(){
		if ($this->form_validation->run('admin_create_company') == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->customers_model->exists_name($this->input->post('name')) > 0) {
            echo '<div class="alert error"><ul><li style="color:red">Company Name already used.</li></ul></div>';
        } elseif ($this->customers_model->exists_email($this->input->post('email')) > 0) {
            echo '<div class="alert error"><ul><li style="color:red">Email already used.</li></ul></div>';
        } else {

            if ($this->customers_model->add_company()) {
                $customer_id = $this->db->insert_id();

                if ($this->customers_model->updt_id($customer_id)) {
                    
                }
                $subject = 'Customer login details';
                $message = 'Hello,  <br><br><b>Email:</b> ' . $this->input->post('email') . '. <br> <b>Password:</b> ' . $this->input->post('password') . '. <br>Please <a href="' . base_url('customer/login') . '">click here</a> for login';

                send_notice($this->input->post('email'), $subject, $message);

                echo 'yes_' . $customer_id;
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
	}
	// end
	
	// add by nanin mulyani 20160901 1141
	function add_process_ajax() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->contact_persons_model->exists_email($this->input->post('email')) > 0) {
            echo '<div class="alert error alert-danger">Email already used.</div>';
        } else {
            if ($this->contact_persons_model->add_contact_persons()) {
                $contact_person_id = $this->db->insert_id();
                echo 'yes_' . $contact_person_id;

                $data['contact_person'] = $this->contact_persons_model->get_contact_persons($contact_person_id);

                $details = array();

                $details['co_person_id'] = $contact_person_id;
                $details['co_person_name'] = $data['contact_person']->first_name . ' ' . $data['contact_person']->last_name;

                echo json_encode($details);
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }
	// end
}
