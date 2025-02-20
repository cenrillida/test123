<?
global $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");
?>


    <?=@$_TPL_REPLACMENT["CONTENT"]?>


<?
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");
?>
