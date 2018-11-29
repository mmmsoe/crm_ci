<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mailbox extends CI_Controller {

    public $hostname = '{imap.gmail.com:993/imap/ssl}';
    public $username = 'nightfellas@gmail.com';
    public $password = 'D43m0n1c';

    function Mailbox() {
        parent::__construct();
        $this->load->database();
        $this->load->model("mailbox_model");
        $this->load->model("customers_model");
        $this->load->model("staff_model");
        $this->load->model("contact_persons_model");
        $this->load->model("user_model", "um");

        $this->load->library('form_validation');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        check_login();
    }

    function index($customer_id = '') {
        // $data['email_list'] = $this->mailbox_model->email_list(userdata('id'), $customer_id);
        //$data['sent_email_list'] = $this->mailbox_model->sent_email_list(userdata('id'), $customer_id);

        $data['contact_persons'] = $this->contact_persons_model->contact_persons_list();
        $data['customers'] = $this->customers_model->company_list();
        $data['email_type'] = $this->mailbox_model->email_type();

        $data['customer_id'] = $customer_id;

        $this->load->view('header');
        $this->load->view('mailbox/index', $data);
        $this->load->view('footer');
    }

    function send_email() {
        if ($this->input->post('check_mail') > 0) {
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
            } else {
                if ($this->reply_mail()) {
                    echo 'yes_';
//                    $user = $this->um->get_mail_config();
//                    $dt = new DateTime();
//                    $this->mailbox_model->add_mail(
//                            $this->input->post('assign_customer_id')
//                            , $this->input->post('opportunity_id')
//                            , $this->input->post('subject')
//                            , $dt->format('Y-m-d H:i:s')
//                            , $user->smtp_user
//                    );
                } else {
                    echo $this->lang->line('technical_problem');
                }
            }
        } else {
            $this->form_validation->set_rules('assign_customer_id', 'Assign Customer', 'required');

            $this->form_validation->set_rules('contact_id', 'Selet Email', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');

            if ($this->form_validation->run() == FALSE) {
                echo '<div class="alert error" style="color:red">' . validation_errors() . '</div>';
            } else {
                if ($this->process_email()) {
                    echo 'yes_';
                    $user = $this->um->get_mail_config();
                    $dt = new DateTime();
                    $this->mailbox_model->add_mail(
                            $this->input->post('assign_customer_id')
                            , $this->input->post('opportunity_id')
                            , $this->input->post('subject')
                            , $dt->format('Y-m-d H:i:s')
                            , userdata('id')
                    );
                } else {
                    echo $this->lang->line('technical_problem');
                }
            }
        }
    }

    //add by kaka: (20160804)
    private function _imap_test() {
        $stream = imap_open("{smtp.gmail.com}INBOX.Drafts", "atd.arkamaya@gmail.com", "satu2tiga");

        $check = imap_check($stream);
        echo "Msg Count before append: " . $check->Nmsgs . "\n";

        imap_append($stream, "{smtp.gmail.com}INBOX.Drafts"
                , "From: atd.arkamaya@gmail.com\r\n"
                . "To: kakangrif@gmail.com\r\n"
                . "Subject: test\r\n"
                . "\r\n"
                . "this is a test message, please ignore\r\n"
        );

        $check = imap_check($stream);
        echo "Msg Count after append : " . $check->Nmsgs . "\n";

        imap_close($stream);
    }

    function get_rowmail(){
        $rowmail =  $this->mailbox_model->get_rowmail($this->input->post('company_id'));
        echo json_encode($rowmail);
    }

    private function process_email() {
        //read user config.
        $user = $this->um->get_mail_config();

        $this->load->library('email');
        $config = array();
        $config['charset'] = 'utf-8';
        $config['useragent'] = 'A2000CRM';
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = $user->smtp_host; //"ssl://smtp.gmail.com"; //pengaturan smtp
        $config['smtp_port'] = $user->smtp_port; //"465";
        $config['smtp_timeout'] = "400";
        $config['smtp_user'] = $user->smtp_user;
        $config['smtp_pass'] = $user->smtp_pass;
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        //memanggil library email dan set konfigurasi untuk pengiriman email
        $this->email->initialize($config);

        //konfigurasi pengiriman
        $this->email->from($user->smtp_user);
        $this->email->to($this->input->post('contact_id'));
        $this->email->subject($this->input->post('subject'));
        $this->email->message($this->input->post('message'));

        if ($this->email->send()) {
            //echo "Berhasil kirim email, silahkan cek email lurd..";
            return true;
        } else {
            //echo "Gagal kirim email, ceurik ahh..";
            return false;
        }
    }

    function ajax_contact_list($company_id) {
        $data['contact_persons'] = $this->contact_persons_model->get_contact_persons_by_company($company_id);
        $this->load->view('ajax_get_contacts', $data);
    }

    /*
     * deletes category     *  
     */

    function delete($mail_id) {

        if ($this->mailbox_model->delete($mail_id)) {
            echo 'deleted';
        }
    }

    function sendsms($message) {
        $url = "https://rest.nexmo.com/sms/json?api_key=ee9b0119&api_secret=99be933be7a4f6fa&from=NEXMO&to=6285722760852&text=" . $message;
        //$url = "https://rest.nexmo.com/sms/json";
        //$url = "http://localhost/ssem/ssem_api/send_sms_api";

        $data = array
            (
            "api_key" => "ee9b0119",
            "api_secret" => "99be933be7a4f6fa",
            "from" => "NEXMO",
            "to" => "628722760852",
            "text" => "this is a test sms"
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, TRUE);
        echo print_r($response);
    }

    function get_emails() {
        $user = $this->um->get_mail_config();
        $place = $this->input->post('place');
        if ($place == "") {
            $place = "INBOX";
        }
        $mailconfig = array(
            'user' => $user->smtp_user,
            'password' => $user->smtp_pass,
            'imap_host' => $user->imap_host,
            'imap_port' => $user->imap_port,
            'mailbox_place' => $place,
            'start' => $_POST['start'],
            'length' => $_POST['length']
        );

        $this->load->library('Mails', $mailconfig);
        $data = $this->mails->get_emails();

        $res = array();
        $total_mails = 0;

        for ($i = 0; $i < count($data); $i++) {
            $total_mails = $data[$i]['total_mails'];


            $act = '';
            $act .= '<a href="#" onclick="javascript:delete_mail(' . $data[$i]['uid'] . ')" class=" btn btn-sm btn-w btn-danger btn-embossed dlt_sm_table"><i class="glyphicon glyphicon-trash"></i></a>';
            $act .= '<a href="#" onclick="javascript:set_reply(' . "'" . $data[$i]['uid'] . "','" . $place . "','" . $data[$i]['from'] . "','" . $data[$i]['subject'] . "'" . ')" class=" btn btn-sm btn-w btn-default btn-embossed dlt_sm_table" data-toggle="modal" data-target="#modal-create_email"><i class="fa fa-reply"></i></a>';
            $act .= '<a href="#" onclick="javascript:set_forward(' . $data[$i]['uid'] . ',\'' . $place . '\')" class=" btn btn-sm btn-w btn-default btn-embossed dlt_sm_table" data-toggle="modal" data-target="#modal-create_email"><i class="glyphicon glyphicon-arrow-right"></i></a>';
            $row = array(
                'subject' => '<a href="javascript:read_email(' . $data[$i]['uid'] . ',\'' . $place . '\')">' . ($data[$i]['seen'] ? '' : '<b>') . $data[$i]['subject'] . ($data[$i]['seen'] ? '' : '</b>') . '</a>',
                'from' => $data[$i]['from'],
                'date' => $data[$i]['date'],
                'act' => $act
            );
            $res[] = $row;
        }


        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $total_mails,
            'recordsFiltered' => $total_mails,
            'data' => $res
        );
        echo json_encode($output);
    }

    function read_email() {
        $user = $this->um->get_mail_config();
        $mailconfig = array(
            'user' => $user->smtp_user,
            'password' => $user->smtp_pass,
            'imap_host' => $user->imap_host,
            'imap_port' => $user->imap_port,
            'mailbox_place' => $this->input->post('place'),
            'attachment_root_dir' => 'attachments/' . $this->session->userdata('id'),
            'uid' => $this->input->post('uid')
        );

        $this->load->library('Mails', $mailconfig);
        $data = $this->mails->read_email();

        $attachment = '';
        if (isset($data['attachment'])) {
            for ($i = 0; $i < count($data['attachment']); $i++) {
                $attachment.='<a href="' . base_url() . $data['attachment_dir'] . $data['attachment'][$i] . '" download>' . $data['attachment'][$i] . '</a>,';
            }
            $attachment = substr($attachment, 0, strlen($attachment) - 1);
        }


        echo json_encode(array(
            "subject" => $data['subject'],
            "from" => $data['from'],
            "date" => $data['date'],
            "message" => base64_encode($data['message']),
            "sender" => $data['sender'],
            "attachment" => $attachment
        ));
    }

    function sendmail() {

        $user = $this->um->get_mail_config();
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => $user->smtp_host,
            'smtp_port' => $user->smtp_port,
            'smtp_user' => $user->smtp_user, // change it to yours
            'smtp_pass' => $user->smtp_pass, // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE,
            'smtp_crypto' => 'ssl'//,
                //'smtp_crypto' = 'ssl'
        );

        $message = 'test deui wae lah ti A2000';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($user->smtp_user); // change it to yours
        $this->email->to($this->input->post('contact_id')[$i]); // change it to yours
        $this->email->subject($this->input->post('subject'));
        $this->email->message($this->input->post('message'));
        //$this->email->attach('uploads/words/5db29d6724fab377987818755a1c9a4e.jpg');


        if ($this->email->send()) {
            echo json_encode($json_data);
        } else {
            show_error($this->email->print_debugger());
            $error = 3;
            $err_message = $this->email->print_debuger();
            $json_data = array('error' => $error, 'message' => $err_message);
            echo json_encode($json_data);
        }
    }

    private function reply_mail() {
        $user = $this->um->get_mail_config();

        $this->load->library('email');
        $config = array();
        $config['charset'] = 'utf-8';
        $config['useragent'] = 'A2000CRM';
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = $user->smtp_host; //"ssl://smtp.gmail.com"; //pengaturan smtp
        $config['smtp_port'] = $user->smtp_port; //"465";
        $config['smtp_timeout'] = "400";
        $config['smtp_user'] = $user->smtp_user;
        $config['smtp_pass'] = $user->smtp_pass;
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;

        //memanggil library email dan set konfigurasi untuk pengiriman email
        $this->email->initialize($config);

        //konfigurasi pengiriman
        $this->email->from($user->smtp_user);
        $this->email->to($this->input->post('recipient'));
        $this->email->subject($this->input->post('subject'));
        $this->email->message($this->input->post('message'));

        if ($this->email->send()) {
            //echo "Berhasil kirim email, silahkan cek email lurd..";
            return true;
        } else {
            //echo "Gagal kirim email, ceurik ahh..";
            return false;
        }
    }

    public function delete_mail() {
        $user = $this->um->get_mail_config();
        $mailconfig = array(
            'user' => $user->smtp_user,
            'password' => $user->smtp_pass,
            'imap_host' => $user->imap_host,
            'imap_port' => $user->imap_port,
            'uid' => $this->input->post('msg_no')
        );

        $this->load->library('Mails', $mailconfig);
        $data = $this->mails->delete_mail();

        echo "ok";
    }

}
