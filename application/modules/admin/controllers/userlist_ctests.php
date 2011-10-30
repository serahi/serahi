<?php

require_once(APPPATH . 'modules/admin/controllers/userlist.php');
load_class('Model', 'core');
require_once(APPPATH . 'modules/admin/models/user_model.php');
Mock::generate('CI_Session');
Mock::generate('CI_Loader');
Mock::generate('CI_Input');
Mock::generate('User_model');
class Userlist_ctests extends MY_Controller {
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
	function testShowUserListPanelOnAdminLoggedIn () {
		$mocked_session = $this->get_mocked_session('admin');
		$mocked_loader = new MockCI_Loader();
		$test = new Userlist();
		$mocked_loader->expectOnce('view', array('userlist_view', '*'));
		$mocked_user_model = new MockUser_model();
		$mocked_user_model->expectOnce('get_users');
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->user_model = $mocked_user_model;
		$test->index();
	}
	function testShowAccessDeniedForUserlistWiewWithoutSessionOrNotAdmin () {
		$session_users = array('guest', 'seller', 'customer');
		$first = true;
		foreach($session_users as $session_user) {
			if ($first) $first = false;
			else $this->setUp();
			$mocked_session = $this->get_mocked_session($session_user);
			$mocked_loader = new MockCI_Loader();
			$test = new Userlist();
			$mocked_loader->expectOnce('view', array('access_denied'));
			$test->session = $mocked_session;
			$test->load = $mocked_loader;
			$test->index();
		}
	}
	function testDeleteActionInUserListWithAdminSession () {
		$mocked_session = $this->get_mocked_session('admin');
		$user = $this->insert_users(1);
		$mocked_input = new MockCI_Input();
		$mocked_input->returns('post', $user['id'], array('id'));
		$mocked_model = new MockUser_model();
		$mocked_model->expectOnce('delete_user', array($user['id']));
		$mocked_loader = new MockCI_Loader();
		$test = new Userlist();
		$test->load = $mocked_loader;
		$test->input = $mocked_input;
		$test->session = $mocked_session;
		$test->user_model = $mocked_model;
		$test->delete();
	}
	function testAccessDeniedOnDeleteActionInUserListWithoutSessionOrNotAdmin () {
		$session_users = array('guest', 'seller', 'customer');
		$first = true;
		foreach($session_users as $session_user) {
			if ($first) $first = false;
			else $this->setUp();
			$mocked_session = $this->get_mocked_session($session_users);
			$user = $this->insert_users(1);
			$mocked_input = new MockCI_Input();
			$mocked_input->returns('post', $user['id'], array('id'));
			$mocked_model = new MockUser_model();
			$mocked_model->expectNever('delete_user', array('*'));
			$mocked_loader = new MockCI_Loader();
			$mocked_loader->expectOnce('view', array('access_denied'));
			$test = new Userlist();
			$test->load = $mocked_loader;
			$test->input = $mocked_input;
			$test->session = $mocked_session;
			$test->user_model = $mocked_model;
			$test->delete();
		}
	}
	function testShowEditUserViewWithDataWithAdminSession () {
		$mocked_session = $this->get_mocked_session('admin');
		$users = $this->insert_user_infos(2);
		foreach ($users as $user) {
			$mocked_input = new MockCI_Input();
			$mocked_input->returns('get', $user['id'], array('id'));
			$mocked_model = new MockUser_model();
			$mocked_model->expectOnce('get_user_info', array($user['id']));
			$mocked_model->returns('get_user_info', $user, array($user['id']));
			$mocked_loader = new MockCI_Loader();
			$mocked_loader->expectOnce('view', array('edit_info_view', $user));
			$test = new Userlist();
			$test->load = $mocked_loader;
			$test->input = $mocked_input;
			$test->session = $mocked_session;
			$test->user_model = $mocked_model;
			$test->edit();
		}
	}
	function testAccessDeniedOnEditUserViewWithoutSessionOrNotAdmin () {
		$session_users = array('guest', 'seller', 'customer');
		$first = true;
		foreach($session_users as $session_user) {
			if ($first) $first = false;
			else $this->setUp();
			$mocked_session = $this->get_mocked_session($session_user);
			$user = $this->insert_user_infos(1);
			$mocked_input = new MockCI_Input();
			$mocked_input->returns('get', $user['id'], array('id'));
			$mocked_model = new MockUser_model();
			$mocked_model->expectNever('get_user_info', array('*'));
			$mocked_loader = new MockCI_Loader();
			$mocked_loader->expectOnce('view', array('access_denied'));
			$test = new Userlist();
			$test->load = $mocked_loader;
			$test->input = $mocked_input;
			$test->session = $mocked_session;
			$test->user_model = $mocked_model;
			$test->edit();
		}
	}
	function insert_users ($count = -1) {
		$users = $this->users;
		if ($count == -1) $count = count(users);
		for($i = 0; $i < $count; $i++) {
			$this->db->insert('users', $users[$i]);
			unset($users[$i]['password']);
			$users[$i]['id'] = $this->db->insert_id();
			$result[] = $users[$i];
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
	function get_mocked_session ($user_type) {
		$mocked_session = new MockCI_Session();
		if ($user_type == 'guest') {
			$mocked_session->returns('userdata', FALSE, array('is_logged_in'));
		} else {
			$mocked_session->returns('userdata', TRUE, array('is_logged_in'));
			$mocked_session->returns('userdata', $user_type, array('user_type'));
		}
		return $mocked_session;
	}
}
