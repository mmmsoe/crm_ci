<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail_entry extends CI_Controller {

    function mail_entry() {
        parent::__construct();
        $this->load->database();
        $this->load->model("mail_entry_model");
        check_login();
    }

    function index() {
        $data['mail_entry'] = $this->mail_entry_model->all_mail_entry_list('');

        $this->load->view('header');
        $this->load->view('mail_entry/index', $data);
        $this->load->view('footer');
    }
}
