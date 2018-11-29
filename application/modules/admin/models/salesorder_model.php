<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salesorder_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add_quotation() {
        $total_fields = $this->salesorder_model->get_quotations_last_id();
        $last_id = $total_fields[0]['id'];

        $quotation_no = "SO00" . ($last_id + 1);

        $quotation_details = array(
            'quotations_number' => $quotation_no,
            'customer_id' => $this->input->post('customer_id'),
            'qtemplate_id' => $this->input->post('quotation_template'),
            'date' => strtotime($this->input->post('date')),
            'pricelist_id' => $this->input->post('pricelist_id'),
            'exp_date' => strtotime($this->input->post('expiration_date')),
            'payment_term' => $this->input->post('payment_term'),
            'sales_person' => $this->input->post('sales_person'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            'terms_and_conditions' => $this->input->post('terms_and_conditions'),
            'status' => $this->input->post('status'),
            'total' => $this->input->post('total'),
            'discount' => $this->input->post('total_discount'),
            'tax_amount' => $this->input->post('tax_amount'),
            'grand_total' => $this->input->post('grand_total'),
            'quot_or_order' => 'q',
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d')
        );

        $quotations_res = $this->db->insert('salesorders', $quotation_details);
        $quotation_order_id = $this->db->insert_id();

        //Add or edit quotation template products 
        $count = count($this->input->post('product_name'));
        for ($i = 0; $i < $count; $i++) {

            $products_add = array(
                'quotation_order_id' => $quotation_order_id,
                'product_id' => $this->input->post('p_id')[$i],
                'product_name' => $this->input->post('product_name')[$i],
                'discription' => $this->input->post('description')[$i],
                'quantity' => $this->input->post('quantity')[$i],
                'price' => $this->input->post('product_price')[$i],
                'sub_total' => $this->input->post('sub_total')[$i],
                'product_discount' => $this->input->post('disc')[$i],
                'uom_id' => $this->input->post('uom_quot')[$i]
            );

            $qtemplate_products = $this->db->insert('salesorders_products', $products_add);
        }


        return $quotations_res;
    }

    function update_quotation() {
        $query = "select * from quotations_salesorder where id = '" . $this->input->post('quotation_id') . "'";
        $quo = $this->db->query($query)->row();

        $quotation_insert = array(
            'quotations_id' => $quo->id,
            'opportunities_id' => $quo->opportunities_id,
            'quotations_number' => $quo->quotations_number,
            'customer_id' => $this->input->post('customer_id'),
            'contact_id' => $this->input->post('contact_id'),
            'qtemplate_id' => $this->input->post('quotation_template'),
            'date' => strtotime($this->input->post('date')),
            'pricelist_id' => $this->input->post('pricelist_id'),
            'exp_date' => strtotime($this->input->post('expiration_date')),
            'payment_term' => $this->input->post('payment_term'),
            'sales_person' => $this->input->post('salesperson_id'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            'terms_and_conditions' => $this->input->post('terms_and_conditions'),
            'status' => $this->input->post('status'),
            'total' => $this->input->post('total'),
            'discount' => $this->input->post('total_discount'),
            'tax_amount' => $this->input->post('tax_amount'),
            'grand_total' => $this->input->post('grand_total'),
            'quot_or_order' => 'o',
            'sales_order_create_date' => $quo->sales_order_create_date,
            'register_time' => $quo->register_time,
            'archive' => $this->input->post('archive'),
            'changed_by' => userdata('first_name') . " " . userdata('last_name'),
            'changed_date' => date('Y-m-d')
        );

        $quotation_details = array(
            'customer_id' => $this->input->post('customer_id'),
            'contact_id' => $this->input->post('contact_id'),
            'qtemplate_id' => $this->input->post('quotation_template'),
            'date' => strtotime($this->input->post('date')),
            'pricelist_id' => $this->input->post('pricelist_id'),
            'exp_date' => strtotime($this->input->post('expiration_date')),
            'payment_term' => $this->input->post('payment_term'),
            'sales_person' => $this->input->post('salesperson_id'),
            'sales_team_id' => $this->input->post('sales_team_id'),
            'terms_and_conditions' => $this->input->post('terms_and_conditions'),
            'status' => $this->input->post('status'),
            'total' => $this->input->post('total'),
            'discount' => $this->input->post('total_discount'),
            'tax_amount' => $this->input->post('tax_amount'),
            'grand_total' => $this->input->post('grand_total'),
            'archive' => $this->input->post('archive'),
            'changed_by' => userdata('first_name') . " " . userdata('last_name'),
            'changed_date' => date('Y-m-d')
        );


        //Add or edit quotation template products 
        $count = count($this->input->post('product_name'));
        for ($i = 0; $i < $count; $i++) {

            if (isset($this->input->post('quotation_product_id')[$i])) {
                $products_edit = array(
                    'quotation_order_id' => $this->input->post('quotation_id'),
                    'product_id' => $this->input->post('p_id')[$i],
                    'product_name' => $this->input->post('product_name')[$i],
                    'discription' => $this->input->post('description')[$i],
                    'quantity' => $this->input->post('quantity')[$i],
                    'price' => $this->input->post('product_price')[$i],
                    'sub_total' => $this->input->post('sub_total')[$i],
                    'product_discount' => $this->input->post('disc')[$i],
                    'uom_id' => $this->input->post('uom_quot')[$i]
                );
                $q = "select count(*) from salesorders_products WHERE quotation_order_id ='" . $this->input->post('quotation_id') . "'";
                $cnt = $this->db->query($q)->row()->cnt;
                if ($cnt > 0) {
                    $this->db->update('salesorders_products', $products_edit, array('id' => $this->input->post('quotation_product_id')[$i]));
                } else {
                    $qo_products = $this->db->insert('salesorders_products', $products_edit);
                }
            } else {

                $products_add = array(
                    'quotation_order_id' => $this->input->post('quotation_id'),
                    'product_id' => $this->input->post('p_id')[$i],
                    'product_name' => $this->input->post('product_name')[$i],
                    'discription' => $this->input->post('description')[$i],
                    'quantity' => $this->input->post('quantity')[$i],
                    'price' => $this->input->post('product_price')[$i],
                    'sub_total' => $this->input->post('sub_total')[$i],
                    'product_discount' => $this->input->post('disc')[$i],
                    'uom_id' => $this->input->post('uom_quot')[$i]
                );

                $qo_products = $this->db->insert('salesorders_products', $products_add);
            }
        }

        $qo_update = array('quot_or_order' => 'o');
        $this->db->update('quotations_salesorder', $qo_update, array('id' => $this->input->post('quotation_id')));


        if ($this->get_filter_sales($this->input->post('quotation_id')) > 0) {
            return $this->db->update('salesorders', $quotation_details, array('id' => $this->input->post('salesorder_id')));
        } else {
            return $this->db->insert('salesorders', $quotation_insert);
        }
    }

    function update_sales_status($salesorder_id) {
        $salesorder_details = array('status' => 'Closed Won');

        return $this->db->update('salesorders', $salesorder_details, array('id' => $salesorder_id));
    }

    function quotations_list($customer_id) {
        $id = userdata('id');
        if ($this->user_model->get_role(userdata('id'))[0]->role_id != '1') {
            $salesteam_id = $this->dashboard_model->get_staff_salesteam($id);

            $this->db->where('sales_person', $id);
            $this->db->or_where('sales_team_id', $salesteam_id);
        }

        if ($customer_id != "") {
            $this->db->where(array('quot_or_order' => 'o', 'customer_id' => $customer_id));
        } else {

            $this->db->where(array('quot_or_order' => 'o'));
        }

        $this->db->where(array('archive' => '0'));

        $this->db->order_by("id", "desc");
        $this->db->from('salesorders');

        return $this->db->get()->result();
    }

    function quotations_archive_list($customer_id) {
        $id = userdata('id');
        if ($this->user_model->get_role(userdata('id'))[0]->role_id != '1') {
            $salesteam_id = $this->dashboard_model->get_staff_salesteam($id);

            $this->db->where('sales_person', $id);
            $this->db->or_where('sales_team_id', $salesteam_id);
        }

        if ($customer_id != "") {
            $this->db->where(array('quot_or_order' => 'o', 'customer_id' => $customer_id));
        } else {

            $this->db->where(array('quot_or_order' => 'o'));
        }

        $this->db->where(array('archive' => '1'));

        $this->db->order_by("id", "desc");
        $this->db->from('salesorders');

        return $this->db->get()->result();
    }

    function get_filter_sales($order_id) {
        $query = "select count(quotations_id) as cnt from salesorders where quotations_id = '" . $order_id . "'";
        return $this->db->query($query)->row()->cnt;
    }

    function get_quotation($order_id) {
        //return $this->db->get_where('salesorders', array('id' => $order_id, 'quot_or_order' => 'o'))->row();

        if ($this->get_filter_sales($order_id) > 0) {
            $tbl = 'salesorders';
            $idx = 'quotations_id';
            $fld = 'id,quotations_id,opportunities_id,quotations_number,customer_id,contact_id,qtemplate_id,date,pricelist_id,exp_date,payment_term,sales_person,sales_team_id,terms_and_conditions,status,total,discount,tax_amount,grand_total,quot_or_order,sales_order_create_date,register_time,archive,create_by,create_date,changed_by,changed_date';
        } else {
            $tbl = 'quotations_salesorder';
            $idx = 'id';
            $fld = 'id as quotations_id,opportunities_id,quotations_number,customer_id,contact_id,qtemplate_id,date,pricelist_id,exp_date,payment_term,sales_person,sales_team_id,terms_and_conditions,status,total,discount,tax_amount,grand_total,quot_or_order,sales_order_create_date,register_time, 0 as archive,create_by,create_date,changed_by,changed_date';
        }

        $sql = "select " . $fld . " from " . $tbl . " where " . $idx . " = '" . $order_id . "'";
        return $this->db->query($sql)->row();

        //return $this->db->get_where($tbl, array($idx => $quotation_id))->row();
    }

    function delete($order_id) {

        if ($this->db->delete('salesorders', array('id' => $order_id))) {  // Delete customer
            return true;
        }
    }

    //Get last row
    function get_quotations_last_id() {
        $query = "select * from salesorders order by id DESC limit 1";

        $res = $this->db->query($query);

        if ($res->num_rows() > 0) {
            return $res->result("array");
        }
        return array();
    }

    function quot_order_products($qo_id) {
        $this->db->where(array('quotation_order_id' => $qo_id));
        $this->db->order_by("id", "ASC");
        $this->db->from('salesorders_products');

        return $this->db->get()->result();
    }

    function get_qo_product($product_id) {
        return $this->db->get_where('salesorders_products', array('id' => $product_id))->row();
    }

    function delete_qo_product($product_id) {
        $product_data = $this->salesorder_model->get_qo_product($product_id);
        $quotations_data = $this->salesorder_model->get_quotation($product_data->quotation_order_id);

        $new_total = number_format($quotations_data->total - $product_data->price, 2, '.', '');

        $new_tax_amount = $quotations_data->tax_amount - number_format($product_data->quantity * $product_data->price * config('sales_tax') / 100, 2, '.', ' ');

        $new_grand_total = number_format($new_total + $new_tax_amount, 2, '.', '');

        $quotation_details = array(
            'total' => $new_total,
            'tax_amount' => $new_tax_amount,
            'grand_total' => $new_grand_total
        );

        $this->db->update('salesorders', $quotation_details, array('id' => $product_data->quotation_order_id));

        if ($this->db->delete('salesorders_products', array('id' => $product_id))) {
            return true;
        }
    }

    function get_invoices_last_id() {
        $query = "select * from invoices order by id DESC limit 1";

        $res = $this->db->query($query);

        if ($res->num_rows() > 0) {
            return $res->result("array");
        }
        return array();
    }

    function get_last_invoice_by_order($order_id) {
        $this->db->select('unpaid_amount, status');
        $this->db->from('invoices');
        $this->db->where(array('order_id' => $order_id));
        $this->db->order_by("id", "desc");
        return $this->db->get()->row();
    }

    function create_invoice($order_id) {
        $order_data = $this->salesorder_model->get_quotation($order_id);

        $total_fields = $this->salesorder_model->get_invoices_last_id();
        $last_id = $total_fields[0]['id'];

        $invoice_number = config('invoice_prefix') . "/" . date('Y') . "/00" . ($last_id + 1);

        $due_date = date('m/d/Y', strtotime(' + ' . $order_data->payment_term . ' days'));

        $invoice_details = array(
            'order_id' => $order_data->id,
            'customer_id' => $order_data->customer_id,
            'salesperson_id' => $order_data->sales_person,
            'sales_team_id' => $order_data->sales_team_id,
            'invoice_number' => $invoice_number,
            'invoice_date' => strtotime(date('m/d/Y')),
            'due_date' => strtotime($due_date),
            'payment_term' => $order_data->payment_term,
            'status' => 'Open Invoice',
            'total' => $order_data->total,
            'discount' => $order_data->discount,
            'tax_amount' => $order_data->tax_amount,
            'grand_total' => $order_data->grand_total,
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d')
        );

        $last_invoice = $this->salesorder_model->get_last_invoice_by_order($order_id);
        // && $last_invoice->status == 'Paid Invoice'
        if ($last_invoice->unpaid_amount > 0) {
            $invoice_details['unpaid_amount'] = $last_invoice->unpaid_amount;
        } else {
            $invoice_details['unpaid_amount'] = $order_data->grand_total;
        }

        $invoice_res = $this->db->insert('invoices', $invoice_details);

        $invoice_id = $this->db->insert_id();

        $qo_products = $this->salesorder_model->quot_order_products($order_id);

        foreach ($qo_products as $qo_product) {
            $products_add = array(
                'invoice_id' => $invoice_id,
                'product_id' => $qo_product->id,
                'product_name' => $qo_product->product_name,
                'discription' => $qo_product->discription,
                'quantity' => $qo_product->quantity,
                'price' => $qo_product->price,
                'sub_total' => $qo_product->sub_total
            );

            $invoices_products = $this->db->insert('invoices_products', $products_add);
        }

        //Actual Invoice update		
        $this->db->where('id', $order_data->sales_team_id);
        $this->db->set('actual_invoice', 'actual_invoice+' . $order_data->grand_total . '', FALSE);
        $this->db->update('salesteams');


        return $invoice_id;
    }

    function get_pricelist_version_by_pricelist_id($pricelist_id) {
        return $this->db->get_where('pricelist_version', array('pricelist_id' => $pricelist_id, 'start_date <=' => strtotime(date('Y-m-d')), 'end_date >=' => strtotime(date('Y-m-d'))))->row();
    }

    function get_pricelist_version_product($pricelist_ver_id, $product_id) {
        $data['product_price'] = $this->db->get_where('pricelist_versions_products', array('pricelist_versions_id' => $pricelist_ver_id, 'product_id' => $product_id))->row();
        return $data['product_price']->special_price;
    }

    function get_product_price($product_id, $pricelist_id) {
        $data['pricelist_version'] = $this->salesorder_model->get_pricelist_version_by_pricelist_id($pricelist_id);

        return $this->db->get_where('pricelist_versions_products', array('product_id' => $product_id, 'pricelist_versions_id' => $data['pricelist_version']->id))->row();
    }

    //added by Danni
    public function get_salesorder_by_staff($staff_id) {

        $this->db->where(array('sales_person' => $staff_id, 'quot_or_order' => 'o'));
        $this->db->order_by("id", "asc");
        $this->db->from('salesorders');
        return $this->db->get()->result();
    }

    //end added by Danni




    function get_detail_file($template_id) {
        $q = "SELECT * FROM salesorders_template_files WHERE id = '" . $template_id . "'";
        return $this->db->query($q)->row();
    }

    function get_templates() {
        $q = "SELECT * FROM salesorders_template_files ORDER BY is_used DESC ";
        return $this->db->query($q)->result();
    }

    function use_template($template_id) {
        $q1 = "UPDATE salesorders_template_files SET is_used = '0'";
        $this->db->query($q1);
        $q2 = "UPDATE salesorders_template_files SET is_used = '1' WHERE id = '" . $template_id . "'";
        $this->db->query($q2);
    }

    function delete_template($template_id) {
        $q2 = "delete from salesorders_template_files WHERE id = '" . $template_id . "'";
        $this->db->query($q2);
    }

    function print_doc_main($order_id) {
        $q = "SELECT 
        qs.id,
        qs.quotations_id,
        qs.opportunities_id,
        CONCAT('CO-',qs.quotations_number) AS quotations_number,
        qs.customer_id,
        qs.contact_id,
        qs.qtemplate_id,
        qs.date,
        qs.pricelist_id,
        qs.exp_date,
        CASE WHEN qs.payment_term  = '0' THEN 'Immediate Payment' ELSE CONCAT(qs.payment_term, ' Days'
) END AS term,
        CONCAT(c1.first_name,' ',c1.last_name) AS contact_name,
              CONCAT(u.first_name, ' ', u.first_name) AS sales_person,
        qs.sales_team_id,
        qs.terms_and_conditions AS remarks,
        c.name AS company_name,
        c.phone,
        c.fax,
        c.address,
        qs.status,
        qs.total,
        qs.discount,
        qs.tax_amount,
        qs.grand_total,
        qs.quot_or_order,
        qs.sales_order_create_date,
        qs.register_time,
        qs.archive,
        qs.create_by,
        qs.create_date,
        qs.changed_by,
        qs.changed_date
        FROM salesorders qs
       LEFT JOIN company c ON c.id = qs.customer_id
      LEFT JOIN customer c1 ON c1.id = qs.contact_id
      LEFT JOIN users u ON u.id = qs.sales_person
      WHERE qs.quotations_id = '$order_id'";

        return $this->db->query($q)->row();
    }

    function print_doc_details($quotation_id) {
        $q = "SELECT
        qsp.product_name, 
        qsp.quantity, 
        tms.system_value_txt AS uom,
        qsp.price,
        (qsp.quantity * qsp.price) * (p.tax/100) AS tax,
        qsp.sub_total,
        qsp.product_discount,
        qsp.discription
        FROM salesorders_products qsp
      LEFT JOIN products p ON p.id = qsp.product_id
            LEFT JOIN tb_m_system tms ON tms.system_type = 'UOM' AND tms.system_code = qsp.uom_id
      WHERE qsp.quotation_order_id = '$quotation_id'";
        return $this->db->query($q)->result();
    }

    function get_used_template() {
        $q = "SELECT template_path FROM salesorders_template_files qtf WHERE qtf.is_used = '1'";
        return $this->db->query($q)->row()->template_path;
    }

    function insert_template($data = array()) {
        $this->db->insert('salesorders_template_files', $data);
    }

}

?>