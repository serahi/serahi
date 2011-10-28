<?php

class Userlist_mtests extends MY_Controller {
	function testGetUsersWithSingleUser () {
		$this->db->query('truncate users;');
		$new_user = array(
			'username' => 'milad',
			'password' => md5('milad'),
			'user_type' => 'seller',
			'email' => 'miladbashiri@comp.iust.ac.ir',
			'creation_time' => date('Y-m-d H:i:s'),
			'first_name' => 'milad',
			'last_name' => 'bashiri'
		);
		$this->db->insert('users', $new_user);
		$this->load->model('user_model');
		$data = $this->user_model->get_users();
		$this->assertEqual(count($data), 1);
		unset($new_user['password']);
		$new_user['id'] = $data[0]['id'];
		$this->assertEqual($new_user, $data[0]);
	}
	function testGetUsersWithMultipleUsers () {
		$this->db->query('truncate users;');
		
		$new_users[0] = array(
			'username' => 'milad',
			'password' => 'milad',
			'user_type' => 'seller',
			'email' => 'miladbashiri@comp.iust.ac.ir',
			'creation_time' => date('Y-m-d H:i:s'),
			'first_name' => 'milad',
			'last_name' => 'bashiri'
		);
		$new_users[1] = array(
			'username' => 'hamed',
			'password' => md5('hamed'),
			'user_type' => 'admin',
			'email' => 'hamed.gholizadeh.f@gmail.com',
			'creation_time' => date('Y-m-d H:i:s'),
			'first_name' => 'hamed',
			'last_name' => 'gholizadeh'
		);
		$count = count($new_users);
		for($i = 0; $i < $count; $i++) {
			$this->db->insert('users', $new_users[$i]);
			unset($new_users[$i]['password']);
			$new_users[$i]['id'] = $this->db->insert_id();
		}
		$this->load->model('user_model');
		$data = $this->user_model->get_users();
		$this->assertEqual(count($data), 2);
		$this->assertEqual($new_users, $data);
	}
}
