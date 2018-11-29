<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller {

    function Settings() {
        parent::__construct();
        $this->load->database();
        $this->load->model("user_model");
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
        //print_r($this->user_model->get_role(userdata('id'))[0]->role_id);
        //die();
        //userdata('id') == 1
        if ($this->user_model->get_role(userdata('id'))[0]->role_id == 1) {
            $data['setting_list'] = $this->settings_model->setting_list();
            $this->load->view('header');
            $this->load->view('settings/general_settings',$data);
            $this->load->view('footer');
        }
    }

    function general_settings() {

        if ($this->form_validation->run('general_settings') == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li>', '</li>') . '</ul></div>';
        } else {

            if ($this->settings_model->general_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
    }

    function upload_settings() {
        check_login();

        if ($this->form_validation->run('upload_settings') == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li>', '</li>') . '</ul></div>';
        } else {

            if ($this->settings_model->upload_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
    }

    function sales_tax_settings() {
        check_login();
        $this->form_validation->set_rules('sales_tax', 'Sales Tax', 'required|numeric|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
        } else {

            if ($this->settings_model->sales_tax_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
    }
	
	function qoutation_exp_settings(){
		check_login();
        $this->form_validation->set_rules('qoutation_exp', 'Quotation Expired', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
        } else {

            if ($this->settings_model->qoutation_exp_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
	}

    function invoice_prefix_settings() {
        check_login();

        $this->form_validation->set_rules('invoice_prefix', 'Invoice Prefix', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
        } else {

            if ($this->settings_model->invoice_prefix_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
    }

    function payment_term_settings() {
        check_login();

        $this->form_validation->set_rules('payment_term1', 'Payment Term 1', 'required|number|xss_clean');

        $this->form_validation->set_rules('payment_term2', 'Payment Term 2', 'required|number|xss_clean');

        $this->form_validation->set_rules('payment_term3', 'Payment Term 3', 'required|number|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
        } else {

            if ($this->settings_model->payment_term_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
    }

    function login_settings() {
        if ($this->settings_model->login_settings()) {
            echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
        } else {
            echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
        }
    }

    function smtp_settings() {


        $this->form_validation->set_rules('smtp_host', 'SMTP host', 'required|xss_clean');

        $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'required|xss_clean');

        $this->form_validation->set_rules('imap_host', 'IMAP host', 'required|xss_clean');

        $this->form_validation->set_rules('imap_port', 'IMAP Port', 'required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
        } else {

            if ($this->settings_model->smtp_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
    }

    function reminder_settings() {
        check_login();

        $this->form_validation->set_rules('opportunities_reminder_days', 'Opportunities Reminder', 'required|number|xss_clean');

        $this->form_validation->set_rules('contract_renewal_days', 'Contract Renewal Reminder', 'required|number|xss_clean');

        $this->form_validation->set_rules('invoice_reminder_days', 'Invoice Reminder', 'required|number|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
        } else {

            if ($this->settings_model->reminder_settings()) {
                echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
            } else {
                echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
            }
        }
    }

    function title_tags_prio_settings() {
        check_login();

        if ($this->settings_model->title_tags_prio_settings()) {
            echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>';
        } else {
            echo '<div class="alert error">' . $this->lang->line('technical_problem') . '</div>';
        }
    }

}
