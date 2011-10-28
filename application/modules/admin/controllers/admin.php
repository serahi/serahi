<?php
class Admin extends MY_Controller {
	function index () {
		if ($this->session->userdata('is_logged_in') === TRUE &&
		    $this->session->userdata('user_type') === 'admin') {
		    $this->load->model('seller_model');
			$view_data['sellers'] = $this->seller_model->get_sellers();
			$this->load->view('index_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}
}
