<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class send_sms extends CI_Controller {

    function send_sms() {
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
        $data = array();
        $data['api_list'] = $this->sms_model->get_active_api();
        $data['processState'] = "Send";
        $this->load->view('header');
        $this->load->view('send_sms/index', $data);
        $this->load->view('footer');
    }

    function send() {
        $this->sms_manager->set_credential($this->input->post('api'));
        $response = $this->sms_manager->send_sms($this->input->post('message'), $this->input->post('to'));
        echo $response['status'];
    }

}

?>