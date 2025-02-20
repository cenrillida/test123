<?php

include_once dirname(__FILE__).'/validate.php';

class valid_base extends validate {


	function alpha ($string) {
		if (!$string) { return FALSE; }
		if (!preg_match("/^[a-zA-Z]+$/", $string)) {
			return 'alpha_only';
		} else {
			return FALSE;
		}
	}


	function numeric ($string) {
		if (!$string) { return FALSE; }
		if (!preg_match("/^[0-9]+$/", $string)) {
			return 'numeric_only';
		} else {
			return FALSE;
		}
	}


	function alphanum ($string) {
		if (!$string) { return FALSE; }
		if (!preg_match("/^[a-zA-Z0-9]+$/", $string)) {
			return 'alphanum_only';
		} else {
			return FALSE;
		}
	}

	// Written by Michael A. Alderete <michael@aldosoft.com>
	function email ($address) {
	    if (preg_match('/^[-!#$%&\'*+\.\/0-9=?A-Z^_`{|}~]+@[-0-9A-Z]+\.+[0-9A-Z]{2,4}$/i', trim($address))) {
			// no problemo
			return FALSE; 			
		} else {
			return 'invalid_email';
		}
	}


	function ip_address ($address) {
		if (preg_match('/^[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}$/i', trim($address))) {
			return FALSE;
		} else {
			return 'invalid_ip';
		}
	}


}

?>
