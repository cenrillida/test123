<?php

require_once dirname(__FILE__)."/../component.php";

class base_tgram_button extends component {

	function _validate () {
		$component	= $this->comp;

		$buttonText		= isset($component['buttonText']) ? $component['buttonText'] : '';
		$textField		= isset($component['text_field']) ? $component['text_field'] : '';
		$photoField		= isset($component['photo_field']) ? $component['photo_field'] : '';
		$tgramType		= isset($component['tgram_type']) ? $component['tgram_type'] : '';


		return array();
	}

}

?>
