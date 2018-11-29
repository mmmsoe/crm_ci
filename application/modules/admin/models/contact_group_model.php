<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);


class Contact_group_model extends CI_Model {

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
    function add_contact()
    {
    		  
			$contact_details = array(
	            'contact_owner' => $this->input->post('contact_owner'),
	            'lead_source' => $this->input->post('lead_source'),
	            'first_name' => $this->input->post('first_name'),
	            'last_name' => $this->input->post('last_name'),
	            'account_name' => $this->input->post('account_name'),
	            'title' => $this->input->post('title'),
				'email' => $this->input->post('email'),
	            'department' => $this->input->post('department'),
	            'phone' => $this->input->post('phone'),
	            'home_phone' => $this->input->post('home_phone'),
	            'other_phone' => $this->input->post('other_phone'),
	            'fax' => $this->input->post('fax'),
	            'mobile' => $this->input->post('mobile'),
	            'date_birth' => strtotime($this->input->post('date_birth')),
	            'assistant' => $this->input->post('assistant'),
	            'asst_phone' => $this->input->post('asst_phone'),
	            'reports_to' => $this->input->post('reports_to'),
	            'email_opt_out' => $this->input->post('email_opt'),
	            'skype_id' => $this->input->post('skype_id'),
	            'secondary_email' => $this->input->post('secondary_email'),
	            'twitter' => $this->input->post('twitter'),
	            'mailling_street' => $this->input->post('mailling_street'),
	            'other_street' => $this->input->post('other_street'),
	            'mailling_city' => $this->input->post('mailling_city'),
	            'other_city' => $this->input->post('other_city'),
	            'mailling_state' => $this->input->post('mailling_state'),
	            'other_state' => $this->input->post('other_state'),
	            'mailling_zip' => $this->input->post('mailling_zip'),
	            'other_zip' => $this->input->post('other_zip'),
	            'mailling_country' => $this->input->post('mailling_country'),
	            'other_country' => $this->input->post('other_country'),
	            'description' => $this->input->post('description'),
	            
	              );
	                               
	       	 return $this->db->insert('contact',$contact_details);
		 
		  
	}
   		function contact_list()
	{
			$sql=	"select a.*,b.system_value_txt from contact a
					left join tb_m_system b on a.contact_owner=b.system_code
					where b.system_type='ACC_OWNER'";
			return $this->db->query($sql)->result();

	}
	
    function get_contact( $contact_id )
	{
		return $this->db->get_where('contact',array('id' => $contact_id))->row();
	}
function update_contact()
    {
    	$contact_details = array(
	            'contact_owner' => $this->input->post('contact_owner'),
	            'lead_source' => $this->input->post('lead_source'),
	            'first_name' => $this->input->post('first_name'),
	            'last_name' => $this->input->post('last_name'),
	            'account_name' => $this->input->post('account_name'),
	            'title' => $this->input->post('title'),
				'email' => $this->input->post('email'),
	            'department' => $this->input->post('department'),
	            'phone' => $this->input->post('phone'),
	            'home_phone' => $this->input->post('home_phone'),
	            'other_phone' => $this->input->post('other_phone'),
	            'fax' => $this->input->post('fax'),
	            'mobile' => $this->input->post('mobile'),
	            'date_birth' => strtotime( $this->input->post('date_birth')),
	            'assistant' => $this->input->post('assistant'),
	            'asst_phone' => $this->input->post('asst_phone'),
	            'reports_to' => $this->input->post('reports_to'),
	            'email_opt_out' => $this->input->post('email_opt'),
	            'skype_id' => $this->input->post('skype_id'),
	            'secondary_email' => $this->input->post('secondary_email'),
	            'twitter' => $this->input->post('twitter'),
	            'mailling_street' => $this->input->post('mailling_street'),
	            'other_street' => $this->input->post('other_street'),
	            'mailling_city' => $this->input->post('mailling_city'),
	            'other_city' => $this->input->post('other_city'),
	            'mailling_state' => $this->input->post('mailling_state'),
	            'other_state' => $this->input->post('other_state'),
	            'mailling_zip' => $this->input->post('mailling_zip'),
	            'other_zip' => $this->input->post('other_zip'),
	            'mailling_country' => $this->input->post('mailling_country'),
	            'other_country' => $this->input->post('other_country'),
	            'description' => $this->input->post('description'),
	            );
	            	
		 return $this->db->update('contact',$contact_details,array('id' => $this->input->post('id')));
	}
    
	function delete( $contact_id )
	{
		if( $this->db->delete('contact',array('id' => $contact_id)) )  // Delete account
		{  
			return true;
		}
	}
     
	
	
	
}



?>