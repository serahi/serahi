<?php
class Userlist extends MY_Controller
{
	function index ()
	{
		if ($this->_is_admin()) {
			$this->load->model('user_model');
			$view_data['users'] = $this->user_model->get_users();
			$this->load->view('userlist_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}

	function delete ()
	{
		if ($this->_is_admin()) {
			$id = $this->input->post('id');
			$this->load->model('user_model');
			$this->user_model->delete_user($id);
			redirect('admin/userlist');
		} else {
			$this->load->view('access_denied');
		}
	}

	function edit ()
	{
		if ($this->_is_admin()) {
			$id = $this->input->get('id');
			if ($id) {
				$this->load->model('user_model');
				$user_info = $this->user_model->get_user_info($id);
				if ($user_info === FALSE) {
					redirect(base_url() . 'admin/userlist');
				}
				$this->load->view('edit_info_view', $user_info);
			} else {
				redirect(base_url() . 'admin/userlist');
			}
		} else {
			$this->load->view('access_denied');
		}
	}

	function save_edit ()
	{
		if ($this->_is_admin()) {
			$user = $this->_post_values(array(
					'id',
					'username',
					'password',
					'first_name',
					'last_name',
					'user_type',
					'email',
					'creation_time'
			));
			if ($user['user_type'] == 'seller') {
				$user = array_merge($user, $this->_post_values(array(
						'address',
						'phone',
						'display_name',
						'approved:b'
				)));
			} else if ($user['user_type'] == 'customer') {
				$user = array_merge($user, $this->_post_values(array(
						'address',
						'postal_code',
						'phone',
						'birth_date'
				)));
			}
			$this->load->model('user_model');
			$this->user_model->edit_user_info($user);
			redirect(base_url() . "admin/userlist");
		} else {
			$this->load->view('access_denied');
		}
	}

	function _post_values ($array)
	{
		$values = array();
		foreach ($array as $field) {
			$parts = explode(':', $field, 2);
			if (count($parts) > 1) {
				$field_name = $parts[0];
				$field_type = $parts[1];
				if ($field_type === 'b') {
					$value = $this->input->post($field_name) ? 't' : 'f';
					$values[$field_name] = $value;
				}
			} else {
				$value = $this->input->post($field);
				if ($value !== FALSE) {
					$values[$field] = $value;
				}
			}
		}
		return $values;
	}

	function _is_admin ()
	{
		return ($this->session->userdata('is_logged_in') === TRUE && $this->session->userdata('user_type') === 'admin');
	}

}
