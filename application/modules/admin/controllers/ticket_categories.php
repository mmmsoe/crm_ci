<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ticket_categories extends CI_Controller {

    function ticket_categories() {
        parent::__construct();
        /* cache control */
        $this->load->model('ticket_categories_model', 'tc');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        check_login();
    }
    
    function index()
    { 
       
        $this->load->view('header');
        $this->load->view('ticket_categories/index');
        $this->load->view('footer');
    }

    function get_filter() {
        $data = array();
        $no = $_POST['start'];
        $o = $this->input->post('order');
        $s = $this->input->post('search');
        $order = $o[0]['column'];
        $order_dir = $o[0]['dir'];
        $search_value = $s['value'];

        switch ($order) {
            case 0:
                $order = "ticket_category_name";
                break;
        }

        $r = $this->tc->categories_data($order, $order_dir, $search_value);
        
        foreach ($r as $l) {
            $no++;

            $row = array(
                "ticket_category_name" => $l->ticket_category_name,
                'act' => ""
            );
            $data[] = $row;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->tc->count_filtered($order, $order_dir, $search_value),
            'recordsFiltered' => $this->tc->count_filtered($order, $order_dir, $search_value),
            'data' => $data
        );

        echo json_encode($output);
    }

}
