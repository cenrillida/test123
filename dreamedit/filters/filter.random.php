<?
global $_CONFIG, $site_templater, $_TPL_REPLACMENT;



$ilines = new Ilines();

$rows = $ilines->getLimitedElements(3, 100, "", "SORT", $_TPL_REPLACMENT["SORT_TYPE"], "status");




if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);

	$k = array_rand($rows);


	$v = $rows[$k];

	$tpl = new Templater();

	$tpl->setValues($v["content"]);
	$tpl->appendValues(array("ID" => $k));

	$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.random.html");


}

?>
