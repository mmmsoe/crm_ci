<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class account extends CI_Controller {

    function account() {
        parent::__construct();
        $this->load->database();
        $this->load->model("account_model");
        $this->load->model("leads_model");
        $this->load->model("system_model");
        $this->load->model("customers_model");
        $this->load->model("staff_model");
        $this->load->model("salesteams_model");
        $this->load->model("calls_model");
        $this->load->library('form_validation');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        check_login();
    }

    function index() {
        if (!check_staff_permission('accounts_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['account'] = $this->account_model->account_list();

        $this->load->view('header');
        $this->load->view('account/index', $data);
        $this->load->view('footer');
    }

    function add() {
        //checking permission for staff
        if (!check_staff_permission('accounts_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['owner'] = $this->account_model->sys_account_list('ACC_OWNER');
        $data['type'] = $this->account_model->sys_account_list('ACC_TYPE');
        $data['industry'] = $this->account_model->sys_account_list('INDUSTRY');
        $data['ownership'] = $this->account_model->sys_account_list('OWNERSHIP');
        $data['rating'] = $this->account_model->sys_account_list('RATING');

        // $data['countries'] = $this->leads_model->country_list(); 
        // $data['staffs'] = $this->staff_model->staff_list(); 
        // $data['salesteams'] = $this->salesteams_model->salesteams_list(); 

        $this->load->view('header');
        $this->load->view('account/add', $data);
        $this->load->view('footer');
    }

    function add_process() {

        //checking permission for staff
        if (!check_staff_permission('accounts_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('account_owner', 'Account Owner', 'required');
        $this->form_validation->set_rules('account_name', 'Account Name', 'required');
        // $this->form_validation->set_rules('account_site', 'Account Site', 'required');
        // $this->form_validation->set_rules('parent_account', 'Parent Account', 'required');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required');
        //	$this->form_validation->set_rules('account_type', 'Account Type', 'required');


        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {

            if ($this->account_model->add_account()) {
                echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function view($account_id) {
        $data['account'] = $this->account_model->get_account($account_id);

        $this->load->view('header');
        $this->load->view('account/view', $data);
        $this->load->view('footer');
    }

    function update($account_id) {
        //checking permission for staff
        if (!check_staff_permission('accounts_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['owner'] = $this->account_model->sys_account_list('ACC_OWNER');
        $data['type'] = $this->account_model->sys_account_list('ACC_TYPE');
        $data['industry'] = $this->account_model->sys_account_list('INDUSTRY');
        $data['ownership'] = $this->account_model->sys_account_list('OWNERSHIP');
        $data['rating'] = $this->account_model->sys_account_list('RATING');

        $data['account'] = $this->account_model->get_account($account_id);

        $this->load->view('header');
        $this->load->view('account/update', $data);
        $this->load->view('footer');
    }

    function update_process() {
        //checking permission for staff
        if (!check_staff_permission('accounts_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('account_owner', 'Account Owner', 'required');
        $this->form_validation->set_rules('account_name', 'Account Name', 'required');
        // $this->form_validation->set_rules('account_site', 'Account Site', 'required');
        // $this->form_validation->set_rules('parent_account', 'Parent Account', 'required');
        $this->form_validation->set_rules('account_number', 'Account Number', 'required');
        //	$this->form_validation->set_rules('account_type', 'Account Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {

            if ($this->account_model->update_account()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function delete($account_id) {
        if (!check_staff_permission('accounts_delete')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        if ($this->account_model->delete($account_id)) {
            echo 'deleted';
        }
    }

}
