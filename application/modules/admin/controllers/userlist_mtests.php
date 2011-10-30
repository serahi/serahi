<?php
class Userlist_mtests extends MY_Controller {
	var $users, $user_infos;
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
		$this->user_infos[0] = $this->users[0];
		$this->users[1] = array(
			'username' => 'milad',
			'password' => md5('milad'),
			'user_type' => 'seller',
			'email' => 'miladbashiri@comp.iust.ac.ir',
			'creation_time' => date('Y-m-d H:i:s'),
			'first_name' => 'milad',
			'last_name' => 'bashiri'
		);
		$this->user_infos[1] = array_merge($this->users[1], array(
			'display_name' => 'میلاد',
			'address' => 'iran, tehran',
			'phone' => '0935',
			'approved' => 'TRUE'
		));
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
	function testGetUserInfo () {
		$users = $this->insert_user_infos(2);
		$this->load->model('user_model');
		$user_info = $this->user_model->get_user_info($users[0]['id']);
		$this->assertEqual($users[0], $user_info);
		$seller_info = $this->user_model->get_user_info($users[1]['id']);
		$this->assertEqual($users[1], $seller_info);
	}
	function testGetUserInfoWithNonExistantID () {
		$this->load->model('user_model');
		$user_info = $this->user_model->get_user_info(1); //users table is truncated, so any id shall do.
		$this->assertEqual($user_info, FALSE);
	}
	function testEditUserInfo () {
		$users = $this->insert_user_infos(2);
		$users[0]['username'] = 'oldadmin';
		$users[0]['email'] = 'oldadmin@serahi.ir';
		$users[0]['password'] = md5('oldadmin');
		$users[0]['first_name'] = 'site';
		$users[0]['last_name'] = 'admin';
		$this->load->model('user_model');
		$this->user_model->edit_user_info($users[0]);
		$db_user = $this->getByID($users[0]['id'], 'users');
		$this->assertEqual($users[0], $db_user);
		$users[1]['username'] = 'miladb';
		$users[1]['password'] = md5('miladb');
		$users[1]['first_name'] = 'm';
		$users[1]['last_name'] = 'b';
		$users[1]['phone'] = '0918';
		$users[1]['approved'] = 't';
		$this->user_model->edit_user_info($users[1]);
		$db_user = $this->getByID($users[1]['id'], 'sellers');
		$this->assertEqual($users[1], $db_user);
	}
	function testEditUserInfoIgnoreEmptyPassword () {
		$user = $this->insert_user_infos(1);
		$user['username'] = 'oldadmin';
		$user['email'] = 'oldadmin@serahi.ir';
		$user['password'] = '';
		$user['first_name'] = 'site';
		$user['last_name'] = 'admin';
		$this->load->model('user_model');
		$this->user_model->edit_user_info($user);
		$user['password'] = md5('admin');
		$db_user = $this->getByID($user['id'], 'users');
		$this->assertEqual($user, $db_user);
	}
	function testCancelEditUserStaticInfo () {
		$user = $this->insert_user_infos(1);
		$temp = $user['creation_time'];
		$user['creation_time'] = '2011-2-5 13:02:40';
		$this->load->model('user_model');
		$this->user_model->edit_user_info($user);
		$user['creation_time'] = $temp;
		$db_user = $this->getByID($user['id'], 'users');
		unset($db_user['password']);
		$this->assertEqual($user, $db_user);
	}
	function testCancelEditUserInfoOnEmptyOrInvalidUserType () {
		$user = $this->insert_user_infos(1);
		$temp = $user;
		$user['user_type'] = '';
		$this->load->model('user_model');
		$this->user_model->edit_user_info($user);
		$db_user = $this->getByID($user['id'], 'users');
		unset($db_user['password']);
		$this->assertEqual($temp, $db_user);
		$user['user_type'] = 'books';
		$this->user_model->edit_user_info($user);
		$db_user = $this->getByID($user['id'], 'users');
		unset($db_user['password']);
		$this->assertEqual($temp, $db_user);
	}
	function getByID ($id, $table) {
		$this->db->where('id', $id);
		$query = $this->db->get($table);
		$user = $query->row();
		$data = array();
		foreach (get_object_vars($user) as $key => $value) {
			$data[$key] = $value;
		}
		return $data;
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
	function insert_user_infos ($count = -1) {
		if ($count == -1) $count = count($this->user_infos);
		for($i = 0; $i < $count; $i++) {
			$table = 'users';
			if ($this->user_infos[$i]['user_type'] != 'admin') {
				$table = $this->user_infos[$i]['user_type'] . 's';
			}
			$this->db->insert($table, $this->user_infos[$i]);
			unset($this->user_infos[$i]['password']);
			$this->user_infos[$i]['id'] = $this->db->insert_id();
			$result[] = $this->user_infos[$i];
		}
		if ($count == 1) return $result[0];
		else return $result;
	}
}
