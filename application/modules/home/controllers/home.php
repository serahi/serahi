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
            $this->home_model->add_transaction();
            redirect(base_url() . 'home/');
        } else {
        	redirect('user/login');
        }
    }

    function cancel_transaction() {
        if ($this->is_logged_in()) {
            $this->load->model('home_model');
            $this->home_model->cancel_transaction();
            redirect('home/');
        } else {
        	redirect('home/');
        }
    }

    function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }
}
