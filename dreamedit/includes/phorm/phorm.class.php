<?php

/////////////////////////////////////////////////////////////////////////////// 
// Phorm Class                         Release 0.9.2                         //
// Copyright 2001 Sean Cazzell         cazzell@eng.usf.edu                   //
//                                                                           //
// $Id: phorm.class.php,v 1.25 2001/08/19 00:24:31 sean Exp $                //
///////////////////////////////////////////////////////////////////////////////
/*
	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.

	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public
	License along with this library; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
///////////////////////////////////////////////////////////////////////////////
/*	Release 1.0.0 TODO
	- Use $var style for displaying vars in templates.
	- Work on documentation
	- Put translation code into it's own class
	- Create more advanced components: date
	- Database integration?
	- Implement hidden field security using md5
	- Method for handling tabindex.

	// Recently DONE
	- Allow components to be added/removed at run-time
	- Allow passing default values to form through get variables
	- Allow default values to be set by passing array to constructor
	- Code for handling hidden input fields
	- Put template code into it's own class
	- Some work done on the docs
	- Added validation routines to base validation class (email, ip)

*/
///////////////////////////////////////////////////////////////////////////////


class phorm {

	var $phorm;

	function phorm ($values = NULL) {
		$this->phorm['errors'] = array();
		$this->phorm['validate_ok'] = FALSE;
		$this->_set_include_path();
		$this->_init_translation_table();
		$this->_init_components($values);
		$this->_init_phorm_action();
	}


	function add_comp ($name, $comp) {
		if (!isset($this->phorm['components'][$name])) {
			$this->phorm['components'][$name] = $comp;
			$this->_init_component($name);
			return TRUE;
		} else {
			return FALSE;
		}
	}


	function add_comps ($components = array()) {
		foreach($components as $name => $comp)
			$this->add_comp($name, $comp);
	}


	function remove_all () {
		foreach($this->data() as $k => $v)
			$this->remove_comp ($k);
	}


	function remove_comp ($name) {
		if (isset($this->phorm['components'][$name])) {
			unset($this->phorm['components'][$name]);
			return TRUE;
		} else {
			return FALSE;
		}
	}


	function edit_comp ($comp_name, $key, $value) {
		if (isset($this->phorm['components'][$comp_name])) {
			$this->phorm['components'][$comp_name][$key] = $value;
			return TRUE;
		} else {
			return FALSE;
		}
	}


	function conf ($name, $value = NULL) {
		if (isset($value)) {
			$this->phorm[$name] = $value;
		} else {
			return $this->phorm[$name];
		}
	}


	// Returns the value of the specified component,
	// or all of the components if no name is specified.
	function value ($name = NULL) {
		if (empty($name)) {
			foreach (array_keys($this->phorm['components']) as $name) {
				$values[$name] = $this->phorm['components'][$name]['object']->value();
			}
			return $values;
		} else {
			return $this->phorm['components'][$name]['object']->value();
		}
	}


	// Like value(), data() returns either the data from a specified
	// component, or all components.
	function data ($name = NULL) {
		if (empty($name)) {
			return $this->phorm['components'];
		} else {
			return $this->phorm['components'][$name];
		}
	}


	// Returns either an array of templates, or the template for a specific
	// component.
	function template ($name = NULL) {
		if (empty($name)) {
			foreach (array_keys($this->phorm['components']) as $name) {
				$templates[$name] = $this->phorm['components'][$name]['object']->template();
			}
			return $templates;
		} else {
			return $this->phorm['components'][$name]['object']->template();
		}
	}


	// Calls the to_string on one component if specified, or on all components
	// if no component is specified.
	function to_string ($name = NULL) {
		if (empty($name)) {
			foreach (array_keys($this->phorm['components']) as $name) {
				$str_values[$name] = $this->phorm['components'][$name]['object']->to_string();
			}
			return $str_values;
		} else {
			return $this->phorm['components'][$name]['object']->to_string();
		}
	}


	// Checks the input; returns true if there aren't any errors
	function validate () {
		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		if ($request_method == 'post') {
			if ($this->_validate_components() <= 0) {
				// Data passed all tests
				$this->phorm['validate_ok'] = TRUE;
			}
		}
		return $this->phorm['validate_ok'];
	}


	// Display templates based on the validation status and errors
	function display () {
		include_once('lib/phplate/phplate.class.php');
		$template = new phplate($this->phorm['template_dir']);

		if ($this->phorm['validate_ok']) {
			$template->display('success', $this->phorm);
		} else {		

			if (count($this->phorm['errors']) > 0) {
				$template->display('errors', $this->phorm);
			}

			$template->display('header', $this->phorm);

			foreach (array_keys($this->phorm['components']) as $name) {
				$template->display($this->template($name), $this->data($name));

			}

			$template->display('footer', $this->phorm);
		}
	}


	// [Private Methods] //


	// Load the translation table into the phorm stash
	function _init_translation_table () {
		$translation_file = $this->phorm['language'];
		include dirname(__FILE__)."/translation/$translation_file.php";
		$this->phorm['translation_table'] = $translation_table;
	}


	// This factory method creates an object for each of the components.
	function _init_components ($values) {
		foreach (array_keys($this->phorm['components']) as $name) {
			if (isset($values[$name])) {
				$this->_init_component($name, $values[$name]);
			} else {
				$this->_init_component($name);
			}
		}
	}


	function _init_component ($name, $value = NULL) {
			$this->phorm['components'][$name]['name'] = $name;
			$component_class = $this->phorm['components'][$name]['class'];
			$component_file  = str_replace("::", "/", $component_class);
			$component_class = str_replace("::", "_", $component_class);

			include_once("components/$component_file.php");
			$component = new $component_class;

			if (isset($value)) {
				$component->init($name, $this->phorm, $value);
			} else {
				$component->init($name, $this->phorm);
			}

			$this->phorm['components'][$name]['object'] = $component;
	}


	function _set_include_path () {
		if (isset($this->phorm['include_path'])) {
			$path = ini_get('include_path') . ':' . $this->phorm['include_path'];
			ini_set('include_path', "$path");
		}
	}


	function _init_phorm_action () {
		if (empty($this->phorm['action'])) {
			$this->phorm['action'] = $_SERVER['PHP_SELF'];
		}
	}


	// Here we call validate() on all of the component objects
	function _validate_components () {
		foreach (array_keys($this->phorm['components']) as $name) {
			$errors = $this->phorm['components'][$name]['object']->validate();
			if (count($errors) > 0) {
				// add errors from validate() to the error stash
				$this->phorm['errors'] = array_merge($this->phorm['errors'], $errors);
			}
		}

		return count($this->phorm['errors']);
	}

}


?>