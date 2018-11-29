<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);


class Account_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function exists_email( $email )
    {
		$email_count = $this->db->get_where('company',array('email' => $email))->num_rows();
		return $email_count;
        
    }
	function sys_account_list($type)
	{
		 
		$this->db->order_by("system_value_num","asc");	
		$this->db->where("system_type",$type);		
		$this->db->select("*");		
        $this->db->from("tb_m_system");
         
        return $this->db->get()->result();
	}
    function add_account()
    {
    		  
			$account_details = array(
	            'account_owner' => $this->input->post('account_owner'),
	            'account_name' => $this->input->post('account_name'),
	            'account_site' => $this->input->post('account_site'),
	            'parent_account' => $this->input->post('parent_account'),
	            'account_number' => $this->input->post('account_number'),
	            'account_type' => $this->input->post('account_type'),
				'industry' => $this->input->post('industry'),
	            'annual_revenue' => $this->input->post('annual_revenue'),
	            'rating' => $this->input->post('rating'),
	            'phone' => $this->input->post('phone'),
	            'fax' => $this->input->post('fax'),
	            'website' => $this->input->post('website'),
	            'ticker' => $this->input->post('ticker'),
	            'ownership' => $this->input->post('ownership'),
	            'employee' => $this->input->post('employee'),
	            'sic' => $this->input->post('sic'),
	            'billing_street' => $this->input->post('billing_street'),
	            'billing_city' => $this->input->post('billing_city'),
	            'billing_state' => $this->input->post('billing_state'),
	            'billing_code' => $this->input->post('billing_code'),
	            'billing_country' => $this->input->post('billing_country'),
	            'shipping_street' => $this->input->post('shipping_street'),
	            'shipping_city' => $this->input->post('shipping_city'),
	            'shipping_state' => $this->input->post('shipping_state'),
	            'shipping_code' => $this->input->post('shipping_code'),
	            'shipping_country' => $this->input->post('shipping_country'),
	            'description' => $this->input->post('description'),
	            
	              );
	                               
	       	 return $this->db->insert('account',$account_details);
		 
		  
	}
   		function account_list()
	{
		$sql="select a.*,b.system_value_txt from account a
					left join tb_m_system b on a.account_owner=b.system_code
					where b.system_type='ACC_OWNER'";
			return $this->db->query($sql)->result();

	}
	
    function get_account( $account_id )
	{
		return $this->db->get_where('account',array('id' => $account_id))->row();
	}
function update_account()
    {
    	$account_details = array(
	            'account_owner' => $this->input->post('account_owner'),
	            'account_name' => $this->input->post('account_name'),
	            'account_site' => $this->input->post('account_site'),
	            'parent_account' => $this->input->post('parent_account'),
	            'account_number' => $this->input->post('account_number'),
	            'account_type' => $this->input->post('account_type'),
				'industry' => $this->input->post('industry'),
	            'annual_revenue' => $this->input->post('annual_revenue'),
	            'rating' => $this->input->post('rating'),
	            'phone' => $this->input->post('phone'),
	            'fax' => $this->input->post('fax'),
	            'website' => $this->input->post('website'),
	            'ticker' => $this->input->post('ticker'),
	            'ownership' => $this->input->post('ownership'),
	            'employee' => $this->input->post('employee'),
	            'sic' => $this->input->post('sic'),
	            'billing_street' => $this->input->post('billing_street'),
	            'billing_city' => $this->input->post('billing_city'),
	            'billing_state' => $this->input->post('billing_state'),
	            'billing_code' => $this->input->post('billing_code'),
	            'billing_country' => $this->input->post('billing_country'),
	            'shipping_street' => $this->input->post('shipping_street'),
	            'shipping_city' => $this->input->post('shipping_city'),
	            'shipping_state' => $this->input->post('shipping_state'),
	            'shipping_code' => $this->input->post('shipping_code'),
	            'shipping_country' => $this->input->post('shipping_country'),
	            'description' => $this->input->post('description'),
	            );
	            	
		 return $this->db->update('account',$account_details,array('id' => $this->input->post('id')));
	}
    	
	function delete( $account_id )
	{
		if( $this->db->delete('account',array('id' => $account_id)) )  // Delete account
		{  
			return true;
		}
	}
     
	
	
	
	
}



?>