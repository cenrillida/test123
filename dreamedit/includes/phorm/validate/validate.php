<?php

class validate {

	function DateTime ($string) {
		if (!$string) { return FALSE; }
		if (!preg_match("/^[0-3][0-9]\.[0-1][0-9]\.[0-9]{4} [0-2][0-9]:[0-5][0-9]$/", $string)) {
			return 'dateTimeOnly';
		} else {
			return FALSE;
		}
	}

	function FullDateTime ($string) {
		if (!$string) { return FALSE; }
		if (!preg_match("/^[0-3][0-9]\.[0-1][0-9]\.[0-9]{4} [0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/", $string)) {
			return 'fullDateTimeOnly';
		} else {
			return FALSE;
		}
	}

	function FullDate ($string) {
		if (!$string) { return FALSE; }
		if (!preg_match("/^[0-3][0-9]\.[0-1][0-9]\.[0-9]{4}$/", $string)) {
			return 'fullDateOnly';
		} else {
			return FALSE;
		}
	}

	function BasicDate ($string) {
		if (!$string) { return FALSE; }
		if (!preg_match("/^[0-3][0-9]\.[0-1][0-9]\.[0-9]{2}$/", $string)) {
			return 'dateOnly';
		} else {
			return FALSE;
		}
	}


}

?>
