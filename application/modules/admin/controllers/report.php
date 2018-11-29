<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("quotations_model");
        $this->load->model("report_model");
        $this->load->model("qtemplates_model");
        $this->load->model("customers_model");
        $this->load->model("staff_model");
        $this->load->model("salesteams_model");
        $this->load->model("opportunities_model");
        $this->load->model("system_model");
        $this->load->model("pricelists_model");
        $this->load->model("products_model");

        $this->load->model("settings_model");
        $this->load->model("leads_model");
        $this->load->model("dashboard_model");

        $this->load->library('form_validation');

        // $this->load->helper('pdf_helper');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        check_login();
    }

    function index($customer_id = null) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $this->load->view('header');
        $this->load->view('report/index', $data);
        $this->load->view('footer');
    }

    function quotation_report($customer_id = '') {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        if ($customer_id) {
            $data['report'] = $this->quotations_model->report_getfilter(userdata('id'), $customer_id);
        }
        if ($customer_id == "todays") {
            $data['title'] = "Todays Sales";
        } else if ($customer_id == "month") {
            $data['title'] = "This Month Sales";
        }
        $data['customer_id'] = $customer_id;

        $this->load->view('header');
        $this->load->view('report/quotations_report', $data);
        $this->load->view('footer');
    }

    //START LEAD REPORTS

    function lead_status() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['leads_group'] = $this->leads_model->get_count_by_group_account('lead_status_id', '', '', '');
        $data['sum_amount'] = $this->leads_model->get_sum_by_group_account('', '', '');


        $this->load->view('header');
        $this->load->view('report/lead_reports/lead_status_report', $data);
        $this->load->view('footer');
    }

    function lead_owner() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['leads_group'] = $this->leads_model->get_count_by_group_account('salesperson_id', '', '', '');


        $this->load->view('header');
        $this->load->view('report/lead_reports/lead_owner_report', $data);
        $this->load->view('footer');
    }

    function lead_industry() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['leads_group'] = $this->leads_model->get_count_by_group_account('industry_id', '', '', '');


        $this->load->view('header');
        $this->load->view('report/lead_reports/lead_industry_report', $data);
        $this->load->view('footer');
    }

    function converted_lead() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['leads_group'] = $this->leads_model->get_count_by_group_account('id', '', '', 'converted');


        $this->load->view('header');
        $this->load->view('report/lead_reports/converted_lead_report', $data);
        $this->load->view('footer');
    }

    function lead_source() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['leads_group'] = $this->leads_model->get_count_by_group_account('lead_source_id', '', '', '');


        $this->load->view('header');
        $this->load->view('report/lead_reports/lead_source_report', $data);
        $this->load->view('footer');
    }

    function today_lead() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['leads_group'] = $this->leads_model->get_list_by_group_account('', '', '', 'today');


        $this->load->view('header');
        $this->load->view('report/lead_reports/today_lead_report', $data);
        $this->load->view('footer');
    }

    //END LEAD REPORTS



    function sales_person_performance() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('salesperson_id', '', '', 'leads');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount('', '', 'leads');


        $this->load->view('header');
        $this->load->view('report/sales_person_performance_report', $data);
        $this->load->view('footer');
    }

    function sales_lead_source() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('lead_source_id', '', '', 'quotations_salesorder');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount('', '', 'quotations_salesorder');

        $this->load->view('header');
        $this->load->view('report/sales_lead_source_report', $data);
        $this->load->view('footer');
    }

    function pipeline_stages() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group_c('stages_id');
        // $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('stages_id', '', '', 'stages');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount_b();
        // $data['sum_amount'] = $this->opportunities_model->get_sum_amount('', '', 'stages');

        $this->load->view('header');
        $this->load->view('report/pipeline_stages_report', $data);
        $this->load->view('footer');
    }

    function pipeline_stages_export(){
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group_c('stages_id');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount_b();
        // $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('stages_id', '', '', 'stages');
        // $data['sum_amount'] = $this->opportunities_model->get_sum_amount('', '', 'stages');
        $data['fname'] = 'Opportunities_by_Stage_report';
        $this->load->view('report/pipeline_stages_export', $data);
    }

    function pipeline_probability() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('probability');


        $this->load->view('header');
        $this->load->view('report/pipeline_probability_report', $data);
        $this->load->view('footer');
    }

    function stage_vs_potential() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_bussines('stages_id', '', '', 'business');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount('', '', 'business');
        $data['typeone'] = $this->opportunities_model->get_sum_amount('', '', 'typeone');
        $data['typetwo'] = $this->opportunities_model->get_sum_amount('', '', 'typetwo');


        $this->load->view('header');
        $this->load->view('report/stage_vs_potential_report', $data);
        $this->load->view('footer');
    }

    function potentials_type() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('type_id');


        $this->load->view('header');
        $this->load->view('report/potentials_bytype_report', $data);
        $this->load->view('footer');
    }

    function potentials_closing() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'), 'month', '', '');


        $this->load->view('header');
        $this->load->view('report/potentials_closing_report', $data);
        $this->load->view('footer');
    }

    //ACCOUNT AND CONTACT REPORTS

    function account_industry() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['leads_group'] = $this->leads_model->get_count_by_group_account('industry_id');


        $this->load->view('header');
        $this->load->view('report/account_and_contact/account_by_industry_report', $data);
        $this->load->view('footer');
    }

    function contact_mailing() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['contacts'] = $this->customers_model->contact_mailing_list();


        $this->load->view('header');
        $this->load->view('report/account_and_contact/contact_mailling_list_report', $data);
        $this->load->view('footer');
    }

    function key_account() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('customer_id');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount('', '', 'customer');


        $this->load->view('header');
        $this->load->view('report/account_and_contact/key_account_report', $data);
        $this->load->view('footer');
    }

    function key_account_export() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group_b('customer_id');
        // $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('customer_id');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount('', '', 'customer');
        $data['fname'] = 'Opportunities_by_account_report';
        $this->load->view('report/account_and_contact/key_account_export', $data);
    }

    //END ACCOUNT AND CONTACT REPORTS
	
	
	
    //START SALES MATRICS REPORT

    function accross_owners() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data = array();
        $data['list'] = $this->report_model->get_lead_conversion_accross_owner();


        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/lead_conversion_accross_owners_report', $data);
        $this->load->view('footer');
    }

	function accross_count_owners() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data = array();
        $data['list'] = $this->report_model->get_lead_conversion_count_accross_owner();


        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/lead_conversion_count_accross_owners_report', $data);
        $this->load->view('footer');
    }
	
	function accross_industries() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data = array();
        $data['list'] = $this->report_model->get_lead_conversion_accross_industries();

        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/lead_accross_industries_report', $data);
        $this->load->view('footer');
    }
	
	

    function sales_duration_potential_type() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data = array();
        $data['list'] = $this->report_model->get_sales_duration_potential_type();

        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/sales_duration_potential_type_report', $data);
        $this->load->view('footer');
    }
	
    function sales_duration_lead_source() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data = array();
        $data['list'] = $this->report_model->get_sales_duration_lead_source();

        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/sales_duration_lead_source_report', $data);
        $this->load->view('footer');
    }
	
   
	
	function accross_source() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data = array();
        $data['list'] = $this->report_model->get_lead_conversion_accross_source();
        
        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/lead_accross_source_report', $data);
		$this->load->view('footer');
    }
	
	//END SALES METRICS REPORT

    function search_period() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $stat = $this->input->post('status');
        $min = $this->input->post('min');
        $max = $this->input->post('max');


        if ($stat == 'probability') {

            $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('probability', $min, $max);
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/table_probability', $data);
        } else if ($stat == 'type') {

            $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('type_id', $min, $max);
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/table_potentials_type', $data);
        } else if ($stat == 'closing') {

            $data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'), '', $min, $max);
            $this->load->view('report/table_potentials_closing', $data);
        } else if ($stat == 'stages') {

            $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('stages_id', $min, $max, 'stages');
            $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'stages');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/table_potentials_stages', $data);
        } else if ($stat == 'lead_source') {

            $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('lead_source_id', $min, $max, 'quotations_salesorder');
            $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'quotations_salesorder');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/table_sales_lead_source', $data);
        } else if ($stat == 'sales_person_performance') {

            $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('salesperson_id', $min, $max, 'leads');
            $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'leads');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/table_sales_person_performance', $data);
        } else if ($stat == 'account_industry') {

            $data['leads_group'] = $this->leads_model->get_count_by_group_account('industry_id', $min, $max);
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/account_and_contact/table_account_by_industry', $data);
        } else if ($stat == 'contact_mailing') {

            $data['contacts'] = $this->customers_model->contact_mailing_list($min, $max);
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/account_and_contact/table_contact_mailling_list', $data);
        } else if ($stat == 'key_account') {

            $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('customer_id', $min, $max, 'customer');
            $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'customer');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/account_and_contact/table_key_account', $data);
        } else if ($stat == 'converted_lead') {

            $data['leads_group'] = $this->leads_model->get_count_by_group_account('id', $min, $max, 'converted');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/lead_reports/table_converted_lead', $data);
        } else if ($stat == 'lead_industry') {

            $data['leads_group'] = $this->leads_model->get_count_by_group_account('industry_id', $min, $max, '');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/lead_reports/table_lead_industry', $data);
        } else if ($stat == 'lead_by_source') {

            $data['leads_group'] = $this->leads_model->get_count_by_group_account('lead_source_id', $min, $max, '');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/lead_reports/table_lead_source', $data);
        } else if ($stat == 'today_lead') {

            $data['leads_group'] = $this->leads_model->get_list_by_group_account('', $min, $max, '');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/lead_reports/table_today_lead', $data);
        } else if ($stat == 'lead_owner') {
            $data['leads_group'] = $this->leads_model->get_count_by_group_account('salesperson_id', $min, $max, '');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/lead_reports/table_lead_owner', $data);
        } else if ($stat == 'lead_status') {
            $data['leads_group'] = $this->leads_model->get_count_by_group_account('lead_status_id', $min, $max, '');
            $data['sum_amount'] = $this->leads_model->get_sum_by_group_account($min, $max, '');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/lead_reports/table_lead_status', $data);
        } else if ($stat == 'stage_potential') {

            $data['opportunities_group'] = $this->opportunities_model->get_count_by_bussines('stages_id', $min, $max, 'business');
            $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'business');
            $data['typeone'] = $this->opportunities_model->get_sum_amount($min, $max, 'typeone');
            $data['typetwo'] = $this->opportunities_model->get_sum_amount($min, $max, 'typetwo');
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/table_stage_vs_potential', $data);
        } else if ($stat == 'sales_duration_lead_source') {

			$data = array();
			$data['list'] = $this->report_model->get_sales_duration_lead_source($min,$max);
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/sales_metrics_reports/table_sales_duration_lead_source', $data);
        } else if ($stat == 'sales_duration_potential_type') {

			$data = array();
			$data['list'] = $this->report_model->get_sales_duration_potential_type($min,$max);
            $data['min'] = $min;
            $data['max'] = $max;

            $this->load->view('report/sales_metrics_reports/table_sales_duration_potential_type', $data);
        } else if ($stat == 'accross_source') {

            $data = array();
			$data['list'] = $this->report_model->get_lead_conversion_accross_source($min, $max);
			$data['min'] = $min;
            $data['max'] = $max;
			
			$this->load->view('report/sales_metrics_reports/table_lead_accross_source', $data);
		} else if ($stat == 'accross_industries') {

            $data = array();
			$data['list'] = $this->report_model->get_lead_conversion_accross_industries($min, $max);
			$data['min'] = $min;
            $data['max'] = $max;
			
			$this->load->view('report/sales_metrics_reports/table_lead_accross_industries', $data);
		}else if ($stat == 'accross_owner') {

            $data = array();
			$data['list'] = $this->report_model->get_lead_conversion_accross_owner($min, $max);
			$data['min'] = $min;
            $data['max'] = $max;
			
			$this->load->view('report/sales_metrics_reports/table_lead_conversion_accross_owners', $data);
		}else if ($stat == 'accross_count_owner') {

            $data = array();
			$data['list'] = $this->report_model->get_lead_conversion_count_accross_owner($min, $max);
			$data['min'] = $min;
            $data['max'] = $max;
			
			$this->load->view('report/sales_metrics_reports/table_lead_conversion_count_accross_owners', $data);
		}

    }

    function get_filter() {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $quotation = $this->input->post("type");
        if ($quotation) {
            $data['report'] = $this->quotations_model->report_getfilter(userdata('id'), $quotation);
        }

        $this->load->view('report/quotation_data', $data);
    }

    function view($quotation_id) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['quotation'] = $this->quotations_model->get_quotation($quotation_id);

        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['qo_products'] = $this->quotations_model->quot_order_products($quotation_id);

        $this->load->view('header');
        $this->load->view('quotations/view', $data);
        $this->load->view('footer');
    }

    function ajax_qtemplates_products($qtemplate_id, $pricelist_id) {
        $data['qtemplate_products'] = $this->qtemplates_model->qtemplate_products($qtemplate_id);

        $data['pricelist_version'] = $this->report_model->get_pricelist_version_by_pricelist_id($pricelist_id);


        $this->load->view('report/ajax_qtemplates_products', $data);
    }

    //START LEAD REPORTS PRINT

    function print_lead_status($min, $lead, $max) {

        $data['leads_group'] = $this->leads_model->get_count_by_group_account('lead_status_id', $min, $max, '');
        $data['sum_amount'] = $this->leads_model->get_sum_by_group_account($min, $max, '');
        $data['min'] = $min;
        $data['max'] = $max;
        $data['title'] = "Leads by Status";
		$data['setting'] = $this->settings_model->get_settings();

        $this->load->view('report/lead_reports/lead_status_print', $data);
    }

    function print_lead_owner($min, $lead, $max) {

        $data['leads_group'] = $this->leads_model->get_count_by_group_account('salesperson_id', $min, $max, '');
        $data['min'] = $min;
        $data['max'] = $max;
        $data['title'] = "Leads by Ownership";
		$data['setting'] = $this->settings_model->get_settings();
		
        $this->load->view('report/lead_reports/lead_owner_print', $data);
    }

    function print_lead_industry($min, $lead, $max) {

        $data['leads_group'] = $this->leads_model->get_count_by_group_account('industry_id', $min, $max, '');
        $data['min'] = $min;
        $data['max'] = $max;
        $data['title'] = "Leads by Industry";
		$data['setting'] = $this->settings_model->get_settings();
		
        $this->load->view('report/lead_reports/lead_industry_print', $data);
    }

    function print_converted_lead($min, $lead, $max) {

        $data['leads_group'] = $this->leads_model->get_count_by_group_account('id', $min, $max, 'converted');
        $data['min'] = $min;
        $data['max'] = $max;
        $data['title'] = "Leads by Industry";
		$data['setting'] = $this->settings_model->get_settings();
		
	
        $this->load->view('report/lead_reports/converted_lead_print', $data);
    }

    function print_lead_source($min, $lead, $max) {

        $data['leads_group'] = $this->leads_model->get_count_by_group_account('lead_source_id', $min, $max, '');
        $data['min'] = $min;
        $data['max'] = $max;
        $data['title'] = "Leads by Source";
		$data['setting'] = $this->settings_model->get_settings();
		
        $this->load->view('report/lead_reports/lead_source_print', $data);
    }

    function print_today_lead($min, $lead, $max) {
        if ($min && $max) {
            $data['leads_group'] = $this->leads_model->get_list_by_group_account('', $min, $max, '');
            $data['title'] = "Custom Leads";
        } else {
            $data['leads_group'] = $this->leads_model->get_list_by_group_account('', '', '', 'today');
            $data['title'] = "Todays Leads";
        }
		$data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;


        $this->load->view('report/lead_reports/today_lead_print', $data);
    }

    //END LEAD REPORTS PRINT


	//START SALES METRICS REPORTS PRINT
	
	function accross_industries_print($min, $lead, $max) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data = array();
        $data['list'] = $this->report_model->get_lead_conversion_accross_industries($min,$max);
        $data['min'] = $min;
        $data['max'] = $max;
		$data['setting'] = $this->settings_model->get_settings();
		$data['title'] = "Lead Conversion Accross Industries";
       
		
        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/lead_accross_industries_print', $data);
		$this->load->view('footer');
    }
	
	function accross_source_print($min, $lead, $max) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data = array();
        $data['list'] = $this->report_model->get_lead_conversion_accross_source($min,$max);
        $data['min'] = $min;
        $data['max'] = $max;
		$data['setting'] = $this->settings_model->get_settings();
		$data['title'] = "Lead Conversion Accross Source";
       
		
        $this->load->view('header');
        $this->load->view('report/sales_metrics_reports/lead_accross_source_print', $data);
		$this->load->view('footer');
    }
	
	function print_sales_duration_lead_source($min, $lead, $max) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
		
		$data = array();
		$data['list'] = $this->report_model->get_sales_duration_lead_source($min,$max);
		$data['min'] = $min;
		$data['max'] = $max;
		$data['setting'] = $this->settings_model->get_settings();
		$data['title'] = "Overall Sales Duration across Lead Sources";
       
        $this->load->view('report/sales_metrics_reports/sales_duration_lead_source_print', $data);
    }
	

	function print_lead_conversion_accross_owner($min, $lead, $max) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
		
		$data = array();
		$data['list'] = $this->report_model->get_lead_conversion_accross_owner($min,$max);
		$data['min'] = $min;
		$data['max'] = $max;
		$data['setting'] = $this->settings_model->get_settings();
		$data['title'] = "Lead Conversion Accross Owner";
       
        $this->load->view('report/sales_metrics_reports/lead_conversion_accross_owner_print', $data);
    }
	
	function print_lead_conversion_count_accross_owner($min, $lead, $max) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
		
		$data = array();
		$data['list'] = $this->report_model->get_lead_conversion_count_accross_owner($min, $max);
		$data['min'] = $min;
		$data['max'] = $max;
		$data['setting'] = $this->settings_model->get_settings();
		$data['title'] = "Lead Conversion Count Accross Owner";
       
        $this->load->view('report/sales_metrics_reports/lead_conversion_count_accross_owner_print', $data);
    }

	function print_sales_duration_potential_type($min, $lead, $max) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
		
		$data = array();
		$data['list'] = $this->report_model->get_sales_duration_potential_type($min,$max);
		$data['min'] = $min;
		$data['max'] = $max;
		$data['setting'] = $this->settings_model->get_settings();
		$data['title'] = "Overall Sales Duration across Potential Type";
       
        $this->load->view('report/sales_metrics_reports/sales_duration_potential_type_print', $data);
    }
	

	//END SALES METRICS REPORTS PRINT

    function print_sales_person_performance($min, $potensial, $max) {

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('salesperson_id', $min, $max, 'leads');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'leads');
        $data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;
        $data['title'] = "Sales Person's Performance Report";

        $this->load->view('report/sales_person_performance_print', $data);
    }

    function print_sales_lead_source($min, $potensial, $max) {

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('lead_source_id', $min, $max, 'quotations_salesorder');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'quotations_salesorder');
        $data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;
        $data['title'] = "Sales by Lead Source Report";

        $this->load->view('report/sales_lead_source_print', $data);
    }

    function print_stages($min, $potensial, $max) {

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('stages_id', $min, $max, 'stages');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'stages');
        $data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;

        $data['title'] = "Pipeline by Stage Report";
        $this->load->view('report/stages_print', $data);
    }

    function print_key_account($min, $potensial, $max) {

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('customer_id', $min, $max, 'customer');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'customer');
        $data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;

        $data['title'] = "Key Accounts Report";
        $this->load->view('report/account_and_contact/key_account_print', $data);
    }

    function print_probability($min, $potensial, $max) {

        $data['setting'] = $this->settings_model->get_settings();
        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('probability', $min, $max);
        $data['min'] = $min;
        $data['max'] = $max;

        $data['title'] = "Pipeline Probality Report";
        $this->load->view('report/probability_print', $data);
    }

    function print_stage_potentila($min, $potensial, $max) {

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_bussines('stages_id', $min, $max, 'business');
        $data['sum_amount'] = $this->opportunities_model->get_sum_amount($min, $max, 'business');
        $data['typeone'] = $this->opportunities_model->get_sum_amount($min, $max, 'typeone');
        $data['typetwo'] = $this->opportunities_model->get_sum_amount($min, $max, 'typetwo');
        $data['setting'] = $this->settings_model->get_settings();

        $data['min'] = $min;
        $data['max'] = $max;

        $data['title'] = "Stage Vs Potentials Report";
        $this->load->view('report/stage_vs_potential_print', $data);
    }

    function print_potentials_type($min, $potensial, $max) {

        $data['opportunities_group'] = $this->opportunities_model->get_count_by_group('type_id', $min, $max);
        $data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;

        $data['title'] = "Potentials by Type Report";
        $this->load->view('report/potentials_type_print', $data);
    }

    function print_account_industry($min, $potensial, $max) {

        $data['leads_group'] = $this->leads_model->get_count_by_group_account('industry_id', $min, $max);
        $data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;

        $data['title'] = "Account by Industry Report";
        $this->load->view('report/account_and_contact/account_by_industry_print', $data);
    }

    function print_contact_mailing($min, $potensial, $max) {

        $data['contacts'] = $this->customers_model->contact_mailing_list($min, $max);
        $data['setting'] = $this->settings_model->get_settings();
        $data['min'] = $min;
        $data['max'] = $max;

        $data['title'] = "Contact Mailing List Report";
        $this->load->view('report/account_and_contact/contact_mailling_list_print', $data);
    }

    function print_potentials_closing($min, $potensial, $max) {
        if ($min && $max) {
            $data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'), $potensial, $min, $max);
        } else {
            $data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'), 'month', $min, $max);
        }
        $data['setting'] = $this->settings_model->get_settings();

        $data['title'] = "Potentials Closing by this Month Report";
        $this->load->view('report/potentials_closing_print', $data);
    }

    function print_quot($quotation) {
        // $data['quotation'] = $this->report_model->get_quotation($quotation_id);
        // $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();
        // $data['companies'] = $this->customers_model->company_list();
        // $data['staffs'] = $this->staff_model->staff_list(); 
        // $data['pricelists'] = $this->pricelists_model->pricelists_list(); 
        // $data['qo_products'] = $this->quotations_model->quot_order_products($quotation_id);   		
        if ($quotation) {
            $data['report'] = $this->quotations_model->report_getfilter(userdata('id'), $quotation);
            $data['setting'] = $this->settings_model->get_settings();
        }
        if ($quotation == "todays") {
            $data['title'] = "Todays Sales Report";
        } else if ($quotation == "month") {
            $data['title'] = "This Month Sales Report";
        }

        $this->load->view('report/quotation_print', $data);
    }

    function ajax_create_pdf($quotation_id) {


        $data['quotation'] = $this->report_model->get_quotation($quotation_id);

        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['qo_products'] = $this->quotations_model->quot_order_products($quotation_id);

        $html = $this->load->view('report/ajax_create_pdf', $data, true);

        $filename = 'Quotation-' . $data['quotation']->quotations_number;

        $pdfFilePath = FCPATH . "/pdfs/" . $filename . ".pdf";


        $mpdf = new mPDF('c', 'A4', '', '', 20, 15, 48, 25, 10, 10);
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Acme Trading Co. - Invoice");
        $mpdf->SetAuthor("Acme Trading Co.");
        $mpdf->SetWatermarkText($data['quotation']->payment_term);
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);

        $mpdf->Output($pdfFilePath, 'F');

        echo base_url() . "pdfs/" . $filename . ".pdf";

        exit;
    }

    function send_quotation() {
        $this->load->helper('template');

        $quotation_id = $this->input->post('quotation_id');
        $email_subject = $this->input->post('email_subject');
        $to = implode(',', $this->input->post('recipients'));

        $email_body = $this->input->post('message_body');

        $message_body = parse_template($email_body);

        $quotation_pdf = $this->input->post('quotation_pdf');

        if (send_email($email_subject, $to, $message_body, $quotation_pdf)) {
            echo "success";
        } else {
            echo "not sent";
        }
    }

    /*
     * confirm sale*  
     */

    function confirm_sale($quotation_id) {
        if ($this->quotations_model->confirm_sales_order($quotation_id)) {
            redirect('admin/salesorder/update/' . $quotation_id);
        }
    }

    /*
     * deletes product     *  
     */

    function delete_qo_product($product_id) {
        if ($this->quotations_model->delete_qo_product($product_id)) {
            echo 'deleted';
        }
    }

    function ajax_get_products_price($product_id, $pricelist_id) {
        $data['products_price'] = $this->quotations_model->get_product_price($product_id, $pricelist_id);

        echo $data['products_price']->special_price;
        exit;
    }

    function ajax_get_quotation_template_duration($qtemplate_id) {
        $data['quotation_template'] = $this->qtemplates_model->get_qtemplate($qtemplate_id);

        $exp_date = date('m/d/Y', strtotime("+" . $data['quotation_template']->quotation_duration . " days"));

        echo $exp_date;
        exit;
    }

    // function get_lead_conversion_accross_industries() {
        // $data = array();
        // $data['list'] = $this->report_model->get_lead_conversion_accross_industries();
        // $this->load->view('report/sales_metrics_reports/lead_conversion_accross_industries_report', $data);
    // }

}
