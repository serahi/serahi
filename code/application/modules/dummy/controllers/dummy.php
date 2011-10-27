<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dummy extends MY_Controller
{
	protected function pre_init()
	{
		$logger_config['module_name'] = 'dummy';
	}
	
	function index ()
	{
		$this->logger->log('DEBUG', 'test_log', 'First Log Test');
		$data['test'] = 'this is a test string';
		$this->load->view('dummy_view', $data);
	}
}

/* End of file dummy.php */
