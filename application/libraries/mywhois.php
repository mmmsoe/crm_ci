<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//author : ucup
require_once APPPATH."/third_party/phpwhois/whois.main.php"; 
class Mywhois extends Whois { 
    public function __construct() { 
        parent::__construct(); 
    } 
}


?>