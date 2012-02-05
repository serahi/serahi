<?php
$_level = '';
function check_access_level() {
	global $_level;
	global $RTR;
	$module = $RTR->fetch_module();
	$controller =  $RTR->fetch_class();
	$action = $RTR->fetch_method();
	$CI = &get_instance();
	$CI->load = clone load_class('Loader');
	$CI->load->_init($CI);
	$CI->load->library('session');
	
	$user_id = $CI->session->userdata('user_id');
	$user_type = $CI->session->userdata('user_type');
	
	$CI->load->config('access_levels');
	
	
	$action_access = $CI->config->item('actions');
	$controller_access = $CI->config->item('controllers');
	$module_access = $CI->config->item('modules');
	
	
	$access_levels = array(
		"$module.$controller.$action" => $action_access,
		"$module.$controller" => $controller_access,
		"$module" => $module_access
	);
	
	foreach ($access_levels as $access_name => $access_level) {
		if (isset($access_level[$access_name])) {
			$access_str = $access_level[$access_name];
			//echo $access_str;die;
			if ($user_id !== FALSE) {
				$redirect = base_url().'user/access_denied';
			} else {
				$redirect = base_url().'user/login';
			}
			if (strpos($access_str, '#') !== FALSE) {
				list($access_str, $redirect) = explode('#', $access_str, 2);
				$redirect = base_url().$redirect;
			}
			$levels = explode('|', $access_str);
			$granted = false;
			foreach($levels as $level) {
				if (
						$user_type === 'admin' ||
						$level ===  'everyone' ||
				    $user_type === $level  || 
				    ($level ===   'registered' && $user_id !== FALSE) ||
				    ($level === 'unregistered' && $user_id === FALSE)
					 ) {
					$granted = true;
				} else if (starts_with($level, 'self')) {
					$var_name = 'user_id';
					$source = 'get';
					if (strpos($level, ':') !== FALSE) {
						list($level, $var_name) = explode(':', $level, 2);
						if (strpos($var_name, '@') !== FALSE) {
							list($var_name, $source) = explode('@', $var_name, 2);
						}
					}
					$expected_user = $CI->input->$source($var_name);
					//echo $var_name; echo $source; echo $expected_user; die;
					if ($expected_user === $user_id) {
						$granted = true;
					}
				}
				if ($granted) {
					$_level = $level;
					return;
				}
			}
			if (!$granted) {
				header('Location:'.$redirect);
				exit;
			}
		}
	}
	header('Location:'.base_url().'user/access_denied');
	exit();
}

function access() {
	global $_level;
	return $_level;
}

