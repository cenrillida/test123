<?
global $_CONFIG, $site_templater, $_TPL_REPLACMENT;



$ilines = new Ilines();

$rows = $ilines->getLimitedElements(14, 100, "", "SORT", $_TPL_REPLACMENT["SORT_TYPE"], "status");


if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{  
		$tpl = new Templater();

		$tpl->setValues($v["content"]);
		$tpl->appendValues(array("ID" => $k));

		$tpl->appendValues(array("GO" => false));
		if(!empty($v["content"]["PREV_TEXT"]))
			$tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.counters.html");
	}
}
echo "<br />";

?>
