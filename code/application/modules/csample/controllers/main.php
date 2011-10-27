<?php
class Main extends MY_Controller {
	function index() {
		echo 'hi';
		echo $this->input->post('what');
	}
}
