<?php

require_once dirname(__FILE__)."/../component.php";

class base_peopleAffiliation extends component {

	function _validate () {
		$component	= $this->comp;

		$errors		= array();
		$value		= isset($component['value']) ? $component['value'] : '';
		$people_affiliation_en	= isset($component['people_affiliation_en']) ? $component['people_affiliation_en'] : '';
		$organization_name	= isset($component['organization_name']) ? $component['organization_name'] : '';
		$organization_name_en	= isset($component['organization_name_en']) ? $component['organization_name_en'] : '';
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
