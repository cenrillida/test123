<?
global $_CONFIG;

if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=503;
$ilines = new Ilines();

if($_SESSION[lang]!="/en")
$rows = $ilines->getLimitedElementsDateRub(5, 3, @$_REQUEST["p"], "date", "DESC", "status",439,"", true);
else
$rows = $ilines->getLimitedElementsDateRubEn(5, 3, @$_REQUEST["p"], "date", "DESC", "status",439, "", true);
//$news_count = $ilines->countElements($_TPL_REPLACMENT["NEWS_LINE"], "status"); // Неправильно тк сразу для двух рубрик кол-во
/*$news_count = count($ilines->getLimitedElementsDateRubNoLimit(5, 3, @$_REQUEST["p"], "date", "DESC", "status",439));

$pages = Pagination::createPages($news_count, 3, @$_REQUEST["p"], 3);
$pg = new Pages();*/

$tplname='smi';

/*
if(@count($pages) > 1)
{
	
	echo "<b>—траницы:</b>&nbsp;&nbsp; ";
}
	foreach($pages as $v)
{
    if ( ($v[0] == $_REQUEST['p']) || ( (empty($_REQUEST["p"]) && ($v[0]==1) ) ))
	echo "<b>".$v[0]."</b>&nbsp;&nbsp;";
    else
    {
    	if(empty($_GET[specrub]))
			echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";
		else
			echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("specrub" => (int)$_GET[specrub],"p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";
	}

}
echo "<br /><br />";*/
$i=1;
if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{
	//	print_r($v);
		$tpl = new Templater();
		if(isset($v["content"]["DATE"]))
		{
			preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
			$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$v["content"]["DATE"] = date("d.m.Y г.", $v["content"]["DATE"]);
		}

		$tpl->setValues($v["content"]);
//		$tpl->appendValues($_TPL_REPLACMENT);
		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("NUMBER" => $i));
		$tpl->appendValues(array("TITLE_NEWS" => $v[content][TITLE]));
        $tpl->appendValues(array("RET" => $_REQUEST[page_id]));
		$tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT[FULL_SMI_ID]));
		$tpl->appendValues(array("GO" => false));
		if(!empty($v["content"]["FULL_TEXT"]))
			$tpl->appendValues(array("GO" => true));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.".$tplname.".html");
		$i++;
	}
}
echo "<br />";
if($_SESSION[lang]!="/en")
	echo '<a href="/index.php?page_id=632&rub=439">ƒругие новости</a>';
else
	echo '<a href="/en/index.php?page_id=632&rub=439">All news</a>';
/*if(@count($pages) > 1)
	echo "<b>—траницы:</b>&nbsp;&nbsp; ";

foreach($pages as $v)
{
    if ( ($v[0] == $_REQUEST['p']) || ( (empty($_REQUEST["p"]) && ($v[0]==1) ) ))
	echo "<b>".$v[0]."</b>&nbsp;&nbsp;";
    else
	echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";

}*/
?>
