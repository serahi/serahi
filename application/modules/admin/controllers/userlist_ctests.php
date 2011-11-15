<?php

require_once (APPPATH . 'modules/admin/controllers/userlist.php');
load_class('Model', 'core');
require_once (APPPATH . 'modules/admin/models/user_model.php');
Mock::generate('CI_Session');
Mock::generate('CI_Loader');
Mock::generate('CI_Input');
Mock::generate('User_model');

class Userlist_ctests extends MY_Controller
{
	var $users, $user_infos;
	function setUp ()
	{
		parent::setUp();
		$this->db->query('truncate users;');
		$this->users[0] = array(
				'username' => 'admin',
				'password' => md5('admin'),
				'first_name' => 'مدیر',
				'last_name' => 'سایت',
				'user_type' => 'admin',
				'email' => 'admin@serahi.ir',
				'creation_time' => date('Y-m-d H:i:s')
		);
		$this->user_infos[0] = $this->users[0];
		$this->users[1] = array(
				'username' => 'milad',
				'password' => md5('milad'),
				'first_name' => 'milad',
				'last_name' => 'bashiri',
				'user_type' => 'seller',
				'email' => 'miladbashiri@comp.iust.ac.ir',
				'creation_time' => date('Y-m-d H:i:s')
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

	function testShowUserListPanelOnAdminLoggedIn ()
	{
		$mocked_session = $this->get_mocked_session('admin');
		$mocked_loader = new MockCI_Loader ();
		$test = new Userlist ();
		$mocked_loader->expectOnce('view', array(
				'userlist_view',
				'*'
		));
		$mocked_user_model = new MockUser_model ();
		$mocked_user_model->expectOnce('get_users');
		CI_Controller::$instance->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->user_model = $mocked_user_model;
		$test->index();
	}

	function testShowAccessDeniedForUserlistWiewWithoutSessionOrNotAdmin ()
	{
		$session_users = array(
				'guest',
				'seller',
				'customer'
		);
		$first = true;
		foreach ($session_users as $session_user) {
			if ($first)
				$first = false;
			else
				$this->setUp();
			$mocked_session = $this->get_mocked_session($session_user);
			$mocked_loader = new MockCI_Loader ();
			$test = new Userlist ();
			$mocked_loader->expectOnce('view', array('access_denied'));
			$mocked_loader->returns('model', $this->load->model('user_model'), array('user_model'));
			
		CI_Controller::$instance->session = $mocked_session;
			$test->load = $mocked_loader;
			$test->index();
		}
	}

	function testDeleteActionInUserListWithAdminSession ()
	{
		$mocked_session = $this->get_mocked_session('admin');
		$user = $this->insert_users(1);
		$mocked_input = new MockCI_Input ();
		$mocked_input->returns('post', $user['id'], array('id'));
		$mocked_model = new MockUser_model ();
		$mocked_model->expectOnce('delete_user', array($user['id']));
		$mocked_loader = new MockCI_Loader ();
		$test = new Userlist ();
		$test->load = $mocked_loader;
		$test->input = $mocked_input;
		
		CI_Controller::$instance->session = $mocked_session;
		$test->user_model = $mocked_model;
		@$test->delete();
	}

	function testAccessDeniedOnDeleteActionInUserListWithoutSessionOrNotAdmin ()
	{
		$session_users = array(
				'guest',
				'seller',
				'customer'
		);
		$first = true;
		foreach ($session_users as $session_user) {
			if ($first)
				$first = false;
			else
				$this->setUp();
			$mocked_session = $this->get_mocked_session($session_users);
			$user = $this->insert_users(1);
			$mocked_input = new MockCI_Input ();
			$mocked_input->returns('post', $user['id'], array('id'));
			$mocked_model = new MockUser_model ();
			$mocked_model->expectNever('delete_user', array('*'));
			$mocked_loader = new MockCI_Loader ();
			$mocked_loader->expectOnce('view', array('access_denied'));
			$test = new Userlist ();
			$test->load = $mocked_loader;
			$test->input = $mocked_input;
			
		CI_Controller::$instance->session = $mocked_session;
			$test->user_model = $mocked_model;
			$test->delete();
		}
	}/* */

	function testShowEditUserViewWithDataWithAdminSession ()
	{
		$mocked_session = $this->get_mocked_session('admin');
		$users = $this->insert_user_infos(2);
		foreach ($users as $user) {
			$mocked_input = new MockCI_Input ();
			$mocked_input->returns('get', $user['id'], array('id'));
			$mocked_model = new MockUser_model ();
			$mocked_model->expectOnce('get_user_info', array($user['id']));
			$mocked_model->returns('get_user_info', $user, array($user['id']));
			$mocked_loader = new MockCI_Loader ();
			$mocked_loader->expectOnce('view', array(
					'edit_info_view',
					$user
			));
			$test = new Userlist ();
			$test->load = $mocked_loader;
			$test->input = $mocked_input;
			
		CI_Controller::$instance->session = $mocked_session;
			$test->user_model = $mocked_model;
			$test->edit();
		}
	}

	function testShowUserListWiewOnRequestEditUserViewWithNoIDInGet ()
	{
		$mocked_session = $this->get_mocked_session('admin');
		$mocked_input = new MockCI_Input ();
		$mocked_input->returns('get', FALSE, array('id'));
		$mocked_model = new MockUser_model ();
		$mocked_model->expectNever('get_user_info', array('*'));
		$mocked_loader = new MockCI_Loader ();
		$test = new Userlist ();
		$test->load = $mocked_loader;
		$test->input = $mocked_input;
		
		CI_Controller::$instance->session = $mocked_session;
		$test->user_model = $mocked_model;
		@$test->edit();
	}/* */

	function testAccessDeniedOnEditUserViewWithoutSessionOrNotAdmin ()
	{
		$session_users = array(
				'guest',
				'seller',
				'customer'
		);
		$first = true;
		foreach ($session_users as $session_user) {
			if ($first)
				$first = false;
			else
				$this->setUp();
			$mocked_session = $this->get_mocked_session($session_user);
			$user = $this->insert_user_infos(1);
			$mocked_input = new MockCI_Input ();
			$mocked_input->returns('get', $user['id'], array('id'));
			$mocked_model = new MockUser_model ();
			$mocked_model->expectNever('get_user_info', array('*'));
			$mocked_loader = new MockCI_Loader ();
			$mocked_loader->expectOnce('view', array('access_denied'));
			$test = new Userlist ();
			$test->load = $mocked_loader;
			$test->input = $mocked_input;
			
		CI_Controller::$instance->session = $mocked_session;
			$test->user_model = $mocked_model;
			$test->edit();
		}
	}

	function testEditUserActionWithAdminSession ()
	{
		$mocked_session = $this->get_mocked_session('admin');
		$user = $this->insert_user_infos(1);
		$user['password'] = 'admin';
		$mocked_input = new MockCI_Input ();
		foreach ($user as $field => $value) {
			$mocked_input->returns('post', $value, array($field));
		}
		$mocked_model = new MockUser_model ();
		$sorted_user = array();
		foreach (array('id', 'username', 'password', 'first_name', 'last_name',
		'user_type', 'email', 'creation_time') as $key) {
			$sorted_user[$key] = $user[$key];
		}
		$mocked_model->expectOnce('edit_user_info', array($sorted_user));
		$mocked_loader = new MockCI_Loader ();
		$test = new Userlist ();
		$test->load = $mocked_loader;
		$test->input = $mocked_input;
		CI_Controller::$instance->input = $mocked_input;
		CI_Controller::$instance->session = $mocked_session;
		$test->user_model = $mocked_model;
		@$test->save_edit();
	}

	function insert_users ($count = -1)
	{
		$users = $this->users;
		if ($count == -1)
			$count = count(users);
		for ($i = 0; $i < $count; $i++) {
			$this->db->insert('users', $users[$i]);
			unset($users[$i]['password']);
			$users[$i]['id'] = $this->db->insert_id();
			$result[] = $users[$i];
		}
		if ($count == 1)
			return $result[0];
		else
			return $result;
	}

	function insert_user_infos ($count = -1)
	{
		$user_infos = $this->user_infos;
		if ($count == -1)
			$count = count($user_infos);
		for ($i = 0; $i < $count; $i++) {
			$table = 'users';
			if ($user_infos[$i]['user_type'] != 'admin') {
				$table = $user_infos[$i]['user_type'] . 's';
			}
			$this->db->insert($table, $user_infos[$i]);
			unset($user_infos[$i]['password']);
			$user_infos[$i]['id'] = $this->db->insert_id();
			$result[] = $user_infos[$i];
		}
		if ($count == 1)
			return $result[0];
		else
			return $result;
	}

	function get_mocked_session ($user_type)
	{
		$mocked_session = new MockCI_Session ();
		if ($user_type == 'guest') {
			$mocked_session->returns('userdata', FALSE, array('is_logged_in'));
		} else {
			$mocked_session->returns('userdata', TRUE, array('is_logged_in'));
			$mocked_session->returns('userdata', $user_type, array('user_type'));
		}
		return $mocked_session;
	}

}
