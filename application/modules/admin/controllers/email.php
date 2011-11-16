<?php

// sends email with gmail
class email extends MY_Controller {

    function index() {
        $email_to = 'serahi90@gmail.com';
        $email_subj = 'Email From Serahi';
        $email_text = 'In Yek Email Ast!';
        $this->send($email_to, $email_subj, $email_text);
    }

    function send($email_to, $email_subj, $email_text) {
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from('serahi90@gmail.com', 'info');
        $this->email->to($email_to);
        $this->email->subject($email_subj);
        $this->email->message($email_text);

        if ($this->email->send()) {
            echo 'email sent';
        } else {
            show_error($this->email->print_debugger());
        }
    }

}
