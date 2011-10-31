<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Controller.php";
require_once(realpath(dirname(__FILE__).'/../../simpletest/autorun.php'));

class MY_Controller extends UnitTestCase
{
	public $autoload = array();
	
	public function __construct() 
	{
		parent::__construct();
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->_init($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
	}
	public function __get($class) {
		return CI::$APP->$class;
	}
	var $users_data;
	var $customers_data;
	var $products_data;
	var $sellers_data;
	var $transactions_data;
	function convert ($input) {
		$data = array();
		foreach (get_object_vars($input) as $key => $value) {
			if ($key == 'password') continue;
			if ($key == 'approved') $value = $value == 't' ? 'TRUE' : 'FALSE';
			$data[$key] = $value;
		}
		return $data;
	}
	public function index() {
		$result = run_local_tests();
		if (SimpleReporter::inCli()) {
		    exit($result ? 0 : 1);
		}
	}
}