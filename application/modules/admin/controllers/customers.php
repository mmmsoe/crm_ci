<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers extends CI_Controller {

    function Customers() {
        parent::__construct();
        $this->load->database();
        $this->load->model("opportunities_model");
        $this->load->model("customers_model");
        $this->load->model("contact_persons_model");
        $this->load->model("leads_model");
        $this->load->model("staff_model");
        $this->load->model("salesteams_model");
        $this->load->model("calls_model");
        $this->load->model("meetings_model");
        $this->load->model("campaign_model");
        $this->load->model("system_model");

        $this->load->library('form_validation');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        check_login();
    }

    function index() {
        if (!check_staff_permission('account_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['customers'] = $this->customers_model->company_contact_list();

        $this->load->view('header');
        $this->load->view('customers/index', $data);
        $this->load->view('footer');
    }

    function add() {
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['contact_persons'] = $this->customers_model->contact_persons_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['countries'] = $this->contact_persons_model->country_list();
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['companies'] = $this->customers_model->company_list();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_persons_model->sys_account_list('LEAD');


        $this->load->view('header');
        $this->load->view('customers/add', $data);
        $this->load->view('footer');
    }

    function getContactList() {
        $customer_id = $this->input->post('customer_id');
        $data = array();
        $r = $this->customers_model->contact_persons_list();
        foreach ($r as $l) {
            if ($l->company_id == '0' || $l->company_id == $customer_id) {
                $name = "";
                if ($l->first_name != "") {
                    $name = $l->first_name . ' ' . $l->last_name;
                } else {
                    $name = $l->first_name;
                }
                $r = array(
                    'id' => $l->id,
                    'name' => $name
                );
                array_push($data, $r);
            }
        }
        echo json_encode($data);
    }

    function add_process() {

        if ($this->form_validation->run('admin_create_company') == FALSE) {
            echo '<div class="alert error"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } elseif ($this->customers_model->exists_name($this->input->post('name')) > 0) {
            echo '<div class="alert error"><ul><li style="color:red">Company Name already used.</li></ul></div>';
        } elseif ($this->customers_model->exists_email($this->input->post('email')) > 0) {
            echo '<div class="alert error"><ul><li style="color:red">Email already used.</li></ul></div>';
        } else {

            if ($this->customers_model->add_company()) {
                $customer_id = $this->db->insert_id();

                if ($this->customers_model->updt_id($customer_id)) {
                    
                }
                $subject = 'Customer login details';
                $message = 'Hello,  <br><br><b>Email:</b> ' . $this->input->post('email') . '. <br> <b>Password:</b> ' . $this->input->post('password') . '. <br>Please <a href="' . base_url('customer/login') . '">click here</a> for login';

                send_notice($this->input->post('email'), $subject, $message);


                echo 'yes_' . $customer_id;
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    function view($company_id) {
        $data['total_sales'] = $this->customers_model->total_sales_collection($company_id);

        $data['open_invoices'] = $this->customers_model->open_invoices_total_collection($company_id);

        $data['overdue_invoices'] = $this->customers_model->overdue_invoices_total_collection($company_id);

        $data['paid_invoices'] = $this->customers_model->paid_invoices_total_collection($company_id);

        $data['quotations_total'] = $this->customers_model->quotations_total_collection($company_id);

        $data['salesorder'] = $this->customers_model->total_salesorders($company_id);

        $data['quotations'] = $this->customers_model->total_quotations($company_id);

        $data['invoices'] = $this->customers_model->total_invoices($company_id);

        $data['calls'] = $this->customers_model->total_calls($company_id);

        $data['meetings'] = $this->customers_model->total_meetings($company_id);

        $data['emails'] = $this->customers_model->total_emails($company_id);

        $data['contracts'] = $this->customers_model->total_contracts($company_id);

        $data['customer'] = $this->customers_model->get_company($company_id);

        $data['contacts'] = $this->customers_model->get_contact_list($company_id);

        $data['companies'] = $this->customers_model->company_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['sources'] = $this->system_model->system_list('LEAD');
        $data['priorities'] = $this->system_model->system_list('PRIORITY');
        $data['types'] = $this->system_model->system_list('OPPORTUNITIES_TYPE');
        $data['stages'] = $this->system_model->system_list('OPPORTUNITIES_STAGES');

        $data['opportunities'] = $this->opportunities_model->get_opportunity_list(userdata('id'), $company_id);

        $this->load->view('header');
        $this->load->view('customers/view', $data);
        $this->load->view('footer');
    }

    function update($company_id) {
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['customer'] = $this->customers_model->get_company($company_id);
        $data['contact_persons'] = $this->customers_model->contact_persons_list();
        $data['countries'] = $this->contact_persons_model->country_list();
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['companies'] = $this->customers_model->company_list();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_persons_model->sys_account_list('LEAD');

        $this->load->view('header');
        $this->load->view('customers/update', $data);
        $this->load->view('footer');
    }

    function update_process() {


        if ($this->form_validation->run('admin_update_company') == FALSE) {
            echo '<div class="alert error red"><ul>' . validation_errors('<li>', '</li>') . '</ul></div>';
        } else {

            if ($this->customers_model->update_company()) {
                $customer_id = $this->input->post('company_id');

                echo 'yes_' . $customer_id;

                if ($this->input->post('main_contact_person') !== $this->input->post('contact_old')) {
                    $this->customers_model->update_contact_id();
                }
            } else {
                if ($this->customers_model->exists_name($this->input->post('name')) > 0) {
                    echo '<div class="alert error"><ul><li style="color:red">Company Name already used.</li></ul></div>';
                } else if ($this->customers_model->exists_email($this->input->post('email')) > 0) {
                    echo '<div class="alert error"><ul><li style="color:red">Email already used.</li></ul></div>';
                } else {
                    echo $this->lang->line('technical_problem');
                }
            }
        }
    }

    /*
     * deletes customer
     * @param  a user id integer
     * @return string for ajax
     */

    function delete($customer_id) {
        check_login();
        $status = "";
        $message = "";
        if ($this->customers_model->delete($customer_id)) {
            $status = "success";
            $message = "Deleted";
        } else {
            $status = "failed";
            $message = "Can't delete account that already use for quotation, sales order or invoice transaction";
        }
        $data = array(
            "status" => $status,
            "message" => $message
        );
        echo json_encode($data);
    }

    function download($file) {


        $path = base_url() . 'uploads/company/' . $file;

        $this->load->helper('file');

        $mime = get_mime_by_extension($path);

        // Build the headers to push out the file properly.
        header('Pragma: public');     // required
        header('Expires: 0');         // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
        header('Cache-Control: private', false);
        header('Content-Type: ' . $mime);  // Add the mime type from Code igniter.
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');  // Add the file name
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($path)); // provide file size
        header('Connection: close');
        readfile($path); // push it out
        exit();
    }

    public function get_activities() {
        $data = array();
        $no = $_POST['start'];
        $o = $this->input->post('order');
        $s = $this->input->post('search');
        $order = $o[0]['column'];
        $order_dir = $o[0]['dir'];
        $search_value = $s['value'];
        $company_id = $this->input->post('company_id');
        $activity_type = $this->input->post('activity_type');

        switch ($order) {
            default:
            case 0:
                $order = "t.activity";
                break;
            case 1:
                $order = "t.created_dt";
                break;
            case 2:
                $order = "t.remarks";
                break;
            case 3:
                $order = "u.first_name";
                break;
        }
        $r = $this->customers_model->activitiesData($company_id, $order, $order_dir, $search_value, $activity_type);

        foreach ($r as $l) {
            $url = "";
            if ($l->activity_type == 1) {
                $url = base_url('admin/logged_calls/view/' . $l->id . '/' . $company_id);
            } else if ($l->activity_type == 2) {
                $url = base_url('admin/meetings/view/' . $l->id . '/' . $company_id);
            } else {
                $url = base_url('admin/mailbox');
            }
            $row = array(
                'activity' => '<a href="' . $url . '">' . $l->activity . '</a>',
                'created_dt' => $l->created_dt,
                'remarks' => $l->remarks,
                'created_by' => $l->created_by
            );
            $data[] = $row;
        }
        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->customers_model->count_filtered($company_id, $order, $order_dir, $search_value, $activity_type),
            'recordsFiltered' => $this->customers_model->count_filtered($company_id, $order, $order_dir, $search_value, $activity_type),
            'data' => $data
        );

        echo json_encode($output);
    }

    function add_from_leads() {
        $data['salesteams'] = $this->salesteams_model->salesteams_list();
        $data['contact_persons'] = $this->customers_model->contact_persons_list();
        $data['staffs'] = $this->staff_model->staff_list();
        $data['countries'] = $this->contact_persons_model->country_list();
        $data['titles'] = $this->system_model->system_list('TITLE_NAME');
        $data['companies'] = $this->customers_model->company_list();
        $data['owner'] = $this->contact_persons_model->sys_account_list('ACC_OWNER');
        $data['leads'] = $this->contact_persons_model->sys_account_list('LEAD');
        $data['lead'] = $this->leads_model->get_lead($this->uri->segment(4), userdata('id'));
        $this->load->view('header');
        $this->load->view('customers/add_from_leads', $data);
        $this->load->view('footer');
    }

    function add_process_from_leads() {
        $comp_id = $this->customers_model->add_process_from_leads();

        echo $comp_id;
    }

}
