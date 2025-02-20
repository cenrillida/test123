<?php

require_once dirname(__FILE__)."/../component.php";

class base_checkbox extends component {

	var $value_is_array;

	function __construct()
	{
		$this->value_is_array	= is_array($this->comp['options']);
	}

	function base_checkbox()
	{
		$this->__construct();
	}

	function _validate () {
/*		$component	= $this->comp;

		$errors		= array();
		$values		= isset($component['value']) ? $component['value'] : array();
		$prompt		= isset($component['prompt']) ? $component['prompt'] : '';
		$required	= isset($component['required']) ? $component['required'] : FALSE;
		$this->value_is_array	= is_array($component['options']);

		if (($required) && (count($values) < 1)) {
			$error = $this->_error('required_field', $component, $prompt);
			array_push($errors, $error);
			// No sense in checking a null field for other errors.
			return $errors;
		}*/
/*
		if (count(array_diff(array_keys($values), array_keys($component['options']))) > 0) {
			$error = $this->_error('invalid_selection', $component, $prompt);
			array_push($errors, $error);
		}
*/
//		return $errors;

		return array();
	}

}


?>
