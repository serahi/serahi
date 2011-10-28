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
}
