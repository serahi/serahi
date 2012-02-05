<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Controller.php";
require_once(realpath(dirname(__FILE__).'/../../simpletest/autorun.php'));

DEFINE("DATE_FORMAT", "Y-m-d H:i:s");

class MY_Controller extends UnitTestCase
{
	public $autoload = array();

	public function __construct ()
	{
		parent::__construct();
                
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class . " MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;

		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->_init($this);

		/* autoload module items */
		$this->load->_autoloader($this->autoload);
//<<<<<<< HEAD
                global $RTR;
                echo $module = $RTR->fetch_module() . ' ';
                echo $class =  $RTR->fetch_class(). ' ';
                echo $method = $RTR->fetch_method(). ' ';
                $this->access_check( $module, $class, $method );
//=======
		$this->load->language('shared', 'farsi');
//>>>>>>> 417c9744a78cfff51a5967a8162b087bce1ba76f
	}

	public function __get ($class)
	{
		return CI::$APP->$class;
	}


	public function index ()
	{
		$result = run_local_tests();
		if (SimpleReporter::inCli()) {
			exit($result ? 0 : 1);
		}
	}
        
        public function access_check( $module, $class, $method ){
            $user_id = $this->session->userdata('user_id');
            $user_type = $this->session->userdata('user_type');
            
            $CI = &get_instance();
            $CI->load->config('access_levels');
            
        }        

}
