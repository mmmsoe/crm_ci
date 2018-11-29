<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() 
    {
         parent::__construct();
		 $this->load->database();
		 $this->load->model("dashboard_model");
		 $this->load->model("invoices_model");
		 $this->load->model("staff_model");
	     $this->load->model("system_model");
         $this->load->library('form_validation');
         
         
        /*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         
        check_login();  
    }

	function index()
	{
    	$data['salesteams']=$this->dashboard_model->total_salesteams();
    	$data['leads']=$this->dashboard_model->total_leads();		    	
    	$data['opportunities']=$this->dashboard_model->total_opportunities();
    	$data['products']=$this->dashboard_model->total_products();	
    	$data['quotations']=$this->dashboard_model->total_quotations();
    	$data['salesorders']=$this->dashboard_model->total_salesorders();
    	$data['calls']=$this->dashboard_model->total_calls();
    	$data['customers']=$this->dashboard_model->total_customers();
    	$data['meetings']=$this->dashboard_model->total_meetings();    
    	//$data['emails']=$this->dashboard_model->total_email();
    	$data['contracts']=$this->dashboard_model->total_contracts();
		
        $data['dis_leads']=$this->dashboard_model->count_leads();
		// $data['dis_leads']=$this->dashboard_model->dis_leads();
		$data['dis_customers']=$this->dashboard_model->dis_customers(userdata('id'));
		//MM
        $data['dis_opportunities']=$this->dashboard_model->count_opportunities();
        $data['dis_opportunities_qualification']=$this->dashboard_model->count_opportunities_qualification();
        $data['dis_opportunities_analysis']=$this->dashboard_model->count_opportunities_analysis();
        $data['dis_opportunities_demo']=$this->dashboard_model->count_opportunities_demo();
        $data['dis_opportunities_proposal']=$this->dashboard_model->count_opportunities_proposal();
        $data['dis_opportunities_negotiation']=$this->dashboard_model->count_opportunities_negotiation();
        $data['dis_opportunities_close']=$this->dashboard_model->count_opportunities_close();
        $data['dis_opportunities_won']=$this->dashboard_model->count_opportunities_won();
        $data['dis_opportunities_lost']=$this->dashboard_model->count_opportunities_lost();
        $data['dis_opportunities_deferred']=$this->dashboard_model->count_opportunities_deferred();
        //MM
    	// $data['dis_opportunities']=$this->dashboard_model->dis_opportunities();
        $data['dis_quotations']=$this->dashboard_model->count_quotations();
    	// $data['dis_quotations']=$this->dashboard_model->dis_quotations();
        $data['dis_salesorders']=$this->dashboard_model->count_quot_salesorders(); 
		// $data['dis_salesorders']=$this->dashboard_model->dis_salesorders();	
    		
    	/*Invoicing Details*/
    	$data['open_invoice_total'] = $this->invoices_model->open_invoices_total_collection();
		    	
    	$data['overdue_invoices_total'] = $this->invoices_model->overdue_invoices_total_collection();
    	
    	$data['paid_invoices_total'] = $this->invoices_model->paid_invoices_total_collection();
    	
    	$data['invoices_total_collection'] = $this->invoices_model->invoices_total_collection();
    	
    	/*SALES STATISTICS*/
    	$data['sales_today_total'] = $this->dashboard_model->sales_today_total();
    	
    	$data['sales_yesterday_total'] = $this->dashboard_model->sales_yesterday_total();
    	
    	$data['sales_this_week_total'] = $this->dashboard_model->sales_this_week_total();
    	
    	$data['sales_this_month_total'] = $this->dashboard_model->sales_this_month_total();
    	
    	$data['top_selling_team'] = $this->dashboard_model->top_selling_team();
    	
        // $data['salesteams_performance_list'] = $this->dashboard_model->salesteams_performance_list();
        $data['opportunities_sumary'] = $this->dashboard_model->count_opportunities_stages();
        // $data['opportunities_sumary'] = $this->dashboard_model->opportunities_sumary();
        $data['opportunities_owner'] = $this->dashboard_model->opportunities_by_owner();
        $data['opportunities_salesperson'] = $this->dashboard_model->opportunities_by_salesperson_b();
    	// $data['opportunities_salesperson'] = $this->dashboard_model->opportunities_by_salesperson();
    	
    	/*LIST*/
    	
    	$salesteam_id = $this->dashboard_model->get_staff_salesteam(userdata('id'));
    	
    	$data['staff_leads_list'] = $this->dashboard_model->staff_leads_list(userdata('id'));  	  
    	
    	$data['staff_leads_by_team'] = $this->dashboard_model->staff_leads_by_team($salesteam_id);
    	
    	$data['staff_opportunities_list'] = $this->dashboard_model->staff_opportunities_list(userdata('id'));  	  
    	
    	$data['staff_opportunities_by_team'] = $this->dashboard_model->staff_opportunities_by_team($salesteam_id);
    
    	$data['staff_call_log_list'] = $this->dashboard_model->staff_call_log_list(userdata('id'));
    	
    	$data['staff_contracts_list'] = $this->dashboard_model->staff_contracts_list(userdata('id'));  	  
    
    	$data['staff_quotations_list'] = $this->dashboard_model->staff_quotations_list(userdata('id'));  	  
    	
    	$data['staff_quotations_by_team'] = $this->dashboard_model->staff_quotations_by_team($salesteam_id);
    	
    	$data['staff_invoices_list'] = $this->dashboard_model->staff_invoices_list(userdata('id'));  	  
    	
    	$data['staff_invoices_by_team'] = $this->dashboard_model->staff_invoices_by_team($salesteam_id);
    	
    	/*EVENTS*/
    	$data['staff_leads_event_list'] = $this->dashboard_model->staff_leads_event_list(userdata('id'));
    	$data['staff_company_event_list'] = $this->dashboard_model->staff_company_event_list(userdata('id'));
    	
    	$data['staff_opportunities_event_list'] = $this->dashboard_model->staff_opportunities_event_list(userdata('id'));
		
    	$data['staff_quotations_event_list'] = $this->dashboard_model->staff_quotations_event_list(userdata('id'), 'q');
    	$data['staff_salesorder_event_list'] = $this->dashboard_model->staff_quotations_event_list(userdata('id'), 'o');
    	
    	$data['staff_logged_call_event_list'] = $this->dashboard_model->staff_logged_call_event_list(userdata('id'));
    	
    	$data['staff_meetings_event_list'] = $this->dashboard_model->staff_meetings_event_list(userdata('id'));
    	$data['staff_contracts_event_list'] = $this->dashboard_model->staff_contracts_event_list(userdata('id'));

        $data['quotation_summary'] = $this->dashboard_model->quotation_summary();
        $data['quotation_summary_by_owner'] = $this->dashboard_model->quotation_summary_by_owner();
    	
		$this->load->view('header');			 
		$this->load->view('dashboard/index',$data);
		$this->load->view('footer');	
			  
	}
	
	/*
     * delete notification     *  
     */
	function delete_notification( $notification_id)
	{
		 
			if( $this->dashboard_model->delete_notification($notification_id) )
			{
				echo 'deleted';
			}
		
	}

    function view_list_opportunities(){
        $year = null;
        $closed_status = null;

        if ($this->input->post('year')){
            $year = $this->input->post('year');
        }
        
        if ($this->input->post('closed_status')){
            $closed_status = $this->input->post('closed_status');
        }

        $data['opportunities_salesperson'] = $this->dashboard_model->opportunities_by_salespersons($year, $closed_status);
        // echo $data['opportunities_salesperson'];
        $this->load->view('dashboard/data_list', $data);
    }
}
