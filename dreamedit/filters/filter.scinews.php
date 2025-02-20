<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;


/*print_r($page_content);*/

$ilines = new Ilines();


//$rows = $ilines->getLimitedElementsMultiSort($page_content["NEWS_BLOCK_LINE"], $page_content["NEWS_BLOCK_COUNT"], @$_REQUEST["p"],"DATE", "DESC", "status");
$rows = $ilines->getLimitedElementsMultiSortDate($page_content["NEWS_BLOCK_LINE3"], $page_content["NEWS_BLOCK_COUNT3"], 1,"DATE", "ASC", "status");


//print_r($rows);

if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{
        if(isset($rows[@$_REQUEST["id"]]["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[@$_REQUEST["id"]]["content"]["DATE"], $matches);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = date("d.m.Yг.", $rows[@$_REQUEST["id"]]["content"]["DATE"]);
	}

		$tpl = new Templater();

		$tpl->setValues($v["content"]);
/*		$tpl->appendValues($page_content);*/


		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => 11));
		if(!empty($v["content"]["FULL_TEXT"]))
		    $tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news_sci.html");

	}
}

$news_count = $ilines->countElements($page_content["NEWS_BLOCK_LINE"],"status");
$pagination = new Pagination();
//$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, @$_REQUEST["p"]);
$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, 1);


$pg = new Pages();
foreach($pages as $v)
{
	echo "<a href=\"".$pg->getPageUrl($page_id)."?p=".$v[0]."\">".$v[1]."</a>&nbsp;&nbsp;";
}
echo "<a href=/news_sci.html>другие новости науки</a>";
?>
