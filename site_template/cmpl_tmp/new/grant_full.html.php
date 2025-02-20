<?
global $DB,$_CONFIG, $site_templater;

$pg = new Pages();

if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])) {
	Dreamedit::sendHeaderByCode(301);
	Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/404");
	exit;
}
$rows0=$DB->select("SELECT icont_text AS title FROM adm_nirs_content WHERE el_id=".(int)$_REQUEST[id]." AND icont_var='title'");

$site_templater->appendValues(array("TITLE" => $rows0[0][title]));

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

//print_r($_TPL_REPLACMENT);
$ilines = new Nirs();

//$rows = $ilines->getElementById(@$_REQUEST["id"]);
$rows = $ilines->appendContentGrantById($_REQUEST["id"]);

//$usl=$ilines->getPodrBYUsluga($_REQUEST[id]);
//print_r($rows);

if(!empty($rows))
{
	foreach($rows as $k => $v)
	{
//print_r($v);
//echo "<br />___".$k." ".$v[el_id];
// echo $v[content]["TITLE"];

		$tpl = new Templater();
		if(isset($rows[@$_REQUEST["id"]]["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[@$_REQUEST["id"]]["content"]["DATE"], $matches);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = date("d.m.Yг.", $rows[@$_REQUEST["id"]]["content"]["DATE"]);
	}



		$tpl->setValues($v);
		$tpl->appendValues($_TPL_REPLACMENT);
		$tpl->appendValues(array("title_news" => $v["title"]));
		$tpl->appendValues(array("date_news" => $v["DATE"]));
		$tpl->appendValues(array("regalii" => str_replace(",",", ",ltrim(rtrim($v["regalii"],","),","))));
		if ($v[otdel]<>"Партнеры" && $v[otdel]<>"Умершие сотрудники" && $v[otdel] <> "Администрация" && $v[otdel] <> "Умер" && $v[otdel] <> "Уволен")
    		$tpl->appendValues(array("otdel" => "<a href=/index.php?page_id=".$v[idpodr]." title='Информация о подразделении'>".$v["otdel"]."</a>"));
		else
		    $tpl->appendValues(array("otdel" =>""));
		$tpl->appendValues(array("fio" => "<a href=/index.php?page_id=".$_TPL_REPLACMENT[PERS_ID]."&id=".$v[idpersons]." title='Информация о руководителе'>".$v["fio"]."</a>"));
		$tpl->appendValues(array("ID" => $v[el_id]));



		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.grant_full.html");//"tpl.news.html");
	}
}
if (!empty($_REQUEST[ret])) $_TPL_REPLACMENT[FULL_ID]=$_REQUEST[ret];
echo "<a href=/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID].">к списку</a><br /><br />";

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>

