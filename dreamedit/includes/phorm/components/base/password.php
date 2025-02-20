<?php

require_once dirname(__FILE__)."/../component.php";

class base_password extends component {

	var $value_is_array = TRUE;

	function value () {
		return array_shift($this->comp['value']);
	}


	function to_string () {
		return array_shift($this->comp['value']);
	}


	function _validate () {
		$component	= $this->comp;

		$errors			= array();
		$values			= isset($component['value'])	 	? $component['value']		: array();
		$prompts		= isset($component['prompt']) 		? $component['prompt']		: array();
		$required		= isset($component['required']) 	? $component['required']	: FALSE;
		$minlength		= isset($component['minlength'])	? $component['minlength']	: FALSE;
		$maxlength		= isset($component['maxlength'])	? $component['maxlength']	: FALSE;

		// We need to check both of the values to check for errors
		for ($i = 0; $i < count($values); $i++) {
			$value  = isset($values[$i])  ? $values[$i]  : '';
			$prompt = isset($prompts[$i]) ? $prompts[$i] : '';

			if ($this->isEmpty($value)) {
				if ($required) {
					$error = $this->_error('required_field', $component, $prompt);
					array_push($errors, $error);
				}
				continue;
			}

			if (($minlength) && (strlen($value) < $minlength)) {
				$error = $this->_error('too_short', $component, $prompt);
				array_push($errors, $error);
			}

			if (($maxlength) && (strlen($value) > $maxlength)) {
				$error = $this->_error('too_long', $component, $prompt);
				array_push($errors, $error);
			}

			if (isset($component['validate_method'])) {
				if ($error_type = $this->_validate_value($value)) {
					$error = $this->_error($error_type, $component, $prompt);
					array_push($errors, $error);
				}
			}
		}

		// If the passwords passed the other tests, make sure they're the same
		if ((count($errors) < 1) && ($values[0] != $values[1])) {
			$error = $this->_error('passwords_do_not_match', $component, $prompts[0]);
			array_push($errors, $error);
		}

		unset($_REQUEST[$component['name']]);
		$_REQUEST[$component['name']] = $values[0];

		return $errors;
	}


}



?>
