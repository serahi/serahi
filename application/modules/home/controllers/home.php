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
//           
            if($insert_result == 'sell_actived')
            {
                $mails_PCs = $this->home_model->get_user_trans_info($this->input->post('product_id'));
                $this->load->library('Email_agent');
                $this->email_agent->sell_active($mails_PCs);
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
            
            redirect('home');
        } else {
            redirect('home');
        }
    }

    function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }
}
