<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST["printmode"])) $_REQUEST["printmode"]=$DB->cleanuserinput($_REQUEST["printmode"]);
$_REQUEST["td1"]=$DB->cleanuserinput($_REQUEST["td1"]);
$_REQUEST["td2"]=$DB->cleanuserinput($_REQUEST["td2"]);
if(!empty($_REQUEST['td1']) && !Dreamedit::validateDate($_REQUEST['td1'])) {
    $_REQUEST['td1'] = "";
}
if(!empty($_REQUEST['td2']) && !Dreamedit::validateDate($_REQUEST['td2'])) {
    $_REQUEST['td2'] = "";
}
$_REQUEST["rub"]=(int)$DB->cleanuserinput($_REQUEST["rub"]);
$_REQUEST["otdel"] = (int)$_REQUEST["otdel"];

if ($_SESSION["lang"]=='/en') 
{
	$suff2="&en";
	$txt1='prev';$txt2='next';$txt3='pages';
	$txt0='News for the period';
	$txtr=' News rubricator';$txtall='All';
}	
else 
{
	$suff2="";
	$txt1='предыдущая';$txt2='следующая';$txt3='страницы';
	$txt0='Сводка новостей за период';
	$txtr='Рубрикатор новостей';$txtall='Все новости';
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


if (empty($_TPL_REPLACMENT["TPL_NAME"])) $_TPL_REPLACMENT["TPL_NAME"]="news_calendar";

$ilines_spisok= $_TPL_REPLACMENT["ILINE_SPISOK"]; //"2,17,14,3,16";]
$il0=explode(",",trim($ilines_spisok));
        $str="(";
        foreach($il0 as $il)
        {
           $str.=" ie.itype_id=".$il." OR ";
        }
        $str=substr($str,0,-4).")";

		
		
// Печать анонса и калдендаря


$ilines = new Events();




if (!empty($_REQUEST["td1"]))
{
    $dateBeg=$_REQUEST["td1"];
}
	else
    $dateBeg="1990.01.01";
if (!empty($_REQUEST["td2"]))
    $dateEnd=$_REQUEST["td2"];
else
    $dateEnd=date("Y").".12.31";

// Рубрикатор новостей
echo "<table width=100%><tr>";
if (!empty($_REQUEST["rub"])) $_TPL_REPLACMENT["RUBRIC"]=$_REQUEST["rub"];

$rubrics=$DB->select("SELECT c.el_id,c.icont_text AS rubric,cc.icont_text AS rubric_en,l.icont_text AS line,p.icont_text AS page 
                      FROM adm_directories_content AS c
					  INNER JOIN adm_directories_content AS l ON l.el_id=c.el_id AND l.icont_var='news_line'
					  INNER JOIN adm_directories_content AS r ON r.el_id=c.el_id AND r.icont_var='sort'
					  INNER JOIN adm_directories_content AS p ON p.el_id=c.el_id AND p.icont_var='page'
					  LEFT OUTER JOIN adm_directories_content AS cc ON cc.el_id=c.el_id AND cc.icont_var='text_en'
					  LEFT OUTER JOIN adm_directories_content AS nsr ON nsr.el_id=c.el_id AND nsr.icont_var='news_not_show'
					  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=3
					  WHERE c.icont_var='text' AND (nsr.icont_text IS NULL OR nsr.icont_text=0)
					  ORDER BY r.icont_text,c.icont_text");
echo "<td valign='top'>";
//echo "<br /><b>".$txtr.":</b><br />";
//echo "<a href=".$_SESSION["lang"]."/index.php?page_id=".$_REQUEST[page_id]."&td1=".$_REQUEST["td1"]."&td2=".$_REQUEST["td2"]."&rub=".">".$txtall."</a><br />";
//if ($_SESSION["lang"]!='/en')
//{
//foreach($rubrics as $r)
//{
//   echo "<a href=".$_SESSION["lang"]."/index.php?page_id=".$r[page]."&rub=".$r["el_id"]."&td1=".$_REQUEST["td1"]."&td2=".$_REQUEST["td2"].">".$r[rubric]."</a><br />";
//}
//}
//else
//{
//foreach($rubrics as $r)
//{
//   if (!empty($r[rubric_en]))
//   echo "<a href=".$_SESSION["lang"]."/index.php?page_id=".$r[page]."&rub=".$r["el_id"]."&td1=".$_REQUEST["td1"]."&td2=".$_REQUEST["td2"].$suff2.">".$r[rubric_en]."</a><br />";
//}
//
//}
echo "</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
if(!isset($_GET["printmode"]) && $_TPL_REPLACMENT["CLN"]==1) {
    echo "<td align=right>";
    include($_TPL_REPLACMENT["CALENDAR"]);
	echo "<br /></td>";
}
echo "</tr></table>";
echo "<div class='sep'> </div>";	
if (!empty($_REQUEST["td1"]))
{

   echo "<strong><font size='3'>".$txt0.": ";
   if ($_SESSION["lang"]!='/en')
   echo substr($dateBeg,8,2).".".substr($dateBeg,5,2).".".substr($dateBeg,0,4)." - ".
        substr($dateEnd,8,2).".".substr($dateEnd,5,2).".".substr($dateEnd,0,4);
   else
       echo substr($dateBeg,5,2)."/".substr($dateBeg,8,2)."/".substr($dateBeg,2,2)." - ".
        substr($dateEnd,5,2)."/".substr($dateEnd,8,2)."/".substr($dateEnd,2,2);
   echo "</font></strong>";
}



if (empty($_TPL_REPLACMENT["COUNT"])) $_TPL_REPLACMENT["COUNT"]=20;
if ($_SESSION["lang"]!='/en') 
$rows = $ilines->getLimitedElementsDateClnRub(@$str, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",$dateBeg,$dateEnd,@$_TPL_REPLACMENT["RUBRIC"], $_REQUEST["otdel"],false, $_GET['year'], $_GET['alfa'], $_GET['author']);
else
$rows = $ilines->getLimitedElementsDateClnRubEn(@$str, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status_en",$dateBeg,$dateEnd,@$_TPL_REPLACMENT["RUBRIC"], $_REQUEST["otdel"],false, $_GET['year'], $_GET['alfa'], $_GET['author']);

//print_r($rows);
//$news_count = $ilines->countElementsDate($_TPL_REPLACMENT["NEWS_LINE"], "status",$dateBeg,$dateEnd);
if ($_SESSION["lang"]!='/en')
	$news_count = $ilines->countElementsDateRub($str, "status",$dateBeg,$dateEnd,$_TPL_REPLACMENT["RUBRIC"], $_REQUEST["otdel"], $_GET['year'], $_GET['alfa'], $_GET['author']);
else	
	$news_count = $ilines->countElementsDateRubEn($str, "status_en",$dateBeg,$dateEnd,$_TPL_REPLACMENT["RUBRIC"], $_REQUEST["otdel"], $_GET['year'], $_GET['alfa'], $_GET['author']);

$pages = Pagination::createPages($news_count, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"],7);

//print_r($pages);
$pg = new Pages();

$bind = new Binding();

//echo "<a hidden=true src=c_p_test>".@count($pages)." ".$_TPL_REPLACMENT["COUNT"]." ".@$_REQUEST["p"]." ".$news_count."</a>";

?>
<nav class="mt-2">
	<ul class="pagination pagination-sm flex-wrap">
		<?php
		$addParams = array();

		if(!empty($_REQUEST['td1'])) {
			$addParams['td1'] = $_REQUEST['td1'];
		}
		if(!empty($_REQUEST['td2'])) {
			$addParams['td2'] = $_REQUEST['td2'];
		}
		if(!empty($_REQUEST['rub'])) {
			$addParams['rub'] = $_REQUEST['rub'];
		}
		if(!empty($_REQUEST['otdel'])) {
			$addParams['otdel'] = $_REQUEST['otdel'];
		}
        if(!empty($_REQUEST['year'])) {
            $addParams['year'] = $_REQUEST['year'];
        }
		$spe2 = Pagination::createPagination($news_count,$_TPL_REPLACMENT["COUNT"],$addParams);

		echo $spe2;
		?>
	</ul>
</nav>
<?php

if(!empty($rows))
{
	$rows2 = $ilines->appendContent($rows);   
	foreach($rows2 as $k => $v)
	{
//print_r($v);
        if (($v["itype_id"]!=6 && $v["itype_id"]!=5 && $v["itype_id"]!=3 && $v["content"]["TITLE_EN"]!='' && isset($_REQUEST["en"])) ||//Для английской версии
		   $_SESSION["lang"]!='/en'
		) 
		{
		if ($v["itype_id"]==6)
		{
		    $direct=$DB->select("SELECT rang.icont_text AS rang,spec.icont_text AS spec,sovet.icont_text AS sovet 
			             FROM adm_directories_content AS c 
						 INNER JOIN adm_directories_content AS rang ON rang.el_id=".$v["content"]["RANG"]." AND rang.icont_var='text' ".
						" INNER JOIN adm_directories_content AS spec ON spec.el_id=".$v["content"]["SPEC"]. " AND spec.icont_var='text' ".
						" INNER JOIN adm_directories_content AS sovet ON sovet.el_id=".$v["content"]["SOVET"]. " AND sovet.icont_var='text' ".
						" WHERE (c.el_id=rang.el_id OR c.el_id=spec.el_id OR c.el_id=sovet.el_id)");
		
	
		}
		$tpl = new Templater();

		if(isset($rows[$v["el_id"]]["date"]))
		{
			if($rows[$v["el_id"]]["date"]>date('Y.m.d'))
			{
			   $ndate='1';

			}
			else
			   $ndate='0';
		 if (!isset($_REQUEST["en"]))
         {			 
			preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[$v["el_id"]]["date"], $matches);
			$rows[$v["el_id"]]["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$rows[$v["el_id"]]["date"] = date("d.m.Y г.", $rows[$v["el_id"]]["date"]);
		}
		else
		{
		    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[$v["el_id"]]["date"], $matches);
			$rows[$v["el_id"]]["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$rows[$v["el_id"]]["date"] = date("m/d/y", $rows[$v["el_id"]]["date"]);
		
		}
		}
        if(isset($rows[$v["el_id"]]["date2"]))
		{
          if ($_SESSION["lang"]!='/en')
         {
			preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[$v["el_id"]]["date2"], $matches);
			$rows[$v["el_id"]]["date2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$rows[$v["el_id"]]["date2"] = date("d.m.Y г.", $rows[$v["el_id"]]["date2"]);
			 $datetimes = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
          }
		  else
		  {
		    preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[$v["el_id"]]["date2"], $matches);
			$rows[$v["el_id"]]["date2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$rows[$v["el_id"]]["date2"] = date("m/d/y", $rows[$v["el_id"]]["date2"]);
			  $datetimes = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		  }

			
		}

        if ($_SESSION["lang"]=='/en')
		{
             $v["content"]["TITLE"]=$v["content"]["TITLE_EN"];
			 $v["content"]["PREV_TEXT"]=$v["content"]["PREV_TEXT_EN"];
			 $v["content"]["LAST_TEXT"]=$v["content"]["LAST_TEXT_EN"];
			 $v["content"]["TODAY_TEXT"]=$v["content"]["TODAY_TEXT_EN"];
		}
		if ($v["content"]["TITLE"]=="")
           $v["content"]["TITLE"]="Информация о конференции";
		$tpl->setValues($v["content"]);
		
		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("ITYPE_ID" => $v["itype_id"]));
		$tpl->appendValues(array("new" => $ndate));
		$tpl->appendValues(array("date" => $rows[$v["el_id"]]["date"]));
		$tpl->appendValues(array("date2" => $rows[$v["el_id"]]["date2"]));

		if ($v["itype_id"]!=6)
		{

		if (substr($v["content"]["DATE2"],0,10)<date("Y.m.d"))
		{
		   if (!empty($v["content"]["LAST_TEXT"]) && $v["content"]["LAST_TEXT"]!='<p>&nbsp;</p>')
			$tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["LAST_TEXT"])));
			else	
			$tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["PREV_TEXT"])));
			
		}
		if (substr($v["content"]["DATE2"],0,10)>date("Y.m.d")) {
		   $tpl->appendValues(array("PREV_TEXT" =>strip_tags($v["content"]["PREV_TEXT"]))); 
		}
		if (substr($v["content"]["DATE2"],0,10)==date("Y.m.d"))
		   {
			   if (!empty($datetimes)) {
				   if (!$v["content"]["TIME_IMPORTANT"]) {
					   $time = "07:00";
				   } else {
					   $time = date("H:i", $datetimes );
				   }
			   } else {
				   $time = "07:00";
			   }

			   if(date("H:i") < $time) {
				   $tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["PREV_TEXT"])));
			   } else {
				   if (date("Y.m.d H:i:s") < date("Y.m.d 16:00:00")) {


					   if (!empty($v["content"]["TODAY_TEXT"]) && $v["content"]["TODAY_TEXT"] != '<p>&nbsp;</p>')
						   $tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["TODAY_TEXT"])));
					   else
						   $tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["PREV_TEXT"])));
				   } else {
					   if (!empty($v["content"]["LAST_TEXT"]) && $v["content"]["LAST_TEXT"] != '<p>&nbsp;</p>')
						   $tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["LAST_TEXT"])));
					   else
						   $tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["PREV_TEXT"])));
				   }
			   }
		   }
        }
		
		$tpl->appendValues(array("title_news" => $v["content"]["TITLE"]));
		if (!empty($v["content"]["RANG"]))
		{
		$tpl->appendValues(array("RANG_TEXT" => $direct[0]["rang"]));
        }
		if (!empty($v["content"]["SOVET"]))
		{
		$tpl->appendValues(array("SOVET_TEXT" => $direct[0]["sovet"]));
        }
		if (!empty($v["content"]["SPEC"]))
		{
		$tpl->appendValues(array("SPEC_TEXT" => $direct[0]["spec"]));
        }
		$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT["FULL_ID"]));
		if(!empty($v["content"]["FULL_TEXT"]) || !empty($v["content"]["REPORT_TEXT"]))
			$tpl->appendValues(array("GO" => true));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.".$_TPL_REPLACMENT["TPL_NAME"].".html");
	}
	}
	
}
//echo "<br />";
?>
<nav class="mt-2">
	<ul class="pagination pagination-sm flex-wrap">
		<?php
		echo $spe2;
		?>
	</ul>
</nav>
<?php
if(Pagination::isLastPage($news_count, $_TPL_REPLACMENT["COUNT"])):?>
	<div><b>Количество элементов: <?=$news_count?></b></div>
<?php
endif;

//echo "</div>";
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
