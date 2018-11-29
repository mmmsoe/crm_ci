<?php

class Sms_manager {

    protected $user;
    protected $password;
    protected $recepients = array();
    protected $api_id; /*     * This is for clickatell gateway* */
    protected $phone_numbner;
    protected $gateway_name;
    protected $gateway_id;
    protected $user_id;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
        $this->user_id = $this->CI->session->userdata("id");
        //ignore_user_abort(TRUE);
    }

    // ========private methods=================
    private function run_curl($url) {
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        // grab URL and pass it to the browser
        $response = curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);
        return $response;
    }

    public function set_credential($id) /*     * $api_id is for clickatell gateway** */ {
        
        $q = "select * from sms_api_config where status='1' and  id='$id'";
        $query = $this->CI->db->query($q);
        $results = $query->result_array();

        if (count($results) == 0)
            return false;
        foreach ($results as $info) {

            $gateway = $info['gateway_name'];
            $auth_id = $info['username_auth_id'];
            $token = $info['password_auth_token'];
            $phone_number = $info['phone_number'];
            $api_id = $info['api_id'];
            $gateway_id = $info['id'];
        }


        $this->user = $auth_id;
        $this->password = $token;
        $this->api_id = $api_id;
        $this->gateway_id = $gateway_id;
        $this->gateway_name = $gateway;
        $this->phone_number = $phone_number;
    }

    public function send_sms($msg, $recepient) {
      

        if (!is_array($recepient)) {
            $recepient = array($recepient);
        }

        /*         * **Initialize Message id as empty at first *** */
        $message_id = "";
        $gateway_id = $this->gateway_id;
        $gateway = $this->gateway_name;
      
        /*         * **** Planet IT SMS Manager ***** */
        if ($gateway == 'planet') {
            $msg = urlencode($msg);
            $str_recepient = implode(',', $recepient);
            $msg = str_replace(' ', '%20', $msg);
            $mask = urlencode("Xerone IT");
            $msg = urlencode($msg);
            $api_url = "http://app.planetgroupbd.com/api/sendsms/plain?user={$this->user}&password={$this->password}&sender={$mask}&SMSText={$msg}&GSM={$str_recepient}";
            $this->run_curl($api_url);
        }

        /*         * *Plivo sms sending option*** */
        if ($gateway == 'plivo') {
            foreach ($recepient as $to_number) {
                $message_info = $this->plivo_sms_send($this->phone_number, $to_number, $msg);
            }
        }

        /*         * *Twilio sms sending option* */
        if ($gateway == 'twilio') {
            
            foreach ($recepient as $to_number) {
                $message_info = $this->twilio_sms_sent($this->phone_number, $to_number, $msg);
            }
        }
        /*         * *2-way sms sending option*** */
        /*         * *not used *** */
        if ($gateway == '2-way') {
            foreach ($recepient as $to_number) {
                $message_info = $this->send_sms_2way($to_number, $msg);
            }
        }

        /*         * ** Clickatell sending option **** */
        if ($gateway == 'clickatell') {
            $msg = urlencode($msg);
            $message_info = $this->clickatell_send_sms($recepient, $msg);
        }


        if ($gateway == 'nexmo') {
            $msg = urlencode($msg);
            
            foreach ($recepient as $to_number) {
                $message_info = $this->nexmo_send_sms($this->phone_number, $to_number, $msg);
            }
        }

        if ($gateway == 'msg91.com') {
            $msg = urlencode($msg);
            foreach ($recepient as $to_number) {
                $message_info = $this->msg91_send_sms($this->phone_number, $to_number, $msg);
            }
        }

        if ($gateway == 'textlocal.in') {
            foreach ($recepient as $to_number) {
                $message_info = $this->textlocal_in($this->phone_number, $to_number, $msg);
            }
        }

        if ($gateway == 'sms4connect.com') {
            foreach ($recepient as $to_number) {
                $message_info = $this->sms_4_connect($this->phone_number, $to_number, $msg);
            }
        }

        if ($gateway == 'mvaayoo.com') {
            foreach ($recepient as $to_number) {
                $message_info = $this->mvaayoo_send_sms($this->phone_number, $to_number, $msg);
            }
        }


        if ($gateway == 'telnor.com') {
            $session_id = $this->telnor_session_id();
            foreach ($recepient as $to_number) {
                $message_info = $this->telnor_send_sms($session_id, $this->phone_number, $to_number, $msg);
            }
        }


        if ($gateway == 'routesms.com') {
            foreach ($recepient as $to_number) {
                $message_info = $this->send_sms_route($this->phone_number, $to_number, $msg);
            }
        }

        if ($gateway == 'trio-mobile.com') {

            foreach ($recepient as $to_number) {
                $message_info = $this->cloudsm_trio_mobile_send_sms($this->phone_number, $to_number, $msg);
            }
        }

        if ($gateway == 'sms40.com') {
            foreach ($recepient as $to_number) {
                $message_info = $this->send_sms_by_sms40($this->phone_number, $to_number, $msg);
            }
        }


        /*         * **Insert sms_history into database *** */
        $user_id = $this->user_id;
        $recepient_str = implode($recepient);
        $time = date('Y-m-d H:i:s');

        $message_id = $message_info['id'];
        $message_status = $message_info['status'];

        $q = "Insert into sms_history(user_id,gateway_id,to_number,sms_uid,sms_status,sent_time,message) values('$user_id','$gateway_id','$recepient_str','$message_id','$message_status','$time','$msg')";

        $this->CI->db->query($q);
        return $message_info;
    }

    /*     * *This Api return response like that 

      {
      "message": "message(s) queued",
      "message_uuid": ["db3ce55a-7f1d-11e1-8ea7-1231380bc196"],
      "api_id": "db342550-7f1d-11e1-8ea7-1231380bc196"
      }

      For error :

      { "api_id": "768a6c29-ae31-11e5-8a51-22000acb8c2c", "error": "Insufficient credit" }

     * * */

    public function plivo_sms_send($src, $dst, $text) {

        $dst = ltrim($dst, '+');

        # Plivo AUTH ID
        $AUTH_ID = $this->user;
        # Plivo AUTH TOKEN
        $AUTH_TOKEN = $this->password;

        $url = 'https://api.plivo.com/v1/Account/' . $AUTH_ID . '/Message/';
        $data = array("src" => "$src", "dst" => "$dst", "text" => "$text");
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, TRUE);

        if (isset($response['message_uuid'])) {
            $message_info['id'] = $response['message_uuid'];
            $message_info['status'] = $response['message'];
        } else {
            $message_info['id'] = "";
            $message_info['status'] = $response['error'];
        }

        return $message_info;
    }

    /*     * ** Get plivo balance ****** */

    public function get_plivo_balance() {

        # Plivo AUTH ID
        $AUTH_ID = $this->user;
        # Plivo AUTH TOKEN
        $AUTH_TOKEN = $this->password;

        $url = "https://api.plivo.com/v1/Account/{$AUTH_ID}/";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, TRUE);
        $balance = $response['cash_credits'];

        return $balance;
    }

    /*     * *	
      Array
      (
      [id] =>
      [status] => "Queued/Bad Credentials"
      )

      This api return response as string now.

     * ** */

    public function twilio_sms_sent($from, $to, $text) {
        
        if ($to[0] != "+")
            $to = "+" . $to;

        require "twilio-php/Services/Twilio.php";
        // set your AccountSid and AuthToken from www.twilio.com/user/account
        $client = new Services_Twilio($this->user, $this->password);
        
        $message = $client->account->messages->create(array(
            "From" => $from,
            "To" => $to,
            "Body" => $text,
        ));
        echo $message;

        if (isset($message->sid)) {
            $message_info['id'] = $message->sid;
            $message_info['status'] = $message->status;
        } else {
            $message_info['id'] = "";
            $message_info['status'] = "Error occured";
        }

        return $message_info;
    }

    // not used
    public function send_sms_2way($to, $text) {
        $api_code = $this->api_id;
        $token = $this->password;

        $url = "http://www.proovl.com/api/{$api_code}/send.php";
        $postfields = array
                    (
                    'token' => "$token",
                    'to' => "$to",
                    'text' => "$text"
        );

        if (!$curld = curl_init()) {
            exit;
        }
        curl_setopt($curld, CURLOPT_POST, true);
        curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($curld, CURLOPT_URL, $url);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($curld);
        curl_close($curld);

        $result = explode(';', $output);

        if ($result[0] == "Error") {
            $message_info['id'] = "";
            $message_info['status'] = $result[1];
        } else {
            if ($result[2] == $token) {
                $message_info['id'] = $result[1];
                $message_info['status'] = $result[0];
            } else {
                $message_info['id'] = "";
                $message_info['status'] = "Incorrect token";
            }
        }

        return $message_info;
    }

    /*     * * Pass the $to_numbers as array. Clickatell will send more numbers at a time with comma separated 
      For single number return the response like this

      Array
      (
      [id] =>
      [status] => "sent/Bad Credentials"
      )

      This api return response as string now.

     * ** */

    function clickatell_send_sms($to_numbers, $msg) {
        $msg = urlencode($msg);
        /*         * *** $to_numbers converted to array then implode it by commaseparated *** */
        if (!is_array($to_numbers)) {
            $to_numbers = array($to_numbers);
        }

        for ($i = 0; $i < count($to_numbers); $i++) {
            $to_numbers[$i] = ltrim($to_numbers[$i], '+');
            $to_numbers[$i] = ltrim($to_numbers[$i], '0');
        }

        $to_numbers = implode(",", $to_numbers);
        $url = "http://api.clickatell.com/http/sendmsg?user={$this->user}&password={$this->password}&api_id={$this->api_id}&to={$to_numbers}&text={$msg}";
        // for us only
        // $url="https://api.clickatell.com/http/sendmsg?user={$this->user}&password={$this->password}&api_id={$this->api_id}&mo=1&from={$this->phone_number}&to={$to_numbers}&text={$msg}";

        $response = $this->run_curl($url);
        $id_pos = strpos($response, "ID:");

        if ($id_pos === FALSE) {
            /** If no ID: is found then means error is occured * */
            $message_info['id'] = "";
            $message_info['status'] = $response;
        } else {
            $response = str_replace("ID:", "", $response);
            $response = trim($response);

            $message_info['id'] = $response;
            $message_info['status'] = "Sent";
        }

        return $message_info;
    }

    /*     * **Get clickatell Balance ***** */

    public function get_clickatell_balance() {
        $url = "https://api.clickatell.com/http/getbalance?user={$this->user}&password={$this->password}&api_id={$this->api_id}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $balance = str_replace("Credit:", "", $response);
        return trim($balance);
    }

    /*     * ** 
      Using Nexmo api   This function return
      Array
      (
      [id] =>
      [status] => "sent/Bad Credentials"
      )

     * ** */

    function nexmo_send_sms($from, $to_number, $msg) {

        $url = "https://rest.nexmo.com/sms/json?api_key={$this->user}&api_secret={$this->password}&from={$from}&to={$to_number}&text={$msg}&type=text";
        
        $response = $this->run_curl($url);
        $result = json_decode($response, TRUE);

        if (isset($result['messages'][0]['message-id']))
            $message_info['id'] = $result['messages'][0]['message-id'];
        else
            $message_info['id'] = "";


        if (isset($result['messages'][0]['status']) && $result['messages'][0]['status'] == '0') {
            $message_info['status'] = "Sent";
            return $message_info;
        } else
            $message_info['status'] = "";



        if (isset($result['messages'][0]['error-text']))
            $message_info['status'] = $result['messages'][0]['error-text'];
        else
            $message_info['status'] = "";

        return $message_info;
    }

    /*     * ** Return Balance in Account *** */

    function get_nexmo_balance() {
        $url = "https://rest.nexmo.com/account/get-balance/{$this->user}/{$this->password}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, TRUE);
        $balance = $response['value'];
        return $balance;
    }

    function msg91_send_sms($from, $to_number, $msg) {

        $to_number = ltrim($to_number, '+');
        $url = "http://api.msg91.com/api/sendhttp.php?authkey={$this->user}&mobiles={$to_number}&message={$msg}&sender={$from}&route=4&country=91";
        $result = $this->run_curl($url);

        $id = "";
        $status = "";

        if (strlen($result) == 24) {
            $id = $result;
            $status = "Submitted";
        } else {
            $status = $result;
        }

        $message_info['id'] = $id;
        $message_info['status'] = $status;

        return $message_info;
    }

    public function textlocal_in($from, $to, $msg) {

        // Textlocal account details
        /* $username = 'youremail@address.com';
          $hash = 'Your API hash'; */

        // Message details
        $to = ltrim($to, '+');
        $numbers = $to;
        $sender = urlencode($from);
        $message = rawurlencode($msg);

        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        //$data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        $data = array('apiKey' => $this->api_id, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('http://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if ($response['status' == 'success']) {

            $send_info = $response['messages'];

            $result = array();
            $i = 0;
            foreach ($send_info as $info) {
                $result[$info->recipient]['id'] = $info->id;
            }
        }

        // Process your response here
        return $result;
    }

    function sms_4_connect($from, $to, $msg) {

        /*         * ****		
          id		= 		A valid Account ID for the customer
          password=	A valid Account Password for the customer
         * ************* */

        $msg = urlencode($msg);
        $url = "http://sms4connect.com/api/sendsms.php/sendsms/url?id={$this->user}&pass={$this->password}&mask={$from}&to={$to}&lang=English&msg={$msg}&type=json";

        $result = $this->run_curl($url);
        $result = json_decode($result, TRUE);

        if ($result['corpsms'][0]['code'] == 300) {
            $message_info['id'] = $result['corpsms'][0]['transactionID'];
        } else {
            $message_info['id'] = 0;
        }

        $message_info['status'] = $result['corpsms'][0]['response'];

        return $message_info;
    }

    public function telnor_session_id() {

        $url = "https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn={$this->user}&password={$this->password}";
        $content = $this->run_curl($url);
        $xml = simplexml_load_string($content);

        /*         * * Error / Ok  as response */

        $response['status'] = (string) $xml->response;
        $response['session_id'] = (string) $xml->data;

        return $response;
    }

    public function telnor_send_sms($session_id, $from, $to, $msg) {

        $msg = urlencode($msg);

        $url = "https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id={$session_id}&to={$to}&text={$msg}&mask={$from}";

        $content = $this->run_curl($url);
        $xml = simplexml_load_string($content);

        /*         * * Error / Ok  as response */


        $status = (string) $xml->response;


        if ($status == 'OK') {
            $message_info['id'] = (string) $xml->data;
            $message_info['status'] = (string) $xml->response;
        } else {
            $message_info['id'] = "";
            $message_info['status'] = (string) $xml->response;
        }

        return $message_info;
    }

    public function mvaayoo_send_sms($from, $to, $msg) {

        /*         * ****
          $this->user		= admin 	 = info@eztechnologies.in
          $this->password	= user 		 = prachi1786@gmail.com:xxxx
          $from			= senderID   = ABSMRT
         * *** */

        $msg = urlencode($msg);
        $url = "http://59.162.167.52/api/MessageCompose?admin={$this->user}&user={$this->password}&senderID={$from}&receipientno={$to}&msgtxt={$msg}&state=4";
        $result = $this->run_curl($url);

        /*         * ***		No details documentation found 	***** */

        $message_info['id'] = $result;
        $message_info['status'] = $result;

        return $message_info;
    }

    public function cloudsm_trio_mobile_send_sms($from, $to, $msg) {

        $msg = urlencode($msg);
        $url = "http://cloudsms.trio-mobile.com/index.php/api/bulk_mt?api_key={$this->user}&action=send&to={$to}&msg={$msg}&sender_id={$from}&content_type=1&mode=longcode";

        $result = $this->run_curl($url);
        $message_info['id'] = $result;
        $message_info['status'] = $result;
        return $message_info;
    }

    public function send_sms_route($from, $to, $msg) {

        $msg = urlencode($msg);
        $url = "http://smsplus.routesms.com:8080/bulksms/bulksms?username={$this->user}&password={$this->password}&type=0&dlr=1&destination={$to}&source={$from}&message={$msg}";

        $result = $this->run_curl($url);

        $result_array = explode('|', $result);

        $sms_id = "";
        $status = "failed";

        if (count($result_array) > 0) {
            if ($result_array[0] == "1701") {
                $status = "success";
                $sms_id = $result_array[2];
            }
        }

        $message_info['id'] = $sms_id;
        $message_info['status'] = $status;

        return $message_info;
    }

    public function send_sms_by_sms40($from, $to, $msg) {
        $msg = urlencode($msg);
        $url = "http://www.sms40.com/api2.php?username={$this->user}&password={$this->password}&type=SendSMS&sender={$from}&mobile={$to}&message={$msg}";
        $result = $this->run_curl($url);
        $message_info['id'] = "";
        $message_info['status'] = $result;
        return $message_info;
    }

}

?>