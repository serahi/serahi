<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Email_agent
{

	function __construct ()
	{
	}

	function send ($email_to, $email_subj, $email_text)
	{
		$CI = &get_instance();
		$CI->load->library('email');
		$CI->load->library('logger');
		$CI->email->set_newline("\r\n");
		$CI->email->from('serahi90@gmail.com', 'info');
		$CI->email->to($email_to);
		$CI->email->subject($email_subj);
		$CI->email->message($email_text);

		if (!$CI->email->send()) {
			$CI->logger->log('ERROR', 'send_mail', 'mail send failed.');
		}
	}

	function sell_active ($emails_PCs)
	{
		$email_subj = 'کد رهگیری خرید شما';
		foreach ($emails_PCs as $info) {
			$email_to = $info['email'];
			$pursuit_code = $info['pursuit_code'];
			$email_text = 'خرید شما با موفقیت انجام شد.  کد رهگیری خرید شما ' . $pursuit_code . ' است.';
			$this->send($email_to, $email_subj, $email_text);
		}
	}

}
