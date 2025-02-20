<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;



$ilines = new Ilines();


//$rows = $ilines->getLimitedElementsMultiSort($page_content["SMI_BLOCK_LINE"], $page_content["SMI_BLOCK_COUNT"], @$_REQUEST["p"],"DATE", "DESC", "status");
$rows = $ilines->getLimitedElementsMultiSort($page_content["SMI_BLOCK_LINE"], $page_content["SMI_BLOCK_COUNT"], 1,"DATE", "DESC", "status");
if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{


		$tpl = new Templater();

		$tpl->setValues($v["content"]);
/*		$tpl->appendValues($page_content);*/
		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => 121));
		if(!empty($v["content"]["FRONTPAGE_TEXT"])) {
		    $tpl->appendValues(array("GO" => true));
		}
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.smi_front.html");

	}
}

$news_count = $ilines->countElements($page_content["SMI_BLOCK_LINE"],"status");
$pagination = new Pagination();
//$pages = $pagination->createPages($news_count[$page_content["SMI_BLOCK_LINE"]], $page_content["SMI_BLOCK_COUNT"], 3, @$_REQUEST["p"]);
$pages = $pagination->createPages($news_count[$page_content["SMI_BLOCK_LINE"]], $page_content["SMI_BLOCK_COUNT"], 3, 1);
$pg = new Pages();
foreach($pages as $v)
{

	echo "<a href=\"".$pg->getPageUrl($page_id)."?p=".$v[0]."\">".$v[1]."</a>&nbsp;&nbsp;";
}

?>
