<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of confirmation
 *
 * @author joeyjones
 */
class Confirmation {

    private $db;
    private $to;
    private $from;
    private $subject;
    private $body;
    private $headers;

    public function __construct($inDB, $inTo, $inFrom, $inSubject) {
        $this->db = $inDB;
        $this->to = $inTo;
        $this->from = $inFrom;
        $this->subject = $inSubject;

        $this->generateBody();
        $this->generateHeaders();
    }

    private function generateBody() {
        $order = new \Order($_SESSION['orderID'], $this->db);
        $user = new \User($order->getUserID(), $this->db);

        $body = "<html><head></head><body><h2>Thank You!</h2><table border='0'>";
        $body .= $user->getInfo(true);
        $body .= "</table>";
        $body .= $order->getImages();
        $body .= "</body></html>";
        $this->body = $body;
    }

    private function generateHeaders() {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        // More headers
        $headers .= 'From: '. $this->from. "\r\n";
        $this->headers = $headers;
    }

    public function send() {
        return mail($this->to, $this->subject, $this->body, $this->headers);
    }

}

?>
