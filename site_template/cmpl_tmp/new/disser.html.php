<?
global $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


$ilines = new Ilines();
$bind = new Binding();
/*$di = new Directories();*/

$_TPL_REPLACMENT["NEWS_LINE"]=6;
//echo "<br />____".$_TPL_REPLACMENT["SORT_FIELD"].' '.$_TPL_REPLACMENT["NEWS_LINE"]."!!!!!";
/*$rang_tests = $di->getDirectoryElements("Соискатели");*/


$rows = $ilines->getLimitedElementsMultiSort(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], @$_TPL_REPLACMENT["SORT_TYPE"], "status",$_REQUEST[diss]);
//print_r($rows);
$news_count = $ilines->countElementsDiss($_TPL_REPLACMENT["NEWS_LINE"], "status",$_REQUEST[diss]);
$pages = Pagination::createPages($news_count, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], 3);
$pg = new Pages();

?>
<nav class="mt-2">
	<ul class="pagination pagination-sm flex-wrap">
		<?php
		$addParams = array();

		if(!empty($_REQUEST['diss'])) {
			$addParams['diss'] = $_REQUEST['diss'];
		}
		$spe2 = Pagination::createPagination($news_count,$_TPL_REPLACMENT["COUNT"],$addParams);

		echo $spe2;
		?>
	</ul>
</nav>
<?php

if(!empty($rows))
{


	$rows = $ilines->appendContentDisser($rows);

//print_r($rows);
	foreach($rows as $k => $v)
	{

	$tpl = new Templater();
		if(isset($v["date"]))
		{
			preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["date"], $matches);
			$v["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$v["date"] = date("d.m.Y г.",$v["date"]);
		}

			preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $v["date2"], $matches);
			$v["date2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$v["date2"] = date("d.m.Y г.", $v["date2"]);




		$tpl->setValues($v);
		$tpl->appendValues($_TPL_REPLACMENT);
		$tpl->appendValues(array("ID" => $k));
		$tpl->appendValues(array("RET_ID" => $_REQUEST[page_id]));
		$tpl->appendValues(array("RANG_TEXT" => $v["rang"]));
		$tpl->appendValues(array("SOVET_TEXT" => $v["SOVET"]));
		$tpl->appendValues(array("SID" => $v["SPAGE"]));
		$tpl->appendValues(array("SPEC_TEXT" => $v["SOVET"]));
		$tpl->appendValues(array("FULL_ID" => $_TPL_REPLACMENT[FULL_ID]));
	//	$tpl->appendValues(array("GO" => false));
		$tpl->appendValues(array("GO" => true));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.disser.html");
	}
}
echo "<br />";
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
//echo "<a href=/index.php?page_id=629&diss=".$_REQUEST[diss].">Состав Диссертационного совета</a>";
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
