<?php
require_once(APPPATH . 'modules/csample/controllers/main.php');

Mock::generate('CI_Input');
Mock::generate('CI_DB');
class Tests extends MY_Controller {
	
	function testMain () {
		$test_class = new Main();
		$mocked_input = new MockCI_Input();
		$mocked_input->returns('post', 'mocked input');
		$test_class->input = $mocked_input;
		$test_class->index();
	}
}
