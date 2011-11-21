<?php
class Home extends MY_Controller
{

	function __construct ()
	{
		parent::__construct();
	}

	function index ()
	{
		$this->load->model('home_model');
		$array['products'] = $this->home_model->get_list();
		
		$this->load->view('home_view', $array);
	}

    function buy() {
        if ($this->is_logged_in()) {
            $this->load->model('home_model');
            $pursuit_code = rand_gen(10);
            $insert_result = $this->home_model->add_transaction($pursuit_code);
//            if ($insert_result == 1)
//            {
//                $email_to = $this->session->userdata('email');
//                $email_subj = 'کد رهگیری خرید شما';
//                $email_text = 'خرید شما با موفقیت انجام شد.  کد رهگیری خرید شما ' .  $pursuit_code . ' است.';
//                $this->load->library('Email_agent');
//                $this->email_agent->send($email_to, $email_subj, $email_text);
//            }elseif( $insert_result == 2)
//            {
//                $email_to = $this->session->userdata('email');
//                $email_to = 'sadegh.kazemy@gmail.com';
//                $email_subj = 'کد رهگیری خرید شما';
//                $email_text = 'خرید شما با موفقیت انجام شد.  کد جدید رهگیری خرید شما ' .  $pursuit_code . ' است.';
//                $this->load->library('Email_agent');
//                $this->email_agent->send($email_to, $email_subj, $email_text);
//            }
            if($insert_result == 'sell_actived')
            {
                $this->load->library('Email_agent');
                $this->Email_agent->sell_active($this->input->post('product_id'));
            }
            redirect('home');
        } else {
            redirect('home');
        }
    }

    function cancel_transaction() {
        if ($this->is_logged_in()) {
            $this->load->model('home_model');
            $this->home_model->cancel_transaction();
            
            $email_to = $this->session->userdata('email');
            $email_subj = 'خرید شما لغو شد.';
            $email_text = 'خرید شما لغو شد. کد رهگیری شما دیگر قابل استفاده نیست. ';
            $this->load->library('Email_agent');
            $this->email_agent->send($email_to, $email_subj, $email_text);
            
            redirect('home');
        } else {
            redirect('home');
        }
    }

    function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }
}
