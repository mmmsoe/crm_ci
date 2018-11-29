<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(0);

class Customers_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function exists_name($name) {
        $name_count = $this->db->get_where('company', array('TRIM(name)' => TRIM($name)))->num_rows();
        return $name_count;
    }

    function exists_email($email) {

        $email_count = $this->db->get_where('company', array('email' => $email))->num_rows();

        return $email_count;
    }

    function add_company() {
        if (!empty($_FILES['company_attachment']['name'])) {

            $config['upload_path'] = './uploads/company/';
            $config['allowed_types'] = config('allowed_extensions');
            $config['max_size'] = config('max_upload_file_size');
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('company_attachment')) {

                echo $this->upload->display_errors();
            } else {
                $company_data = $this->upload->data();
                $company_attachment = $company_data['file_name'];
            }
        } else {
            $company_attachment = '';
        }

        if (empty($_FILES['company_avatar']['name'])) {
            $company_details = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'website' => $this->input->post('website'),
                'phone' => $this->input->post('phone'),
                'mobile' => $this->input->post('mobile'),
                'fax' => $this->input->post('fax'),
                //'title' => $this->input->post('title'),
                'email' => $this->input->post('email'),
                'company_attachment' => $company_attachment,
                'main_contact_person' => $this->input->post('main_contact_person'),
                'sales_team_id' => $this->input->post('sales_team_id'),
                'salesperson_id' => $this->input->post('salesperson_id'),
                'register_time' => strtotime(date('d F Y g:i a')),
                'ip_address' => $this->input->server('REMOTE_ADDR'),
                'status' => '1',
                'create_by' => userdata('first_name') . " " . userdata('last_name'),
                'create_date' => date('Y-m-d')
            );

            return $this->db->insert('company', $company_details);
            // $company_id=$this->db->insert_id();       
            // if($insert){
            // $customer_details = array(
            // 'company_id' => $company_id
            // );
            // $this->db->update('customer',$customer_details,array('id' => $this->input->post('main_contact_person')));
            // return $insert;
            // }				
        } else {


            $config['upload_path'] = './uploads/company/';
            $config['allowed_types'] = config('allowed_extensions');
            $config['max_size'] = config('max_upload_file_size');
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('company_avatar')) {

                echo $this->upload->display_errors();
            } else {
                $img_data = $this->upload->data();
                $company_details = array(
                    'name' => $this->input->post('name'),
                    'address' => $this->input->post('address'),
                    'website' => $this->input->post('website'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'fax' => $this->input->post('fax'),
                    // 'title' => $this->input->post('title'),
                    'email' => $this->input->post('email'),
                    'company_avatar' => $img_data['file_name'],
                    'company_attachment' => $company_attachment,
                    'main_contact_person' => $this->input->post('main_contact_person'),
                    'sales_team_id' => $this->input->post('sales_team_id'),
                    'salesperson_id' => $this->input->post('salesperson_id'),
                    'register_time' => strtotime(date('d F Y g:i a')),
                    'ip_address' => $this->input->server('REMOTE_ADDR'),
                    'status' => '1',
                    'create_by' => userdata('first_name') . " " . userdata('last_name'),
                    'create_date' => date('Y-m-d')
                );

                return $this->db->insert('company', $company_details);
                // if($insert){
                // $customer_details = array(
                // 'company_id' => $company_id
                // );
                // $this->db->update('customer',$customer_details,array('id' => $this->input->post('main_contact_person')));
                // return $insert;
                // }		
            }
        }
    }

    function updt_id($company_id) {

        $customer_details = array(
            'company_id' => $company_id
        );
        $this->db->update('customer', $customer_details, array('id' => $this->input->post('main_contact_person')));
    }

    function update_contact_id($company_id) {

        $customer_details = array(
            'company_id' => 0
        );
        $this->db->update('customer', $customer_details, array('id' => $this->input->post('contact_old')));
    }

    function contact_mailing_list($min, $max) {
        if ($min && $max) {
            if ($min !== '-' || $max !== '-') {
                $this->db->where("DATE_FORMAT(FROM_UNIXTIME(a.register_time),'%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($min)) . "' AND '" . date('Y-m-d', strtotime($max)) . "'");
            }
        }
        // $this->db->order_by("first_name", "desc");		
        $this->db->select("a.*");
        $this->db->from('customer a');
        // $this->db->where('company_id', $company_id);

        return $this->db->get()->result();
    }

    function get_company($company_id) {
        return $this->db->get_where('company', array('id' => $company_id))->row();
    }

    function get_contact_list($company_id) {
        $this->db->order_by("first_name", "desc");
        $this->db->from('customer');
        $this->db->where('company_id', $company_id);

        return $this->db->get()->result();
    }

    function get_cities_name($name, $field, $cat) {
        $this->db->select($field);
        if ($cat == 'city') {
            $this->db->from('cities');
        } else if ($cat == 'state') {
            $this->db->from('states');
        } else if ($cat == 'country') {
            $this->db->from('countries');
        }
        $this->db->where('id', $name);


        return $this->db->get()->row()->$field;
    }

    function update_company() {

        if (!empty($_FILES['company_attachment']['name'])) {

            $config['upload_path'] = './uploads/company/';
            $config['allowed_types'] = config('allowed_extensions');
            $config['max_size'] = config('max_upload_file_size');
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('company_attachment')) {

                echo $this->upload->display_errors();
            } else {
                $company_data = $this->upload->data();

                $company_attachment = $company_data['file_name'];
            }
        } else {
            $company_attachment = $this->input->post('attach_file');
        }

        if (empty($_FILES['company_avatar']['name'])) {
            if ($this->input->post('email_old') == $this->input->post('email')) {
                $email = $this->input->post('email_old');
            } else {
                $email = $this->input->post('email');
            }

            $company_details = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'website' => $this->input->post('website'),
                'phone' => $this->input->post('phone'),
                'mobile' => $this->input->post('mobile'),
                'fax' => $this->input->post('fax'),
                //'title' => $this->input->post('title'),
                'email' => $email,
                'company_attachment' => $company_attachment,
                'main_contact_person' => $this->input->post('main_contact_person'),
                'salesperson_id' => $this->input->post('salesperson_id'),
                'sales_team_id' => $this->input->post('sales_team_id'),
                'status' => '1',
                'changed_by' => userdata('first_name') . " " . userdata('last_name'),
                'changed_date' => date('Y-m-d')
            );

            $update = $this->db->update('company', $company_details, array('id' => $this->input->post('company_id')));

            if ($update) {
                $customer_details = array(
                    'company_id' => $this->input->post('company_id')
                );
                return $this->db->update('customer', $customer_details, array('id' => $this->input->post('main_contact_person')));
            }
        } else {


            $config['upload_path'] = './uploads/company/';
            $config['allowed_types'] = config('allowed_extensions');
            $config['max_size'] = config('max_upload_file_size');
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('company_avatar')) {

                echo $this->upload->display_errors();
            } else {
                $img_data = $this->upload->data();

                //Unlink Old image					
                $img_name = $this->customers_model->get_company($this->input->post('company_id'));
                unlink('./uploads/company/' . $img_name->company_avatar);

                $company_details = array(
                    'name' => $this->input->post('name'),
                    'address' => $this->input->post('address'),
                    'website' => $this->input->post('website'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'fax' => $this->input->post('fax'),
                    //   'title' => $this->input->post('title'),
                    'email' => $this->input->post('email'),
                    'company_avatar' => $img_data['file_name'],
                    'company_attachment' => $company_attachment,
                    'main_contact_person' => $this->input->post('main_contact_person'),
                    'sales_team_id' => $this->input->post('sales_team_id'),
                    'salesperson_id' => $this->input->post('salesperson_id'),
                    'status' => '1',
                    'changed_by' => userdata('first_name') . " " . userdata('last_name'),
                    'changed_date' => date('Y-m-d')
                );

                $update = $this->db->update('company', $company_details, array('id' => $this->input->post('company_id')));

                if ($update) {
                    $customer_details = array(
                        'company_id' => $this->input->post('company_id')
                    );
                    return $this->db->update('customer', $customer_details, array('id' => $this->input->post('main_contact_person')));
                }
            }
        }
    }

    // function sales_list()
    // {
    // $this->db->order_by("first_name", "asc");		
    // $this->db->from('users');
    // return $this->db->get()->result();
    // }
    function total_customers() {
        $this->db->order_by("id", "desc");
        $this->db->from('customer');

        return count($this->db->get()->result());
    }

    function company_list() {
        $this->db->order_by("name", "asc");
        $this->db->from('company');
        return $this->db->get()->result();
    }

    function company_contact_list() {
        $this->db->order_by("company.name", "asc");
        $this->db->select('company.id,company.name,company.phone,company.company_attachment,company.salesperson_id,company.main_contact_person,company.email,company.company_avatar');
        $this->db->from('company');


        return $this->db->get()->result();
    }

    function get_contact_person($contact_person, $field) {
        $this->db->select($field);
        $this->db->from('customer');
        $this->db->where('id', $contact_person);


        return $this->db->get()->row()->$field;
    }

    function get_customers($customer_id) {
        return $this->db->get_where('customer', array('id' => $customer_id))->row();
    }

    function get_account_name($account_name, $field) {
        $this->db->select($field);
        $this->db->from('company');
        $this->db->where('id', $account_name);


        return $this->db->get()->row()->$field;
    }

    function delete($company_id) {
        $q = "SELECT COUNT(customer_id) as cnt FROM (
            SELECT customer_id FROM quotations_salesorder qs
            UNION ALL 
            SELECT customer_id FROM salesorders s
            UNION ALL 
            SELECT customer_id FROM invoices i
          )t WHERE t.customer_id = '" . $company_id . "'";
        $cnt = $this->db->query($q)->row()->cnt;
        if ($cnt > 0) {
            return false;
        } else {
            $img_name = $this->customers_model->get_company($company_id);
            unlink('./uploads/company/' . $img_name->company_avatar);

            if ($this->db->delete('company', array('id' => $company_id))) {  // Delete customer
                return true;
            }
        }
    }

    function contact_persons_list() {

        $this->db->order_by("first_name", "asc");
        $this->db->from('customer');

        return $this->db->get()->result();
    }

    function total_salesorders($customer_id) {

        $this->db->where(array('quot_or_order' => 'o', 'customer_id' => $customer_id));
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

        return count($this->db->get()->result());
    }

    function total_quotations($customer_id) {

        $this->db->where(array('quot_or_order' => 'q', 'customer_id' => $customer_id));
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

        return count($this->db->get()->result());
    }

    function total_calls($customer_id) {

        $this->db->where(array('company_id' => $customer_id));
        $this->db->order_by("id", "desc");
        $this->db->from('calls');

        return count($this->db->get()->result());
    }

    function total_invoices($customer_id) {

        $this->db->where(array('customer_id' => $customer_id));
        $this->db->order_by("id", "desc");
        $this->db->from('invoices');

        return count($this->db->get()->result());
    }

    function total_meetings($customer_id) {

        $this->db->order_by("id", "desc");
        $this->db->from('meetings');

        $meetings_res = $this->db->get()->result();
        $total = 0;

        foreach ($meetings_res as $meetings) {
            $b = explode(',', $meetings->attendees);
            if (in_array($customer_id, $b)) {
                $total++;
            }
        }
        return $total;
    }

    function total_sales_collection($customer_id) {

        $this->db->select_sum('grand_total');
        $this->db->from('invoices');
        $this->db->where(array('customer_id' => $customer_id));
        $query = $this->db->get();
        $total_sold = $query->row()->grand_total;

        if ($total_sold > 0) {
            return $total_sold;
        }

        return '0';
    }

    function open_invoices_total_collection($customer_id) {

        $this->db->select_sum('unpaid_amount');
        $this->db->from('invoices');
        $this->db->where(array('status' => 'Open Invoice', 'customer_id' => $customer_id));
        $query = $this->db->get();
        $total_sold = $query->row()->unpaid_amount;

        if ($total_sold > 0) {
            return $total_sold;
        }

        return '0';
    }

    function overdue_invoices_total_collection($customer_id) {

        $this->db->select_sum('unpaid_amount');
        $this->db->from('invoices');
        $this->db->where(array('status' => 'Overdue Invoice', 'customer_id' => $customer_id));
        $query = $this->db->get();
        $total_sold = $query->row()->unpaid_amount;

        if ($total_sold > 0) {
            return $total_sold;
        }

        return '0';
    }

    function paid_invoices_total_collection($customer_id) {

        $this->db->select_sum('grand_total');
        $this->db->from('invoices');
        $this->db->where(array('status' => 'Paid Invoice', 'customer_id' => $customer_id));
        $query = $this->db->get();
        $total_sold = $query->row()->grand_total;

        if ($total_sold > 0) {
            return $total_sold;
        }

        return '0';
    }

    function quotations_total_collection($customer_id) {

        $this->db->select_sum('grand_total');
        $this->db->from('quotations_salesorder');
        $this->db->where(array('quot_or_order' => 'q', 'customer_id' => $customer_id));
        $query = $this->db->get();
        $total_sold = $query->row()->grand_total;

        if ($total_sold > 0) {
            return $total_sold;
        }

        return '0';
    }

    function total_emails($customer_id) {

        $this->db->where(array('company_id' => $customer_id));
        $this->db->order_by("id", "desc");
        $this->db->from('emails');

        return count($this->db->get()->result());
    }

    function total_contracts($customer_id) {

        $this->db->where(array('company_id' => $customer_id));
        $this->db->order_by("id", "desc");
        $this->db->from('contracts');

        return count($this->db->get()->result());
    }

    function getActivities($company_id) {
        $q = "SELECT t.id, c.name, t.opportunity_id, t.activity_type, t.activity, t.remarks, case when u.role_id = '1' THEN r.role_name ELSE CONCAT(u.first_name,' ',u.last_name) END as created_by, t.created_dt FROM (
        select id, company_id, opportunity_id, 1 AS activity_type, 'Logged Calls' as activity, call_summary as remarks, created_by, created_dt from calls
        UNION ALL
        select id, company_id, opportunity_id, 2 AS activity_type, 'Meetings' as activity, meeting_subject as remarks, created_by, created_dt from meetings
        UNION ALL
        select id,company_id,opportunity_id,3 as activity_type,'E-Mail' as activity,`subject`, created_by, created_dt  from emails
        
        )t 
        LEFT JOIN users u ON u.id = t.created_by 
        LEFT JOIN company c ON c.id = t.company_id
        LEFT JOIN role r ON u.role_id = r.role_id
        WHERE t.company_id = '$company_id' ";
        return $q;
    }

    function activitiesData($company_id, $order = '', $order_dir = '', $search_value = '', $activity_type = '0') {//added by yusuf
        $q = $this->getActivities($company_id);
        if ($search_value != "") {
            $q.=" AND (c.name LIKE = '%$search_value%' OR t.activity LIKE '%$search_value%' OR t.remarks LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%') ";
        }
        if ($activity_type != '0') {
            $q.=" AND t.activity_type = '$activity_type' ";
        }

        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }

        $q.= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        return $this->db->query($q)->result();
    }

    function count_filtered($company_id, $order = '', $order_dir = '', $search_value = '', $activity_type = '0') {
        $q = $this->getActivities($company_id);
        if ($search_value != "") {
            $q.=" AND (c.name LIKE = '%$search_value%' OR t.activity LIKE '%$search_value%' OR t.remarks LIKE '%$search_value%' OR u.first_name LIKE '%$search_value%' OR u.last_name LIKE '%$search_value%') ";
        }

        if ($activity_type != '0') {
            $q.=" AND t.activity_type = '$activity_type' ";
        }

        if ($order != "") {
            $q .= " ORDER BY $order $order_dir";
        }

        return $this->db->query($q)->num_rows();
    }

    function add_process_from_leads() {
        if ($this->exists_name($this->input->post('name')) > 0) {
            return "Company name already exist";
        } else if ($this->exists_email($this->input->post('email')) > 0) {
            return "Email address already exist";
        } else {
            $lead_id = $this->input->post('lead_id');
            $data = array(
                'lead_id' => $lead_id,
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'website' => $this->input->post('website'),
                'phone' => $this->input->post('phone'),
                'mobile' => $this->input->post('mobile'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'sales_team_id' => $this->input->post('sales_team_id'),
                'salesperson_id' => $this->input->post('salesperson_id')
            );
            $this->db->trans_start();
            $this->db->insert('company', $data);
            $comp_id = $this->db->insert_id();
            $this->db->trans_complete();


            $cp = $this->input->post('main_contact_person');
            $last_name = "";
            $first_name = "";
            if (strpos($cp, " ") == true) {
                $cp = explode(" ", $cp);
                $first_name = $cp[0];
                if (count($cp) > 2) {
                    for ($i = 1; $i < count($cp); $i++) {
                        $last_name .= $cp[$i] . " ";
                    }
                    $last_name = substr($last_name, 0, strlen($last_name) - 1);
                } else {
                    $last_name = $cp[1];
                }
            } else {
                $first_name = $cp;
            }

            $data2 = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'company_id' => $comp_id,
                'main_contact_person' => '1',
                'contact_owner' => $this->input->post('contact_owner')
            );

            $this->db->trans_start();
            $this->db->insert('customer', $data2);
            $cp_id = $this->db->insert_id();
            $this->db->trans_complete();

            $this->db->trans_start();
            $data3 = array(
                'main_contact_person' => $cp_id
            );
            $this->db->where('id', $comp_id);
            $this->db->update('company', $data3);
            $this->db->trans_complete();

            $this->db->trans_start();
            $data4 = array(
                'customer_id' => $comp_id,
                'company_name' => $this->input->post('name')
            );
            $this->db->where('id', $lead_id);
            $this->db->update('leads', $data4);
            $this->db->trans_complete();

            return 'yes_' . $lead_id;
        }
    }

    function company_auto() {
        $q = "SELECT t.company_name AS name FROM (
        (SELECT company_name, email, 'l' AS indicator FROM leads l)
        UNION DISTINCT
        (SELECT c.name AS company_name, email, 'c' AS indicator FROM company c)
)t GROUP BY name";
        return $this->db->query($q)->result();
    }

}

?>