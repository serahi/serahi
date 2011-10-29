<?php
class Userlist extends MY_Controller {
	function index () {
		if ($this->session->userdata('is_logged_in') == TRUE &&
		    $this->session->userdata('user_type') === 'admin') {
		  $this->load->model('user_model');
			$view_data['users'] = $this->user_model->get_users();
			$this->load->view('userlist_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}
	function delete () {
		if ($this->session->userdata('is_logged_in') == TRUE &&
		    $this->session->userdata('user_type') === 'admin') {
			$id = $this->input->post('id');
			$this->load->model('user_model');
			$this->user_model->delete_user($id);
		} else {
			$this->load->view('access_denied');
		}
	}
	function edit () {
		if ($this->session->userdata('is_logged_in') == TRUE &&
		    $this->session->userdata('user_type') === 'admin') {
			$id = $this->input->get('id');
			$this->load->model('user_model');
			$user_info = $this->user_model->get_user_info($id);
			$this->load->view('edit_info_view', $user_info);
		} else {
			$this->load->view('access_denied');
		}
	}
}
