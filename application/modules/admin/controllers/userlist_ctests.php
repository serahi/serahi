<?php

require_once(APPPATH . 'modules/admin/controllers/userlist.php');
load_class('Model', 'core');
require_once(APPPATH . 'modules/admin/models/user_model.php');
Mock::generate('CI_Session');
Mock::generate('CI_Loader');
Mock::generate('CI_Input');
Mock::generate('User_model');
class Userlist_ctests extends MY_Controller {
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
	function testShowUserListPanelOnAdminLoggedIn () {
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$test = new Userlist();
		$mocked_session->returns('userdata', TRUE, array('is_logged_in'));
		$mocked_session->returns('userdata', 'admin', array('user_type'));
		$mocked_loader->expectOnce('view', array('userlist_view', '*'));
		$mocked_loader->returns('model', $this->load->model('user_model'),
		                        array('user_model'));
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->index();
	}
	function testShowAccessDeniedOnUserNotLoggedIn () {
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$test = new Userlist();
		$mocked_session->returns('userdata', FALSE, array('is_logged_in'));
		$mocked_loader->expectOnce('view', array('access_denied'));
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->index();
	}
	
	function testShowAccessDeniedUserLoggedInNotAdmin () {
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$test = new Userlist();
		$mocked_session->returns('userdata', TRUE, array('is_logged_in'));
		$mocked_session->returns('userdata', 'seller', array('user_type'));
		$mocked_loader->expectOnce('view', array('access_denied'));
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->index();
	}
	function testDeleteActionInUserList () {
		$user = $this->insert_users (1);
		$mocked_input = new MockCI_Input();
		$mocked_input->returns('post', $user['id'], array('id'));
		$mocked_model = new MockUser_model();
		$mocked_model->expectOnce('delete_user', array($user['id']));
		$mocked_loader = new MockCI_Loader();
		//$mocked_loader->returnsByReference('model', $mocked_model, array('user_model'));
		$test = new Userlist();
		$test->load = $mocked_loader;
		$test->input = $mocked_input;
		$test->user_model = $mocked_model;
		$test->delete();
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
