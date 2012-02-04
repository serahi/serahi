<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @section LICENSE
 * this code does not bear any licenses or complexities as such,
 * and should be treated same as works in the public domain.
 * 
 * @author Milad Bashiri
 * @version 0.1
 */

class Validator
{
	function __construct ()
	{
		// Store the Codeigniter super global instance... whatever
		$CI =& get_instance();
		$CI->load->library('form_validation');
		$CI->load->config('validator');
		$messages = $CI->config->item('messages');
		foreach ($messages as $rule => $message) {
			$CI->form_validation->set_message($rule, $message);
		}
		$CI->form_validation->set_error_delimiters('<div class = "error_msg">', '</div>');
	}
	function validate ($fields, $override = '')
	{
		$CI =& get_instance();
		$fields = (array)$fields; // Make sure we are dealing with an array.
		$rules = array();
		$override_rules = array();
		if ($override != '') {
			$override_rules = $CI->config->item($override);
		}
		foreach ($fields as $field) {
			$rule = $CI->config->item($field);
			if (isset($override_rules[$field])) {
				$rule = $override_rules[$field];
			}
				
			$rules[] = array(
				'field' => $field,
				'label' => _t($field),
				'rules' => $rule
			);
		}
		$CI->form_validation->set_rules($rules);
		return $CI->form_validation->run();
	}
}
	