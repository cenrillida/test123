<?
global $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
if (!isset($_GET[printmode]))
{
   if (empty($_SERVER[REDIRECT_URL]))
       echo "<div style='text-align:right;'><a href=/index.php?".$_SERVER[QUERY_STRING]."&printmode&printall >
       <img src=/files/Image/printers.jpg title='печать списка' border='0' align='AbsMiddle' />
       печать списка</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>";
   else
      echo "<div style='text-align:right;'><a  href=/".substr($_SERVER[REDIRECT_URL],1)."?".$_SERVER[QUERY_STRING]."&printmode&printall >
      <img src=/files/Image/printers.jpg title='печать списка' border='0'  align='AbsMiddle' />
      печать списка</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>";
}
if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=503;
//echo "<br />___".$_TPL_REPLACMENT["FULL_SMI_ID"].$_TPL_REPLACMENT["NEWS_LINE"];
$ilines = new Ilines();
//print_r($_TPL_REPLACMENT);
if(isset($_GET[printall]))
  $_TPL_REPLACMENT["COUNT"]=1000000;

$rows = $ilines->getLimitedElementsDateRub(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"]);

//$news_count = $ilines->countElements($_TPL_REPLACMENT["NEWS_LINE"], "status"); // Ќеправильно тк сразу длЯ двух рубрик кол-во
$news_count = count($ilines->getLimitedElementsDateRubNoLimit(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"]));

//echo $news_count."@".$_TPL_REPLACMENT["COUNT"];
$pages = Pagination::createPages($news_count, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], 3);
$pg = new Pages();
//print_r($pages);
if(!empty($_TPL_REPLACMENT[TPL_NAME]))
   $tplname=$_TPL_REPLACMENT[TPL_NAME];
else
   $tplname='smi';
if (!empty($_TPL_REPLACMENT["ANONS"]))
echo $_TPL_REPLACMENT["ANONS"]."<span class='hr'>&nbsp;</span><br /><br />";
//echo count($pages);
if(@count($pages) > 1)
{
	
	echo "<b>Страницы:</b>&nbsp;&nbsp; ";
}
	foreach($pages as $v)
/*

	echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";
*/
{
    if ( ($v[0] == $_REQUEST['p']) || ( (empty($_REQUEST["p"]) && ($v[0]==1) ) ))
	echo "<b>".$v[0]."</b>&nbsp;&nbsp;";
    else
	echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";

}
echo "<br /><br />";
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
if(@count($pages) > 1)
	echo "<b>Страницы:</b>&nbsp;&nbsp; ";

foreach($pages as $v)
/*
	echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";
*/
{
    if ( ($v[0] == $_REQUEST['p']) || ( (empty($_REQUEST["p"]) && ($v[0]==1) ) ))
	echo "<b>".$v[0]."</b>&nbsp;&nbsp;";
    else
	echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";

}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>