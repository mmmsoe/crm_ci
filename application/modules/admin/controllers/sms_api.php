<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_api extends CI_Controller {

    function Sms_api() {
        parent::__construct();
        $this->load->database();
        check_login();
        $this->load->library('sms_manager');
        $this->load->model('sms_model');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    function index() {
        
        $this->load->view('header');
        $this->load->view('sms_api/index');
        $this->load->view('footer');
    }

    /* function sms_api() {
      $this->load->view('header');
      $this->load->view('sms_api/index');
      $this->load->view('footer');
      } */

    function api_form() {
        $act = $this->uri->segment(4);
        $id = $this->uri->segment(5);

        $data = array();
        if ($act == "edit") {
            $data['processState'] = "Edit";
        } else {
            $data['processState'] = "Add";
        }

        if ($id != "") {
            $r = $this->sms_model->getAPIbyID($id);
            $data['id'] = $r->row()->id;
            $data['gateway_name'] = $r->row()->gateway_name;
            $data['username_auth_id'] = $r->row()->username_auth_id;
            $data['password_auth_token'] = $r->row()->password_auth_token;
            $data['api_id'] = $r->row()->api_id;
            $data['phone_number'] = $r->row()->phone_number;
            $data['status'] = $r->row()->status;
        } else {
            $data['id'] = "";
            $data['gateway_name'] = "";
            $data['username_auth_id'] = "";
            $data['password_auth_id'] = "";
            $data['api_id'] = "";
            $data['phone_number'] = "";
            $data['status'] = "1";
        }

        $status_list = array(
            array('1', 'Enabled'),
            array('0', 'Disabled')
        );

        $gateway_list = array(
            'planet',
            'plivo',
            'twilio',
            'clickatell',
            'nexmo',
            'msg91.com',
            'textlocal.in',
            'sms4connect.com',
            'telnor.com',
            'mvaayoo.com',
            'routesms.com',
            'trio-mobile.com',
            'sms40.com'
        );
        $data['gateway_list'] = $gateway_list;
        $data['status_list'] = $status_list;
        $this->load->view('header');
        $this->load->view('sms_api/form', $data);
        $this->load->view('footer');
    }

    function save() {
        if ($this->sms_model->save_api()) {
            echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>';
        } else {
            echo $this->lang->line('technical_problem');
        }
    }

    function get_api() {
        $o = $this->input->post('order');
        $s = $this->input->post('search');
        $order = $o[0]['column'];
        $order_dir = $o[0]['dir'];
        $search_value = $s['value'];

        switch ($order) {
            default:
            case 0:
                $order = "gateway_name";
                break;
            case 1:
                $order = "username_auth_id";
                break;
            case 2:
                $order = "password_auth_token";
                break;
            case 3:
                $order = "api_id";
                break;
            case 4:
                $order = "phone_number";
                break;
            case 5:
                $order = "status";
                break;
        }

        $r = $this->sms_model->getAPI($order, $order_dir, $search_value);


        $data = array();
        foreach ($r as $l) {

            $act = "";
            //if (check_staff_permission('lead_write')) {
            $act.='<a href="' . base_url('admin/sms_api/api_form/edit/' . $l->id) . '" class=" btn btn-sm btn-w btn-default btn-embossed dlt_sm_table"><i class="icon-note"></i></a>';
            //}
            //if (check_staff_permission('lead_delete')) {
            $act.='<a href="javascript:void(0)" onClick="setId(\'' . $l->id . '\')" class="btn btn-sm btn-danger btn-embossed dlt_sm_table" data-toggle="modal" data-target="#modal-basic"><i class="glyphicon glyphicon-trash"></i></a>';
            //}
            $sts = "";
            if ($l->status == 1) {
                $sts = '<p class="text-success">Enabled</p>';
            } else {
                $sts = '<p class="text-danger">Disabled</p>';
            }
            $row = array(
                "gateway_name" => $l->gateway_name,
                "username_auth_id" => $l->username_auth_id,
                "password_auth_token" => $l->password_auth_token,
                "api_id" => $l->api_id,
                "phone_number" => $l->phone_number,
                "status" => $sts,
                "act" => $act
            );
            $data[] = $row;
        }
        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->sms_model->count_all_getAPI(),
            'recordsFiltered' => $this->sms_model->count_getAPI($order, $order_dir, $search_value),
            'data' => $data
        );
        echo json_encode($output);
    }

    function send_sms() {
        $this->sms_manager->set_credential($this->session->userdata('id'));
        $response = $this->sms_manager->send_sms("test", "6285722760852");
        echo json_encode($response);
    }

}

?>