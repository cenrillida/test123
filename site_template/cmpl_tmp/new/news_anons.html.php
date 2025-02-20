<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST["printmode"])) $_REQUEST["printmode"]=$DB->cleanuserinput($_REQUEST["printmode"]);
$_REQUEST["page_id"]=(int)$DB->cleanuserinput($_REQUEST["page_id"]);
$_REQUEST["sem"]=(int)$DB->cleanuserinput($_REQUEST["sem"]);
$_REQUEST["pg"]=(int)$DB->cleanuserinput($_REQUEST["pg"]);
$_REQUEST["year"]=(int)$DB->cleanuserinput($_REQUEST["year"]);

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
if (empty($_TPL_REPLACMENT["COUNT"])) $_TPL_REPLACMENT["COUNT"]=20;
if($_SESSION["lang"]=="/en")
{
    $param="/en";
	$suff="_en";
	$txt1='Pages: ';
}
else
{
   $param="";
   $suff="";
   $txt1="Страницы: ";
}
$ilines = new Ilines();
$dir = new Directories();
if ($_TPL_REPLACMENT['TPL_NAME']!="" )
{
    $tplname= $_TPL_REPLACMENT['TPL_NAME'];
  }
else
    $tplname="news";


if ($_TPL_REPLACMENT['TPL_NAME']!="hist_anons" )
    $sortt= $_TPL_REPLACMENT["SORT_TYPE"];
else
    $sortt="desc";

if($_REQUEST["page_id"]==849) {
	$_REQUEST["sem"] = 483;
}

if (empty($_REQUEST["sem"]))
{
	$rows = $ilines->getLimitedElementsRub(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status",$_TPL_REPLACMENT["RUBRIC"],$_REQUEST["otdel"],$_GET['year'],$_GET['alfa'],$_GET['author']);
	$news_count = $ilines->getLimitedElementsRubCount(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status",$_TPL_REPLACMENT["RUBRIC"],$_REQUEST["otdel"],$_GET['year'],$_GET['alfa'],$_GET['author']);
}
else {
    if($_TPL_REPLACMENT['NEWS_LINE_ALL']) {
        $newsLine = "*";
    } else {
        $newsLine = $_TPL_REPLACMENT["NEWS_LINE"];
    }

	$rows = $ilines->getLimitedElementsSem($newsLine, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status",$_REQUEST["sem"],$_REQUEST["year"]);
	$nnews_count= $ilines->getLimitedElementsSemCount($newsLine, "1000", @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status",$_REQUEST["sem"],$_REQUEST["year"]);
	//echo "<a hidden=true src=c_p_test1>".count($nnews_count)."</a>";
	}
	//$news_count = $ilines->countElements($_TPL_REPLACMENT["NEWS_LINE"], "status");
//echo "@@@@@@@@@@@@@@@@@@@@@@@@@";print_r($news_count);
if ($_TPL_REPLACMENT['TPL_NAME']=="hist_anons" )
{
    $rows = $ilines->getLimitedElementsBank(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status");
    $news_count = $ilines->countElementsBank($_TPL_REPLACMENT["NEWS_LINE"], "status");
	//$news_count = $ilines->getLimitedElementsBankCount(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status");
	//echo "<a hidden=true src=c_p_test>".@count($pages)." ".$_TPL_REPLACMENT["COUNT"]." ".@$_REQUEST["p"]." ".$news_count."</a>";
}



if (empty($news_count))$news_count=count($nnews_count); 
if (empty($news_count))$news_count=count($rows); 
//echo "@".$news_count;

$pages = Pagination::createPages($news_count, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], 3);

$pg = new Pages();
$ilines = new Ilines();

//echo "<a hidden=true src=c_p_test2>".@count($pages)." ".$_TPL_REPLACMENT["COUNT"]." ".@$_REQUEST["p"]." ".$news_count."</a>";

if (!empty($_REQUEST["sem"]) && $_REQUEST["page_id"]!=849)
{
    $semname=$dir->getSemName($_REQUEST["sem"]);
//	print_r($semname);
  if (!($semname[0]['name']=="Заседания Ученого Совета" || $semname[0]['name']=="Meetings of the Academic Council"))
    echo "<h4>".$semname[0]['name'.$suff]."</h4>";
	if ($_SESSION["lang"]!='/en') echo "<p align=right><a href=".$param."/index.php?page_id=".$_REQUEST["pg"].">О мероприятии</a></p>";
	else echo "<p align=right><a href=".$param."/index.php?page_id=".$_REQUEST["pg"].">About the Seminar</a></p>";
	
	$years=$ilines->getSemYears($_REQUEST["sem"]);

   if (!empty($years))
   {
   	  if ($_SESSION["lang"]!='/en') echo "<br /><b>Архив заседаний по годам: </b>";
	  else echo "<br /><b>Archive: </b>";
   	  $i=0;echo "<br />";
	  foreach($years as $y)
   	  {
       if ($i==7)
	   {
	   //echo "<br />";
		   $i=0;
	   }
	   if ($y["year"]==$_REQUEST["year"])
	  echo " &nbsp;".
   	     $y["year"]." &nbsp;|";
   	 
	   else
  	  echo " &nbsp;"."<a href=".$param."/index.php?page_id=".$_REQUEST["page_id"]."&sem=".$_REQUEST["sem"]."&pg=".$_REQUEST["pg"]."&year=".$y["year"].">".
   	     $y["year"]."</a> &nbsp;|";
   	   $i++;
	}
	if ($_SESSION["lang"]!='/en')echo "<br /><br /><h4>".$_REQUEST["year"]." год </h4>";  
	else echo "<br /><br /><h4>".$_REQUEST["year"]."</h4>";  

	}
}
echo $_TPL_REPLACMENT["ANONS".$suff]."<div class='sep'> </div>";

?>
<nav class="mt-2">
	<ul class="pagination pagination-sm flex-wrap">
		<?php
		$addParams = array();

		if(!empty($_REQUEST['sem'])) {
			$addParams['sem'] = $_REQUEST['sem'];
		}
		if(!empty($_REQUEST['pg'])) {
			$addParams['pg'] = $_REQUEST['pg'];
		}
		if(!empty($_REQUEST['year'])) {
			$addParams['year'] = $_REQUEST['year'];
		}
		if(!empty($_REQUEST['otdel'])) {
			$addParams['otdel'] = $_REQUEST['otdel'];
		}
        if(!empty($_REQUEST['alfa'])) {
            $addParams['alfa'] = $_REQUEST['alfa'];
        }
		$spe2 = Pagination::createPagination($news_count,$_TPL_REPLACMENT["COUNT"],$addParams);

		echo $spe2;
		?>
	</ul>
</nav>
<?php

// echo $_TPL_REPLACMENT["NEWS_LINE"];
$tt="tpl.".$tplname.".html";

if(!empty($rows))
{
	$rows = $ilines->appendContent($rows);


	foreach($rows as $k => $v)
	{
//print_r($v);
//        $usl=$ilines->getPodrByUsluga($v[el_id]);
//print_r($usl);
		
		if ($_SESSION["lang"]=="/en")
		{
			$v["content"]["TITLE"]=$v["content"]["TITLE_EN"];
			$v["content"]["PREV_TEXT"]=$v["content"]["PREV_TEXT_EN"];
			$v["content"]["LAST_TEXT"]=$v["content"]["LAST_TEXT_EN"];
			$v["content"]["FULL_TEXT"]=$v["content"]["FULL_TEXT_EN"];
			$v["content"]["REPORT_TEXT"]=$v["content"]["REPORT_TEXT_EN"];
		}

		$date2=$v["content"]["DATE2"];



		$tpl = new Templater();
		if(isset($v["content"]["DATE"]))
	{
		if ($_SESSION["lang"]!='/en')
		{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
		$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE"] = date("d.m.Y г.", $v["content"]["DATE"]);
		}
		else
		{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE"], $matches);
		$v["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE"] = date("m/d/y", $v["content"]["DATE"]);
			
		}
	}
	if(isset($v["content"]["DATE2"]))
	{
		if ($_SESSION["lang"]!='/en')
		{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE2"], $matches);
		$v["content"]["DATE2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE2"] = date("d.m.Y г.", $v["content"]["DATE2"]);
			$datetimes = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		}
		else
		{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["content"]["DATE2"], $matches);
		$v["content"]["DATE2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$v["content"]["DATE2"] = date("m/d/y", $v["content"]["DATE2"]);
			$datetimes = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		
		
		}
	}
// echo "<br />";print_r($v);

		$tpl->setValues($v["content"]);
//		$tpl->appendValues($_TPL_REPLACMENT);

   if ($_TPL_REPLACMENT["NEWS_LINE"]==3)
		$tpl->appendValues(array("TITLE_NEWS" => $v["content"]["DATE"]." ".$v["content"]["TITLE"]));
	else
		$tpl->appendValues(array("TITLE_NEWS" => $v["content"]["TITLE"]));
		$tpl->appendValues(array("date" => $v["content"]["DATE"]));



		if ($date2<date("Y.m.d") && !empty($v["content"]["LAST_TEXT"])&& $v["content"]["LAST_TEXT"]!="<p>&nbsp;</p>")
		{
			if(!empty($v["content"]["FULL_TEXT"]) && ($v["content"]["FULL_TEXT"]!= '<p>&nbsp;</p>'))
				$tpl->appendValues(array("GO" => true));
			$tpl->appendValues(array("PREV_TEXT" => $v["content"]["LAST_TEXT"]));
			if (!empty( $_TPL_REPLACMENT["REPORT_TEXT"]))
			{
				$tpl->appendValues(array("FULL_TEXT" => $_TPL_REPLACMENT["REPORT_TEXT"]));
				$tpl->appendValues(array("GO" => true));
			}
			$tpl->appendValues(array("REPORT" => true));
  		}
  		if (substr($date2,0,10)==date("Y.m.d")) {

			if (!empty($datetimes)) {
				if (!$v["content"]["TIME_IMPORTANT"]) {
					$time = "07:00";
				} else {
					$time = date("H:i", $datetimes );
				}
			} else {
				$time = "07:00";
			}


			if (date("H:i") < $time) {
				$tpl->appendValues(array("PREV_TEXT" => strip_tags($v["content"]["PREV_TEXT"])));
			} else {
				if (date("Y.m.d H:i:s") < date("Y.m.d 16:00:00")) {


					if (!empty($v["content"]["TODAY_TEXT"]) && $v["content"]["TODAY_TEXT"] != '<p>&nbsp;</p>')
						$tpl->appendValues(array("PREV_TEXT" => $v["content"]["TODAY_TEXT"]));
					else
						$tpl->appendValues(array("PREV_TEXT" => $v["content"]["PREV_TEXT"]));

				} else {
					if (!empty($v["content"]["LAST_TEXT"]) && $v["content"]["LAST_TEXT"] != '<p>&nbsp;</p>')
						$tpl->appendValues(array("PREV_TEXT" => $v["content"]["LAST_TEXT"]));
					else
						$tpl->appendValues(array("PREV_TEXT" => $v["content"]["PREV_TEXT"]));
				}

			}
		}
		if (empty($_REQUEST["sem"]) && !empty($v["content"]["sem"]))
		{
			if ($_SESSION["lang"]!="/en")$semname=$dir->getSemName($v["content"]["sem"]);
			else $semname=$dir->getSemNameEn($v["content"]["sem"]);
			
			$tpl->appendValues(array("sem_name" => $semname[0]["name"]));
			$tpl->appendValues(array("sem_id" => $semname[0]["sem_id"]));
		}
		else
			$tpl->appendValues(array("sem_name" => ' '));

		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("YEAR" => $v["content"]["year"]));
        $tpl->appendValues(array("NEWS_LINE" => $_TPL_REPLACMENT["NEWS_LINE"]));
		$tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT["FULL_ID"]));
		$tpl->appendValues(array("RET_ID" => $_REQUEST["page_id"]));
		$tpl->appendValues(array("SEM" => $_REQUEST["sem"]));
		$tpl->appendValues(array("TYEAR" => $_REQUEST["year"]));
		$tpl->appendValues(array("GO" => false));
		

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"].$tt);//"tpl.news.html");
	}
}
//echo "<br />".$tt."@@@@@@@@@@@@@@@@@@@@@@";
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

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
