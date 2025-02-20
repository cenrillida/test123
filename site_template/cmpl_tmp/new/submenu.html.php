<?
global $_CONFIG, $site_templater;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

	if($_SESSION[lang]!="/en") {
		echo $_TPL_REPLACMENT['CONTENT_BEFORE'];
	} else {
		echo $_TPL_REPLACMENT['CONTENT_BEFORE_EN'];
	}

    include($_TPL_REPLACMENT["SUBMENU"]);


	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

?>
