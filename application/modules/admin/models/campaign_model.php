<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class campaign_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
	function system_list_category($type)
	{
		$this->db->order_by("system_value_num", "asc");
		$this->db->where('system_type',$type); 
        $this->db->select('system_code, system_value_txt');
        $this->db->from('tb_m_system');
        
        
        return $this->db->get()->result();
	}
	
	function campaign_list($campaign_id)
	{		
        $this->db->select("a.id, a.campaign_name, c.system_value_txt as status, d.system_value_txt as type, a.start_date, a.end_date, b.first_name, b.last_name");
        $this->db->from("campaign a , users b, tb_m_system c, tb_m_system d");
        $this->db->where("a.customer_id = b.id and a.status=c.system_code and a.type=d.system_code and c.system_type='CAMPAIGN_STS' and d.system_type='CAMPAIGN_TYPE'");
        
		return $this->db->get()->result();
	}
	
	function campaign_detail($campaign_id) {
        $this->db->order_by("campaign_name", "asc");
        $this->db->from('campaign');
		
		if ($campaign_id !=''){
		$this->db->where("id = $campaign_id");
        }
		
        return $this->db->get()->result();
    }
	
    function get_campaign( $campaign_id )
	{
		return $this->db->get_where('campaign',array('id' => $campaign_id))->row();
	}
	
    function add_campaign()
    {
			$campaign_details = array(
	            'customer_id' => $this->input->post('campaign_owner'),
	            'type' => $this->input->post('campaign_type'),
	            'campaign_name' => $this->input->post('campaign_name'),
	            'status' => $this->input->post('campaign_sts'),
	            'campaign_source_id' => $this->input->post('campaign_source_id'),
	            'start_date' => strtotime( $this->input->post('start_date')),	            
	            'end_date' => strtotime( $this->input->post('end_date')),
	            'expected_revenue' => $this->input->post('expected_revenue'),
	            'budgeted_cost' => $this->input->post('budgeted_cost'),        
	            'actual_cost' => $this->input->post('actual_cost'),
	            'expected_response' => $this->input->post('expected_response'),
	            'num_sent' => $this->input->post('num_sent'),
	            'description' => $this->input->post('description_information')
	            );
	                               
	       	 return $this->db->insert('campaign',$campaign_details);

	}
	
	function update_campaign()
    {
			$campaign_details = array(
	            'customer_id' => $this->input->post('campaign_owner'),
	            'type' => $this->input->post('campaign_type'),
	            'campaign_name' => $this->input->post('campaign_name'),
				'campaign_source_id' => $this->input->post('campaign_source_id'),
	            'status' => $this->input->post('campaign_sts'),
	            'start_date' => strtotime( $this->input->post('start_date')),	            
	            'end_date' => strtotime( $this->input->post('end_date')),
	            'expected_revenue' => $this->input->post('expected_revenue'),
	            'budgeted_cost' => $this->input->post('budgeted_cost'),        
	            'actual_cost' => $this->input->post('actual_cost'),
	            'expected_response' => $this->input->post('expected_response'),
	            'num_sent' => $this->input->post('num_sent'),
	            'description' => $this->input->post('description_information')
	            );
	            	
		 return $this->db->update('campaign',$campaign_details,array('id' => $this->input->post('campaign_id')));
	}
	
	function delete( $campaign_id )
	{
		if( $this->db->delete('campaign',array('id' => $campaign_id)) )  // Delete customer
		{  
			return true;
		}
	}
     
	 

}



?>