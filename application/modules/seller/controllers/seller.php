<?php
class Seller extends MY_Controller {
	function index () {
		if (!is_seller()) {
			$this->load->view('access_denied');
		} else {
			$user_id = $this->session->userdata('user_id');
			$this->load->model('seller_model');
			$view_data('products') = $this->seller_model->get_transaction_summary($user_id);
			$this->load->view('index_view', $view_data);
		}
	}
	function is_seller () {
		return ($this->session->userdata('is_logged_in') === TRUE &&
		        $this->session->userdata('user_type') === 'seller');
	}
}
