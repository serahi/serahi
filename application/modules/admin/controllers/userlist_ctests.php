<?php

require_once(APPPATH . 'modules/admin/controllers/userlist.php');

Mock::generate('CI_Session');
Mock::generate('CI_Loader');

class Userlist_ctests extends MY_Controller {
	function testShowManageUserPanelOnAdminLoggedIn () {
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$test = new Userlist();
		$mocked_session->returns('userdata', TRUE, array('is_logged_in'));
		$mocked_session->returns('userdata', 'admin', array('user_type'));
		$mocked_loader->expectOnce('view', array('user_manage_view'));
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
}
