<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

// Новости на главной (английские)
//print_r($page_content);

$ilines = new Ilines();
$ievent = new Events();
$rows = $ilines->getLimitedElementsMultiSort($page_content["NEWS_EN_LINE"], $page_content["NEWS_EN_COUNT"], 1,"DATE", "DESC", "status");
$name0=$ilines->getTypeById($page_content["NEWS_EN_LINE"]);
echo "<h3>".$name0[itype_name]."</h3>";

if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{
//echo "<br />".print_r($rows);
        if(isset($v["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
		$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE"] = date("d.m.Yг.", $v["content"]["DATE"]);
	}

		$tpl = new Templater();

		$tpl->setValues($v["content"]);
/*		$tpl->appendValues($page_content);*/


		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("date" => $v["content"]["DATE"]));
		if ($v["content"]["DATE2"]<date("Y.m.d") && !empty($v["content"]["LAST_TEXT"]))
			$tpl->appendValues(array("PREV_TEXT" => $v["content"]["LAST_TEXT"]));
  		if (substr($v["content"]["DATE2"],0,10)==date("Y.m.d"))
			$tpl->appendValues(array("PREV_TEXT" => $v["content"]["TODAY_TEXT"]));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => 11));
		if(!empty($v["content"]["FULL_TEXT"]))
		    $tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news_anons.html");

	}
}

echo "<a href=/index.php?page_id=498>More news</a>";
?>
