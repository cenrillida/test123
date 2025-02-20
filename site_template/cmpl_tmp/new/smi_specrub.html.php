<?
global $_CONFIG, $site_templater, $DB;
if(empty($_GET[specrub]))
	$_GET[specrub]=-1;

$specrubrics = $DB->select("SELECT l.el_id AS ARRAY_KEY, l.el_id AS id,l.icont_text AS rubric, ex.icont_text AS extra_section, exf.icont_text AS extra_section_flag, cc.icont_text AS comment_color 
                FROM adm_ilines_type AS c
               INNER JOIN adm_ilines_element AS e ON e.itype_id=c.itype_id AND e.itype_id=13 
               INNER JOIN adm_ilines_content AS l ON l.el_id=e.el_id AND l.icont_var= 'title'
               INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var= 'sort'
               INNER JOIN adm_ilines_content AS ex ON ex.el_id=e.el_id AND ex.icont_var= 'extra_section'
               INNER JOIN adm_ilines_content AS exf ON exf.el_id=e.el_id AND exf.icont_var= 'extra_section_flag'
               INNER JOIN adm_ilines_content AS st ON st.el_id=e.el_id AND st.icont_var= 'status'
               LEFT JOIN adm_ilines_content AS cc ON cc.el_id=e.el_id AND cc.icont_var= 'comment_color'
               WHERE st.icont_text='1'
                 ORDER BY s.icont_text");
$site_templater->appendValues(array("TITLE" => $specrubrics[$_GET[specrub]][rubric]));

//Statistic::theCounter("specrub-".(int)$_GET[specrub]);
$all_views = Statistic::getAllViews("specrub-".(int)$_GET[specrub]);
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

$specrubInt = (int)$_GET[specrub];

if(!empty($specrubInt)) {
    Statistic::ajaxCounter("specrub",$specrubInt);
    Statistic::getAjaxViews("specrub", $specrubInt);
}



echo "<div style='text-align: right; color: #979797;'><img width='15px' style='vertical-align: middle' src='/img/eye.png'/> <span id='stat-views-counter' style='vertical-align: middle'>".$all_views."</span></div>";

if (empty($_TPL_REPLACMENT["FULL_SMI_ID"])) $_TPL_REPLACMENT["FULL_SMI_ID"]=503;
//echo "<br />___".$_TPL_REPLACMENT["FULL_SMI_ID"].$_TPL_REPLACMENT["NEWS_LINE"];
$ilines = new Ilines();
//print_r($_TPL_REPLACMENT);
$_TPL_REPLACMENT["COUNT"]=9;
if(isset($_GET[printall]))
  $_TPL_REPLACMENT["COUNT"]=1000000;


$rows = $ilines->getLimitedElementsDateRubSpecRub(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],(int)$_GET[specrub]);
$news_count = count($ilines->getLimitedElementsDateRubNoLimitSpecRub(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",@$_TPL_REPLACMENT["RUBRIC"],(int)$_GET[specrub]));
//echo $news_count."@".$_TPL_REPLACMENT["COUNT"];
$pages = Pagination::createPages($news_count, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], 3);
$pg = new Pages();
//print_r($pages);
if(!empty($_TPL_REPLACMENT[TPL_NAME]))
   $tplname=$_TPL_REPLACMENT[TPL_NAME];
else
   $tplname='smi_specrub';
if (!empty($_TPL_REPLACMENT["ANONS"]) && $_TPL_REPLACMENT["ANONS"]!="<p>&nbsp;</p>")
echo $_TPL_REPLACMENT["ANONS"]."<span class='hr'>&nbsp;</span><br /><br />";

if($_GET[specrub]==-1){
	foreach ($specrubrics as $key => $value) {
		if($value[extra_section_flag]==1)
			if(!empty($value[extra_section]) && $value[extra_section]!="<p>&nbsp;</p>")
				echo $value[extra_section]."<br />";
	}
}
else
{
	if(!empty($specrubrics[$_GET[specrub]][extra_section]) && $specrubrics[$_GET[specrub]][extra_section]!="<p>&nbsp;</p>")
		echo $specrubrics[$_GET[specrub]][extra_section]."<br />";
}

//echo count($pages);
if(@count($pages) > 1)
{
    if (!isset($_GET[printmode]))
    {
        if (empty($_SERVER[REDIRECT_URL]))
            echo "<div class='mt-3' style='text-align:right;'><a class=\"btn btn-lg imemo-button text-uppercase imemo-print-button\" href=\"/index.php?".$_SERVER[QUERY_STRING]."&printmode&printall\" role=\"button\">Весь список</a></div>";
        else
            echo "<div class='mt-3' style='text-align:right;'><a class=\"btn btn-lg imemo-button text-uppercase imemo-print-button\" href=\"/".substr($_SERVER[REDIRECT_URL],1)."?".$_SERVER[QUERY_STRING]."&printmode&printall\" role=\"button\">Весь список</a></div>";
    }
	
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
    {
		echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("specrub" => (int)$_GET[specrub],"p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";
	}

}
echo "<br /><br />";
$i=1;
echo '<div class="row">';
if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);
	if(empty($_REQUEST["p"]))
		$currentPage=0;
	else
		$currentPage=(int)$_REQUEST["p"]-1;
	$elementCounter = $_TPL_REPLACMENT["COUNT"]*$currentPage+1;
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
		$tpl->appendValues(array("PDF_FILE" => $v[content][PDF_FILE]));
        $tpl->appendValues(array("RET" => $_REQUEST[page_id]));
        $tpl->appendValues(array("COMMENT_COLOR" => $specrubrics[$_GET[specrub]][comment_color]));
        $tpl->appendValues(array("SPECRUB" => $_REQUEST[specrub]));
		$tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT[FULL_SMI_ID]));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array('COUNTER_EL' => $elementCounter));
		if(!empty($v["content"]["FULL_TEXT"]) && $v["content"]["FULL_TEXT"]!="<p>&nbsp;</p>")
			$tpl->appendValues(array("GO" => true));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.".$tplname.".html");
		$i++;
		$elementCounter++;
	}
}

echo '</div>';
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
    {
		echo "<a href=\"".$pg->getPageUrl($_REQUEST["page_id"], array("specrub" => (int)$_GET[specrub],"p" => $v[0]))."\">".$v[1]."</a>&nbsp;&nbsp;";
	}

}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>