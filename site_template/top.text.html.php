<?
	global $DB,$_CONFIG, $site_templater;
	
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");
	$pname=$DB->select("SELECT page_name,page_name_en,page_template FROM adm_pages WHERE page_id=".$_REQUEST[page_id]);
//	if (isset($_REQUEST[en])) $_TPL_REPLACMENT["TITLE"]=$_TPL_REPLACMENT["TITLE_EN"];

?>
<div id="content">
	<div id="main">		
		<div class="box boxSingle">
			<div class="title blue">
<?
//echo "pname=".$pname[0][page_template]," title=".$_TPL_REPLACMENT["TITLE"];
if(empty($_TPL_REPLACMENT["TITLE"])) 
{
$_TPL_REPLACMENT["TITLE"]=$pname[0][page_name];
if ($_SESSION[lang]=='/en')$_TPL_REPLACMENT["TITLE"]=$pname[0][page_name_en];
if ($_SESSION[lang]=='/en' && (empty($_TPL_REPLACMENT["TITLE"]) && $pname[0][page_template]!='news_full'))
 $_TPL_REPLACMENT["TITLE"]=$pname[0][page_name_en];
}
 if (!isset($_REQUEST['printmode']))
{
?>
			<h2>
					<?=@$_TPL_REPLACMENT[BREADCRUMBS]?>
					<span class="current"></span>
				</h2>
				</div>
<?
if (!isset($_REQUEST[en]))
{
		echo "<div id='printbutton'><a href='".$_SERVER["REQUEST_URI"].(strpos($_SERVER[REQUEST_URI],"?")>-1 ? "&" : "?")."printmode"."'><img src='/img/printer.jpg' alt='print' /> версия для печати</a></div>";
	 echo "<h1>".$_TPL_REPLACMENT["TITLE"]."</h1>";

}
	else
{
		echo "<div id='printbutton'><a href='".$_SERVER["REQUEST_URI"].(strpos($_SERVER[REQUEST_URI],"?")>-1 ? "&" : "?")."printmode"."'><img src='/img/printer.jpg' alt='print' /> print</a></div>";
if($_TPL_REPLACMENT["TITLE_EN"]!='')
	 echo "<h1>".$_TPL_REPLACMENT["TITLE_EN"]."</h1>";
else
	 echo "<h1>".$_TPL_REPLACMENT["TITLE"]."</h1>";


}

	
	 
?>
			<div class="sep"> </div>
			<div class="single singleFull">
<?
}

else
    echo "<h2><img src=img/logo_print.jpg hspace=20 align='absmiddle'>". $_TPL_REPLACMENT["TITLE"]."</h2>";
?>			