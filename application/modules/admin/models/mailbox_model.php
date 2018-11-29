<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mailbox_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
    function send_email() {

        $count_id = count($this->input->post('to_email_id'));

        for ($i = 0; $i < $count_id; $i++) {
            $email_details = array(
                'assign_customer_id' => $this->input->post('assign_customer_id'),
                /* 'to' => $this->input->post('to_email_id')[$i], */
				/* modified by kaka (20160804) */
                'to' => $this->input->post('contact_id')[$i],
                'from' => userdata('id'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message'),
                'date_time' => strtotime(date('d F Y g:i a')),
                'ip_address' => $this->input->server('REMOTE_ADDR')
            );

            $mail_res = $this->db->insert('emails', $email_details);
        }
        return $mail_res;
    }
	
    function email_list($id, $customer_id) {
        if ($customer_id != "") {
            $this->db->where(array('to' => $id, 'assign_customer_id' => $customer_id));
        } else {
            $this->db->where(array('to' => $id));
        }
        $this->db->order_by("id", "desc");
        $this->db->select('emails.*');
        $this->db->from('emails');
        return $this->db->get()->result();
    }
    
    function sent_email_list($id, $customer_id) {

        if ($customer_id != "") {
            $this->db->where(array('from' => $id, 'assign_customer_id' => $customer_id));
        } else {
            $this->db->where(array('from' => $id));
        }

        $this->db->order_by("id", "desc");
        $this->db->select('emails.*');
        $this->db->from('emails');
        return $this->db->get()->result();
    }
    
    function email_type() {
        $this->db->where(array('system_type' => 'EMAIL_TYPE'));        
        $this->db->where(array('system_code <>' => '00'));
        $this->db->order_by("system_code", "asc");
        $this->db->select('*');
        $this->db->from('tb_m_system');
        return $this->db->get()->result();
    }

    function get_call($call_id) {
        return $this->db->get_where('calls', array('id' => $call_id))->row();
    }

    function delete($mail_id) {
        if ($this->db->delete('emails', array('id' => $mail_id))) {  // Delete call
            return true;
        }
    }
    
    function add_mail($company_id,$opportunity_id,$subject,$created_dt,$created_by) {
        date_default_timezone_set("Asia/Jakarta");
        $add_mail = array(
            'company_id' => $company_id,
            'opportunity_id' => $opportunity_id,
            'subject' => $subject,
            'created_dt' => date("Y-m-d H:i:s"),
            'created_by' => $created_by

        );
        
      $this->db->insert('emails', $add_mail);
    }
       function get_rowmail($company_cd) {
        $sql = "SELECT 
                    IFNULL(MAX(SUBSTRING_INDEX((SUBSTRING_INDEX(`subject`, '-', -1)), ']', 1)),0)+1 as nomor
                FROM 
                    emails 
                WHERE 
                    company_id = '".$company_cd."'
                AND SUBSTRING_INDEX((SUBSTRING_INDEX(`subject`, '-', -2)), '-', 1) = '".$company_cd."'
                ORDER BY SUBSTRING_INDEX((SUBSTRING_INDEX(`subject`, '-', -1)), ']', 1) DESC";
        return $this->db->query($sql)->row()->nomor;
    }

}

?>