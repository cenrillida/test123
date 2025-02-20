<?php

require_once ('components/component.php');

class base_skeleton extends component {

	function _validate () {
		$component	= $this->comp;

		// do validation stuff here, pushing errors onto 
		// the $errors array;

		return $errors;
	}
}

?>
