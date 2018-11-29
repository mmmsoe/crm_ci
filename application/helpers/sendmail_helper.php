<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function send_notice($email, $subject, $message) {
    $CI = & get_instance();


    $CI->load->library('email');
    $config['charset'] = 'utf-8';
    $config['mailtype'] = 'html';
    $CI->email->initialize($config);


    $CI->email->from(config('email'), config('first_name'));
    $CI->email->to($email);

    $CI->email->subject($subject);
    $CI->email->message($message);

    $CI->email->send();
}

/*
  function send_email($subject  = '', $to = '',  $body = '', $attachment = ''){
  $CI =& get_instance();


  $from_email = config('site_email');
  $from_name = config('site_name');

  $CI->load->library("email");
  $config['charset'] = 'utf-8';
  $config['mailtype'] = 'html';
  $CI->email->initialize($config);
  $CI->email->from($from_email, $from_name);
  $CI->email->to($to);
  $CI->email->subject($subject);
  $CI->email->message($body);

  if($attachment != '')
  $CI->email->attach($attachment);

  if($CI->email->send()){
  return true;
  }


  } */

function send_email($subject = '', $to = '', $body = '', $attachment = '') {
    $CI = & get_instance();



    $CI->load->library('email');
    $CI->load->helper('path');


    // Configure email library

    if (userdata('smtp_host') != "" and userdata('smtp_port') != "" and userdata('smtp_user') != "" and userdata('smtp_pass') != "") {
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = userdata('smtp_host');
        $config['smtp_port'] = userdata('smtp_port');
        $config['smtp_user'] = userdata('smtp_user');
        $config['smtp_pass'] = userdata('smtp_pass');
    }

    $config['mailtype'] = 'html';
    $config['charset'] = 'iso-8859-1';
    $config['smtp_crypto'] = "tls";
    $config['newline'] = "\r\n";
    $CI->email->initialize($config);


    $CI->email->from(userdata('email'), userdata('first_name') . ' ' . userdata('last_name'));
    $CI->email->to($to);

    $CI->email->subject($subject);
    $CI->email->message($body);

    $path = set_realpath('pdfs/');
    $CI->email->attach($path . $attachment);

    //$CI->email->attach($attachment);

    if ($CI->email->send()) {
        return true;
    }
}

?>