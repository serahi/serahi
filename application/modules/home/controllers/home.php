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

	function buy ()
	{
		//access_level: registered
		//redirect: user/login
			$this->load->model('home_model');
			$pursuit_code = rand_gen(10);
			$insert_result = $this->home_model->add_transaction($pursuit_code);

			if ($insert_result == 'sell_actived') {
				$mails_PCs = $this->home_model->get_user_trans_info($this->input->post('product_id'));
				$this->load->library('Email_agent');
				$this->email_agent->sell_active($mails_PCs);
			}
			redirect('home');
	}

	function cancel_transaction ()
	{
		//access_level: registered
		//redirect: user/login
		$this->load->model('home_model');
		$this->home_model->cancel_transaction();

		redirect('home');
	}
        
        function news(){
            $this->load->model('home_model');
            $array['news'] = $this->home_model->get_news();
            $this->load->view('news', $array);
        }

}
