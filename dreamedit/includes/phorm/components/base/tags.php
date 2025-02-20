<?php

require_once dirname(__FILE__)."/../component.php";

class base_tags extends component {

	function _validate () {
		$component	= $this->comp;

		$errors		= array();
		$value		= isset($component['value']) ? $component['value'] : '';
		$prompt		= isset($component['prompt']) ? $component['prompt'] : '';
		$required	= isset($component['required']) ? $component['required'] : FALSE;
		$minlength	= isset($component['minlength']) ? $component['minlength'] : FALSE;
		$maxlength	= isset($component['maxlength']) ? $component['maxlength'] : FALSE;


		if ($this->isEmpty($value)) {
			if ($required) {
				$error = $this->_error('required_field', $component, $prompt);
				array_push($errors, $error);
			}
			return $errors;
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

		return $errors;
	}

}



?>
