<?php

//created by ucup
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CI_Mails {

    var $user = '';
    var $password = '';
    var $smtp_host = '';
    var $smtp_port = '465';
    var $imap_host = '';
    var $imap_port = '993';
    var $mailbox_place = 'INBOX';
    var $mail_connection = '';
    var $start = 0;
    var $length = 10;
    var $uid = '';
    var $attachment_root_dir = '';

    public function __construct($config = array()) {
        $this->CI = & get_instance();
        if (count($config) > 0) {
            foreach ($config as $key => $val) {
                if (isset($this->$key)) {
                    $method = 'set_' . $key;
                    if (method_exists($this, $method)) {
                        $this->$method($val);
                    } else {
                        $this->$key = $val;
                    }
                }
            }
        }
        log_message('debug', "Mails Class Initialized");
    }

    //setter
    public function set_user($user = '') {
        $this->user = $user;
        return $this;
    }

    public function set_password($password = '') {
        $this->password = $password;
        return $this;
    }

    public function set_smtp_host($smtp_host = '') {
        $this->smtp_host = $smtp_host;
        return $this;
    }

    public function set_smtp_port($smtp_port = '') {
        $this->smtp_port = $smtp_port;
        return $this;
    }

    public function set_imap_host($imap_host = '') {
        $this->imap_host = $imap_host;
        return $this;
    }

    public function set_imap_port($imap_port = '') {
        $this->smtp_port = $smtp_port;
        return $this;
    }

    public function set_mailbox_place($mailbox_place = '') {
        $this->mailbox_place = $mailbox_place;
        return $this;
    }

    public function set_start($start = '') {
        $this->start = $start;
        return $this;
    }

    public function set_length($length = '') {
        $this->length = $length;
        return $this;
    }

    public function set_mail_connection($mail_connection) {
        $this->mail_connection = $mail_connection;
        return $this;
    }

    public function set_uid($uid) {
        $this->uid = $uid;
        return $this;
    }

    public function set_attachment_root_dir($attachment_root_dir = '') {
        $this->attachment_root_dir = $attachment_root_dir;
        return $this;
    }

    //getter

    public function get_user() {
        return $this->user;
    }

    public function get_password() {
        return $this->password;
    }

    public function get_smtp_host() {
        return $this->smtp_host;
    }

    public function get_smtp_port() {
        return $this->smtp_port;
    }

    public function get_imap_host() {
        return $this->imap_host;
    }

    public function get_imap_port() {
        return $this->imap_port;
    }

    public function get_mailbox_place() {
        return $this->mailbox_place;
    }

    public function get_start() {
        return $this->start;
    }

    public function get_length() {
        return $this->length;
    }

    public function get_mail_connection() {
        return $this->mail_connection;
    }

    public function get_uid() {
        return $this->uid;
    }

    public function get_attachment_root_dir($attachment_root_dir = '') {
        return $this->attachment_root_dir;
    }

    public function mailbox_connect() {
        $cs = "{" . $this->get_imap_host() . ":" . $this->get_imap_port() . "/imap/ssl}" . $this->get_mailbox_place();
        $this->mail_connection = imap_open($cs, $this->get_user(), $this->get_password(), NULL, 1) or die('Cannot connect to mail server: ' . imap_last_error());
    }

    public function mailbox_disconnect() {
        imap_close($this->mail_connection);
    }

    public function get_emails() { //getting email list 
        $this->mailbox_connect();
        $emails = imap_search($this->get_mail_connection(), 'ALL');
        rsort($emails);
        $data = array();
        for ($i = $this->get_start(); $i < $this->get_length() + $this->get_start(); $i++) {
            if (isset($emails[$i])) {
                $overview = imap_fetch_overview($this->get_mail_connection(), $emails[$i], 0);
                $or = $overview[0]->subject;
                mb_internal_encoding('UTF-8');
                $subject = str_replace("_", " ", mb_decode_mimeheader($or));
                $time = strtotime($overview[0]->date);
                $newtime = substr($overview[0]->date, strlen($overview[0]->date) - 14, 9);
                $newdate = date('Y-m-d', $time) . ' ' . $newtime;
                $row = array(
                    'uid' => $overview[0]->uid,
                    'seen' => $overview[0]->seen,
                    'subject' => $subject,
                    'from' => $overview[0]->from,
                    'date' => $newdate,
                    'msgNo' => imap_msgno($this->get_mail_connection(), $overview[0]->uid),
                    'total_mails' => count($emails)
                );
                $data[] = $row;
            }
        }
        $this->mailbox_disconnect();
        return $data;
    }

    public function delete_mail() {
        $this->mailbox_connect();
        $msgno = imap_msgno($this->get_mail_connection(), $this->get_uid());
        imap_delete($this->get_mail_connection(), $msgno);
        imap_expunge($this->get_mail_connection());

        $this->mailbox_disconnect();
        echo $msgno;
    }

    public function read_email() {
        $this->mailbox_connect();
        $msgno = imap_msgno($this->get_mail_connection(), $this->get_uid());
        $header = imap_header($this->get_mail_connection(), $msgno);
        $overview = imap_fetch_overview($this->get_mail_connection(), $this->get_uid(), FT_UID);
        $struct = imap_fetchstructure($this->get_mail_connection(), $msgno);
        $attachment_dir = '';
        $attachments = array();
        $parts = $struct->parts;
        $i = 0;

        if (!$parts) { /* Simple message, only 1 piece */
            $attachment = array(); /* No attachments */
            $content = imap_body($this->get_mail_connection(), $msgno);
        } else { /* Complicated message, multiple parts */

            $endwhile = false;

            $stack = array(); /* Stack while parsing message */
            $content = "";    /* Content of message */
            $attachment = array(); /* Attachments */

            while (!$endwhile) {
                if (!$parts[$i]) {
                    if (count($stack) > 0) {
                        $parts = $stack[count($stack) - 1]["p"];
                        $i = $stack[count($stack) - 1]["i"] + 1;
                        array_pop($stack);
                    } else {
                        $endwhile = true;
                    }
                }

                if (!$endwhile) {
                    /* Create message part first (example '1.2.3') */
                    $partstring = "";
                    foreach ($stack as $s) {
                        $partstring .= ($s["i"] + 1) . ".";
                    }
                    $partstring .= ($i + 1);

                    if (strtoupper($parts[$i]->disposition) == "ATTACHMENT") {
                        $attachment[] = array("filename" => $parts[$i]->parameters[0]->value,
                            "filedata" => imap_fetchbody($this->get_mail_connection(), $msgno, $partstring));
                    }

                    if ($struct->subtype == "MIXED") {
                        if (strtoupper($struct->parts[0]->subtype) == "ALTERNATIVE") {
                            if (strtoupper($parts[$i]->subtype) == "PLAIN") {
                                $content = imap_fetchbody($this->get_mail_connection(), $msgno, $partstring);
                            }
                            if (strtoupper($parts[$i]->subtype) == "HTML") {
                                $content = imap_fetchbody($this->get_mail_connection(), $msgno, $partstring);
                            }
                        } else {
                            $content = imap_fetchbody($this->get_mail_connection(), $msgno, $partstring);
                        }
                    } else {
                        $content = imap_fetchbody($this->get_mail_connection(), $msgno, $i + 1);
                    }
                }

                if ($parts[$i]->parts) {
                    $stack[] = array("p" => $parts, "i" => $i);
                    $parts = $parts[$i]->parts;
                    $i = 0;
                } else {
                    $i++;
                }
            }
        }
        if (count($attachment) > 0) {
            for ($i = 0; $i < count($attachment); $i++) {
                $root_dir = $this->get_attachment_root_dir();
                if (!file_exists($root_dir)) {
                    mkdir($root_dir);
                }
                $mail_dir = '/' . $msgno;
                if (!file_exists($root_dir . $mail_dir)) {
                    mkdir($root_dir . $mail_dir);
                }
                $att_dir = $root_dir . $mail_dir;

                $dst = $att_dir . '/' . $attachment[$i]['filename'];
                if (isset($attachment[$i]['filedata'])) {
                    if (!file_exists($dst)) {
                        file_put_contents($dst, base64_decode($attachment[$i]['filedata']));
                    }
                }

                $attachments[] = $attachment[$i]['filename'];
                $attachment_dir = $att_dir . '/';
            }
        } else {
            $attachment_dir = "";
        }

        $from = $overview[0]->from . " (" . $header->from[0]->mailbox . '@' . $header->from[0]->host . ")";
        $time = strtotime($header->date);
        $newtime = substr($header->date, strlen($header->date) - 14, 9);
        $newdate = date('Y-m-d', $time) . ' ' . $newtime;

        $data = array(
            "subject" => $header->subject,
            "from" => $from,
            "date" => $newdate,
            "message" => quoted_printable_decode($content),
            "sender" => $header->from[0]->mailbox . '@' . $header->from[0]->host,
            "attachment_dir" => $attachment_dir,
            "attachment" => $attachments
        );
        $this->mailbox_disconnect();
        return $data;
    }

}

?>