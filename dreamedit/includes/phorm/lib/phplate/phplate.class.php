<?php

/////////////////////////////////////////////////////////////////////////////// 
// PHPlate Class                       Version 1.0                           //
// Copyright 2001 Sean Cazzell         cazzell@eng.usf.edu                   //
//                                                                           //
// $Id: phplate.class.php,v 1.3 2001/07/27 13:44:42 sean Exp $                 //
///////////////////////////////////////////////////////////////////////////////
/*	General TODO


*/
///////////////////////////////////////////////////////////////////////////////

class phplate {

	var $template_dir;

	function __construct($template_dir) {
		$this->template_dir = $template_dir;

	}


	function display ($template, $vars) {
		$template = str_replace("::", "/", $template);

		extract($vars, EXTR_SKIP);

		if(isset($buttons))
		{
			$btn = array();
			foreach(explode(",", $buttons) as $v)
				$btn[] = $this->createButton(trim($v), $vars);

			$buttons = implode("", $btn);
		}

		return include dirname(__FILE__)."/../../templates/".$this->template_dir."/".$template.".php";
	}


	function capture ($template, $vars)
	{
		ob_start;
		$this->display($template, $vars);
		$ret_val = ob_get_contents;
		ob_end_clean;
		return $ret_val;
	}


	function displayButton($btnName, $vars)
	{
		extract($vars, EXTR_SKIP);
		include dirname(__FILE__)."/../../templates/buttons/".$btnName.".php";
	}


	function createButton($btnName, $vars)
	{
		ob_start();
		$this->displayButton($btnName, $vars);
		$retVal = ob_get_contents();
		ob_end_clean();
		return $retVal;
	}


}
