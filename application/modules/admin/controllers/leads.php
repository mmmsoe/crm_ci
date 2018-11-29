<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leads extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();

        $this->load->model("leads_model");
        $this->load->model("customers_model");
        $this->load->model("staff_model");
        $this->load->model("salesteams_model");
        $this->load->model("calls_model");
        $this->load->model("system_model");
        $this->load->model("campaign_model");
        $this->load->model("contact_persons_model");
		$this->load->model("opportunities_model");
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
        if (!check_staff_permission('lead_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        // $times='month';
        // $data['leads'] = $this->leads_model->leads_list(userdata('id'));
        // $times = 'month';
        // if($times){
        // $data['leads'] = $this->leads_model->leads_getfilter_type(userdata('id'), '', $times);
        // }else{
        // $data['leads'] = $this->leads_model->leads_getfilter_type(userdata('id'),'','');
        // }

        $data['allstatus'] = $this->system_model->system_list('LEAD_STATUS');

        $this->load->view('header');
        $this->load->view('leads/index', $data);
        $this->load->view('footer');
    }

    function exporta($times=null,$leads=null, $ar=null){
       if (!check_staff_permission('lead_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        if ($ar != '' || $ar == 'archive_leads') {
            $archive = "1";
        } else {
            $archive = "0";
        }

        $s = $this->input->post('search');

        
        $r = $this->leads_model->leads_datax(userdata('id'), $leads, $times, '', '', '', '');
        if (count($r) > 0) {
            $delimiter = ",";
            $f = fopen('php://memory', 'w');
            //set column headers
            $fields = array('LEAD NAME', 'COMPANY', 'EMAIL', 'CAMPAIGN SOURCE', 'SALES', 'CREATED DATE', 'CREATED BY');
            fputcsv($f, $fields, $delimiter);

            foreach ($r as $key => $v) {
                $fields = array(
                        $v->lead_name,
                        $v->company_name,
                        $v->email,
                        $v->campaign_name,
                        $v->sales,
                        $v->create_date,
                        $v->create_by
                    );
                fputcsv($f, $fields, $delimiter);
            }

            // output headers so that the file is downloaded rather than displayed
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Leads.csv');

            //move back to beginning of file
            fseek($f, 0);
            //output all remaining data on a file pointer
            fpassthru($f);
        }
    }

    function archive_leads() {
        //checking permission for staff
        if (!check_staff_permission('lead_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        // $times='month';
        // $data['leads'] = $this->leads_model->leads_list(userdata('id'));
        $times = 'month';
        // if($times){
        $data['leads'] = $this->leads_model->leads_getfilter_type(userdata('id'), '', $times);
        // }else{
        // $data['leads'] = $this->leads_model->leads_getfilter_type(userdata('id'),'','');
        // }

        $data['allstatus'] = $this->system_model->system_list('LEAD_STATUS');

        $this->load->view('header');
        $this->load->view('leads/leads_archived', $data);
        $this->load->view('footer');
    }

    function add() {
        //checking permission for staff
        if (!check_staff_permission('lead_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['processState'] = 'Create';
        $data['processButton'] = 'Create';
        $data['companies'] = $this->customers_model->company_list();
        $data['countries'] = $this->leads_model->country_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['industrys'] = $this->system_model->system_list('INDUSTRY');
        $data['sources'] = $this->system_model->system_list('LEAD');
        $data['ratings'] = $this->system_model->system_list('RATING');
        $data['tags'] = $this->system_model->system_list('TAGS');
        $data['allstatus'] = $this->system_model->system_list('LEAD_STATUS');
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['priorities'] = $this->system_model->system_list('PRIORITY');
        $data['campaigns'] = $this->campaign_model->campaign_detail();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
		//added by nanin mulyani 20160903
		$data['salesteams_user'] = $this->opportunities_model->get_salesteams_user(userdata('id'));
		//and
        $this->load->view('header');
        $this->load->view('leads/form', $data);
        $this->load->view('footer');
    }

    function add_process() {

        //checking permission for staff
        if (!check_staff_permission('lead_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('lead_name', 'Lead Name', 'required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'required');
        $this->form_validation->set_rules('salesperson_id', 'Sales on Lead owner', 'required');
        $this->form_validation->set_rules('sales_team_id', 'Sales Team on Lead owner', 'required');
        $this->form_validation->set_rules('tags_id', 'Tags', 'required');



        $url = htmlspecialchars($_POST['website']);

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->leads_model->exists_email($this->input->post('email')) > 0) {
            echo '<div class="alert error"><li style="color:red">Email already used in lead.</li></ul></div>';
        } elseif ($this->leads_model->exists_email($this->input->post('email'), 'company') > 0) {
            echo '<div class="alert error"><li style="color:red">Email already used in company.</li></ul></div>';
        } elseif ($url !== '' && !preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+\.[\w\-]+)/i", $url)) {
            echo '<div class="alert error"><li style="color:red">Invalid URL</li></ul></div>';
            if ($this->leads_model->exists_website($this->input->post('website')) > 0) {
                echo '<div class="alert error"><li style="color:red">Website already used in lead.</li></ul></div>';
            }
        } elseif ($this->leads_model->exists_website($this->input->post('website'), 'company') > 0) {
            echo '<div class="alert error"><li style="color:red">Website already used in company.</li></ul></div>';
        } else {
            if ($this->leads_model->add_leads()) {
                $lead_id = $this->db->insert_id();
                add_notifications($this->input->post('salesperson_id'), 'New Lead Added', $lead_id, 'leads');
                echo 'yes_' . $lead_id . '_add';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function view($lead_id, $stat) {
        //checking permission for staff
        if (!check_staff_permission('lead_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
		
		// add by nanin mulyani 20160831 1445
		$check_leader_lead = $this->leads_model->get_salesteam_incharge(userdata('id'));
		// end
		
        $data['companies'] = $this->customers_model->company_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['calls'] = $this->calls_model->calls_list($lead_id, $type = 'leads');
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['industrys'] = $this->system_model->system_list('INDUSTRY');
        $data['sources'] = $this->system_model->system_list('LEAD');
        $data['ratings'] = $this->system_model->system_list('RATING');
        $data['allstatus'] = $this->system_model->system_list('LEAD_STATUS');
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['priorities'] = $this->system_model->system_list('PRIORITY');
        $data['campaigns'] = $this->campaign_model->campaign_list($lead_id);
        $data['types'] = $this->system_model->system_list('OPPORTUNITIES_TYPE');
        $data['tags'] = $this->system_model->system_list('TAGS');
	// edit by nanin mulyani 20160831 1446
        $data['lead'] = $this->leads_model->get_lead($lead_id, userdata('role_id'), $check_leader_lead);
	// end
        $data['opportunity'] = $this->leads_model->get_opportunity($lead_id);
        $data['status'] = $stat;
        $data['message'] = 'Email already Exist';
        $this->load->view('header');
        $this->load->view('leads/view', $data);
        $this->load->view('footer');
    }

    function update($lead_id) {
        //checking permission for staff
        if (!check_staff_permission('lead_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['processState'] = 'Edit';
        $data['processButton'] = 'Update';
        $data['companies'] = $this->customers_model->company_list();
        $data['countries'] = $this->leads_model->country_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['industrys'] = $this->system_model->system_list('INDUSTRY');
        $data['sources'] = $this->system_model->system_list('LEAD');
        $data['ratings'] = $this->system_model->system_list('RATING');
        $data['allstatus'] = $this->system_model->system_list('LEAD_STATUS');
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['priorities'] = $this->system_model->system_list('PRIORITY');
        $data['tags'] = $this->system_model->system_list('TAGS');
        $data['campaigns'] = $this->campaign_model->campaign_detail();
		$data['calls'] = $this->calls_model->calls_list($lead_id, $type = 'leads');
		
	// comment by nanin mulyani 20160831 1557
	//$data['lead'] = $this->leads_model->get_lead($lead_id, userdata('id'));
	// edit by nanin mulyani 20160831 1556
        $data['lead'] = $this->leads_model->get_lead($lead_id, userdata('role_id'), $check_leader_lead);
	// end
		
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $this->load->view('header');
        $this->load->view('leads/form', $data);
        $this->load->view('footer');
    }

    function update_process() {
        //checking permission for staff
        if (!check_staff_permission('lead_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('lead_name', 'Lead Name', 'required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'required');
        $this->form_validation->set_rules('salesperson_id', 'Sales on Lead owner', 'required');
        $this->form_validation->set_rules('sales_team_id', 'Sales Team on Lead owner', 'required');
        $this->form_validation->set_rules('tags_id', 'Tags', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');


        $url = htmlspecialchars($_POST['website']);

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->input->post('website') !== $this->input->post('web_old')) {
            if ($url !== '' && !preg_match("/^(https?:\/\/+[\w\-]+\.[\w\-]+\.[\w\-]+)/i", $url)) {
                echo '<div class="alert error"><li style="color:red">Invalid URL</li></ul></div>';
            } elseif ($this->leads_model->exists_website($this->input->post('website')) > 0) {
                echo '<div class="alert error"><li style="color:red">Website already used.</li></ul></div>';
            } else {
                if ($this->leads_model->update_leads()) {
                    $lead_id = $this->input->post('lead_id');

                    echo 'yes_' . $lead_id . '_update';
                } else {
                    echo '<div class="alert alert-danger">Something goes wrong!</div>';
                }
            }
        } else {
            if ($this->leads_model->update_leads()) {
                $lead_id = $this->input->post('lead_id');

                echo 'yes_' . $lead_id . '_update';
            } else {
                echo '<div class="alert alert-danger">Something goes wrong!</div>';
            }
        }
    }

    /*
     * deletes lead     *  
     */

    function delete($lead_id) {
        //checking permission for staff
        if (!check_staff_permission('lead_delete')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        if ($this->leads_model->delete($lead_id)) {
            echo 'deleted';
        }
    }

    function get_filter() {//modified by yusuf
        if (!check_staff_permission('lead_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $leads = $this->input->post("type");
        $times = $this->input->post("time");
        $ar = $this->input->post("archived");
        if ($ar != '' || $ar == 'archive_leads') {
            $archive = "1";
        } else {
            $archive = "0";
        }
        //if ($times) {
        $data = array();
        $no = $_POST['start'];
        $o = $this->input->post('order');
        $s = $this->input->post('search');
        $order = $o[0]['column'];
        $order_dir = $o[0]['dir'];
        $search_value = $s['value'];

        switch ($order) {
            default:
            case 0:
                $order = "l.lead_name";
                break;
            case 1:
                $order = "l.company_name";
                break;
            case 2:
                $order = "l.email";
                break;
            case 3:
                $order = "cpg.campaign_name";
                break;
            case 4:
                $order = "u.first_name";
                break;
            case 5:
                $order = "l.create_date";
                break;
            case 6:
                $order = "l.create_by";
                break;
        }

        $r = $this->leads_model->leads_data(userdata('id'), $leads, $times, $order, $order_dir, $search_value, $archive);

        foreach ($r as $l) {
            $no++;

            $act = "";

            /* if ($l->customer_id !== 0 && $this->leads_model->exists_leads($l->id) !== 0) {
              $act.='   <a  style="background-color:#4B4E4D;margin-left: 4px;" title="Leads has been converted to Account and Opportunity" class="btn btn-sm btn-success"><i class="fa fa-check-circle-o"></i></a>';
              } else if ($this->leads_model->stat_convert($l->id)) {
              $act.='   <a  class="edit btn btn-sm btn-warning dlt_sm_table" style="background-color: rgb(132, 74, 15);" title="Leads has been converted to Account"><i class="fa fa-user" disabled></i></a>';
              } */

            if ($l->customer_id == 0 && $this->leads_model->exists_leads($l->id) == 0) {
                if ($this->leads_model->exists_leads($l->id) == 0) {
                    if (check_staff_permission('lead_write')) {
                        $act.='<a href="' . base_url('admin/leads/update/' . $l->id) . '" class=" btn btn-sm btn-w btn-default btn-embossed dlt_sm_table"><i class="icon-note"></i></a>';
                    }
                }

                if (check_staff_permission('lead_delete')) {
                    $act.='<a href="javascript:void(0)" onClick="setLeadId(\'' . $l->id . '\')" class="btn btn-sm btn-danger btn-embossed dlt_sm_table" data-toggle="modal" data-target="#modal-basic"><i class="glyphicon glyphicon-trash"></i></a>';
                }

                $row = array(
                    'lead_name' => '<a href="' . base_url('admin/leads/view/' . $l->id) . '">' . $l->lead_name . '</a>',
                    'company_name' => $l->company_name,
                    'email' => $l->email,
                    'campaign_name' => $l->campaign_name,
                    'sales' => $l->sales,
                    'create_date' => $l->create_date,
                    'create_by' => $l->create_by,
                    'act' => $act
                );
                $data[] = $row;
            }
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->leads_model->count_filtered(userdata('id'), $leads, $times, $order, $order_dir, $search_value, $archive),
            'recordsFiltered' => $this->leads_model->count_filtered(userdata('id'), $leads, $times, $order, $order_dir, $search_value, $archive),
            'data' => $data
        );
        echo json_encode($output);
    }

    function ajax_state_list2($country_id) {
        $data['data'] = $this->leads_model->state_list($country_id);
        //$this->load->view('ajax_get_state', $data);
        echo json_encode($data);
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
        $this->form_validation->set_rules('opportunity', 'Opportunity', 'required');
        $this->form_validation->set_rules('expected_closing', 'Expected Closing', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div style="color:red;margin-left:28px;"><ul>' . validation_errors('<li>', '</li>') . '</ul></div>';
        } else {

            if ($this->leads_model->add_convert_to_opportunity()) {
                // redirect("admin/opportunities/update/".$this->db->insert_id());              		  
                echo 'yes_' . $this->db->insert_id();
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function convert_to_customer($lead_id) {


        $customer_id = $this->leads_model->add_convert_to_customer($lead_id);

       /* if ($customer_id) {
            redirect("admin/customers/update/" . $customer_id);
        } else {
            redirect("admin/leads/view/" . $lead_id);
            // echo $this->lang->line('technical_problem');
            // echo $customer_id;
        }*/
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

    // function get_whois()
    // {
    // $this->load->library('Llbci_whois');
    // // $url = "https://whois.icann.org/en/lookup?name=olx.co.id";
    // // $US_Rate = file_get_contents($url);
    // // print_r($US_Rate);
    // // return $data;
    // //$this->load->library('whois');
    // $this->Llbci_whois->protocol_query('detik.com','')
    // }

    function whois() {
        //$domain = $this->input->post('website');
        $domain = "";
        /*$d = explode(".", $this->input->post('website'));
        
        for ($i = 1; $i < count($d); $i++) {
            $domain.=$d[$i] . ".";
        }*/
        

        //$domain = substr($domain, 0, strlen($domain) - 1);
        $d = $this->input->post('website');
        $d = explode("@",$d);
        $domain = $d[1];
        $this->load->library('mywhois');

        $this->mywhois->deep_whois = true;
        $this->mywhois->non_icann = true;
        $result = $this->mywhois->Lookup($domain, true);

        $regrinfo = $result['regrinfo'];
        $regyinfo = $result['regyinfo'];
        $owner = $regrinfo['owner'];
        $admin = $regrinfo['admin'];
        $tech = $regrinfo['tech'];
        $owneremail = $owner['email'];
        $techemail = $tech['email'];
        $adminemail = $admin['email'];
        $rawdata = $result['rawdata'];
        $regyinfo = $result['regyinfo'];
        $registrar = $regyinfo['registrar'];
        $regurl = $regyinfo['referrer'];

        $reg_name = "";
        $reg_org = "";
        $reg_street = "";
        $reg_city = "";
        $reg_state = "";
        $reg_postal = "";
        $reg_country = "";
        $reg_phone = "";
        $reg_phone_ext = "";
        $reg_fax = "";
        $reg_fax_ext = "";
        $reg_email = "";
        $x = "";

        for ($i = 0; $i < count($rawdata); $i++) {
            if (strpos($rawdata[$i], "Registrant Name") !== false) {
                $name = explode(":", $rawdata[$i]);
                $reg_name = trim($name[1]);
            }

            if (strpos($rawdata[$i], "Registrant Organization") !== false) {
                $org = explode(":", $rawdata[$i]);
                $reg_org = trim($org[1]);
            }

            if (strpos($rawdata[$i], "Registrant Street") !== false) {
                $street = explode(":", $rawdata[$i]);
                $reg_street = trim($street[1]);
            }

            if (strpos($rawdata[$i], "Registrant City") !== false) {
                $city = explode(":", $rawdata[$i]);
                $reg_city = trim($city[1]);
            }

            if (strpos($rawdata[$i], "Registrant State/Province") !== false) {
                $state = explode(":", $rawdata[$i]);
                $reg_state = trim($state[1]);
            }

            if (strpos($rawdata[$i], "Registrant Postal Code") !== false) {
                $postal = explode(":", $rawdata[$i]);
                $reg_postal = trim($postal[1]);
            }

            if (strpos($rawdata[$i], "Registrant Country") !== false) {
                $country = explode(":", $rawdata[$i]);
                $reg_country = trim($country[1]);
            }

            if (strpos($rawdata[$i], "Registrant Phone") !== false) {
                $phone = explode(":", $rawdata[$i]);
                if ($phone[0] == "Registrant Phone") {
                    $reg_phone = trim($phone[1]);
                    $reg_phone = str_replace(".", "", $reg_phone);
                }
            }

            if (strpos($rawdata[$i], "Registrant Fax") !== false) {
                $fax = explode(":", $rawdata[$i]);
                if ($fax[0] == "Registrant Fax") {
                    $reg_fax = trim($fax[1]);
                    $reg_fax = str_replace(".", "", $reg_fax);
                }
            }

            if (strpos($rawdata[$i], "Registrant Phone Ext") !== false) {
                $phone_ext = explode(":", $rawdata[$i]);
                if ($phone_ext[0] == "Registrant Phone Ext") {
                    $reg_phone_ext = trim($phone_ext[1]);
                }
            }

            if (strpos($rawdata[$i], "Registrant Fax Ext") !== false) {
                $fax_ext = explode(":", $rawdata[$i]);
                if ($fax_ext[0] == "Registrant Fax Ext") {
                    $reg_fax_ext = trim($fax_ext[1]);
                }
            }

            if (strpos($rawdata[$i], "Registrant Email") !== false) {
                $email = explode(":", $rawdata[$i]);
                $reg_email = trim($email[1]);
            }
        }

        $arr = array(
            'reg_name' => $reg_name,
            'reg_org' => $reg_org,
            'reg_street' => $reg_street,
            'reg_city' => $reg_city,
            'reg_state' => $this->leads_model->getStateIDByName($reg_state),
            'reg_postal' => $reg_postal,
            'reg_country' => $this->leads_model->getCountryIDBySortname($reg_country),
            'reg_phone' => $reg_phone,
            'reg_phone_ext' => $reg_phone_ext,
            'reg_fax' => $reg_fax,
            'reg_fax_ext' => $reg_fax_ext,
            'reg_email' => $reg_email
        );

        echo json_encode($arr);
    }

    public function upload() {
        $this->load->view('header');
        $this->load->view('leads/form_upload');
        $this->load->view('footer');
    }

    public function do_upload() {
        $pid = $this->leads_model->setProcessId("Upload csv");

        if ($_POST["label"]) {
            $label = $_POST["label"];
        }
        $path = "uploads/csv/";

        $temp = explode(".", $_FILES["file"]["name"]);
        $ext1 = end($temp);
        //$filename = md5($pid);
        $filename1 = $pid . '.' . $ext1;

        //echo $path;

        if ($_FILES["file"]["error"] > 0) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            }
        } else {
            $this->leads_model->csvtosql(addslashes($_FILES["file"]["tmp_name"]), $pid);
            $this->leads_model->temptoleads($pid);
        }
    }

    function check_comp() {
        $company_name = $this->input->post('company_name');
        $data = $this->leads_model->checkCompany($company_name, "company_name");
        echo json_encode($data->result());
    }
    
    function get_company_auto()
    {
        $r = $this->customers_model->company_auto();
        $data = array();
        foreach($r as $l)
        {
            array_push($data, $l->name);
        }
        echo json_encode($data);
        
    }

}
