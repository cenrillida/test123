<?
global $_CONFIG, $site_templater;


	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

 //   echo @$_TPL_REPLACMENT["TODAY"];
	echo @$_TPL_REPLACMENT["CONTENT"];


$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>

