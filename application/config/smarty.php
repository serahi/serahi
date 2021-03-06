<?php if (! defined ( 'BASEPATH' )) exit( 'No direct script access allowed' );

/**
* @name CI Smarty
* @copyright Dwayne Charrington, 2011.
* @author Dwayne Charrington and other Github contributors
* @license (DWYWALAYAM)
Do What You Want As Long As You Attribute Me Licence
* @version 1.2
* @link http://ilikekillnerds.com
*/

// Where templates are compiled
$config['compile_directory'] = APPPATH . "cache/smarty/compiled";

// Where templates are cached
$config['cache_directory'] = APPPATH . "cache/smarty/cached";

// Where Smarty configs are located
$config['config_directory'] = APPPATH . "third_party/Smarty/configs";

// PHP error reporting level (can be any valid error reporting level)
$config['error_reporting'] = error_reporting(E_ALL); 
