<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign extends CI_Controller {

    function Campaign() 
    {
         parent::__construct();
		 $this->load->database();
		 $this->load->model("campaign_model");
		 $this->load->model("staff_model");
		    
         $this->load->library('form_validation');
         
         /*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         
         check_login();  
    }

	function index($campaign_id='')
	{
				//checking permission for staff
			if (!check_staff_permission('campaign_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
		    	// $data['salesteams'] = $this->campaign_model->salesteams_list();
				$data['campaign'] = $this->campaign_model->campaign_list($campaign_id);
		    			    	 
				$this->load->view('header');
				$this->load->view('campaign/index',$data);
				$this->load->view('footer');
			 
	}
	function add()
	{
				//checking permission for staff
			if (!check_staff_permission('campaign_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
		    	$data['staffs'] = $this->staff_model->staff_list();
		    	$data['type'] = $this->campaign_model->system_list_category('CAMPAIGN_TYPE');
		    	$data['status'] = $this->campaign_model->system_list_category('CAMPAIGN_STS');
		    	$data['sources'] = $this->campaign_model->system_list_category('CAMPAIGN_SOURCE');
		    	$data['campaign'] = $this->campaign_model->get_campaign('');
				$data['title'] = "Add Campaign Management";
				$data['submit'] = "Create";
		    	
				$this->load->view('header');
				$this->load->view('campaign/update',$data);
				$this->load->view('footer');
			 
	}
	
	function view($salesteam_id)
	{
		    	//checking permission for staff
			if (!check_staff_permission('campaign_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			  
				$data['opportunity'] = $this->campaign_model->get_salesteam( $salesteam_id );	 
		    	 
				$this->load->view('header');
				$this->load->view('campaign/view',$data);
				$this->load->view('footer');
			 
	}
	
	function update($campaign_id)
	{
				//checking permission for staff
			if (!check_staff_permission('campaign_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
				$data['staffs'] = $this->staff_model->staff_list();
		    	$data['type'] = $this->campaign_model->system_list_category('CAMPAIGN_TYPE');
		    	$data['status'] = $this->campaign_model->system_list_category('CAMPAIGN_STS');
				$data['sources'] = $this->campaign_model->system_list_category('CAMPAIGN_SOURCE');
		    	$data['campaign'] = $this->campaign_model->get_campaign( $campaign_id );	 
				$data['title'] = "Update Campaign Management";
				$data['submit'] = "Update";
				 
				$this->load->view('header');
				$this->load->view('campaign/update',$data);
				$this->load->view('footer');
			 
	}
	
	function save()
	{
		//checking permission for staff
			if (!check_staff_permission('campaign_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
		$id = $this->input->post('campaign_id');
		
		$this->form_validation->set_rules('campaign_owner', 'Campaign Owner', 'required');
		$this->form_validation->set_rules('campaign_type', 'Type', 'required');
		$this->form_validation->set_rules('campaign_name', 'Campaign Name', 'required');
		$this->form_validation->set_rules('campaign_sts', 'Status', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required'); 
		$this->form_validation->set_rules('end_date', 'End Date', 'required'); 
		$this->form_validation->set_rules('expected_revenue', 'Expected Revenue', 'required'); 
		$this->form_validation->set_rules('budgeted_cost', 'Budgeted Cost', 'required'); 
		$this->form_validation->set_rules('actual_cost', 'Actual Cost', 'required'); 
		$this->form_validation->set_rules('expected_response', 'Expected Response', 'required'); 
		$this->form_validation->set_rules('num_sent', 'Num Sent', 'required'); 
		$this->form_validation->set_rules('description_information', 'Description Information', 'required'); 
		
		if( $this->form_validation->run() == FALSE )
        {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">','</li>') . '</ul></div>';
        }
        else
        {
        
			if( $id ){

				if( $this->campaign_model->update_campaign() )
				{
					$campaign_id = $this->input->post('campaign_id');

                    echo 'yes_' . $campaign_id . '_update';}
				else
				{
					echo $this->lang->line('technical_problem');
				}
				
			}else{
				
				if( $this->campaign_model->add_campaign())
				{ 
				$campaign_id = $this->db->insert_id();
				echo 'yes_' . $campaign_id . '_add';
				
				}else
				{
					echo $this->lang->line('technical_problem');
				}
				
			}
        }
	}
	
	/*
     * deletes opportunity     *  
     */
	function delete( $campaign_id )
	{
		//checking permission for staff
			if (!check_staff_permission('campaign_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}  
		 
		if( $this->campaign_model->delete($campaign_id) )
		{
			echo 'deleted';
		}
		
	}	
	 
	 
}
