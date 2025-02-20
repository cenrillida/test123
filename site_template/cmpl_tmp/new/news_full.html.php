<?
global $DB,$_CONFIG, $site_templater;

$id_news=(int)$_GET['id'];


$cleanId = (int)$_REQUEST[id];


$all_views = 0;

if(!empty($id_news)) {
    $eng_stat = "";
    if($_SESSION[lang]=="/en")
        $eng_stat = "-en";
    //Statistic::theCounter("newsfull-".$id_news.$eng_stat);
    $all_views = Statistic::getAllViews("newsfull-".$id_news.$eng_stat);
}

if ($_SESSION[lang]=="/en")
{
  $suff2='&en';$txt='news list';
}
else 
{
  $suff2='';$txt='к списку';
}  
$pg = new Pages();

if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])) {
    Dreamedit::sendHeaderByCode(301);
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/404");
    exit;
}

$ilines = new Ilines();

$rows = $ilines->getFullNewsById($cleanId);

if($rows[0]['status']==0) {

    if($_SESSION['lang']!="/en" || $rows[0]['status_en']==0) {
        if(empty($rows[0]['get_code']) || $rows[0]['get_code']!=$_GET['code']) {
            Dreamedit::sendHeaderByCode(301);
            Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/404");
            exit;
        }
    }
}

//
//if ($_SESSION[lang]!="/en")
//	$rows=$DB->select("SELECT icont_text AS title FROM adm_ilines_content WHERE el_id=? AND icont_var='title'",$cleanId);
//else
//	$rows=$DB->select("SELECT icont_text AS title FROM adm_ilines_content WHERE el_id=? AND icont_var='title_en'",$cleanId);

if(isset($rows[0]['no_top']) && $rows[0]['no_top']==1) {
    $site_templater->appendValues(array("NO_TOP" => 1));
}

if(!empty($rows[0]['title_seo_ilines'])) {
    $site_templater->appendValues(array("TITLE" => $rows[0]['title_seo_ilines']));
    $site_templater->appendValues(array("TITLE_SEO_ILINES" => $rows[0]['title_seo_ilines']));
} else {
    $site_templater->appendValues(array("TITLE" => $rows[0][title]));
    $site_templater->appendValues(array("TITLE_SEO_ILINES" => $rows[0]['title_seo_ilines']));
}

if(!empty($rows[0]['title_seo_ilines_en'])) {
    $site_templater->appendValues(array("TITLE_EN" => $rows[0]['title_seo_ilines_en']));
    $site_templater->appendValues(array("TITLE_SEO_ILINES_EN" => $rows[0]['title_seo_ilines_en']));
} else {
    if(empty($rows[0]['title_en'])) {
        $site_templater->appendValues(array("TITLE_EN" => "News in detail"));
        $site_templater->appendValues(array("TITLE_SEO_ILINES_EN" => "News in detail"));
        if($_SESSION['lang']=="/en") {
            $site_templater->appendValues(array("NO_TOP" => 1));
        }
    } else {
        $site_templater->appendValues(array("TITLE_EN" => $rows[0]["title_en"]));
        $site_templater->appendValues(array("TITLE_SEO_ILINES_EN" => $rows[0]['title_en']));
    }
}

$site_templater->appendValues(array("DESCR_SEO_ILINES" => $rows[0]['descr_seo_ilines']));
$site_templater->appendValues(array("DESCR_SEO_ILINES_EN" => $rows[0]['descr_seo_ilines_en']));

$site_templater->appendValues(array("KEYWORDS_SEO_ILINES" => $rows[0]['keywords_seo_ilines']));
$site_templater->appendValues(array("KEYWORDS_SEO_ILINES_EN" => $rows[0]['keywords_seo_ilines_en']));

$site_templater->appendValues(array("OG_IMAGE_ILINES" => $rows[0]['og_image_ilines']));
$site_templater->appendValues(array("OG_IMAGE_ILINES_EN" => $rows[0]['og_image_ilines_en']));

$site_templater->appendValues(array("OG_VIDEO_ILINES" => $rows[0]['og_video_ilines']));
$site_templater->appendValues(array("OG_VIDEO_ILINES_EN" => $rows[0]['og_video_ilines_en']));

$site_templater->appendValues(array("OG_AUDIO_ILINES" => $rows[0]['og_audio_ilines']));
$site_templater->appendValues(array("OG_AUDIO_ILINES_EN" => $rows[0]['og_audio_ilines_en']));

if($rows[0]['no_right_column']==1) {
    $site_templater->appendValues(array("NO_RIGHT_COLUMN" => "1"));
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if(!empty($id_news) && $rows[0]['no_counter']!=1) {
    Statistic::ajaxCounter("newsfull", $id_news);
    Statistic::getAjaxViews("newsfull", $id_news);
}

//print_r($_TPL_REPLACMENT);


//$rows = $ilines->appendContent(array(@$_REQUEST["id"] => $rows));
//print_r($rows);

if(!empty($rows))
{
	$tpl = new Templater();
	if(isset($rows[@$_REQUEST["id"]]["content"]["DATE"]))
	{
		if ($_SESSION[lang]!='/en')
         {	
		preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows[$cleanId]["content"]["DATE"], $matches);
		$rows[$cleanId]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows[$cleanId]["content"]["DATE"] = date("d.m.Y г.", $rows[@$_REQUEST["id"]]["content"]["DATE"]);
		}
		else
		{
		$rows[$cleanId]["content"]["DATE"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
		$rows[$cleanId]["content"]["DATE"] = date("m/d/t", $rows[$cleanId]["content"]["DATE"]);
		
		}
	}
	
	if(empty($rows[0]["full_text_en"]))
	$rows[0]["full_text_en"]="Sorry, this information only in Russian";
	
//	$tpl->setValues($rows);
	$tpl->appendValues(array("ID" => $cleanId));
	
//	$tpl->appendValues($rows[@$_REQUEST["id"]]["content"]);
    if($rows[0]['no_counter']!=1) {
        $tpl->appendValues(array("STAT_VIEWS" => $all_views));
    }

    $fullText = "";
    $fullTextEn = "";

    if (substr($rows[0]["date2"], 0, 10) == date("Y.m.d")) {
        if (date("Y.m.d H:i:s") < date("Y.m.d 16:00:00")) {
            $fullText = $rows[0]["full_text"];
            $fullTextEn = $rows[0]["full_text_en"];
        } else {
            if (!empty($rows[0]["report_text"]) && $rows[0]["report_text"] != '<p>&nbsp;</p>') {
                $fullText = $rows[0]["report_text"];
            } else {
                $fullText = $rows[0]["full_text"];
            }
            if (!empty($rows[0]["report_text_en"]) && $rows[0]["report_text_en"] != '<p>&nbsp;</p>') {
                $fullTextEn = $rows[0]["report_text_en"];
            } else {
                $fullTextEn = $rows[0]["full_text_en"];
            }
        }
    } else {
        $fullText = $rows[0]["full_text"];
        $fullTextEn = $rows[0]["full_text_en"];
    }

    if(!empty($rows[0]["full_text"])) {
        $sliderHeight="100%";
        if(!empty($rows[0]["swiper_slider_height"])) {
            $sliderHeight = $rows[0]["swiper_slider_height"]."px";
        }
        $sliderBuilder = new SwiperSliderBuilder("news-slider",$rows[0]["swiper_slider"],$sliderHeight);
        $fullText = $sliderBuilder->processTextBlock($fullText);
        $fullTextEn = $sliderBuilder->processTextBlock($fullTextEn);
        $sliderBuilder->echoJs();
        $sliderBuilder->echoStyles();
    }

    $tpl->appendValues(array("FULL_TEXT" => $fullText));
    $tpl->appendValues(array("FULL_TEXT_EN" => $fullTextEn));
	$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.news_full.html");
}
?>
<script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="https://yastatic.net/share2/share.js"></script>
<div class="ya-share2 py-2" data-services="vkontakte,odnoklassniki,whatsapp,telegram,moimir,lj,viber,skype,collections,gplus" data-lang="<?php if($_SESSION[lang]!="/en") echo 'ru'; else echo 'en';?>" data-limit="6"></div>
<?
if(empty($_REQUEST[ret])) {
    $_REQUEST[ret] = 498;
}

$specrub_url = "";

if(!empty($_REQUEST[specrub])) {
    $specrub_url = "&specrub=".$_REQUEST[specrub];
}

//if (!empty($_REQUEST[ret]))
//	echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$_REQUEST["ret"]."&sem=".$_REQUEST[sem]."&year=".$_REQUEST[year].$specrub_url.">".$txt."</a><br /><br />";
//
//else
// echo "<a href=".$_SESSION[lang].">".$txt."</a><br /><br />";

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>

