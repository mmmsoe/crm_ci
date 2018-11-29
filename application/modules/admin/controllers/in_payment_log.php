<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class In_payment_log extends CI_Controller {

    function In_payment_log() 
    {
         parent::__construct();
		 $this->load->database();		 
		 $this->load->model("invoices_payment_log_model");		 
		 $this->load->model("staff_model");
		 $this->load->model("invoices_model");
		  
		 $this->load->library('form_validation');
         
         $this->load->helper('pdf_helper');  
         
         /*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         
         check_login(); 
    }

	function index()
	{
            if (!check_staff_permission('payment_log_read')) {
                redirect(base_url('admin/access_denied'), 'refresh');
            }    	 
    	$data['invoice_payments'] = $this->invoices_payment_log_model->invoice_payments_log();
    	    	 
    	    	 
		$this->load->view('header');
		$this->load->view('payment_log/index',$data);
		$this->load->view('footer');
	 
	}
	
	/*
     * deletes invoice payment log    *  
     */
	function delete( $payment_id )
	{
		 
			if( $this->invoices_payment_log_model->delete($payment_id) )
			{
				echo 'deleted';
			}
		
	} 
}
