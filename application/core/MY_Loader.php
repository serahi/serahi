<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * A custom Loader class integerating the Swampy Template Engine
 * with CodeIgniter
 *
 * @section LICENSE
 * This code does not bear any licenses or complexities as such,
 * and should be treated same as works in the public domain.
 *
 * @author Milad Bashiri
 * @version 0.1
 */

/* load the MX_Loader class */
require APPPATH . "third_party/MX/Loader.php";

class MY_Loader extends MX_Loader
{
	public function _ci_load ($_ci_data)
	{
		$CI = &get_instance();
		foreach (array('_ci_view', '_ci_vars', '_ci_path',
		'_ci_return') as $_ci_val) {
			$$_ci_val = (!isset($_ci_data[$_ci_val])) ? FALSE : $_ci_data[$_ci_val];
		}

		if ($_ci_path == '') {
			$_ci_file = strpos($_ci_view, '.') ? $_ci_view : $_ci_view . EXT;
			$_ci_path = $this->_ci_view_path . $_ci_file;
		} else {
			$_ci_file = end(explode('/', $_ci_path));
		}

		if (!file_exists($_ci_path)) {
			show_error('Unable to load the requested file: ' . $_ci_file);
		}
		/* $_ci_dir is unused right now, i guess. might probably be removed */
		$_ci_dir = substr($_ci_path, 0, strlen($_ci_path) - strlen($_ci_file));
		$_ci_relative = substr($_ci_path, strlen(APPPATH));
		$CI->load->library('smarty', APPPATH);

		if (is_array($_ci_vars)) {
			$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
			foreach ($_ci_vars as $key => $val) {
				$CI->smarty->assign($key, $val);
			}
		}

		$str = $CI->smarty->fetch('extends:templates/template.php|' . $_ci_relative);

		extract($this->_ci_cached_vars);

		ob_start();

		echo eval('?>' . $str);

		if ($_ci_return == TRUE) {
			return ob_get_clean();
		}

		if (ob_get_level() > $this->_ci_ob_level + 1) {
			ob_end_flush();
		} else {
			CI::$APP->output->append_output(ob_get_clean());
		}
	}

}

/* End of file DK_Loader.php */
