<?php
class User_model extends CI_Model {
	function get_users () {
		$query = $this->db->get('users');
		$data = array();
		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'username' => $row->username,
				'email' => $row->email,
				'first_name' => $row->first_name,
				'last_name' => $row->last_name,
				'user_type' => $row->user_type,
				'creation_time' => $row->creation_time
			);
		}
		return $data;
	}
	function delete_user ($id) {
		$this->db->where('id', $id);
		$this->db->delete('users');
	}
	function get_user_info ($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('users');
		$user = $query->row();
		if ($user->user_type != 'admin') {
			$this->db->where('id', $id);
			$query = $this->db->get($user->user_type . 's');
			$user = $query->row();
		}
		$data = array();
		foreach (get_object_vars($user) as $key => $value) {
			if ($key == 'password') continue;
			if ($key == 'approved') $value = $value == 't' ? 'TRUE' : 'FALSE';
			$data[$key] = $value;
		}
		return $data;
	}
}