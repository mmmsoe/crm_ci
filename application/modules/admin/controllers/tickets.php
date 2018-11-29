<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tickets extends CI_Controller {

    function tickets() {
        parent::__construct();
        $this->load->database();
        $this->load->model("leads_model");

        $this->load->model("ticket_model");

        $this->load->model("customers_model");
        $this->load->model("staff_model");
        $this->load->model("salesteams_model");
        $this->load->model("calls_model");
        $this->load->model("system_model");
        $this->load->model('ticket_categories_model', 'tc');
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
        if (!check_staff_permission('tickets_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }


        $data['ticket'] = $this->ticket_model->ticket_list();
        $this->load->view('header');
        $this->load->view('tickets/index', $data);
        $this->load->view('footer');
    }

    function add() {
        //checking permission for staff
        if (!check_staff_permission('tickets_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        //	$data['owner'] = $this->contact_group_model->sys_account_list('ACC_OWNER');
        //	$data['leads'] = $this->contact_group_model->sys_account_list('LEAD');
        //$data['ticket_cat'] = $this->system_model->system_list('TICKET_CAT');
        $data['ticket_cat'] = $this->tc->get_all_categories();
        $data['ticket_priority'] = $this->system_model->system_list('TICKET_PRIORITY');

        $this->load->view('header');
        $this->load->view('tickets/add', $data);
        $this->load->view('footer');
    }

    function add_process() {

        //checking permission for staff
        if (!check_staff_permission('tickets_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('ticket_priority', 'priority', 'required');
        $this->form_validation->set_rules('ticket_category', 'category', 'required');
        $this->form_validation->set_rules('ticket_subject', 'subject', 'required');
        // $this->form_validation->set_rules('parent_account', 'Parent Account', 'required');
        // $this->form_validation->set_rules('account_number', 'Account Number', 'required'); 
        // $this->form_validation->set_rules('account_type', 'Account Type', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {

            if ($this->ticket_model->add_ticket()) {
                echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function reply_process() {

        //checking permission for staff
        if (!check_staff_permission('tickets_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('ticket_reply', 'comment', 'required');
        //	$this->form_validation->set_rules('ticket_category', 'category', 'required');
        //	$this->form_validation->set_rules('ticket_subject', 'subject', 'required');
        // $this->form_validation->set_rules('parent_account', 'Parent Account', 'required');
        // $this->form_validation->set_rules('account_number', 'Account Number', 'required'); 
        // $this->form_validation->set_rules('account_type', 'Account Type', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {

            if ($this->ticket_model->reply_ticket()) {
                echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function view($ticket_id) {
        //checking permission for staff
//            print_r($ticket_id);
//		print_r($this->ticket_model->get_reply($ticket_id));		
//            die();
        $thedata['ticket'] = $this->ticket_model->get_ticket($ticket_id);
        $thedata['reply'] = $this->ticket_model->get_reply($ticket_id);
		
        $this->load->view('header');
        $this->load->view('tickets/view', $thedata);
        $this->load->view('footer');
    }
	// function viewticket() {

        // $thedata = $this->ticket_model->get_ticket2();
        // echo json_encode(array('data'=>$thedata));
    // }

    function update($contact_id) {
        //checking permission for staff
        if (!check_staff_permission('accounts_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }


        $data['owner'] = $this->contact_group_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_group_model->sys_account_list('LEAD');

        $data['contact'] = $this->contact_group_model->get_contact($contact_id);
        $data['ticket_cat'] = $this->system_model->system_list('TICKET_CAT');
        $data['ticket_priority'] = $this->system_model->system_list('TICKET_PRIORITY');

        $this->load->view('header');
        $this->load->view('contact/update', $data);
        $this->load->view('footer');
    }

    function update_process() {
        //checking permission for staff
        if (!check_staff_permission('tickets_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('opportunity', 'Opportunity', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');

        $this->form_validation->set_rules('sales_team_id', 'Sales Team', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger"><ul>' . validation_errors('<li>', '</li>') . '</ul></div>';
        } else {

            if ($this->leads_model->update_leads()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    /*
     * change status    *  
     */

    function change_status($id) {
        //checking permission for staff
        if (!check_staff_permission('tickets_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        if ($this->ticket_model->update_status($id)) {
            //    echo '<div class="alert alert-success">'.$this->lang->line('change_succesful').'</div>';
        } else {
            echo $this->lang->line('technical_problem');
        }
    }

    function ajax_state_list($country_id) {
        $data['state'] = $this->leads_model->state_list($country_id);
        $this->load->view('ajax_get_state', $data);
    }

    function ajax_city_list($state_id) {
        $data['cities'] = $this->leads_model->city_list($state_id);
        $this->load->view('ajax_get_city', $data);
    }

    //Add Call
    function add_call() {

        $this->form_validation->set_rules('date', 'Date', 'required');

        $this->form_validation->set_rules('call_summary', 'Call Summary', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo '<div style="color:red;margin-left:15px;">' . validation_errors() . '</div>';
        } else {

            if ($this->calls_model->add_calls()) {
                echo 'yes';
                //echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>';
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

    function edit_call($call_id) {
        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['call'] = $this->calls_model->get_call($call_id);



        $this->load->view('header');
        $this->load->view('opportunities/edit_call', $data);
        $this->load->view('footer');
    }

    function edit_call_process() {
        $this->form_validation->set_rules('date', 'Date', 'required');

        $this->form_validation->set_rules('call_summary', 'Call Summary', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo '<div style="color:red;margin-left:15px;">' . validation_errors() . '</div>';
        } else {

            if ($this->calls_model->edit_calls()) {
                echo '<div style="margin-left:15px;">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function convert_to_opportunity() {



        if ($this->leads_model->add_convert_to_opportunity()) {

            // redirect("admin/opportunities/update/".$this->db->insert_id());              		  
            echo 'yes_' . $this->db->insert_id();
        } else {
            echo $this->lang->line('technical_problem');
        }
    }

    function convert_to_customer($lead_id) {


        $customer_id = $this->leads_model->add_convert_to_customer($lead_id);

        if ($customer_id) {

            redirect("admin/customers/update/" . $customer_id);
        } else {
            redirect("admin/leads/view/" . $lead_id);
        }
    }

    function export_leads() {
        $filename = "leads_csv.csv";
        $fp = fopen('php://output', 'w');

        $header = array('Opportunity', 'Company Name', 'Email', 'Phone', 'Mobile', 'Fax');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);

        $num_column = count($header);
        $query = "SELECT opportunity,company_name,email,phone,mobile,fax FROM leads";
        $result = mysql_query($query);
        while ($row = mysql_fetch_row($result)) {
            fputcsv($fp, $row);
        }
        exit;
    }

    //ticket categories


    function ticket_categories() {

        $this->load->view('header');
        $this->load->view('tickets/ticket_categories');
        $this->load->view('footer');
    }

    function get_filter_categories() {
        $data = array();
        $no = $_POST['start'];
        $o = $this->input->post('order');
        $s = $this->input->post('search');
        $order = $o[0]['column'];
        $order_dir = $o[0]['dir'];
        $start = $_POST['start'];
        $length = $_POST['length'];

        switch ($order) {
            case 0:
                $order = "ticket_category_name";
                break;
        }

        $r = $this->tc->categories_data($order, $order_dir, $search_value, $start, $length);

        foreach ($r as $l) {
            $no++;
            $act = "";
            $act.='<a href="' . base_url('admin/tickets/categories_form/' . $l->ticket_category_id) . '" class=" btn btn-sm btn-w btn-default btn-embossed dlt_sm_table"><i class="icon-note"></i></a>';
            $act.='<a href="javascript:void(0)" onClick="setCatId(\'' . $l->ticket_category_id . '\')" class="btn btn-sm btn-danger btn-embossed dlt_sm_table" data-toggle="modal" data-target="#modal-basic"><i class="glyphicon glyphicon-trash"></i></a>';
            $row = array(
                "ticket_category_name" => $l->ticket_category_name,
                'act' => $act
            );
            $data[] = $row;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->tc->count_filtered($order, $order_dir, $search_value),
            'recordsFiltered' => $this->tc->count_filtered($order, $order_dir, $search_value),
            'data' => $data
        );

        echo json_encode($output);
    }

    function categories_form() {

        $data = array();
        if ($this->uri->segment(4) != "") {
            $data['title'] = "Edit Ticket Category";
            $data['submit'] = "Update Category";
            $r = $this->tc->get_category($this->uri->segment(4));
            $data['ticket_category_name'] = $r;
        } else {
            $data['title'] = "Add Ticket Category";
            $data['submit'] = "Create Category";
            $data['ticket_category_name'] = "";
        }
        $this->load->view('header');
        $this->load->view('tickets/ticket_categories_form', $data);
        $this->load->view('footer');
    }

    function save_categories() {
        $id = $this->input->post('ticket_category_id');
        $name = $this->input->post('ticket_category_name');
        $r = $this->tc->save($id, $name);
        echo json_encode($r);
    }
    
    function delete_ticket_category()
    {
        $id = $this->input->post('ticket_category_id');
        $r = $this->tc->delete($id);
        echo $r;
    }
	function delete_tickets($id) {
		$data = $this->ticket_model->delete_tickets($id);
		echo json_encode(array('data'=>$data));
	}
	function delete_reply($id) {
		$data = $this->ticket_model->delete_reply($id);
		echo json_encode(array('data'=>$data));
	}

    //end ticket categories
}
