<?php

class Home extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		if ($this->is_logged_in()) {
			$this -> load -> model('home_model');
			$array['products'] = $this -> home_model -> getall();
			$this -> load -> view('home_view', $array);
		}else{
			$this -> load -> view('home_view');
		}
		
	}

	function is_logged_in() {
		return $this -> session -> userdata('is_logged_in');
	}

}
