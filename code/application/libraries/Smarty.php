<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* @name CI Smarty
* @copyright Dwayne Charrington, 2011.
* @author Dwayne Charrington and other Github contributors
* @license (DWYWALAYAM)
Do What You Want As Long As You Attribute Me Licence
* @version 1.2
* @link http://ilikekillnerds.com
*/

require_once APPPATH . "third_party/Smarty/Smarty.class.php";

class CI_Smarty extends Smarty
{
	public function __construct ($template_dir)
	{
		parent::__construct();
		
		// Store the Codeigniter super global instance... whatever
		$CI =& get_instance();
		
		$CI->load->config('smarty');
		
		$this->template_dir = array($template_dir);
		$this->compile_dir = config_item('compile_directory');
		$this->cache_dir = config_item('cache_directory');
		$this->config_dir = array(config_item('config_directory'));
		//$this->exception_handler = null;
		
		// Only show serious errors. Without this if you try and use variables that
		// do not exist, Smarty will throw variable does not exist errors
		$this->error_reporting = config_item('error_reporting');
		//$this->php_handling = Smarty::PHP_ALLOW;
		
		// Add all helpers to plugins_dir
		$helpers = glob(APPPATH . 'helpers/', GLOB_ONLYDIR | GLOB_MARK);
		
		foreach ($helpers as $helper) {
			$this->plugins_dir[] = $helper;
		}
		
		// Should let us access Codeigniter stuff in views
		$this->assign("this", $CI);
	}
}