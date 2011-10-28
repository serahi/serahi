<?php
class Userlist extends MY_Controller {
	function index () {
		if ($this->session->userdata('is_logged_in') === TRUE &&
		    $this->session->userdata('user_type') === 'admin') {
		    $this->load->model('user_model');
			$view_data['users'] = $this->user_model->get_users();
			$this->load->view('user_manage_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}
}