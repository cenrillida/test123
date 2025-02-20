<?php

// $Id: component.php,v 1.9 2001/08/17 12:37:21 sean Exp $

class component {

	var $comp;

	function init ($name, &$phorm, $value = NULL) {
		$this->phorm = &$phorm;
		$this->comp = &$phorm['components'][$name];
		$this->_init_error();
		$this->_init_value($value);
		$this->_init();
	}


	function value () {
		return $this->comp['value'];
	}


	// This method attempts to output the value of the component
	// as a human-readable string.  Overload it if your component
	// needs to do something special.
	function to_string () {
		if (is_array($this->comp['value'])) {
			return implode(', ', $this->comp['value']);
		} else {
			return $this->comp['value'];
		}
	}


	function data () {
		return $this->comp;
	}


	function template () {
		$template = isset($this->comp['template']) ? $this->comp['template'] : $this->comp['class'];
		$template = "components::$template";
		return $template;
	}


	function validate () {

		// Call the real validation method, supplied by the component.
		$errors = $this->_validate();

		if (count($errors) > 0) {
			// Store the errors in the component's stash
			$this->comp['validate_errors'] = $errors;
		} else {
			$this->comp['validate_errors'] = array();
		}

		return $errors;
	}


	function _error ($key, $component, $prompt) {
		$error_msg = $this->_get_text($key);

		extract($component, EXTR_SKIP);

		/******************
		здесь надо заменить эвал на какую-нить другую херь...
		*************************/
		@eval("\$error_msg = \"$error_msg\";");
//		echo '$error_msg = "'.$error_msg.';';

		return array('msg' => $error_msg, 'prompt' => $prompt);
	}


	// Lookup a string from the translation table
	function _get_text ($key) {
		if (isset($this->phorm['translation_table'][$key])) {
			return Dreamedit::translate($this->phorm['translation_table'][$key]);
		} else {
			return FALSE;
		}
	}


	function _validate_value ($string = '', $validate_method = "") {
		if(empty($validate_method))
			$validate_method = $this->comp['validate_method'];
		list($class, $method) = explode('::', $validate_method);

		$class_file = dirname(__FILE__)."/../validate/$class.php";
		$class = "valid_$class";

		include_once $class_file;
		$validate_obj = new $class;
		return $validate_obj->$method($string);
	}


	// This tries to get the component's value from the post vars.
	// Overload this if you need to do something special to get the
	// value of your component (ie - for file uploads).
	function _init_value ($value) {
		if (isset($value))
			$this->comp['value'] = $value;
		elseif (!isset($this->comp['value'])) {
//		else {
			// No default value, and no value posted - init value to an empty
			// string or empty array.
			$value_is_array = isset($this->value_is_array) ? $this->value_is_array : FALSE;
			$this->comp['value'] = $value_is_array ? array() : '';
		}

	}


	function _init_error () {
		$this->comp['validate_errors'] = array();
	}


	// Overload this method if you need to do anything when the
	// component is created.
	function _init () {
		return;
	}

	function isEmpty($value)
	{
		if(trim($value) == "")
			return true;
		return false;
	}
}


?>
