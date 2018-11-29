<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quotations extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("quotations_model");
        $this->load->model("qtemplates_model");
        $this->load->model("customers_model");
        $this->load->model("staff_model");
        $this->load->model("salesteams_model");
        $this->load->model("pricelists_model");
        $this->load->model("products_model");
        $this->load->model("contact_persons_model");
        $this->load->model("system_model");
        $this->load->model("opportunities_model");

        $this->load->model("dashboard_model");

        $this->load->library('form_validation');

        $this->load->helper('pdf_helper');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        check_login();
    }

    function index($customer_id = '') {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['quotations'] = $this->quotations_model->quotations_list($customer_id);

        $this->load->view('header');
        $this->load->view('quotations/index', $data);
        $this->load->view('footer');
    }

    function export($customer_id = null) {
        //checking permission for staff
        // if (!check_staff_permission('quotations_read')) {
        //     redirect(base_url('admin/access_denied'), 'refresh');
        // }

        $data['quotations'] = $this->quotations_model->quotations_list($customer_id);
        $this->load->view('quotations/export', $data);
    }

    function archive_quotations($customer_id = '') {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data['quotations'] = $this->quotations_model->quotations_archive_list($customer_id);

        $this->load->view('header');
        $this->load->view('quotations/archive_quotations', $data);
        $this->load->view('footer');
    }

    function add() {
        //checking permission for staff
        if (!check_staff_permission('quotations_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['salesteams'] = $this->salesteams_model->salesteams_list();

        //added by nanin mulyani 20160903
        $data['salesteams_user'] = $this->opportunities_model->get_salesteams_user(userdata('id'));
        //and

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['products'] = $this->products_model->products_list();

        $id = userdata('id');

        $data['salesteam_id'] = $this->dashboard_model->get_staff_salesteam($id);

        $data['team_members_id'] = $this->salesteams_model->get_salesteam($data['salesteam_id'])->team_members;

        $data['team_leader_id'] = $this->salesteams_model->get_salesteam($data['salesteam_id'])->team_leader;

        $data['uoms'] = $this->system_model->system_list('UOM');

        $this->load->view('header');
        $this->load->view('quotations/add', $data);
        $this->load->view('footer');
    }

    function add_process() {
        //checking permission for staff
        if (!check_staff_permission('quotations_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('customer_id', 'Customer', 'required');

        $this->form_validation->set_rules('salesperson_id', 'Sales Person on Sales Owner', 'required');

        $this->form_validation->set_rules('sales_team_id', 'Sales Team on Sales Owner', 'required');

        $this->form_validation->set_rules('contact_id', 'Contact', 'required');

        $this->form_validation->set_rules('date', 'Date', 'required');

        //$this->form_validation->set_rules('quotation_template', 'Quotation Template', 'required');
        //$this->form_validation->set_rules('pricelist_id', 'Pricelist', 'required');

        $this->form_validation->set_rules('payment_term', 'Payment Term', 'required');

        $this->form_validation->set_rules('grand_total', 'Total', 'required');

        $this->form_validation->set_rules('p_id', 'Product', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red"><ul>' . validation_errors('<li style="color:red">', '</li>') . '</ul></div>';
        } else {
            $qid = $this->quotations_model->add_quotation();


            add_notifications($this->input->post('sales_person'), 'New Quotation Added', $qid, 'quotations');

            echo 'yes_' . $qid;

            /* if( $this->quotations_model->add_quotation())
              {
              echo '<div class="alert ok">'.$this->lang->line('create_succesful').'</div>';
              }
              else
              {
              echo $this->lang->line('technical_problem');
              } */
        }
    }

    function view($quotation_id) {
        //checking permission for staff
        if (!check_staff_permission('quotations_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['quotation'] = $this->quotations_model->get_quotation($quotation_id);

        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['qo_products'] = $this->quotations_model->quot_order_products($quotation_id);
        $data['template'] = $this->quotations_model->get_used_template();

        $this->load->view('header');
        $this->load->view('quotations/view', $data);
        $this->load->view('footer');
    }

    function update($qo_id) {
        //checking permission for staff
        if (!check_staff_permission('quotations_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $data['quotation'] = $this->quotations_model->get_quotation($qo_id);

        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['salesteams'] = $this->salesteams_model->salesteams_list();

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['products'] = $this->products_model->products_list();
        $data['qo_products'] = $this->quotations_model->quot_order_products($qo_id);

        $id = userdata('id');

        $data['salesteam_id'] = $this->dashboard_model->get_staff_salesteam($id);

        $data['team_members_id'] = $this->salesteams_model->get_salesteam($data['salesteam_id'])->team_members;

        $data['team_leader_id'] = $this->salesteams_model->get_salesteam($data['salesteam_id'])->team_leader;

        $data['uoms'] = $this->system_model->system_list('UOM');
        $data['template'] = $this->quotations_model->get_used_template();

        $this->load->view('header');
        $this->load->view('quotations/update', $data);
        $this->load->view('footer');
    }

    function update_from_opportunities($qo_id) {
        //checking permission for staff
        if (!check_staff_permission('quotations_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $q = $this->quotations_model->get_quotation($qo_id);
        $data['quotation'] = $q;

        $data['comp'] = $this->customers_model->get_company($q->customer_id);
        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['salesteams'] = $this->salesteams_model->salesteams_list();

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['products'] = $this->products_model->products_list();
        $data['qo_products'] = $this->quotations_model->quot_order_products($qo_id);

        $id = userdata('id');

        $data['salesteam_id'] = $this->dashboard_model->get_staff_salesteam($id);

        $data['team_members_id'] = $this->salesteams_model->get_salesteam($data['salesteam_id'])->team_members;

        $data['team_leader_id'] = $this->salesteams_model->get_salesteam($data['salesteam_id'])->team_leader;

        $data['uoms'] = $this->system_model->system_list('UOM');
        $data['template'] = $this->quotations_model->get_used_template();
        $this->load->view('header');
        $this->load->view('quotations/update_from_opportunities', $data);
        $this->load->view('footer');
    }

    function update_process() {
        //checking permission for staff
        if (!check_staff_permission('quotations_write')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        $this->form_validation->set_rules('customer_id', 'Customer', 'required');

        $this->form_validation->set_rules('salesperson_id', 'Sales person', 'required');

        $this->form_validation->set_rules('sales_team_id', 'Sales Team', 'required');

        $this->form_validation->set_rules('contact_id', 'Contact', 'required');

        $this->form_validation->set_rules('date', 'Date', 'required');

        //$this->form_validation->set_rules('quotation_template', 'Quotation Template', 'required');
        //$this->form_validation->set_rules('pricelist_id', 'Pricelist', 'required');

        $this->form_validation->set_rules('grand_total', 'Total', 'required');

        $this->form_validation->set_rules('p_id', 'Product', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert error" style="color:red"> ' . validation_errors() . '</div>';
        } else {

            if ($this->quotations_model->update_quotation()) {
                echo 'yes_' . $this->input->post('quotation_id');
            } else {
                echo $this->lang->line('technical_problem');
            }
        }
    }

    /*
     * deletes pricelist     *  
     */

    function delete($quotation_id) {
        //checking permission for staff
        if (!check_staff_permission('quotations_delete')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }

        if ($this->quotations_model->delete($quotation_id)) {
            echo 'deleted';
        }
    }

    function ajax_qtemplates_products($qtemplate_id, $pricelist_id) {
        $data['qtemplate_products'] = $this->qtemplates_model->qtemplate_products($qtemplate_id);

        $data['pricelist_version'] = $this->quotations_model->get_pricelist_version_by_pricelist_id($pricelist_id);


        $this->load->view('quotations/ajax_qtemplates_products', $data);
    }

    function print_quot($quotation_id) {
        $data['quotation'] = $this->quotations_model->get_quotation($quotation_id);

        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['qo_products'] = $this->quotations_model->quot_order_products($quotation_id);


        $this->load->view('quotations/quotation_print', $data);
    }

    function ajax_create_pdf($quotation_id) {


        $data['quotation'] = $this->quotations_model->get_quotation($quotation_id);

        $data['qtemplates'] = $this->qtemplates_model->qtemplate_list();

        $data['companies'] = $this->customers_model->company_list();

        $data['staffs'] = $this->staff_model->staff_list();

        $data['pricelists'] = $this->pricelists_model->pricelists_list();

        $data['qo_products'] = $this->quotations_model->quot_order_products($quotation_id);

        $html = $this->load->view('quotations/ajax_create_pdf', $data, true);

        $filename = 'Quotation-' . $data['quotation']->quotations_number;

        $pdfFilePath = FCPATH . "/pdfs/" . $filename . ".pdf";


        $mpdf = new mPDF('c', 'A4', '', '', 20, 15, 48, 25, 10, 10);
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Acme Trading Co. - Invoice");
        $mpdf->SetAuthor("Acme Trading Co.");
        $mpdf->SetWatermarkText($data['quotation']->payment_term);
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);

        $mpdf->Output($pdfFilePath, 'F');

        echo base_url() . "pdfs/" . $filename . ".pdf";

        exit;
    }

    function send_quotation() {
        $this->load->helper('template');

        $quotation_id = $this->input->post('quotation_id');
        $email_subject = $this->input->post('email_subject');
        $to = implode(',', $this->input->post('recipients'));

        $email_body = $this->input->post('message_body');

        $message_body = parse_template($email_body);

        $quotation_pdf = $this->input->post('quotation_pdf');

        if (send_email($email_subject, $to, $message_body, $quotation_pdf)) {
            echo "success";
        } else {
            echo "not sent";
        }
    }

    /*
     * confirm sale*  
     */

    function confirm_sale($quotation_id) {
        /*if ($this->quotations_model->confirm_sales_order($quotation_id)) {

            $opp_id = $this->input->post('opportunity_id');
            if ($this->quotations_model->updt_stage($opp_id)) {
                
            }
            redirect('admin/salesorder/update/' . $quotation_id. '/1');
        }
         * 
         */
        redirect('admin/salesorder/update/' . $quotation_id. '/1');
    }

    /*
     * deletes product     *  
     */

    function delete_qo_product($product_id) {
        
        $status = "";
        $message = "";
        if ($this->quotations_model->delete_qo_product($product_id)) {
            $status = "success";
            $message = "Product has been removed";
        } else {
            $status = "failed";
            $message = "This product has been used in sales order";
        }
        $data = array(
            'status'=>$status,
            'message'=>$message
        );
        echo json_encode($data);
    }

    function ajax_get_products_price($product_id, $pricelist_id) {
        $data['products_price'] = $this->quotations_model->get_product_price($product_id, $pricelist_id);

        echo $data['products_price']->special_price;
        exit;
    }

    function ajax_get_quotation_template_duration($qtemplate_id) {
        $data['quotation_template'] = $this->qtemplates_model->get_qtemplate($qtemplate_id);

        $exp_date = date('m/d/Y H:i', strtotime("+" . $data['quotation_template']->quotation_duration . " days"));

        echo $exp_date;
        exit;
    }

    function ajax_contact_list($company_id) {
        $data['contact_persons'] = $this->contact_persons_model->get_contact_persons_by_company($company_id);
        $this->load->view('ajax_get_contact', $data);
    }

    function templates() {
        //$data['templates'] = $this->quotations_model->get_templates();
        $this->load->view('header');
        $this->load->view('quotations/templates', $data);
        $this->load->view('footer');
    }

    function get_templates() {
        $data = array("data" => $this->quotations_model->get_templates());
        echo json_encode($data);
    }

    function use_template() {
        $id = $this->input->post('template_id');
        $this->quotations_model->use_template($id);
    }

    function delete_template() {
        $id = $this->input->post('template_id');
        $files = $this->quotations_model->get_detail_file($id);

        unlink('./uploads/words/' . $files->template_path);
        unlink('./uploads/words/' . $files->template_screenshot);

        $this->quotations_model->delete_template($id);
    }

    public function do_upload() {
        if ($_POST["label"]) {
            $label = $_POST["label"];
        }
        $template_name = $_POST['template_name'];
        $path = "uploads/words/";

        $temp = explode(".", $_FILES["file"]["name"]);
        $temp2 = explode(".", $_FILES["file2"]["name"]);
        $ext1 = end($temp);
        $ext2 = end($temp2);
        $filename = $filename = md5(date("Y-m-d H:i:s") . $template_name);
        $filename1 = $filename . '.' . $ext1;
        $filename2 = $filename . '.' . $ext2;

        //echo $path;

        if ($_FILES["file"]["error"] > 0 || $_FILES["file2"]["error"] > 0) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            }

            if ($_FILES["file2"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file2"]["error"] . "<br>";
            }
        } else {
            if (file_exists($path . $filename1) || file_exists($path . $filename2)) {
                echo "Template name already exist";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename1);
                move_uploaded_file($_FILES["file2"]["tmp_name"], $path . $filename2);
                $data = array(
                    'template_path' => $filename1,
                    'template_screenshot' => $filename2,
                    'template_name' => $template_name,
                    'is_used' => '0'
                );

                $this->quotations_model->insert_template($data);
                echo "Upload Finished";
            }
        }
    }

    public function print_doc() {
        $this->load->library('number_towords');
        $quotation_id = $this->input->post('quotations_id');
        $r = $this->quotations_model->print_doc_main($quotation_id);
        $r2 = $this->quotations_model->print_doc_details($quotation_id);
        $products = array();
        $i = 1;
        $pre = '<w:p><w:r><w:t>';
        $post = '</w:t></w:r></w:p>';
        foreach ($r2 as $l) {
            $description = str_replace("&", "and", $l->discription);
            $description = str_replace("\n", "<w:br/>", $description);
            $description = str_replace("<br />", "<w:br/>", $description);
            $des = array("description" => $pre . $description . $post);
            $d = array(
                'no' => $i,
                'product_name' => $l->product_name,
                'description' => $des,
                'quantity' => $l->quantity,
                'prod_uom' => $l->uom,
                'price' => number_format($l->price),
                'tax' => number_format($l->tax),
                'prod_sub_total' => number_format($l->sub_total),
                'product_discount' => number_format($l->product_discount)
            );
            $i++;
            array_push($products, $d);
        }
        $remarks = str_replace("&", "and", $r->remarks);
        $remarks = str_replace("\n", "<w:br/>", $remarks);
        $remarks = str_replace("<br />", "<w:br/>", $remarks);
        $rem = array("remarks" => $pre . $remarks . $post);
        $page = array(
            'quotation_id' => $r->quotation_id,
            'opportunities_id' => $r->opportunities_id,
            'quotations_number' => $r->quotations_number,
            'remarks' => $rem,
            'term' => $r->term,
            'company_name' => $r->company_name,
            'phone' => $r->phone,
            'fax' => $r->fax,
            'address' => $r->address,
            'contact_name' => $r->contact_name,
            'sales_person' => $r->sales_person,
            'total' => $r->total,
            'discount' => $r->discount,
            'tax_amount' => $r->tax_amount,
            'grand_total' => $r->grand_total,
            'date' => date('Y/m/d H:i'),
            'uom' => $r->uom,
            'products' => $products,
            'amt_words' => $this->number_towords->convert_number_to_words($r->grand_total)
        );
        $data['page'] = $page;
        echo json_encode($data);
    }

    function get_ajax_expired() {
        $date = $this->input->post('date');
        $data_Date = explode("/", $date);
        $dt_date = explode(" ", $data_Date[2])[0] . "-" . $data_Date[0] . "-" . $data_Date[1];
        $expired_date = $this->quotations_model->get_expired($dt_date);
        echo json_encode($expired_date);
    }

}
