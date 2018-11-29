<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quotations_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add_quotation() {
        $total_fields = $this->quotations_model->get_quotations_last_id();
        $last_id = $total_fields;
        $next = $last_id + 1;
        $leng = strlen($next);
        switch ($leng) {
            case 1 :
                $quotation_no = "SO" . date('Ym') . '0000' . $next;
                break;
            case 2 :
                $quotation_no = "SO" . date('Ym') . '000' . $next;
                break;
            case 3 :
                $quotation_no = "SO" . date('Ym') . '00' . $next;
                break;
            case 4 :
                $quotation_no = "SO" . date('Ym') . '0' . $next;
                break;
            case 5 :
                $quotation_no = "SO" . date('Ym') . $next;
                break;
            default:
                $quotation_no = "SO" . date('Ym') . '00001';
                break;
        }

        $quotation_details = array(
            'quotations_number' => $quotation_no,
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
            'register_time' => strtotime(date('Y-m-d')),
            'quot_or_order' => 'q',
            'archive' => $this->input->post('archive'),
            'create_by' => userdata('first_name') . " " . userdata('last_name'),
            'create_date' => date('Y-m-d')
        );

        if ($_FILES['file_quotation']['name'] != ""){
            $file_name = $this->upload_file_crm('file_quotation');
            if ($file_name != false){
                $quotation_details['file_quotation'] = $file_name; 
            }
        }

        $quotations_res = $this->db->insert('quotations_salesorder', $quotation_details);
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

            $qtemplate_products = $this->db->insert('quotations_salesorder_products', $products_add);
            $id_salesproduct = $this->db->insert_id();
            $products_add->id = $id_salesproduct;
            //$this->db->insert('salesorders_products', $products_add);
        }


        return $quotation_order_id;
    }

    function update_quotation() {

        $quotation_details['customer_id'] = $this->input->post('customer_id');
        $quotation_details['contact_id'] = $this->input->post('contact_id');
        $quotation_details['qtemplate_id'] = $this->input->post('quotation_template');
        $quotation_details['date'] = strtotime($this->input->post('date'));
        $quotation_details['pricelist_id'] = $this->input->post('pricelist_id');
        $quotation_details['exp_date'] = strtotime($this->input->post('expiration_date'));
        $quotation_details['payment_term'] = $this->input->post('payment_term');
        $quotation_details['sales_person'] = $this->input->post('salesperson_id');
        $quotation_details['sales_team_id'] = $this->input->post('sales_team_id');
        $quotation_details['terms_and_conditions'] = $this->input->post('terms_and_conditions');
        $quotation_details['status'] = $this->input->post('status');
        $quotation_details['discount'] = $this->input->post('total_discount');
        $quotation_details['total'] = $this->input->post('total');
        $quotation_details['tax_amount'] = $this->input->post('tax_amount');
        $quotation_details['grand_total'] = $this->input->post('grand_total');
        $quotation_details['archive'] = $this->input->post('archive');
        $quotation_details['changed_by'] = userdata('first_name') . " " . userdata('last_name');
        $quotation_details['changed_date'] = date('Y-m-d');

        if ($_FILES['file_quotation']['name'] != ""){
            $file_name = $this->upload_file_crm('file_quotation');
            if ($file_name != false){
                $quotation_details['file_quotation'] = $file_name; 
            }
        }


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

                $this->db->update('quotations_salesorder_products', $products_edit, array('id' => $this->input->post('quotation_product_id')[$i]));
                //$this->db->update('salesorders_products', $products_edit, array('id' => $this->input->post('quotation_product_id')[$i]));
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

                $qo_products = $this->db->insert('quotations_salesorder_products', $products_add);
                $id_salesproduct = $this->db->insert_id();
                $products_add->id = $id_salesproduct;
                //$qo_products = $this->db->insert('salesorders_products', $products_add);
            }
        }

        return $this->db->update('quotations_salesorder', $quotation_details, array('id' => $this->input->post('quotation_id')));
    }

    function quotations_list($customer_id) {
        $id = userdata('id');
        if ($this->user_model->get_role(userdata('id'))[0]->role_id != '1') {
            $salesteam_id = $this->dashboard_model->get_staff_salesteam($id);

            $this->db->where('sales_person', $id);
            $this->db->or_where('sales_team_id', $salesteam_id);
        }

        if ($customer_id != "") {
            $this->db->where(array('customer_id' => $customer_id));
        }

        $this->db->where('archive', 0);
        $this->db->or_where('archive', NULL);

        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

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
            $this->db->where(array('customer_id' => $customer_id));
        }

        $this->db->where(array('archive' => '1'));

        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

        return $this->db->get()->result();
    }

//Filter data Potensial Report
    function potensial_list($customer_id, $x, $y) {
        if ($customer_id != '1') {
            $this->db->where('customer_id', $customer_id);
        }

        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

        return $this->db->get()->result();
    }

    function report_getfilter($staff_id, $filter) {
        if ($staff_id != '1') {
            $this->db->where('customer_id', $staff_id);
        }
        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';

        if ($filter == "todays") {
            $this->db->where('date', strtotime(date('Y/m/d')));
            $this->db->where(array('quot_or_order' => 'o'));
        } else if ($filter == "month") {
            $this->db->where('date >=', strtotime($startDate));
            $this->db->where('date <', strtotime($endDate));
            $this->db->where(array('quot_or_order' => 'o'));
        }


        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

        return $this->db->get()->result();
    }

    function get_quotation($quotation_id) {
        // return $this->db->get_where('quotations_salesorder',array('id' => $quotation_id,'quot_or_order' => 'q'))->row();
        return $this->db->get_where('quotations_salesorder', array('id' => $quotation_id))->row();
    }

    function delete($quotation_id) {

        if ($this->db->delete('quotations_salesorder', array('id' => $quotation_id))) {  // Delete customer
            return true;
        }
    }

    //Get last row
    function get_quotations_last_id() {
        $query = "select * from quotations_salesorder where register_time = '" . strtotime(date('Y-m-d')) . "' order by id DESC";

        $res = $this->db->query($query);

        // if($res->num_rows() > 0) {
        // return $res->result("array");
        // }
        return $res->num_rows();
    }

    function confirm_sales_order($quotation_id) {
        $quotation_data = $this->quotations_model->get_quotation($quotation_id);
        $this->db->update('opportunities', array('closed_status' => 1, 'stages_id' => '07'), array('id' => $quotation_data->opportunities_id));

        $quotation_details = array(
            //'quot_or_order' => 'o',
            'sales_order_create_date' => strtotime(date('Y-m-d')),
            'changed_by' => userdata('first_name') . " " . userdata('last_name'),
            'changed_date' => date('Y-m-d')
        );
        /*
          $q = "
          INSERT INTO salesorders_products
          SELECT * FROM quotations_salesorder_products WHERE quotation_order_id  = '".$quotation_id."'";
          $this->db->query($q); */
        return $this->db->update('quotations_salesorder', $quotation_details, array('id' => $quotation_id));
    }

    function quot_order_products($qo_id) {
        $this->db->where(array('quotation_order_id' => $qo_id));
        $this->db->order_by("id", "ASC");
        $this->db->from('quotations_salesorder_products');

        return $this->db->get()->result();
    }

    function updt_stage($opp_id) {

        $opp_details = array(
            'stages_id' => '07'
        );

        $this->db->update('opportunities', $opp_details, array('id' => $opp_id));
    }

    function get_qo_product($product_id) {
        return $this->db->get_where('quotations_salesorder_products', array('id' => $product_id))->row();
    }

    function delete_qo_product($product_id) {
        $product_data = $this->quotations_model->get_qo_product($product_id);
        $quotations_data = $this->quotations_model->get_quotation($product_data->quotation_order_id);

        $q = "SELECT COUNT(*) as cnt FROM salesorders_products WHERE quotation_order_id = '" . $product_data->quotation_order_id . "' AND product_id = '" . $product_data->product_id . "'";
        $cnt = $this->db->query($q)->row()->cnt;

        if ($cnt > 0) {
            return false;
        } else {
            $new_total = number_format($quotations_data->total - $product_data->price, 2, '.', '');

            $new_tax_amount = $quotations_data->tax_amount - number_format($product_data->quantity * $product_data->price * config('sales_tax') / 100, 2, '.', ' ');

            $new_grand_total = number_format($new_total + $new_tax_amount, 2, '.', '');

            $quotation_details = array(
                'total' => $new_total,
                'tax_amount' => $new_tax_amount,
                'grand_total' => $new_grand_total
            );

            $this->db->update('quotations_salesorder', $quotation_details, array('id' => $product_data->quotation_order_id));

            if ($this->db->delete('quotations_salesorder_products', array('id' => $product_id))) {
                $this->db->delete('salesorders_products', array('id' => $product_id));
                return true;
            }
        }
    }

    function get_pricelist_version_by_pricelist_id($pricelist_id) {
        return $this->db->get_where('pricelist_version', array('pricelist_id' => $pricelist_id, 'start_date <=' => strtotime(date('Y-m-d')), 'end_date >=' => strtotime(date('Y-m-d'))))->row();
    }

    function get_pricelist_version_product($pricelist_ver_id, $product_id) {
        $data['product_price'] = $this->db->get_where('pricelist_versions_products', array('pricelist_versions_id' => $pricelist_ver_id, 'product_id' => $product_id))->row();
        return $data['product_price']->special_price;
    }

    function get_product_price($product_id, $pricelist_id) {
        $data['pricelist_version'] = $this->quotations_model->get_pricelist_version_by_pricelist_id($pricelist_id);

        return $this->db->get_where('pricelist_versions_products', array('product_id' => $product_id, 'pricelist_versions_id' => $data['pricelist_version']->id))->row();
    }

    function number_to_word($num = '') {
        $num = (string) ( (int) $num );

        if ((int) ( $num ) && ctype_digit($num)) {
            $words = array();

            $num = str_replace(array(',', ' '), '', trim($num));

            $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');

            $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred');

            $list3 = array('', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion');

            $num_length = strlen($num);
            $levels = (int) ( ( $num_length + 2 ) / 3 );
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = (int) ( $num_part / 100 );
                $hundreds = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
                $tens = (int) ( $num_part % 100 );
                $singles = '';

                if ($tens < 20) {
                    $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
                } else {
                    $tens = (int) ( $tens / 10 );
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ( $num_part % 10 );
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . ( ( $levels && (int) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
            }

            $commas = count($words);

            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words = implode(', ', $words);

            //Some Finishing Touch
            //Replacing multiples of spaces with one space
            $words = trim(str_replace(' ,', ',', trim_all(ucwords($words))), ', ');
            if ($commas) {
                $words = str_replace_last(',', ' and', $words);
            }

            return $words;
        } else if (!( (int) $num )) {
            return 'Zero';
        }
    }

    function get_detail_file($template_id) {
        $q = "SELECT * FROM quotations_template_files WHERE id = '" . $template_id . "'";
        return $this->db->query($q)->row();
    }

    function get_templates() {
        $q = "SELECT * FROM quotations_template_files ORDER BY is_used DESC ";
        return $this->db->query($q)->result();
    }

    function use_template($template_id) {
        $q1 = "UPDATE quotations_template_files SET is_used = '0'";
        $this->db->query($q1);
        $q2 = "UPDATE quotations_template_files SET is_used = '1' WHERE id = '" . $template_id . "'";
        $this->db->query($q2);
    }

    function delete_template($template_id) {
        $q2 = "delete from quotations_template_files WHERE id = '" . $template_id . "'";
        $this->db->query($q2);
    }

    function print_doc_main($quotation_id) {
        $q = "SELECT 
        qs.id AS quotation_id, 
        qs.opportunities_id,  
        CONCAT('CO-',qs.quotations_number) AS quotations_number,
        qs.terms_and_conditions AS remarks,
        CASE WHEN qs.payment_term  = '0' THEN 'Immediate Payment' ELSE CONCAT(qs.payment_term, ' Days') END AS term,
        c.name AS company_name,
        c.phone,
        c.fax,
        c.address,
        CONCAT(c1.first_name,' ',c1.last_name) AS contact_name,
        CONCAT(u.first_name, ' ', u.first_name) AS sales_person,
        qs.total,
        qs.discount,
        qs.tax_amount,
        qs.grand_total
        FROM quotations_salesorder qs
        LEFT JOIN company c ON c.id = qs.customer_id
        LEFT JOIN customer c1 ON c1.id = qs.contact_id
        LEFT JOIN users u ON u.id = qs.sales_person
        WHERE qs.id = '$quotation_id'";

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
      FROM quotations_salesorder_products qsp 
      LEFT JOIN products p ON p.id = qsp.product_id
      LEFT JOIN tb_m_system tms ON tms.system_type = 'UOM' AND tms.system_code = qsp.uom_id
      WHERE qsp.quotation_order_id = '$quotation_id'";
        return $this->db->query($q)->result();
    }

    function get_used_template() {
        $q = "SELECT template_path FROM quotations_template_files qtf WHERE qtf.is_used = '1'";
        return $this->db->query($q)->row()->template_path;
    }

    function insert_template($data = array()) {
        $this->db->insert('quotations_template_files', $data);
    }

    function get_expired($dt_date) {
        $q = "select date_Format(DATE_ADD('" . $dt_date . "',INTERVAL (select quotation_exp from settings where id = 1) DAY), '%m-%d-%Y 00:00') as date_exp";
        return $this->db->query($q)->row()->date_exp;
    }

    function upload_file_crm($input_file_name)
    {
        date_default_timezone_set('Asia/Jakarta');    
        $this->load->library('upload');

        $upload_path  = './uploads/contacts';
        $allowed_types = 'gif|jpg|jpeg|png|ico|mp3|mp4|mpeg|ogg|pdf|webm|GIF|JPG|JPEG|PNG|ICO|MP3|MP4|MPEG|OGG|PDF|WEBM';
        $pattern = "/.gif|.jpg|.jpeg|.png|.ico|.mp3|.mp4|.mpeg|.ogg|.pdf|.webm|.GIF|.JPG|.JPEG|.PNG|.ICO|.MP3|.MP4|.MPEG|.OGG|.PDF|.WEBM$/";

        $fileName = $_FILES[$input_file_name]['name'];
        $fileType = $_FILES[$input_file_name]['type'];
        $fileError = $_FILES[$input_file_name]['error'];
        $fileContent = file_get_contents($_FILES[$input_file_name]['tmp_name']);

        $newname = "";
        if (preg_match($pattern, $fileName, $matches,PREG_OFFSET_CAPTURE)) 
        {
            $ext = $matches[0][0];
            $oldname = str_replace($ext, "", $fileName);
            $newname = 'crm_'.date("Ymd_His").$ext;

            $config = array(
                'file_name'     => $newname,
                'upload_path'   => $upload_path,
                'allowed_types' => $allowed_types,
                'overwrite'     => 1,
                'max_size'     => '99999999'
            );
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload($input_file_name)) 
            {
                // return json_encode(array('error' => $this->upload->display_errors()));
                return false;
            } else {
                // Continue processing the uploaded data
                $this->upload->data();
                return $newname;
            }
        } else {
            // not allowed file type
            return false;
        }
    }

}

?>