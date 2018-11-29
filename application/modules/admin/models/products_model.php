<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add_products() {
        if (empty($_FILES['product_image']['name'])) {

            $products_details = array(
                'product_name' => $this->input->post('product_name'),
                'internal_category' => $this->input->post('internal_category'),
                'product_type' => $this->input->post('product_type'),
                'status' => $this->input->post('status'),
                'tax' => $this->input->post('tax'),
                'quantity_on_hand' => $this->input->post('quantity_on_hand'),
                'quantity_available' => $this->input->post('quantity_available'),
                'tax' => $this->input->post('tax'),
                'uom_id' => $this->input->post('uom_id'),
                // 'total_uom' => $this->input->post('total_uom'),
                'sale_price' => $this->input->post('sale_price'),
                'description' => $this->input->post('description'),
                'active' => $this->input->post('active'),
                'description_for_quotations' => $this->input->post('description_for_quotations'),
            );
        } else {

            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = config('allowed_extensions');
            //$config['max_size']	= config('max_upload_file_size');
            $config['max_size'] = 300;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('product_image')) {

                $err = $this->upload->display_errors();
                if (trim($err) == "<p>The file you are attempting to upload is larger than the permitted size.</p>") {
                    $err = "<p>The file you are attempting to upload is larger than the permitted size. Max uploaded size is 300KB</p>";
                }
                echo $err;
            } else {
                $img_data = $this->upload->data();

                $config2['image_library'] = 'gd2';
                $config2['source_image'] = './uploads/products/' . $img_data['file_name'];
                $config2['new_image'] = './uploads/products/';
                $config2['maintain_ratio'] = TRUE;
                $config2['create_thumb'] = false;
                //$config2['thumb_marker'] = '_thumb';
                $config2['width'] = 150;
                $config2['height'] = 100;
                $this->load->library('image_lib', $config2);

                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('errors', $this->image_lib->display_errors('', ''));
                }


                $products_details = array(
                    'product_name' => $this->input->post('product_name'),
                    'product_image' => $img_data['file_name'],
                    'internal_category' => $this->input->post('internal_category'),
                    'product_type' => $this->input->post('product_type'),
                    'status' => $this->input->post('status'),
                    'tax' => $this->input->post('tax'),
                    'quantity_on_hand' => $this->input->post('quantity_on_hand'),
                    'quantity_available' => $this->input->post('quantity_available'),
                    'tax' => $this->input->post('tax'),
                    'uom_id' => $this->input->post('uom_id'),
                    // 'total_uom' => $this->input->post('total_uom'),
                    'sale_price' => $this->input->post('sale_price'),
                    'description' => $this->input->post('description'),
                    'active' => $this->input->post('active'),
                    'description_for_quotations' => $this->input->post('description_for_quotations'),
                );
            }
        }
        $product_res = $this->db->insert('products', $products_details);

        $product_id = $this->db->insert_id();

        //Add variants 
        $check_attr = $this->input->post('attribute_name');
        if (!empty($check_attr)) {
            $count = count($this->input->post('attribute_name'));

            for ($i = 0; $i < $count; $i++) {
                $data = array(
                    'product_id' => $product_id,
                    'attribute_name' => $this->input->post('attribute_name')[$i],
                    'product_attribute_value' => $this->input->post('product_attribute_value')[$i]
                );

                $product_variant = $this->db->insert('product_variants', $data);
            }
        }


        return $product_res;
    }

    function update_products() {
        if (empty($_FILES['product_image']['name'])) {

            $products_details = array(
                'product_name' => $this->input->post('product_name'),
                'internal_category' => $this->input->post('internal_category'),
                'product_type' => $this->input->post('product_type'),
                'status' => $this->input->post('status'),
                'tax' => $this->input->post('tax'),
                'quantity_on_hand' => $this->input->post('quantity_on_hand'),
                'quantity_available' => $this->input->post('quantity_available'),
                'tax' => $this->input->post('tax'),
                'uom_id' => $this->input->post('uom_id'),
                // 'total_uom' => $this->input->post('total_uom'),
                'sale_price' => $this->input->post('sale_price'),
                'description' => $this->input->post('description'),
                'active' => $this->input->post('active'),
                'description_for_quotations' => $this->input->post('description_for_quotations'),
            );
        } else {

            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = config('allowed_extensions');
            $config['max_size'] = config('max_upload_file_size');
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('product_image')) {

                echo $this->upload->display_errors();
            } else {
                $img_data = $this->upload->data();

                $config2['image_library'] = 'gd2';
                $config2['source_image'] = './uploads/products/' . $img_data['file_name'];
                $config2['new_image'] = './uploads/products';
                $config2['maintain_ratio'] = TRUE;
                $config2['create_thumb'] = false;
                //$config2['thumb_marker'] = '_thumb';
                $config2['width'] = 150;
                $config2['height'] = 100;
                $this->load->library('image_lib', $config2);

                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('errors', $this->image_lib->display_errors('', ''));
                }

                $products_details = array(
                    'product_name' => $this->input->post('product_name'),
                    'product_image' => $img_data['file_name'],
                    'internal_category' => $this->input->post('internal_category'),
                    'product_type' => $this->input->post('product_type'),
                    'status' => $this->input->post('status'),
                    'tax' => $this->input->post('tax'),
                    'quantity_on_hand' => $this->input->post('quantity_on_hand'),
                    'quantity_available' => $this->input->post('quantity_available'),
                    'tax' => $this->input->post('tax'),
                    'uom_id' => $this->input->post('uom_id'),
                    // 'total_uom' => $this->input->post('total_uom'),
                    'sale_price' => $this->input->post('sale_price'),
                    'description' => $this->input->post('description'),
                    'active' => $this->input->post('active'),
                    'description_for_quotations' => $this->input->post('description_for_quotations'),
                );
            }
        }

        //Add or Edit variants 
        $check_attr = $this->input->post('attribute_name');
        if (!empty($check_attr)) {

            $count = count($this->input->post('attribute_name'));
            for ($i = 0; $i < $count; $i++) {

                if (isset($this->input->post('variant_id')[$i])) {
                    $variants_edit = array(
                        'attribute_name' => $this->input->post('attribute_name')[$i],
                        'product_attribute_value' => $this->input->post('product_attribute_value')[$i]
                    );

                    $this->db->update('product_variants', $variants_edit, array('id' => $this->input->post('variant_id')[$i]));
                } else {
                    $variants_add = array(
                        'product_id' => $this->input->post('product_id'),
                        'attribute_name' => $this->input->post('attribute_name')[$i],
                        'product_attribute_value' => $this->input->post('product_attribute_value')[$i]
                    );

                    $product_variant = $this->db->insert('product_variants', $variants_add);
                }
            }
        }

        return $this->db->update('products', $products_details, array('id' => $this->input->post('product_id')));
    }

    function products_list() {
        $this->db->order_by("id", "asc");
        $this->db->from('products');

        return $this->db->get()->result();
    }

    function get_products($product_id) {
        return $this->db->get_where('products', array('id' => $product_id))->row();
    }

    function check_used_product($product_id) {
        $q = "SELECT COUNT(product_id) AS cnt FROM (
        SELECT product_id FROM salesorders_products sp WHERE sp.product_id = '" . $product_id . "'
        UNION ALL
        SELECT product_id FROM quotations_salesorder_products qsp WHERE qsp.product_id = '" . $product_id . "'
        UNION ALL 
        SELECT product_id FROM invoices_products qsp WHERE qsp.product_id = '" . $product_id . "'
        )t;";
        return $this->db->query($q)->row()->cnt;
    }

    function delete($product_id) {
        if ($this->check_used_product($product_id) == 0) {
            $this->db->delete('product_variants', array('product_id' => $product_id));

            if ($this->db->delete('products', array('id' => $product_id))) {  // Delete customer
                return true;
            }
        } else {
            return false;
        }
    }

    function product_variants($product_id) {
        $this->db->where(array('product_id' => $product_id));
        $this->db->order_by("id", "desc");
        $this->db->from('product_variants');

        return $this->db->get()->result();
    }

    function delete_variant($variant_id) {
        if ($this->db->delete('product_variants', array('id' => $variant_id))) {  // Delete customer
            return true;
        }
    }

}

?>