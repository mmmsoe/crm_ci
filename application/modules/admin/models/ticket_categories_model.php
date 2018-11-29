<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ticket_categories_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    
    function get_categories() {
        $q = "SELECT * FROM ticket_categories WHERE 1 = 1 ";
        return $q;
    }
    
    function get_all_categories()
    {
        return $this->db->query($this->get_categories())->result();
    }

    function categories_data($order = '', $order_dir = '', $search_value = '', $start, $length) {
        $q = $this->get_categories();
        if ($search_value != "") {
            $q.=" AND ticket_category_name LIKE '%" + $search_value + "%' ";
        }
        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }
        $q.= " LIMIT " . $start . ", " . $length;
        return $this->db->query($q)->result();
    }

    function count_filtered($order = '', $order_dir = '', $search_value = '') {
        $q = $this->get_categories();
        if ($search_value != "") {
            $q.=" AND ticket_category_name LIKE '%" + $search_value + "%' ";
        }
        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }
        //echo $q;
        return $this->db->query($q)->num_rows();
    }

    public function count_all() {
        $this->db->from("ticket_categories");
        return $this->db->count_all_results();
    }

    public function get_category($id = '') {
        $q = "SELECT ticket_category_name FROM ticket_categories WHERE ticket_category_id = '$id'";
        return $this->db->query($q)->row()->ticket_category_name;
    }

    public function save($id, $name) {
        
        $q = "";
        $data = array();
        if ($id != "") {
            $q = "UPDATE ticket_categories SET ticket_category_name = '$name' WHERE ticket_category_id = '$id'";
        } else {
            $q = "INSERT INTO ticket_categories (ticket_category_name) VALUES ('$name')";
        }
        
        if($this->db->query($q))
        {
           $data['result'] = 'success';
           $data['message'] = 'Category successfuly saved';
        }
        else
        {
            $data['result'] = 'failed';
            $data['message'] = 'Category failed to saved';
        }
        
        return $data;
    }
    
    public function delete($id)
    {
        $q = "DELETE FROM ticket_categories WHERE ticket_category_id = '$id'";
        $this->db->query($q);
        return "deleted";
    }

}
