<?php

function _post_values ($array)
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
				$values[$field] = $value;
			}
		}
	}
	return $values;
}

function _is_admin ()
{
	$CI = &get_instance();
	return ($CI->session->userdata('is_logged_in') === TRUE &&
	        $CI->session->userdata('user_type') === 'admin');
}