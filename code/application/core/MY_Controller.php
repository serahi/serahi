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
	public function setUp() {
		echo 'eh';
		//require "/var/www/ci_test/system/core/CodeIgniter.php";
	}
	public function index() {
		$result = run_local_tests();
		if (SimpleReporter::inCli()) {
		    exit($result ? 0 : 1);
		}
	}
