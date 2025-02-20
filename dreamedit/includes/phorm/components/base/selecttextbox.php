<?php

require_once dirname(__FILE__)."/../component.php";

class base_selecttextbox extends component {

	var $value_is_array = TRUE;

	function value () {

		if ((isset($this->comp['multiple'])) && ($this->comp['multiple'])) {
			return $this->comp['value'];
		} else {
			return array_shift($this->comp['value']);
		}
	}

	// Might need to add a custom to_string here

	function _validate () {

		$component	= $this->comp;

		$errors			= array();
		$non_null_value	= FALSE;
		$values			= isset($component['value']) ? $component['value'] : array();
		$texts			= isset($component['texts']) ? explode("|",$component['texts']) : array();
		$prompt			= isset($component['prompt']) ? $component['prompt'] : '';
		$required		= isset($component['required']) ? $component['required'] : FALSE;
		$multiple		= isset($component['multiple']) ? $component['multiple'] : FALSE;

		if ($required) {
			foreach ($values as $value) {
				if (!$this->isEmpty($value)) $non_null_value = TRUE;
			}
			if (!$non_null_value) {
				$error = $this->_error('required_field', $component, $prompt);
				array_push($errors, $error);
			}
		}
/*
//		if (count(array_diff(array_keys($values), array_keys($component['options']))) > 0) {
			$error = $this->_error('invalid_selection', $component, $prompt);
			array_push($errors, $error);
		}
*/
/*		if ((count($values > 1) && (!$multiple)) {
			$error = $this->_error('too_many_selections', $component, $prompt);
			array_push($errors, $error);
		}
*/
		return $errors;

	}

}



?>



