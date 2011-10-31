<?php
class Seller extends MY_Controller {
	function index () {
		if (!is_seller()) {
			
		}
	}
	function is_seller () {
		return ($this->session->userdata('is_logged_in') === TRUE &&
		        $this->session->userdata('user_type') === 'seller');
	}
}
