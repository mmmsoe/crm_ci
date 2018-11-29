<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_persons extends CI_Controller {

    function Contact_persons() {
        parent::__construct();
        $this->load->database();
        $this->load->model("customers_model");
        $this->load->model("contact_persons_model");
        $this->load->model("salesteams_model");
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
        if (!check_staff_permission('contacts_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['contact_persons'] = $this->contact_persons_model->contact_persons_list();

        $this->load->view('header');
        $this->load->view('contact_persons/index', $data);
        $this->load->view('footer');
    }

    function add() {
        if (!check_staff_permission('contacts_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['processState'] = 'Create';
        $data['processButton'] = 'Create';
        $data['countries'] = $this->contact_persons_model->country_list();
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['companies'] = $this->customers_model->company_list();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_persons_model->sys_account_list('LEAD');
        $this->load->view('header');
        $this->load->view('contact_persons/form', $data);
        $this->load->view('footer');
    }

    function add_process() {
        check_login();

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        //$this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->contact_persons_model->exists_email($this->input->post('email')) > 0) {
            echo '<div class="alert error alert-danger">Email already used.</div>';
        } else {
            if ($this->contact_persons_model->add_contact_persons()) {
                $contact_person_id = $this->db->insert_id();
                echo 'yes_' . $contact_person_id . '_add';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function view($customer_id) {
        if (!check_staff_permission('contacts_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['contact_person'] = $this->contact_persons_model->get_contact_persons($customer_id);

        $this->load->view('header');
        $this->load->view('contact_persons/view', $data);
        $this->load->view('footer');
    }

    function update($customer_id) {
        if (!check_staff_permission('contacts_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['processState'] = 'Edit';
        $data['processButton'] = 'Update';
        $data['countries'] = $this->contact_persons_model->country_list();
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['companies'] = $this->customers_model->company_list();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_persons_model->sys_account_list('LEAD');
        $data['contact_persons'] = $this->contact_persons_model->get_contact_persons($customer_id);
        //$data['main_contact'] = $this->customers_model->get_company($data['contact_person']->company); 

        $this->load->view('header');
        $this->load->view('contact_persons/form', $data);
        $this->load->view('footer');
    }

    function update_process() {
        check_login();

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        //$this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');

        if ($this->form_validation->run('admin_update_customers') == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {
            if ($this->contact_persons_model->update_contact_person()) {
                $contact_person_id = $this->input->post('customer_id');
                echo 'yes_' . $contact_person_id . '_update';
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    /*
     * deletes contact person
     * @param  a user id integer
     * @return string for ajax
     */

    function delete($contact_person_id) {
        if (!check_staff_permission('contacts_delete')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        
        check_login();

        if ($this->contact_persons_model->delete($contact_person_id)) {
            echo 'deleted';
        }
    }

    function add_process_ajax() {
        check_login();

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        //$this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->contact_persons_model->exists_email($this->input->post('email')) > 0) {
            echo '<div class="alert error alert-danger">Email already used.</div>';
        } else {
            if ($this->contact_persons_model->add_contact_persons()) {
                $contact_person_id = $this->db->insert_id();
                echo 'yes_' . $contact_person_id;
                //echo 'yes_' . $contact_person_id;
                //echo json_encode($this->db->insert_id());
                $data['contact_person'] = $this->contact_persons_model->get_contact_persons($contact_person_id);

                $details = array();

                $details['co_person_id'] = $contact_person_id;
                $details['co_person_name'] = $data['contact_person']->first_name . ' ' . $data['contact_person']->last_name;
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function ajax_state_list($country_id) {
        $data['state'] = $this->contact_persons->state_list($country_id);
        $this->load->view('ajax_get_state', $data);
        echo $country_id;
    }

    function ajax_city_list($state_id) {
        $data['cities'] = $this->contact_persons->city_list($state_id);
        $this->load->view('ajax_get_city', $data);
    }

}
