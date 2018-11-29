<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class salesteams_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    
    function add_salesteam()
    {
    		  
			$salesteam_details = array(
	            'salesteam' => $this->input->post('salesteam'),
	            'quotations' => $this->input->post('quotations'),
	            'leads' => $this->input->post('leads'),
	            'opportunities' => $this->input->post('opportunities'),
	            'team_leader' => implode(',',$this->input->post('team_leader')),	            
	            'invoice_target' => $this->input->post('invoice_target'),
	            'invoice_forecast' => $this->input->post('invoice_forecast'),
	            'status' => $this->input->post('status'),	             
	            'team_members' => implode(',',$this->input->post('team_members')),
	            'notes' => $this->input->post('notes'),	            
	            'register_time' => strtotime( date('d F Y g:i a') ),
	            'ip_address' => $this->input->server('REMOTE_ADDR')
	            );
	                               
	       	 return $this->db->insert('salesteams',$salesteam_details);
		 
		  
	}
	
	function update_salesteam()
    {
    	$salesteam_details = array(
	            'salesteam' => $this->input->post('salesteam'),
	            'quotations' => $this->input->post('quotations'),
	            'leads' => $this->input->post('leads'),
	            'opportunities' => $this->input->post('opportunities'),
	            'team_leader' => implode(',',$this->input->post('team_leader')),	            
	            'invoice_target' => $this->input->post('invoice_target'),
	            'invoice_forecast' => $this->input->post('invoice_forecast'),
	            'status' => $this->input->post('status'),	             
	            'team_members' => implode(',',$this->input->post('team_members')),
	            'notes' => $this->input->post('notes')
	            );
				
		 return $this->db->update('salesteams',$salesteam_details,array('id' => $this->input->post('salesteam_id')));
	
	}
	
	 function staff_list() {
        $this->db->order_by("id", "desc");
        $this->db->select('*');
        $this->db->from('users');


        return $this->db->get()->result();
    }
    
	function salesteams_list()
	{
		$this->db->order_by("id", "desc");		
        $this->db->from('salesteams');
         
        return $this->db->get()->result();
	} 
	
    function get_salesteam( $salesteam_id )
	{
		return $this->db->get_where('salesteams',array('id' => $salesteam_id))->row();
	}
	
	function delete( $salesteam_id )
	{
		if( $this->db->delete('salesteams',array('id' => $salesteam_id)) )  // Delete customer
		{  
			return true;
		}
	}
	 

}



?>