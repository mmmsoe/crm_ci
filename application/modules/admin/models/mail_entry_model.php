<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mail_entry_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function all_mail_entry_list($search) {
        if ($search != "") {
            $this->db->where(array('e.subject' => $search));
            $this->db->where(array('e.created_by' => $search));
            $this->db->where(array('e.created_dt' => $search));
            $this->db->where(array('c.name' => $search));
        }
        $this->db->order_by("e.id", "desc");
        $this->db->select("e.*,c.`name` as company_name,case when u.role_id = '1' THEN r.role_name ELSE CONCAT(u.first_name,' ',u.last_name) END as entered_by",false);
        $this->db->from('emails e');
        $this->db->join('company c', 'e.company_id = c.id');
        $this->db->join('users u', 'e.created_by = u.id');
        $this->db->join('role r', 'u.role_id = r.role_id');
        return $this->db->get()->result();
    }
}

?>