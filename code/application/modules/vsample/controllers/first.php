<?php 
class First extends MY_Controller
{
	public function index ()
	{
		$data = array('hi' => 'hi', 'bye' => 'bye');
		$this->load->view('first_view', $data);
	}
}
