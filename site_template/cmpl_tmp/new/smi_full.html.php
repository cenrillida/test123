<?
global $DB,$_CONFIG, $site_templater;

$pg = new Pages();

$id_news=(int)$_GET['id'];
$all_views = 0;

if(!empty($id_news)) {
    $eng_stat = "";
    if($_SESSION[lang]=="/en")
        $eng_stat = "-en";
    //Statistic::theCounter("newsfull-".$id_news.$eng_stat);
    $all_views = Statistic::getAllViews("newsfull-".$id_news.$eng_stat);
}

if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])) {
    Dreamedit::sendHeaderByCode(301);
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/404");
    exit;
}
if($_SESSION[lang]!="/en")
	$rows=$DB->select("SELECT icont_text AS title FROM adm_ilines_content WHERE el_id=".(int)$_REQUEST[id]." AND icont_var='title'");
else
	$rows=$DB->select("SELECT icont_text AS title FROM adm_ilines_content WHERE el_id=".(int)$_REQUEST[id]." AND icont_var='title_en'");

$site_templater->appendValues(array("TITLE" => $rows[0][title]));
$site_templater->appendValues(array("TITLE_EN" => $rows[0][title]));

//print_r($_TPL_REPLACMENT);
$ilines = new Ilines();

$rows = $ilines->getFullSMIById(@$_REQUEST["id"]);

if($rows[0]['status']==0) {
    if(empty($rows[0]['get_code']) || $rows[0]['get_code']!=$_GET['code']) {
        Dreamedit::sendHeaderByCode(404);
        exit;
    }
}

if($rows[0]['no_right_column']==1) {
    $site_templater->appendValues(array("NO_RIGHT_COLUMN" => "1"));
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


if(!empty($id_news)) {
    Statistic::ajaxCounter("newsfull", $id_news);
    Statistic::getAjaxViews("newsfull", $id_news);
}



//$rows = $ilines->appendContent(array(@$_REQUEST["id"] => $rows));
//echo  $rows[0][full_text];
//print_r($rows[0]);
if(!empty($rows))
{
	$tpl = new Templater();
	if(isset($rows[@$_REQUEST["id"]]["content"]["DATE"]))
	{
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[@$_REQUEST["id"]]["content"]["DATE"], $matches);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows[@$_REQUEST["id"]]["content"]["DATE"] = date("d.m.Yг.", $rows[@$_REQUEST["id"]]["content"]["DATE"]);
	}

//	$tpl->setValues($rows);
	$tpl->appendValues(array("ID" => $_REQUEST[id]));
	
//	$tpl->appendValues($rows[@$_REQUEST["id"]]["content"]);
    $tpl->appendValues(array("STAT_VIEWS" => $all_views));
    $tpl->appendValues(array("FULL_TEXT" => $rows[0]["full_text"]));
    $tpl->appendValues(array("FULL_TEXT_EN" => $rows[0]["full_text"]));
	$tpl->appendValues(array("PICTURE" => $rows[0]["picture"]));
	if (empty($rows[0]['full_text'])) 
	   $tpl->appendValues(array("FULL_TEXT" => $rows[0]['prev_text']));
	$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.news_full.html");
}
?>
<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="https://yastatic.net/share2/share.js"></script>
<div class="ya-share2" data-services="vkontakte,odnoklassniki,whatsapp,telegram,moimir,lj,viber,skype,collections,gplus" data-lang="<?php if($_SESSION[lang]!="/en") echo 'ru'; else echo 'en';?>" data-limit="6"></div>
<?
//if (!empty($_REQUEST[ret]))
//	echo "<a href=/index.php?page_id=".$_REQUEST[ret].">к списку</a><br /><br />";
//else
//echo "<a href=/>к списку</a><br /><br />";

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>

