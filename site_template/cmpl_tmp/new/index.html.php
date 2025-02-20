<?
global $_CONFIG, $site_templater;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.main.html");
?>



<?
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.main.html");
?>
