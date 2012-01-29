<?php
$val_repo;
function _post_values ($array, $numbered = false)
{
	$CI = &get_instance();
	$values = array();
	foreach ($array as $field) {
		if ($field == 'approved') {
			$value = $CI->input->post($field) ? 't' : 'f';
			$values[$field_name] = $value;
		} else {
			$value = $CI->input->post($field);
			if ($value !== FALSE) {
				if ($numbered)
					$values[] = $value;
				else
					$values[$field] = $value;
			}
		}
	}
	return $values;
}

function convert_obj_to_array ($input)
{
	$data = array();
	foreach (get_object_vars($input) as $key => $value) {
		if ($key == 'password')
			continue;
		$data[$key] = $value;
	}
	return $data;
}

function _is_admin ()
{
	$CI = &get_instance();
	return ($CI->session->userdata('is_logged_in') === TRUE &&
	        $CI->session->userdata('user_type') === 'admin');
}


/**
 * @brief Generate a random string of length $len
 * 
 * Generates a random string consisting of lowercase characters and 
 * numbers, using linux's native random generator /dev/urandom.
 * The string generated is not guaranteed to be unique, nor uniformly-
 * distributed, and is less random  than /dev/urandom output itself.
 * Speed was the main concern while implementing this function.
 * 
 * @author Milad Bashiri
 * @param $len length of the random string generated
 * @return a random string of length $len
 */
function rand_gen($len)
{
	$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$random_string = '';
	/* courtesy of php.net community */
	$fp = fopen('/dev/urandom','rb');
	$random_bytes = array();
	if ($fp !== FALSE) {
		$random_bytes = fread($fp,$len);
		fclose($fp);
	}
	/*********************************/
	for ($i = 0; $i < $len; $i++) {
		$random_string .= $chars[ord($random_bytes[$i]) % 36];
	}
	
	return $random_string;
}

function ends_with( $str, $sub ) {
   return ( substr( $str, strlen( $str ) - strlen( $sub ) ) === $sub );
}


function t($line)
{
	echo _t($line);
}

function _t ($line)
{
	$CI =& get_instance();
	$line = (array) $line;
	$translate = '';
	$first = true;
	foreach ($line as $word) {
		if ($first) {
			$first = false;
		} else {
			$translate .= ' ';
		}
		$translate .= $CI->lang->line($word);
	}
	return $translate;
}

function debug ($str)
{
	echo $str;
}

function _t_input ($field, $options_str = '')
{
	$html = '';
	$input_id = $field;
	$input_class = '';
	$label_class = '';
	$default = '';
	$nofill = FALSE;
	$is_password = FALSE;
	$hidden = FALSE;
	if (strpos($field, 'password') !== FALSE) {
		$is_password = TRUE;
		$nofill = TRUE;
	}
	$options = explode('|', $options_str);
	$t = $field;
	if ($options[0] != '') {
		foreach ($options as $option) {
			if ($option == 'no_id') {
				$input_id = '';
			} else if ($option == 'hidden'){
				$hidden = TRUE;
			} else {
				list($type, $value) = explode(":", $option);
				if ($type == 'id') {
					$input_id = $value;
				} else if ($type == 'class') {
					$input_class = $value;
				} else if ($type == 'label_class') {
					$label_class = $value;
				} else if ($type == 'default') {
					$default = $value;
				} else if ($type == 'nofill') {
					$nofill = TRUE;
				} else if ($type == 'pass') {
					$is_password = TRUE;
				} else if ($type == 't') {
					$t = $value;
				}
			}
		}
	}
	if ($default == '') {
		global $val_repo;
		if (isset($val_repo[$field])) {
			$default = $val_repo[$field];
		}
	}
	if ($label_class == '' && $input_class != '') {
		$label_class = $input_class;
	}
	if ($hidden == FALSE) {
		$html .= _t_label($t, $input_id, $label_class);
	}
	
	$html .= "<input name = '$field' ";
	if ($input_id != '') $html .= "id = '$input_id' ";
	if ($input_class != '') $html .= "class = '$input_class' ";
	if ($hidden == TRUE) $html .= "type = 'hidden' ";
	else if ($is_password == TRUE) $html .= "type = 'password' ";
	if ($nofill == FALSE) $html .= "value = '" . set_value($field, $default) . "' ";
	if ($nofill == TRUE)  $html .= "value = '$default' ";
	$html .= '>';
	return $html;
}
function t_input ($field, $options_str = '')
{
	echo _t_input($field, $options_str);
}
function _t_label ($field, $id = '', $class = '')
{
	$search = strpos($class, 'validate[');
	if ($search >= 0) {
		$ending = strrpos($class, ']');
		$class = substr($class, 0, $search) . substr($class, $ending + 1);
	}
	
	$html = "<label ";
	if ($id != '')    $html .= "for = '$id' ";
	if ($class != '') $html .= "class = '$class' ";
	$html .= '>'._t($field)."</label>";
	
	return $html;	
}
function t_label ($field, $id = '', $class = '') {
	if ($id == '') $id = $field;
	echo _t_label($field, $id, $class);
}
function _t_select ($field, $data, $options_str = '', $option_key = '', $option_value = '')
{
	$html = '';
	$id = $field;
	$class = '';
	$label_class = '';
	$default = '';
	$associative = FALSE;
	$trans_values = FALSE;
	$null = FALSE;
	
	$options = explode('|', $options_str);
	$t = $field;
	if ($options[0] != '') {
		foreach ($options as $option) {
			if ($option == 'no_id') {
				$id = '';
			} else if ($option == 'assoc') {
				$associative = TRUE;
			} else if ($option == 'trans_values') {
				$trans_values = TRUE;
			} else if ($option == 'null') {
				$null = TRUE;
			} else {
				list($type, $value) = explode(":", $option);
				if ($type == 'id') {
					$id = $value;
				} else if ($type == 'class') {
					$class = $value;
				} else if ($type == 'label_class') {
					$label_class = $value;
				} else if ($type == 'value') {
					$default = $value;
				} else if ($type == 't') {
					$t = $value;
				}
			}
		}
	}
	if ($label_class == '' && $class != '') {
		$label_class = $class;
	}
	$html .= _t_label($t, $id, $class);
	
	$html .= "<select name = '$field' ";
	if ($id != '')    $html .= "id = '$id' ";
	if ($class != '') $html .= "class = '$class' ";
	$html .= '>';
	if ($associative) {
		foreach ($data as $key => $value) {
			$html .= "<option value = '" . $key . "'";
			if ($key == $default) {
				$html .= set_select($field, $key, TRUE);
			} else {
				$html .= set_select($field, $key);
			}
			$html .= ">";
			if ($trans_values) $html .= _t($value);
			else $html .= $value;
			$html .= "</option>";
		}
	} else {
		if ($null == TRUE) {
			$html .= "<option value = ''>" . _t('null_select') . '</option>';
		}
		foreach ($data as $row) {
			$html .= "<option value = '" . $row[$option_key] . "'";
			if ($row[$option_key] == $default) {
				$html .= set_select($field, $row[$option_key], TRUE);
			} else {
				$html .= set_select($field, $row[$option_key]);
			}
			$html .= ">";
			if ($trans_values) $html .= _t($row[$option_value]);
			else $html .= $row[$option_value];
			$html .= "</option>";
		}
	}
	$html .= '</select>';
	return $html;
}
function t_select ($field, $data, $options_str = '', $option_key = '', $option_value = '')
{
	echo _t_select($field, $data, $options_str, $option_key, $option_value);
}
