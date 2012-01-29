<?php

class Userlist extends MY_Controller
{

	function index ()
	{
		$this->load->model('user_model');
		$view_data['users'] = $this->user_model->get_users();
		$this->load->view('userlist_view', $view_data);
	}

	function delete ()
	{
		$id = $this->input->post('id');
		$this->load->model('user_model');
		$this->user_model->delete_user($id);
		redirect('admin/userlist');
	}

	function edit ()
	{
		//access level: admin|self
		
		$user_id = $this->session->userdata('user_id');
		$id = $this->input->get('id');
		
		if ($this->input->post('id')) {		
			// A Form has been submitted, save the data.
			$user_type = $this->input->post('user_type');
		
			//FIXME: decide based on access-level, not post value: access('self:id@post)
			$user_type = $user_type ? $user_type : $this->session->userdata('user_type');
			$fields = array(
				'id',
				'username',
				'password',
				'first_name',
				'last_name',
				'email'
			);
			
			if (_is_admin()) {
				$fields[] = 'user_type';
				if ($this->input->post('user_type') == 'seller')
					$fields[] = 'approved';
			}
			if ($user_type == 'seller' || $user_type == 'customer') {
				$fields[] = 'address';
				$fields[] = 'phone';
				if ($user_type == 'seller') {
					$fields[] = 'display_name';
					$fields[] = 'map_location';
				} else {
					$fields[] = 'postal_code';
					$fields[] = 'birth_date';
				}
			}
			$user = _post_values($fields);
			
			$this->load->library('validator');
			$validated = $this->validator->validate($fields);
			
			if ($validated) {
				$this->load->model('user_model');
				$this->user_model->edit_user_info($user);
				if (_is_admin()) {
					redirect("admin/userlist");
				} else {
					$this->load->view('edit_success_view');
				}
			} else {
				$id = $this->input->post('id');
			}
		}
		
		if ($id) {
			$this->load->model('user_model');
			$user_info = $this->user_model->get_user_info($id);
			if (isset($user_info['map_location']) && $user_info['map_location'] != '') {
				list($user_info['map_lat'], $user_info['map_lng']) = explode(' ', $user_info['map_location']);
			}
			if ($user_info === FALSE) {
				redirect('admin/userlist');
				return;
			}
			$this->load->view('edit_info_view', $user_info);
		} else {
			redirect('admin/userlist');
		}
	}

	function save_edit ()
	{
		//access level: admin|self:id@post
		$user_id = $this->session->userdata('user_id');

	}
}
