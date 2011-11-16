<?php

// sends email with gmail
class email extends MY_Controller {

    function index() {
        $email_to = 'hamed.gholizadeh.f@gmail.com';
        $email_subj = 'This is an email';
        $email_text = 'It is working. Great!';
        $this->send($email_to, $email_subj, $email_text);
    }

    function send($email_to, $email_subj, $email_text) {
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from('serahi@gmail.com', 'Serahi');
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
