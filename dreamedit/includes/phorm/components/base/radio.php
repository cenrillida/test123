<?php

require_once dirname(__FILE__)."/../component.php";

class base_radio extends component {

	function _validate () {
		$component	= $this->comp;

		$errors	= array();
		$value	= isset($component['value']) ? $component['value'] : '';
		$prompt	= isset($component['prompt']) ? $component['prompt'] : '';
		$required	= isset($component['required']) ? $component['required'] : FALSE;

		if (($required) && $this->isEmpty($value)) {
			$error = $this->_error('required_field', $component, $prompt);
			array_push($errors, $error);
			// No sense in checking a null field for other errors.
			return $errors;
		}

		if (!in_array($value, $component['options'])) {
			$error = $this->_error('invalid_selection', $component, $prompt);
			array_push($errors, $error);
		}

		return $errors;
	}
}

?>
