<?php

function _post_values ($array, $numbered = false)
{
	$CI = &get_instance();
	$values = array();
	foreach ($array as $field) {
		$parts = explode(':', $field, 2);
		if (count($parts) > 1) {
			$field_name = $parts[0];
			$field_type = $parts[1];
			if ($field_type === 'b') {
				$value = $CI->input->post($field_name) ? 't' : 'f';
				$values[$field_name] = $value;
			}
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