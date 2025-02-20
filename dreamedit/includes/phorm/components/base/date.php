<?php

require_once dirname(__FILE__)."/../component.php";

class base_date extends component {

	function _validate () {
		$component	= $this->comp;

		$errors		= array();
		$value		= isset($component['value']) ? $component['value'] : '';
		$prompt		= isset($component['prompt']) ? $component['prompt'] : '';
		$required	= isset($component['required']) ? $component['required'] : FALSE;
//		$type		= (isset($component['type']) && in_array($component['type'], $this->types))? $this->types[array_search($component['type'], $types)]: $this->types[0];

		if ($this->isEmpty($value)) {
			if ($required) {
				$error = $this->_error('required_field', $component, $prompt);
				array_push($errors, $error);
			}
			return $errors;
		}
/*
		if ($error_type = $this->_validate_value($value, "base::".$type)) {
			$error = $this->_error($error_type, $component, $prompt);
			array_push($errors, $error);
		}
*/

		return $errors;
	}

}



?>
