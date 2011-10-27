<?php
require_once(APPPATH . 'modules/home/controllers/home.php');
Mock::generate('CI_Session');
Mock::generate('CI_Loader');
class Ctests extends MY_Controller{
	
	function testIndexWorksOnUserLoggedIn() {
		$test = new Home();
		$mocked_session = new MockCI_Session();
		$mocked_loader = new MockCI_Loader();
		$mocked_session->returns('userdata', TRUE , array('is_logged_in'));
		$mocked_loader->returns('model', $this->load->model('home_model'));
		$mocked_loader->expectOnce('view', array('home_view', '*'));
		$test->session = $mocked_session;
		$test->load = $mocked_loader;
		$test->index();
	}
}
