<?php

require_once dirname(__FILE__)."/../component.php";

class base_selectIdirectory extends component {

	var $value_is_array = TRUE;

	function value () {
			return array_shift($this->comp['value']);
	}

	// Might need to add a custom to_string here

	function _validate () {
		$component	= $this->comp;

		$errors			= array();
		$non_null_value		= FALSE;
		$values			= isset($component['value']) ? $component['value'] : array();
		$dirname		= isset($component['dirname']) ? $component['dirname'] : '';
		$ilinestype		= isset($component['ilinestype']) ? $component['ilinestype'] : '';
		$keyname		= isset($component['keyname']) ? $component['keyname'] : '';
		$textname		= isset($component['textname']) ? $component['textname'] : '';
		$use_id			= isset($component['useid']) ? $component['useid'] : '';
		$prompt			= isset($component['prompt']) ? $component['prompt'] : '';
		$required		= isset($component['required']) ? $component['required'] : FALSE;

		if ($required) {
			if(is_array($values)){
				foreach ($values as $value) {
					if (!$this->isEmpty($value)) $non_null_value = TRUE;
				}
			}
			else{
				if (!$this->isEmpty($values)) $non_null_value = TRUE;
			}
			

			if (!$non_null_value) {
				$error = $this->_error('required_field', $component, $prompt);
				array_push($errors, $error);
			}
		}

		return $errors;
	}

}



?>
