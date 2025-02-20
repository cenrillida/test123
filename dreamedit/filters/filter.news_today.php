<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

// Новости на сегодня


$ilines = new Events();

$ilines_spisok= $page_content["ILINE_SPISOK"]; //"2,17,14,3,16";]
if (empty($page_content["ILINE_SPISOK"])) $ilines_spisok="1";
//print_r($page_content);

$il0=explode(",",trim($ilines_spisok));
        $str="(";
        foreach($il0 as $il)
        {
           $str.=" ie.itype_id=".$il." OR ";
        }
        $str=substr($str,0,-4).")";

$rows = $ilines->getLimitedElementsDate(@$str, 1, @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",date('Ymd'),date('Ymd'));

$count_today=count($rows);


$bind = new Binding();

if(!empty($rows))
{

    echo "
	<font color=#0486b0><strong>Сегодня в институте:</strong></font><br />";
	echo "<br />";
	echo "<table >";
	echo "<tr><td>";
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{


		$tpl = new Templater();

		$tpl->setValues($v["content"]);
/*		$tpl->appendValues($page_content);*/
		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("GO" => false));
		if (isset($v["content"][RANG]))  //Объявления о защите
		{
		$bar1 = $bind->getTextByValue("directories","value","text","Соискатели","no",$v["content"]["RANG"]);
  		$bar2 = $bind->getTextByValue("directories","value","text","Диссертационные советы","no",$v["content"]["SOVET"]);
    	$bar3 = $bind->getTextByValue("directories","value","text","Специальности","no",$v["content"]["SPEC"]);

		   $tpl->appendValues(array("PREV_TEXT" => "<strong>Защита диссертации</strong> в ".$v["content"]["TIME"].
		   "<br /> на соискание ученой степени ".$bar1[0][text].
		   ".<br /><em> ".$v['content']["FIO"]."</em>".".<br />".$v['content']["PREV_TEXT"].
		         "(совет: ".$bar2[0][text].", специальность: ".$bar3[0][text]. ")"

		         ));
		}
		if (isset($v["content"][TODAY_TEXT]) && !empty($v["content"][TODAY_TEXT]))
		    $tpl->appendValues(array("PREV_TEXT" => $v["content"][TODAY_TEXT]));
		$tpl->appendValues(array("FULL_ID" => 120));
		if(!empty($v["content"]["FULL_TEXT"]))


	    $tpl->appendValues(array("GO" => true));

//	    echo $tpl[PREV_TEXT];
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news.html");

	}
	echo "</td></tr></table>";
	echo "<br /><br />";
}


/*
$news_count = $ilines->countElements($page_content["NEWS_BLOCK_LINE"],"status");
$pagination = new Pagination();
//$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, @$_REQUEST["p"]);
$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, 1);


$pg = new Pages();
foreach($pages as $v)
{
	echo "<a href=\"".$pg->getPageUrl($page_id)."?p=".$v[0]."\">".$v[1]."</a>&nbsp;&nbsp;";
}
*/

// Если за сегодня новостей мало, читаем анонс

if (empty($page_content["NEWS_BLOCK_COUNT"])) $page_content["NEWS_BLOCK_COUNT"]=3;

if ($count_today < $page_content["NEWS_BLOCK_COUNT"])
{
$ilines = new Ilines();
$rows = $ilines->getLimitedElementsMultiSort($page_content["NEWS_BLOCK_LINE"], $page_content["NEWS_BLOCK_COUNT"], 1,"DATE2", "DESC", "status");


//print_r($rows);
$ind=true;
if(1==2)
{
	$rows = $ilines->appendContent($rows);
	foreach($rows as $k => $v)
	{

        if (substr($v["content"]["DATE2"],0,10) != date('Y.m.d'))
        {
		if ($ind)
		{
		    if ($count_today>0) echo " <font color=#0486b0><strong>Объявления: </strong></font><br />";
		    $ind=false;
		}
		$tpl = new Templater();

		$tpl->setValues($v["content"]);
/*		$tpl->appendValues($page_content);*/
		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => $page_content["NEWS_BLOCK_PAGE"]));
		if (substr($v["content"]["DATE2"],0,10) < date('Y.m.d'))
		   $tpl->appendValues(array("PREV_TEXT" => $v[content]["LAST_TEXT"]));
		if(!empty($v["content"]["FULL_TEXT"]))
		    $tpl->appendValues(array("GO" => true));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.news.html");
        }
	}
}
}


echo "<a href=/index.php?page_id=498>другие новости</a>";
?>
