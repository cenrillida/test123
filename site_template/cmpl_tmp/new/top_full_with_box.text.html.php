<?
	global $DB,$_CONFIG, $site_templater; 
//echo $_TPL_REPLACMENT["TITLE_EN"];	
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");
	$dd=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".$_REQUEST[page_id]);
	if (!empty($_REQUEST[id]) && substr($dd[0][page_template],0,8)=='magazine' && $dd[0][page_template]!='magazine_author')
	{
	$pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,IFNULL(m.page_name,'') AS mname,IFNULL(m.page_name_en,'') AS mname_en FROM adm_pages AS p 
	 LEFT OUTER JOIN adm_magazine AS m ON m.page_id=".(int)$_REQUEST[id].
	" WHERE p.page_id=".(int)$_REQUEST[page_id]);
	
	} 
	 else
	  $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template
	  FROM adm_pages AS p ".
	 
	" WHERE p.page_id=".(int)$_REQUEST[page_id]);
//print_r($pname); echo $_TPL_REPLACMENT["TITLE_EN"];

?>
<div id="content">
	<div id="main" class="width-full">		
		<div class="box boxSingle">
			<div class="title blue">
<?
//echo "pname=".$pname[0][page_template]," title=".$_TPL_REPLACMENT["TITLE"];
if (empty($_TPL_REPLACMENT["TITLE_EN"]) || $_TPL_REPLACMENT["TITLE_EN"]=='Editions') $_TPL_REPLACMENT["TITLE_EN"]=$pname[0][page_name_en];
//print_r($pname); echo "!".$_TPL_REPLACMENT["TITLE_EN"];
if ($pname[0][page_template]=='magazine_full')
{
  $_TPL_REPLACMENT["TITLE"]=$pname[0][mname];
  if (!empty($pname[0][mname_en])) $_TPL_REPLACMENT["TITLE_EN"]=$pname[0][mname_en];
}
//print_r($pname); echo "!".$_TPL_REPLACMENT["TITLE_EN"];
if(empty($_TPL_REPLACMENT["TITLE_EN"]) || $_SESSION[lang]=='/en' || $_TPL_REPLACMENT["TITLE_EN"]=='Editions') 
{
if ($_SESSION[lang]=='/en' && (empty($_TPL_REPLACMENT["TITLE"]) &&  $pname[0][page_template]!='news_full' && substr($pname[0][page_template],0,8)!='magazine'))
 $_TPL_REPLACMENT["TITLE_EN"]=$pname[0][page_name_en];
}
//print_r($pname); echo $_TPL_REPLACMENT["TITLE_EN"];


if($_REQUEST[rub]==492 && $_REQUEST[page_id]==498)
{
	if ($_SESSION[lang]=='/en')
	$_TPL_REPLACMENT["TITLE"]='News FANO';
	else
	$_TPL_REPLACMENT["TITLE"]='Новости ФАНО России';
}
//echo "___".$_TPL_REPLACMENT["TITLE"]." ".$pname[0][page_name_en];

 if (!isset($_REQUEST['printmode']))
{
?>
			<h2>
                <?php
                if($_GET[debug]==2) {
                    echo $_TPL_REPLACMENT[BREADCRUMBS];
                } else {
                    include($_TPL_REPLACMENT[BREADCRUMBS]);
                }?>
					<span class="current"></span>
				</h2>
				</div>
<?
//echo "<a hidden=true src=t_test>".$_SESSION[lang]."  ".$_TPL_REPLACMENT["TITLE_EN"]."</a>";

if ($_SESSION[lang]!="/en")
{
		echo "<div id='printbutton'><a href='#' onclick='event.preventDefault(); window.print();'><i class=\"fas fa-print\"></i></a></div>";
	 echo "<h1>".$_TPL_REPLACMENT["TITLE"]."</h1>";

}
	else
{
		echo "<div id='printbutton'><a href='#' onclick='event.preventDefault(); window.print();'><i class=\"fas fa-print\"></i></a></div>";
		if($_TPL_REPLACMENT["TITLE_EN"]!='')
		{
			if($_TPL_REPLACMENT["TITLE_EN"]=="News in detail")
			{
				if($_TPL_REPLACMENT["TITLE"]!='')
					echo "<h1>".$_TPL_REPLACMENT["TITLE"]."</h1>";
				else
					echo "<h1>".$_TPL_REPLACMENT["TITLE_EN"]."</h1>";
			}
			else
			{
				echo "<h1>".$_TPL_REPLACMENT["TITLE_EN"]."</h1>";
			}
		}
else
	 echo "<h1>".$_TPL_REPLACMENT["TITLE"]."</h1>";


}

	
	 
?>
			<div class="sep"> </div>
			<div class="single singleFull width-full">
<?
}

else
    echo "<h2><img src=img/logo_print.jpg hspace=20 align='absmiddle'>". $_TPL_REPLACMENT["TITLE"]."</h2>";
?>			