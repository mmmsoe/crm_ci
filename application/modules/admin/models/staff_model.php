<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staff_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function exists_email($email) {
        $email_count = $this->db->get_where('users', array('email' => $email))->num_rows();
        return $email_count;
    }

    function staff_list() {
        $this->db->order_by("users.id", "desc");
        //$this->db->where('users.id !=',1); 
        $this->db->select('users.id, users.first_name,users.last_name, users.email,users.register_time');
        $this->db->from('users');


        return $this->db->get()->result();
    }
    
    function get_role() {
        $this->db->order_by("role_id", "asc");
        $this->db->select('*');
        $this->db->from('role');
        return $this->db->get()->result();
    }

    function get_user($staff_id) {
        //return $this->db->get_where('users', array('id' => $staff_id))->row();
        $this->db->where('id',$staff_id); 
        /*$this->db->select('
            id
            ,first_name
            ,last_name
            ,email
            ,lostpw
            ,phone_number
            ,user_avatar
            ,register_time
            ,ip_address
            ,account_role_id
            ,status
            ,smtp_user
            ,smtp_pass
            ,smtp_host
            ,smtp_port
            ,imap_host
            ,imap_port
            ,role_id
            ,email as email_auth
            ,support_access_level'
            
         );*/
        $this->db->select('
            id
            ,first_name
            ,last_name
            ,email
            ,lostpw
            ,phone_number
            ,user_avatar
            ,register_time
            ,ip_address
            ,account_role_id
            ,status
            ,smtp_user
            ,smtp_pass
            ,smtp_host
            ,smtp_port
            ,imap_host
            ,imap_port
            ,role_id
            ,email as email_auth'
         );
        $this->db->from('users');
        return $this->db->get()->row();
    }

    function add_staff() {
        if (empty($_FILES['user_avatar']['name'])) {
            $staff_details = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('pass1')),
                'smtp_user' => $this->input->post('smtp_user'),
                'smtp_pass' => $this->input->post('smtp_pass'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_port' => $this->input->post('smtp_port'),
                'imap_host' => $this->input->post('imap_host'),
                'imap_port' => $this->input->post('imap_port'),
                'register_time' => strtotime(date('d F Y g:i a')),
                'ip_address' => $this->input->server('REMOTE_ADDR'),
                'account_role_id' => $this->input->post('account_role_id'),
                'status' => '1',
                'role_id' => $this->input->post('role_id')
            );
        } else {
            $config['upload_path'] = './uploads/staffs/';
            $config['allowed_types'] = config('allowed_extensions');
            $config['max_size'] = config('max_upload_file_size');
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('user_avatar')) {
                echo $this->upload->display_errors();
            } else {

                $img_data = $this->upload->data();

                $staff_details = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('pass1')),
                    'smtp_user' => $this->input->post('smtp_user'),
                    'smtp_pass' => $this->input->post('smtp_pass'),
                    'smtp_host' => $this->input->post('smtp_host'),
                    'smtp_port' => $this->input->post('smtp_port'),
                    'imap_host' => $this->input->post('imap_host'),
                    'imap_port' => $this->input->post('imap_port'),
                    'user_avatar' => $img_data['file_name'],
                    'register_time' => strtotime(date('d F Y g:i a')),
                    'ip_address' => $this->input->server('REMOTE_ADDR'),
                    'account_role_id' => $this->input->post('account_role_id'),
                    'status' => '1',
                    'role_id' => $this->input->post('role_id')
                );
            }
        }

        $user_res = $this->db->insert('users', $staff_details);

        $user_id = $this->db->insert_id();

        $permission_details = array(
            'staff_id' => $user_id,
            'sales_team_read' => $this->input->post('sales_team_read'),
            'sales_team_write' => $this->input->post('sales_team_write'),
            'sales_team_delete' => $this->input->post('sales_team_delete'),
            
            'lead_read' => $this->input->post('lead_read'),
            'lead_write' => $this->input->post('lead_write'),
            'lead_delete' => $this->input->post('lead_delete'),
            
            'opportunities_read' => $this->input->post('opportunities_read'),
            'opportunities_write' => $this->input->post('opportunities_write'),
            'opportunities_delete' => $this->input->post('opportunities_delete'),
            
            'logged_calls_read' => $this->input->post('logged_calls_read'),
            'logged_calls_write' => $this->input->post('logged_calls_write'),
            'logged_calls_delete' => $this->input->post('logged_calls_delete'),
            
            'meetings_read' => $this->input->post('meetings_read'),
            'meetings_write' => $this->input->post('meetings_write'),
            'meetings_delete' => $this->input->post('meetings_delete'),
            
            'products_read' => $this->input->post('products_read'),
            'products_write' => $this->input->post('products_write'),
            'products_delete' => $this->input->post('products_delete'),
            
            'quotations_read' => $this->input->post('quotations_read'),
            'quotations_write' => $this->input->post('quotations_write'),
            'quotations_delete' => $this->input->post('quotations_delete'),
            
            'sales_orders_read' => $this->input->post('sales_orders_read'),
            'sales_orders_write' => $this->input->post('sales_orders_write'),
            'sales_orders_delete' => $this->input->post('sales_orders_delete'),
            
            'invoices_read' => $this->input->post('invoices_read'),
            'invoices_write' => $this->input->post('invoices_write'),
            'invoices_delete' => $this->input->post('invoices_delete'),
            
            'tickets_read' => $this->input->post('tickets_read'),
            'tickets_write' => $this->input->post('tickets_write'),
            'tickets_delete' => $this->input->post('tickets_delete'),
            
            'knowledge_base_read' => $this->input->post('knowledge_base_read'),
            'knowledge_base_write' => $this->input->post('knowledge_base_write'),
            'knowledge_base_delete' => $this->input->post('knowledge_base_delete'),
            
            'staff_read' => $this->input->post('staff_read'),
            'staff_write' => $this->input->post('staff_write'),
            'staff_delete' => $this->input->post('staff_delete'),
            
            'payment_log_read' => $this->input->post('payment_log_read'),
            'payment_log_write' => $this->input->post('payment_log_write'),
            'payment_log_delete' => $this->input->post('payment_log_delete'),
            
            'analytics_read' => $this->input->post('analytics_read'),
            'analytics_write' => $this->input->post('analytics_write'),
            'analytics_delete' => $this->input->post('analytics_delete'),
            
            'email_read' => $this->input->post('email_read'),
            'email_write' => $this->input->post('email_write'),
            'email_delete' => $this->input->post('email_delete'),
            
            'activity_entry_read' => $this->input->post('activity_entry_read'),
            'activity_entry_write' => $this->input->post('activity_entry_write'),
            'activity_entry_delete' => $this->input->post('activity_entry_delete'),
            
            'calendar_read' => $this->input->post('calendar_read'),
            'calendar_write' => $this->input->post('calendar_write'),
            'calendar_delete' => $this->input->post('calendar_delete'),
            
            'account_read' => $this->input->post('account_read'),
            'account_write' => $this->input->post('account_write'),
            'account_delete' => $this->input->post('account_delete'),
            
            'contacts_read' => $this->input->post('contacts_read'),
            'contacts_write' => $this->input->post('contacts_write'),
            'contacts_delete' => $this->input->post('contacts_delete'),
            
            
            'campaign_listing_read' => $this->input->post('campaign_listing_read'),
            'campaign_listing_write' => $this->input->post('campaign_listing_write'),
            'campaign_listing_delete' => $this->input->post('campaign_listing_delete'),
            
            'update_application_read' => $this->input->post('update_application_read'),
            'update_application_write' => $this->input->post('update_application_write'),
            'update_application_delete' => $this->input->post('update_application_delete'),
            
            'people_listing_read' => $this->input->post('people_listing_read'),
            'people_listing_write' => $this->input->post('people_listing_write'),
            'people_listing_delete' => $this->input->post('people_listing_delete'),
            
            'product_setting_read' => $this->input->post('product_setting_read'),
            'product_setting_write' => $this->input->post('product_setting_write'),
            'product_setting_delete' => $this->input->post('product_setting_delete'),
            
            'system_setting_read' => $this->input->post('system_setting_read'),
            'system_setting_write' => $this->input->post('system_setting_write'),
            'system_setting_delete' => $this->input->post('system_setting_delete'),
            
            'master_system_read' => $this->input->post('master_system_read'),
            'master_system_write' => $this->input->post('master_system_write'),
            'master_system_delete' => $this->input->post('master_system_delete')
        );

        $add_permission = $this->db->insert('account_permission', $permission_details);

        return $user_res;
    }

    function update_staff() {

        $q = "SELECT COUNT(*) as cnt FROM account_permission WHERE staff_id = '".$this->input->post('user_id')."'";
        $n = $this->db->query($q)->row()->cnt;
        
        $permission_details = array(
            'sales_team_read' => $this->input->post('sales_team_read'),
            'sales_team_write' => $this->input->post('sales_team_write'),
            'sales_team_delete' => $this->input->post('sales_team_delete'),
            
            'lead_read' => $this->input->post('lead_read'),
            'lead_write' => $this->input->post('lead_write'),
            'lead_delete' => $this->input->post('lead_delete'),
            
            'opportunities_read' => $this->input->post('opportunities_read'),
            'opportunities_write' => $this->input->post('opportunities_write'),
            'opportunities_delete' => $this->input->post('opportunities_delete'),
            
            'logged_calls_read' => $this->input->post('logged_calls_read'),
            'logged_calls_write' => $this->input->post('logged_calls_write'),
            'logged_calls_delete' => $this->input->post('logged_calls_delete'),
            
            'meetings_read' => $this->input->post('meetings_read'),
            'meetings_write' => $this->input->post('meetings_write'),
            'meetings_delete' => $this->input->post('meetings_delete'),
            
            'products_read' => $this->input->post('products_read'),
            'products_write' => $this->input->post('products_write'),
            'products_delete' => $this->input->post('products_delete'),
            
            'quotations_read' => $this->input->post('quotations_read'),
            'quotations_write' => $this->input->post('quotations_write'),
            'quotations_delete' => $this->input->post('quotations_delete'),
            
            'sales_orders_read' => $this->input->post('sales_orders_read'),
            'sales_orders_write' => $this->input->post('sales_orders_write'),
            'sales_orders_delete' => $this->input->post('sales_orders_delete'),
            
            'invoices_read' => $this->input->post('invoices_read'),
            'invoices_write' => $this->input->post('invoices_write'),
            'invoices_delete' => $this->input->post('invoices_delete'),
            
            'tickets_read' => $this->input->post('tickets_read'),
            'tickets_write' => $this->input->post('tickets_write'),
            'tickets_delete' => $this->input->post('tickets_delete'),
            
            'knowledge_base_read' => $this->input->post('knowledge_base_read'),
            'knowledge_base_write' => $this->input->post('knowledge_base_write'),
            'knowledge_base_delete' => $this->input->post('knowledge_base_delete'),
            
            'staff_read' => $this->input->post('staff_read'),
            'staff_write' => $this->input->post('staff_write'),
            'staff_delete' => $this->input->post('staff_delete'),
            
            
            'payment_log_read' => $this->input->post('payment_log_read'),
            'payment_log_write' => $this->input->post('payment_log_write'),
            'payment_log_delete' => $this->input->post('payment_log_delete'),
            
            'analytics_read' => $this->input->post('analytics_read'),
            'analytics_write' => $this->input->post('analytics_write'),
            'analytics_delete' => $this->input->post('analytics_delete'),
            
            'email_read' => $this->input->post('email_read'),
            'email_write' => $this->input->post('email_write'),
            'email_delete' => $this->input->post('email_delete'),
            
            'activity_entry_read' => $this->input->post('activity_entry_read'),
            'activity_entry_write' => $this->input->post('activity_entry_write'),
            'activity_entry_delete' => $this->input->post('activity_entry_delete'),
            
            'calendar_read' => $this->input->post('calendar_read'),
            'calendar_write' => $this->input->post('calendar_write'),
            'calendar_delete' => $this->input->post('calendar_delete'),
            
            'account_read' => $this->input->post('account_read'),
            'account_write' => $this->input->post('account_write'),
            'account_delete' => $this->input->post('account_delete'),
            
            'contacts_read' => $this->input->post('contacts_read'),
            'contacts_write' => $this->input->post('contacts_write'),
            'contacts_delete' => $this->input->post('contacts_delete'),
            
            'campaign_listing_read' => $this->input->post('campaign_listing_read'),
            'campaign_listing_write' => $this->input->post('campaign_listing_write'),
            'campaign_listing_delete' => $this->input->post('campaign_listing_delete'),
            
            'update_application_read' => $this->input->post('update_application_read'),
            'update_application_write' => $this->input->post('update_application_write'),
            'update_application_delete' => $this->input->post('update_application_delete'),
            
            'people_listing_read' => $this->input->post('people_listing_read'),
            'people_listing_write' => $this->input->post('people_listing_write'),
            'people_listing_delete' => $this->input->post('people_listing_delete'),
            
            'product_setting_read' => $this->input->post('product_setting_read'),
            'product_setting_write' => $this->input->post('product_setting_write'),
            'product_setting_delete' => $this->input->post('product_setting_delete'),
            
            'system_setting_read' => $this->input->post('system_setting_read'),
            'system_setting_write' => $this->input->post('system_setting_write'),
            'system_setting_delete' => $this->input->post('system_setting_delete'),
            
            'master_system_read' => $this->input->post('master_system_read'),
            'master_system_write' => $this->input->post('master_system_write'),
            'master_system_delete' => $this->input->post('master_system_delete')
        );
        
        if($n>0)
        {
            $update_permission = $this->db->update('account_permission', $permission_details, array('staff_id' => $this->input->post('user_id')));
        }
        else{
            $permission_details['staff_id']=$this->input->post('user_id');
            $update_permission = $this->db->insert('account_permission', $permission_details);
        }
        


        if ($this->input->post('banned') == 1) {
            $status = 0;
        } else {
            $status = 1;
        }


        if (empty($_FILES['user_avatar']['name'])) {
            if ($this->input->post('pass1') != "") {
                $member_details = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('pass1')),
                    'phone_number' => $this->input->post('phone_number'),
                    'account_role_id' => $this->input->post('account_role_id'),
                    'smtp_user' => $this->input->post('smtp_user'),
                    'smtp_pass' => $this->input->post('smtp_pass'),
                    'smtp_host' => $this->input->post('smtp_host'),
                    'smtp_port' => $this->input->post('smtp_port'),
                    'imap_host' => $this->input->post('imap_host'),
                    'imap_port' => $this->input->post('imap_port'),
                    'status' => $status,
                    'role_id' => $this->input->post('role_id')/*,
                    'support_access_level' => $this->input->post('support_access_level')*/
                );
            } else {

                $member_details = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone_number' => $this->input->post('phone_number'),
                    'account_role_id' => $this->input->post('account_role_id'),
                    'smtp_user' => $this->input->post('smtp_user'),
                    'smtp_pass' => $this->input->post('smtp_pass'),
                    'smtp_host' => $this->input->post('smtp_host'),
                    'smtp_port' => $this->input->post('smtp_port'),
                    'imap_host' => $this->input->post('imap_host'),
                    'imap_port' => $this->input->post('imap_port'),
                    'status' => $status,
                    'role_id' => $this->input->post('role_id')/*,
                    'support_access_level' => $this->input->post('support_access_level')*/
                );
            }



            return $this->db->update('users', $member_details, array('id' => $this->input->post('user_id')));
        } else {
            $config['upload_path'] = './uploads/staffs/';
            $config['allowed_types'] = config('allowed_extensions');
            $config['max_size'] = config('max_upload_file_size');
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('user_avatar')) {
                echo $this->upload->display_errors();
            } else {


                $img_data = $this->upload->data();

                if ($this->input->post('pass1') != "") {
                    $member_details = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'email' => $this->input->post('email'),
                        'password' => md5($this->input->post('pass1')),
                        'phone_number' => $this->input->post('phone_number'),
                        'account_role_id' => $this->input->post('account_role_id'),
                        'user_avatar' => $img_data['file_name'],
                        'smtp_user' => $this->input->post('smtp_user'),
                        'smtp_pass' => $this->input->post('smtp_pass'),
                        'smtp_host' => $this->input->post('smtp_host'),
                        'smtp_port' => $this->input->post('smtp_port'),
                        'imap_host' => $this->input->post('imap_host'),
                        'imap_port' => $this->input->post('imap_port'),
                        'status' => $status,
                        'role_id' => $this->input->post('role_id')/*,
                    'support_access_level' => $this->input->post('support_access_level')*/
                    );
                } else {
                    $member_details = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'email' => $this->input->post('email'),
                        'phone_number' => $this->input->post('phone_number'),
                        'account_role_id' => $this->input->post('account_role_id'),
                        'user_avatar' => $img_data['file_name'],
                        'smtp_user' => $this->input->post('smtp_user'),
                        'smtp_pass' => $this->input->post('smtp_pass'),
                        'smtp_host' => $this->input->post('smtp_host'),
                        'smtp_port' => $this->input->post('smtp_port'),
                        'imap_host' => $this->input->post('imap_host'),
                        'imap_port' => $this->input->post('imap_port'),
                        'status' => $status,
                        'role_id' => $this->input->post('role_id')/*,
                    'support_access_level' => $this->input->post('support_access_level')*/
                    );
                }


                return $this->db->update('users', $member_details, array('id' => $this->input->post('user_id')));
            }
        }
    }

    function delete($staff_id) {
        if ($this->db->delete('users', array('id' => $staff_id, 'users.id !=' => '1'))) {  // Delete user
            return true;
        }
    }

    function get_user_fullname($staff_id) {

        $this->db->where('id', $staff_id);
        //here we select every clolumn of the table
        $q = $this->db->get('users');
        $data = $q->result_array();

        return $data[0]['first_name'] . ' ' . $data[0]['last_name'];
    }

    function get_staff_user_image($staff_id) {

        $this->db->where('id', $staff_id);
        //here we select every clolumn of the table
        $q = $this->db->get('users');
        $data = $q->result_array();

        return $data[0]['user_avatar'];
    }

    function cloning($staff_id, $new_first_name, $new_last_name, $new_email, $new_password) {
        $q = "INSERT INTO users (first_name, last_name, email, PASSWORD, lostpw, phone_number, user_avatar, register_time, ip_address, account_role_id, smtp_user, smtp_pass, smtp_port, status)
              SELECT '" . $new_first_name . "','" . $new_last_name . "','" . $new_email . "','" . $new_password . "', lostpw, phone_number, user_avatar, register_time, ip_address, account_role_id, smtp_user, smtp_pass, smtp_port , '1' FROM users u WHERE u.id = '" . $staff_id . "'";
        if ($this->db->query($q)) {
            $last_id = $this->db->insert_id();
            $q2 = "INSERT INTO account_permission (staff_id, sales_team_read, sales_team_write, sales_team_delete, lead_read, lead_write, lead_delete, opportunities_read, opportunities_write, opportunities_delete, logged_calls_read, logged_calls_write, logged_calls_delete, meetings_read, meetings_write, meetings_delete, products_read, products_write, products_delete, quotations_read, quotations_write, quotations_delete, sales_orders_read, sales_orders_write, sales_orders_delete, invoices_read, invoices_write, invoices_delete, tickets_read, tickets_write, tickets_delete, knowledge_base_read, knowledge_base_write, knowledge_base_delete, staff_read, staff_write, staff_delete)
            SELECT '" . $last_id . "', sales_team_read, sales_team_write, sales_team_delete, lead_read, lead_write, lead_delete, opportunities_read, opportunities_write, opportunities_delete, logged_calls_read, logged_calls_write, logged_calls_delete, meetings_read, meetings_write, meetings_delete, products_read, products_write, products_delete, quotations_read, quotations_write, quotations_delete, sales_orders_read, sales_orders_write, sales_orders_delete, invoices_read, invoices_write, invoices_delete, tickets_read, tickets_write, tickets_delete, knowledge_base_read, knowledge_base_write, knowledge_base_delete, staff_read, staff_write, staff_delete FROM account_permission WHERE staff_id = '" . $staff_id . "'";
            if ($this->db->query($q2)) {
                return true;
            }
        }
    }

}

?>