<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staff extends CI_Controller {

    function Staff() {
        parent::__construct();
        $this->load->database();
        $this->load->model("staff_model");
        $this->load->model("leads_model");
        $this->load->model("salesteams_model");
        $this->load->model("system_model");
        $this->load->model("opportunities_model");
        $this->load->model("customers_model");
        $this->load->model("salesorder_model");
        $this->load->model("settings_model");
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

        if ($this->user_model->get_role(userdata('id'))[0]->role_id != 1 || !check_staff_permission('staff_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['staffs'] = $this->staff_model->staff_list();
        $data['role'] = $this->staff_model->get_role();

        $this->load->view('header');
        $this->load->view('staff/staff_list', $data);
        $this->load->view('footer');
    }

    function add() {
        //checking permission for staff
        if ($this->user_model->get_role(userdata('id'))[0]->role_id != 1 || !check_staff_permission('staff_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['role'] = $this->staff_model->get_role();
        $data['setting_list'] = $this->settings_model->setting_list();
        
        $this->load->view('header');
        $this->load->view('staff/add_staff', $data);
        $this->load->view('footer');
    }

    function add_process() {
        //checking permission for staff

        if ($this->user_model->get_role(userdata('id'))[0]->role_id != 1 || !check_staff_permission('staff_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        };


        $this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
//        $this->form_validation->set_rules('last_name', 'Last Name', 'required|alpha|min_length[3]');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');


        $this->form_validation->set_rules('pass1', 'Password', 'required');
        $this->form_validation->set_rules('pass2', 'Password again', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->staff_model->exists_email($this->input->post('email')) > 0) {
            echo '<div class="alert error">Email already used.</div>';
        } elseif ($this->input->post('pass1') != $this->input->post('pass2')) {
            echo '<div class="alert error"><li style="color:red">Your password and Confirmation Password do not match.</li></ul></div>';
        } else {

            if ($this->staff_model->add_staff()) {
                $staff_id = $this->db->insert_id();

                echo 'yes_' . $staff_id;
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function view($staff_id) {
        //checking permission for staff
        if ($this->user_model->get_role(userdata('id'))[0]->role_id != 1 || !check_staff_permission('staff_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        if ($staff_id == '1') {

            $this->session->set_flashdata('message', '<div class="alert media fade in alert-danger" style="text-align: center;">You can not update admin</div>');
            redirect('admin/staff', 'refresh');
        } else {
            $data['staff'] = $this->staff_model->get_user($staff_id);
            $data['leads'] = $this->leads_model->get_lead_by_staff($staff_id);
            $data['opportunities'] = $this->opportunities_model->get_opportunity_by_staff($staff_id);
            $data['salesorders'] = $this->salesorder_model->get_salesorder_by_staff($staff_id);
            $data['role'] = $this->staff_model->get_role();

            $this->load->view('header');
            $this->load->view('staff/view_staff', $data);
            $this->load->view('footer');
        }
    }

    /*
     * Displays member update form
     */

    function update($staff_id) {
        //checking permission for staff


        if ($this->user_model->get_role(userdata('id'))[0]->role_id != 1 || !check_staff_permission('staff_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        //$data['support_access'] = $this->system_model->system_list('SUPPORT_ACC_LEVEL');
        if ($staff_id == '1') {

            $this->session->set_flashdata('message', '<div class="alert media fade in alert-danger" style="text-align: center;">You can not update admin</div>');
            redirect('admin/staff', 'refresh');
        } else {
            $data['staff'] = $this->staff_model->get_user($staff_id);
            $data['role'] = $this->staff_model->get_role();

            $this->load->view('header');
            $this->load->view('staff/update_staff', $data);
            $this->load->view('footer');
        }
    }

    /*
     * update processing
     */

    function update_process() {
        //checking permission for staff
        if (!check_staff_permission('staff_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
//        $this->form_validation->set_rules('last_name', 'Last Name', 'required|alpha|min_length[3]');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        // $this->form_validation->set_rules('pass1', 'Password', 'required');
        // $this->form_validation->set_rules('pass2', 'Password again', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->input->post('pass1') != $this->input->post('pass2')) {
            echo '<div class="alert error"><li style="color:red">Your password and Confirmation Password do not match.</li></ul></div>';
        } else {

            if ($this->staff_model->update_staff()) {
                $staff_id = $this->input->post('user_id');

                echo 'yes_' . $staff_id;
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
        
    }

    /*
     * deletes user
     * @param  a user id integer
     * @return string for ajax
     */

    function delete($staff_id) {
        //checking permission for staff
        if ($this->user_model->get_role(userdata('id'))[0]->role_id != 1 || !check_staff_permission('staff_delete')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        if ($this->staff_model->delete($staff_id)) {
            echo 'deleted';
        }
    }

    function cloning() {
        $staff_id = $this->input->post('staff_id');
        $new_first_name = $this->input->post('new_first_name');
        $new_last_name = $this->input->post('new_last_name');
        $new_email = $this->input->post('new_email');
        $new_password = md5($this->input->post('new_password'));
        if (!check_staff_permission('staff_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        if ($this->staff_model->cloning($staff_id, $new_first_name, $new_last_name, $new_email, $new_password)) {
            echo 'cloned';
        }
    }

}
