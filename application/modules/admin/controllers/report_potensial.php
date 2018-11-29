<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_potensial extends CI_Controller {

    function Report_potensial() 
    {
         parent::__construct();
		 $this->load->database();		 
		 $this->load->model("opportunities_model");
		 $this->load->model("system_model");
		 $this->load->model("customers_model");
		 $this->load->model("staff_model");
		 $this->load->model("settings_model");
		 
		 $this->load->model("dashboard_model");
		 
         $this->load->library('form_validation');
         
         $this->load->helper('pdf_helper');  
         
         /*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         
         check_login(); 
    }

	function index($potensial='')
	{
				//checking permission for staff
			if (!check_staff_permission('opportunities_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			} 
			if($potensial){
				$data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'),$potensial,'','');
			}
			
			if ( $potensial == "open"){
				$data['title'] = "Open Potential";
			}else if ( $potensial == "lost"){
				$data['title'] = "Lost Potential";
			}
			$data['potensial'] = $potensial;
			
				$this->load->view('header');
				$this->load->view('report_potensial/index',$data);
				$this->load->view('footer');
			 
	}
	
	function get_filter()
	{
				//checking permission for staff
			if (!check_staff_permission('opportunities_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			} 
			$potensial = $this->input->post('type');
			$min = $this->input->post('min');
			$max = $this->input->post('max');
			
			if ( $potensial ){
				$data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'),$potensial,$min,$max);
			}
			
				$this->load->view('report_potensial/table',$data);
			 
	}
   	
   	function print_quot( $min, $potensial, $max)
	{
		if ( $potensial ){
			if ($min=="-" && $max=="-"){
				$data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'),$potensial,'','');
			}else{
				$data['opportunities'] = $this->opportunities_model->opportunities_getfilter(userdata('id'),$potensial,$min,$max);
			}
		}
		$data['setting'] = $this->settings_model->get_settings();
		
		
		if ( $potensial == "open"){
			$data['title'] = "Open Potential";
		}else if ( $potensial == "lost"){
			$data['title'] = "Lost Potential";
		}
		
		$this->load->view('report_potensial/report_potensial_print',$data);
				
	}
	
}
