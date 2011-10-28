<?php

require_once(APPPATH . 'modules/admin/controllers/admin.php');

Mock::generate('CI_Session');
Mock::generate('CI_Loader');

class CTests extends MY_Controller {
	function testShowAdminPanelOnAdminLoggedIn () {
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$test = new Admin();
		$mocked_session->returns('userdata', TRUE, array('is_logged_in'));
		$mocked_session->returns('userdata', 'admin', array('user_type'));
		$mocked_loader->expectOnce('view', array('index_view'));
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->index();
	}
	function testShowAccessDeniedOnUserNotLoggedIn () {
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$test = new Admin();
		$mocked_session->returns('userdata', FALSE, array('is_logged_in'));
		$mocked_loader->expectOnce('view', array('access_denied'));
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->index();
	}
	
	function testShowAccessDeniedUserLoggedInNotAdmin () {
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$test = new Admin();
		$mocked_session->returns('userdata', TRUE, array('is_logged_in'));
		$mocked_session->returns('userdata', 'seller', array('user_type'));
		$mocked_loader->expectOnce('view', array('access_denied'));
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->index();
	}
}