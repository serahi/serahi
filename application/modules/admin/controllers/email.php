<?php

// sends email with gmail
class Email extends MY_Controller {

    function index() {

        $this->load->library('Email_agent');
        $email_to = 'serahi90@gmail.com';
        $email_subj = 'Email From Serahi';
        $email_text = 'In Yek Email Ast!';
        $this->email_agent->send($email_to, $email_subj, $email_text);
    }

}
