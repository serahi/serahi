<?php
class Userlist_mtests extends MY_Controller {
	var $users;
	function setUp () {
		$this->db->query('truncate users;');
		$this->users[0] = array(
			'username' => 'admin',
			'password' => md5('admin'),
			'user_type' => 'admin',
			'email' => 'admin@serahi.ir',
			'creation_time' => date('Y-m-d H:i:s'),
			'first_name' => 'مدیر',
			'last_name' => 'سایت'
		);
		$this->users[1] = array(
			'username' => 'milad',
			'password' => md5('milad'),
			'user_type' => 'seller',
			'email' => 'miladbashiri@comp.iust.ac.ir',
			'creation_time' => date('Y-m-d H:i:s'),
			'first_name' => 'milad',
			'last_name' => 'bashiri'
		);
		$this->users[2] = array(
			'username' => 'hamed',
			'password' => md5('hamed'),
			'user_type' => 'admin',
			'email' => 'hamed.gholizadeh.f@gmail.com',
			'creation_time' => date('Y-m-d H:i:s'),
			'first_name' => 'hamed',
			'last_name' => 'gholizadeh'
		);
	}
	function testGetUsersWithSingleUser () {
		$new_user = $this->insert_users(1);
		$this->load->model('user_model');
		$data = $this->user_model->get_users();
		$this->assertEqual(count($data), 1);
		unset($new_user['password']);
		$new_user['id'] = $data[0]['id'];
		$this->assertEqual($new_user, $data[0]);
	}
	function testGetUsersWithMultipleUsers () {
		$new_users = $this->insert_users();
		$count = count($new_users);
		$this->load->model('user_model');
		$data = $this->user_model->get_users();
		$this->assertEqual(count($data), $count);
		$this->assertEqual($new_users, $data);
	}
	function testDeleteUser () {
		$user = $this->insert_users(1);
		$this->load->model('user_model');
		$this->user_model->delete_user($user['id']);
		$this->db->where('id', $user['id']);
		$query = $this->db->get('users');
		$this->assertEqual($query->num_rows, 0);
	}	
	function insert_users ($count = -1) {
		if ($count == -1) $count = count($this->users);
		for($i = 0; $i < $count; $i++) {
			$this->db->insert('users', $this->users[$i]);
			unset($this->users[$i]['password']);
			$this->users[$i]['id'] = $this->db->insert_id();
			$result[] = $this->users[$i];
		}
		if ($count == 1) return $result[0];
		else return $result;
	}
}
