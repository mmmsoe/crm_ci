<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

    function Contact() 
    {	
         parent::__construct();
		 $this->load->database();
		 $this->load->model("leads_model");
		 $this->load->model("contact_group_model");
		 $this->load->model("customers_model");
		 $this->load->model("staff_model");
		 $this->load->model("salesteams_model");		  
         $this->load->model("calls_model");          
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
			//checking permission for staff
			if (!check_staff_permission('lead_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
			
				$data['contact'] = $this->contact_group_model->contact_list();
		    			    	 
				$this->load->view('header');
				$this->load->view('contact/index',$data);
				$this->load->view('footer');
			 
	}
	function add()
	{
				//checking permission for staff
				if (!check_staff_permission('lead_write'))	
				{
				    redirect(base_url('admin/access_denied'), 'refresh');  
				} 
			 
		    	$data['owner'] = $this->contact_group_model->sys_account_list('ACC_OWNER');
		    	$data['leads'] = $this->contact_group_model->sys_account_list('LEAD');
		    	 
				$this->load->view('header');
				$this->load->view('contact/add',$data	);
				$this->load->view('footer');
			 
	}
	function add_process()
	{
			  
		//checking permission for staff
			if (!check_staff_permission('accounts_write'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
		  
			$this->form_validation->set_rules('contact_owner', 'Contact Owner', 'required');
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		// $this->form_validation->set_rules('parent_account', 'Parent Account', 'required');
		// $this->form_validation->set_rules('account_number', 'Account Number', 'required'); 
		// $this->form_validation->set_rules('account_type', 'Account Type', 'required');
			 
		
		if( $this->form_validation->run() == FALSE )
        {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">','</li>') . '</ul></div>';
        }         
        else
        {
            
            if( $this->contact_group_model->add_contact())
            { 
                echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>';
            }
            else
            {
                echo $this->lang->line('technical_problem');
            }
        }
			 
	}
	function view($lead_id)
	{
				//checking permission for staff
				if (!check_staff_permission('lead_read'))	
		 		{
					redirect(base_url('admin/access_denied'), 'refresh');  
		 		} 
				 
				
		    	$data['companies'] = $this->customers_model->company_list();
		    	$data['staffs'] = $this->staff_model->staff_list();		    			    	
		    	$data['calls'] = $this->calls_model->calls_list($lead_id,$type='leads'); 
		    	$data['salesteams'] = $this->salesteams_model->salesteams_list(); 
		    	  
				$data['lead'] = $this->leads_model->get_lead( $lead_id,userdata('id') );	 
		    	 
				$this->load->view('header');
				$this->load->view('leads/view',$data);
				$this->load->view('footer');
			 
	}
	
	
	function update($contact_id)
	{
				//checking permission for staff
			if (!check_staff_permission('accounts_write'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
				
		    	$data['owner'] = $this->contact_group_model->sys_account_list('ACC_OWNER');
		    	$data['leads'] = $this->contact_group_model->sys_account_list('LEAD');
		    	  
		    	$data['contact'] = $this->contact_group_model->get_contact( $contact_id );	 
		    	 
				$this->load->view('header');
				$this->load->view('contact/update',$data);
				$this->load->view('footer');
			 
	}
	
	function update_process()
	{
		//checking permission for staff
		 if (!check_staff_permission('lead_write'))	
	 		{
				redirect(base_url('admin/access_denied'), 'refresh');  
	 		}   
		
		$this->form_validation->set_rules('opportunity', 'Opportunity', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|htmlspecialchars|max_length[50]|valid_email');
		 
		$this->form_validation->set_rules('sales_team_id', 'Sales Team', 'required');
		
		if( $this->form_validation->run() == FALSE )
        {
            echo '<div class="alert alert-danger"><ul>' . validation_errors('<li>','</li>') . '</ul></div>';
        }
        else
        {
            
            if( $this->leads_model->update_leads() )
            {
                echo '<div class="alert alert-success">'.$this->lang->line('update_succesful').'</div>';
            }
            else
            {
                echo $this->lang->line('technical_problem');
            }
        }
	}
	
	/*
     * deletes lead     *  
     */
	function delete( $lead_id )
	{
		//checking permission for staff
		 if (!check_staff_permission('lead_delete'))	
	 		{
				redirect(base_url('admin/access_denied'), 'refresh');  
	 		} 	
	 			 
			if( $this->leads_model->delete($lead_id) )
			{
				echo 'deleted';
			}
		
	}
	
	function ajax_state_list($country_id)
    {	
    	$data['state'] = $this->leads_model->state_list($country_id);    	 
        $this->load->view('ajax_get_state',$data);
    	
   	}
   	function ajax_city_list($state_id)
    {	
    	$data['cities'] = $this->leads_model->city_list($state_id);    	 
        $this->load->view('ajax_get_city',$data);
    	
   	}
   	
   	
   	//Add Call
   	function add_call()
	{
		    
		$this->form_validation->set_rules('date', 'Date', 'required');
		
		$this->form_validation->set_rules('call_summary', 'Call Summary', 'required');
		 
		
		if( $this->form_validation->run() == FALSE )
        {
            echo '<div style="color:red;margin-left:15px;">' . validation_errors() . '</div>';
        }
        else
        {
            
            if( $this->calls_model->add_calls())
            { 
            	echo 'yes';
                //echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>';
            }
            else
            {
                echo $this->lang->line('technical_problem');
            }
        }
			 
	}
	
	/*
     * deletes call     *  
     */
	function call_delete( $call_id )
	{
		check_login();  
		 
			if( $this->calls_model->delete($call_id) )
			{
				echo 'deleted';
			}
		
	}
	
	
    function edit_call($call_id)
    {	
    	$data['companies'] = $this->customers_model->company_list();
				
		$data['staffs'] = $this->staff_model->staff_list(); 
	
    	$data['call'] = $this->calls_model->get_call( $call_id );	    	 
     
     	 
     	 
     	$this->load->view('header');
		$this->load->view('opportunities/edit_call',$data);
	    $this->load->view('footer');
        
    	
   	}
   	
   	function edit_call_process()
    {
    	$this->form_validation->set_rules('date', 'Date', 'required');
    	
    	$this->form_validation->set_rules('call_summary', 'Call Summary', 'required');
		 
		
		if( $this->form_validation->run() == FALSE )
        {
            echo '<div style="color:red;margin-left:15px;">' . validation_errors() . '</div>';
        }
        else
        {
            
            if( $this->calls_model->edit_calls())
            { 
                echo '<div style="margin-left:15px;">'.$this->lang->line('update_succesful').'</div>';
            }
            else
            {
                echo $this->lang->line('technical_problem');
            }
        }
    	
    }
    
    function convert_to_opportunity()
	{
		    
		   
		    
            if( $this->leads_model->add_convert_to_opportunity())
            { 
            	 
              // redirect("admin/opportunities/update/".$this->db->insert_id());              		  
              echo 'yes_'.$this->db->insert_id();	
            }
            else
            {
                echo $this->lang->line('technical_problem');
            }
        	 
	}
	
	function convert_to_customer($lead_id)
	{
		    
		   
		    $customer_id=$this->leads_model->add_convert_to_customer($lead_id);
		    
            if($customer_id)
            { 
            	 
              redirect("admin/customers/update/".$customer_id);              		  
               
            }
            else
            {
                redirect("admin/leads/view/".$lead_id);
            }
        	 
	}
	
	function export_leads()
	{ 
        $filename = "leads_csv.csv";
		$fp = fopen('php://output', 'w');

		$header=array('Opportunity', 'Company Name', 'Email', 'Phone', 'Mobile', 'Fax');
		
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);

		$num_column = count($header);		
		$query = "SELECT opportunity,company_name,email,phone,mobile,fax FROM leads";
		$result = mysql_query($query);
		while($row = mysql_fetch_row($result)) {
			fputcsv($fp, $row);
		}
		exit;    
        	 
	}
	 
}
