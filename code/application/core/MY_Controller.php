<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Custom Controller class for easier management and more predictable
 * behaviour from subclasses.
 * Subclasses should not try to define their own __construct method;
 * Instead, they should overwrite the pre_init, and post_init functions;
 * 
 * @section Subclasses
 * The logger library is automatically loaded in the __construct method.
 * Subclasses should set a $logger_config variable  in their pre_init
 * function to pass in custom config to the logger library. example below:
 * 
 * @code
 * // put this inside the pre_init() function
 * $logger_config = array(
 *                        'module_name' => 'dummy',
 *                        'user_id' => '0'
 *                       );
 * @endcode
 * 
 * @section LICENSE
 * This code does not bear any licenses or complexities as such,
 * and should be treated same as works in the public domain.
 * 
 * @author Milad Bashiri
 * @version 0.1
 */

/* The MX_Controller class is autoloaded as required */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->pre_init();
		/* MY_Controller init code */
		if (!isset($logger_config)) {
			$logger_config = array();
		}
		$this->load->library('logger', $logger_config);
		/***************************/
		$this->post_init();
	}
	
	protected function pre_init()
	{
	}
	
	protected function post_init()
	{
		
	}
}

/* End of file MY_Controller.php */
