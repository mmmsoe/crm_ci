<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sms_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function save_api() {
        $data = array(
            'gateway_name' => $this->input->post('gateway_name'),
            'username_auth_id' => $this->input->post('username_auth_id'),
            'password_auth_token'=>$this->input->post('password_auth_token'),
            'api_id' => $this->input->post('api_id'),
            'phone_number' => $this->input->post('phone_number'),
            'status' => $this->input->post('status'),
            'user_id'=>$this->session->userdata('id')
        );
        
        if ($this->input->post('id') != "") {
            $key = array(
                'id' => $this->input->post('id')
            );
            return $this->db->update('sms_api_config', $data, $key);
        }
        else
        {
            return $this->db->insert('sms_api_config',$data);
        }
    }

    function getAPI($order, $order_dir, $search_value) {
        $this->db->select("id, gateway_name, username_auth_id, password_auth_token, api_id, phone_number, status");
        $this->db->from("sms_api_config");
        if ($search_value != "") {
            $this->db->like('gateway_name', $search_value);
            $this->db->or_like('username_auth_id', $search_value);
        }
        $this->db->order_by($order, $order_dir);
        $this->db->limit($_POST['length'], $_POST['start']);
        $q = $this->db->get();
        return $q->result();
    }
    
    function get_active_api()
    {
        //$q = "SELECT id, gateway_name FROM sms_api_config WHERE status = '1' AND user_id = '".$this->session->userdata('id')."'";
        //return $this->db-query($q)->result();
        /*$this->db->select('id, gateway_name');
        $this->db->form('sms_api_config');
        $array = array('status' => '1', 'user_id' => $this->session->userdata('id'));
        $this->db->where($array); 
        return $this->db->get()->result();*/
        $this->db->select("id, gateway_name, username_auth_id, password_auth_token, api_id, phone_number, status");
        $this->db->from("sms_api_config");
        $array = array("status" => "1", "user_id" => $this->session->userdata('id'));
        $this->db->where($array); 
        return $this->db->get()->result();
    }

    function getAPIbyID($id) {
        $this->db->select("id, gateway_name, username_auth_id, password_auth_token, api_id, phone_number, status");
        $this->db->from("sms_api_config");
        $this->db->where("id", $id);
        $q = $this->db->get();
        return $q;
        /* $q = "select * from sms_api_config where id = '$id'";

          return $this->db->query($q)->result(); */
    }

    function count_getAPI($order, $order_dir, $search_value) {
        $this->db->select("id");
        $this->db->from("sms_api_config");
        if ($search_value != "") {
            $this->db->like('gateway_name', $search_value);
            $this->db->or_like('username_auth_id', $search_value);
        }
        $this->db->order_by($order, $order_dir);
        $this->db->limit($_POST['length'], $_POST['start']);
        $q = $this->db->get();
        return $q->num_rows();
    }

    public function count_all_getAPI() {
        $this->db->from("sms_api_config");
        return $this->db->count_all_results();
    }

}

?>
