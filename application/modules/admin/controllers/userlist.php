<?php
class Userlist extends MY_Controller
{
	function index ()
	{
		if (_is_admin()) {
			$this->load->model('user_model');
			$view_data['users'] = $this->user_model->get_users();
			$this->load->view('userlist_view', $view_data);
		} else {
			$this->load->view('access_denied');
		}
	}

	function delete ()
	{
		if (_is_admin()) {
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
		if (_is_admin()) {
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
		if (_is_admin()) {
			$user = _post_values(array(
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
				$user = array_merge($user, _post_values(array(
						'address',
						'phone',
						'display_name',
						'approved:b'
				)));
			} else if ($user['user_type'] == 'customer') {
				$user = array_merge($user, _post_values(array(
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

}
