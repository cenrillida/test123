<?
global $DB, $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


$ilines = new Nirs();

if ($_TPL_REPLACMENT['TPL_NAME']!="" )
{
    $tplname= $_TPL_REPLACMENT['TPL_NAME'];
  }
else
    $tplname="news";


/*
$rows = $ilines->getLimitedElements(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status");

$news_count = $ilines->countElements($_TPL_REPLACMENT["NEWS_LINE"], "status");

if ($_TPL_REPLACMENT['TPL_NAME']=="hist_anons" )
{
    $rows = $ilines->getLimitedElementsBank(@$_TPL_REPLACMENT["NEWS_LINE"], @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], @$_TPL_REPLACMENT["SORT_FIELD"], $sortt, "status");
    $news_count = $ilines->countElements($_TPL_REPLACMENT["NEWS_LINE"], "status");

}

$pages = Pagination::createPages($news_count, @$_TPL_REPLACMENT["COUNT"], @$_REQUEST["p"], 3);
$pg = new Pages();

*/
//echo "*".$tpl."*";

//echo "<br /><br />";

$banner0=$DB->select("SELECT picture_b AS pic_link, link_b AS site_link	FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]."");
foreach($banner0 as $banner)
{
	if($banner[pic_link]!="")
		echo "<a href=".$banner[site_link]." target='_blank'><img width='244' height='60' border='0' src=".$banner[pic_link]." </img></a>";
}

echo $_TPL_REPLACMENT["ANONS"];

echo "<br /><br />";

$tt="tpl.".$tplname.".html";


 if(date("Y")<$years['end'])
     $y1=date("Y");
 else
     $y1=$years['end'];

 //echo $_TPL_REPLACMENT["NEWS_LINE"];
 $years=$ilines->GrantYears($rows,"2008",@$_TPL_REPLACMENT["NEWS_LINE"]);
  if(date("Y")<$years['end'])
     $y1=date("Y");
 else
     $y1=$years['end'];
 if(isset($_GET[year])) $y0=$_GET[year];
 else $y0=$y1;

 echo "<strong>������ �� �����:&nbsp;&nbsp;&nbsp; </strong>";
 for($i=$y1;$i>=$years['beg'];$i=$i-1)
 {
    $ii="<a href=/index.php?page_id=".$_REQUEST[page_id]."&year=".$i." title='������ ������� �� ".$i." ���'>";
    if ($i==$y0)
        echo "<strong>".$ii.$i."</strong>";
    else
        echo $ii.$i;
    echo "</a>";
    if ($i>$years[beg]) echo " | ";
 }
 echo "<span class='hr'>&nbsp;</span>";
 echo "<br /><br />";
 echo "<font size='3'><strong>".$y0." ���</strong></font><br /><br />";
	$rows = $ilines->appendContentGrant($rows,$y0,@$_TPL_REPLACMENT["NEWS_LINE"]);
	
//print_r($rows[@$_REQUEST["id"]]["content"]["DATE"]);
//echo $rows[@$_REQUEST["id"]]["content"]["DATE"];

//print_r($rows);
	?>
	<script type="text/javascript">   
$(document).ready(function(){


$(".buts").delegate(".buts1", "click", function(){
     $(this).parent().find(".buts_text").stop().slideToggle();
     if($(this).parent().find(".buts1").text()=='���������')
     	$(this).parent().find(".buts1").text('������');
     else
     	$(this).parent().find(".buts1").text('���������');
   });
});
</script>

	<?php



	foreach($rows as $k => $v)
	{
//print_r($v);
// echo $v[content]["TITLE"];

		$tpl = new Templater();
		if(isset($rows[@$_REQUEST["id"]]["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[@$_REQUEST["id"]]["content"]["DATE"], $matches);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = date("d.m.Y�.", $rows[@$_REQUEST["id"]]["content"]["DATE"]);
	}

		if(empty($v['otdel']) && !empty($v['otdelexe'])) {
		    $v['otdel'] = $v['otdelexe'];
            $v[idpodr] = $v['idpodrexe'];
        }
		$tpl->setValues($v);
		$tpl->appendValues($_TPL_REPLACMENT);
		$tpl->appendValues(array("title_news" => $v["title"]));
		$tpl->appendValues(array("date_news" => $v["DATE"]));
		$tpl->appendValues(array("EL_ID" => $v[el_id]));
		$tpl->appendValues(array("regalii" => str_replace(",",", ",ltrim(rtrim($v["regalii"],","),","))));
        $tpl->appendValues(array("regaliiexe" => str_replace(",",", ",ltrim(rtrim($v["regaliiexe"],","),","))));
		if ($v[otdel]<>"��������" && $v[otdel]<>"������� ����������" && $v[otdel] <> "�������������" && $v[otdel] <> "����" && $v[otdel] <> "������")
    		$tpl->appendValues(array("otdel" => "<a href=/index.php?page_id=".$v[idpodr]." title='���������� � �������������'>".$v["otdel"]."</a>"));
		else
		    $tpl->appendValues(array("otdel" =>""));
		$tpl->appendValues(array("fio" => "<a href=/index.php?page_id=".$_TPL_REPLACMENT[PERS_ID]."&id=".$v[idpersons]." title='���������� � ������������'>".$v["fio"]."</a>"));
		if(!empty($v['fioexe'])) {
            $tpl->appendValues(array("fioexe" => "<a href=/index.php?page_id=" . $_TPL_REPLACMENT[PERS_ID] . "&id=" . $v[idpersonsexe] . " title='���������� �� �����������'>" . $v["fioexe"] . "</a>"));
        }
		$tpl->appendValues(array("ID" => $k));

		$tpl->appendValues(array("GO" => false));
		if(!empty($v["content"]["FULL_TEXT"]))
			$tpl->appendValues(array("GO" => true));

		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"].$tt);//"tpl.news.html");
	}

echo "<br />";
// ��������� ������-�����
 echo "<strong>������ �� �����:&nbsp;&nbsp;&nbsp; </strong>";
for($i=$y1;$i>=$years['beg'];$i=$i-1)
 {
    $ii="<a href=/index.php?page_id=".$_REQUEST[page_id]."&year=".$i." title='������ ������� �� ".$i." ���'>";
    if ($i==$y0)
        echo "<strong>".$ii.$i."</strong>";
    else
        echo $ii.$i;
    echo "</a>";
    if ($i>$years[beg]) echo " | ";
 }
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
