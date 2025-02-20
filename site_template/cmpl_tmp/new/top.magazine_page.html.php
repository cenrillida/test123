<?
	global $DB,$_CONFIG, $site_templater;

$cur_url = "https://";
// Append the host(domain name, ip) to the URL.
$cur_url.= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$cur_url.= $_SERVER['REQUEST_URI'];


$pg = new Pages();

$page_attr = $pg->getPageById($_REQUEST["page_id"]);
//echo $_TPL_REPLACMENT["TITLE_EN"];	
	?>

<!DOCTYPE html>
<html lang="en" class="mdl-js"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?php if($_SESSION[lang]!="/en"):

        $keywords_seo = $_TPL_REPLACMENT["KEYWORDS"];

        if(!empty($_TPL_REPLACMENT["KEYWORDS_SEO_ILINES"])) {
            $keywords_seo = $_TPL_REPLACMENT["KEYWORDS_SEO_ILINES"];
        } elseif(!empty($page_attr["keywords_seo"])) {
            $keywords_seo = $page_attr["keywords_seo"];
        }

        $descr_seo = $_TPL_REPLACMENT["DESCRIPTION"];

        if(!empty($_TPL_REPLACMENT["DESCR_SEO_ILINES"])) {
            $descr_seo = $_TPL_REPLACMENT["DESCR_SEO_ILINES"];
        } elseif(!empty($page_attr["descr_seo"])) {
            $descr_seo = $page_attr["descr_seo"];
        }

        $og_image = "";

        if(!empty($_TPL_REPLACMENT["OG_IMAGE_ILINES"])) {
            if (!empty($_TPL_REPLACMENT["OG_IMAGE_ILINES"]) && $_TPL_REPLACMENT["OG_IMAGE_ILINES"] != '<p>&nbsp;</p>') {
                preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT["OG_IMAGE_ILINES"], $imgSrc);

                $imgSrc = array_pop($imgSrc);
                if(!empty($imgSrc[0])) {
                    $og_image = $imgSrc[0];
                }
            }
        } elseif(!empty($page_attr["og_image"])) {
            if (!empty($page_attr["og_image"]) && $page_attr["og_image"] != '<p>&nbsp;</p>') {
                preg_match_all('@src="([^"]+)"@', $page_attr["og_image"], $imgSrc);

                $imgSrc = array_pop($imgSrc);
                if(!empty($imgSrc[0])) {
                    $og_image = $imgSrc[0];
                }
            }
        }
        if(empty($og_image)) {
            if (!empty($_TPL_REPLACMENT["OG_IMAGE_COMMON"]) && $_TPL_REPLACMENT["OG_IMAGE_COMMON"] != '<p>&nbsp;</p>') {
                preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT["OG_IMAGE_COMMON"], $imgSrc);

                $imgSrc = array_pop($imgSrc);
                if(!empty($imgSrc[0])) {
                    $og_image = $imgSrc[0];
                }
            }
        }
        if(substr($og_image,0,1)=="/") {
            $og_image = "https://imemo.ru".$og_image;
        }


        $og_video = "";

        if(!empty($_TPL_REPLACMENT["OG_VIDEO_ILINES"])) {
            $og_video = $_TPL_REPLACMENT["OG_VIDEO_ILINES"];
        } elseif(!empty($page_attr["og_video"])) {
            $og_video = $page_attr["og_video"];
        }

        $og_audio = "";

        if(!empty($_TPL_REPLACMENT["OG_AUDIO_ILINES"])) {
            $og_audio = $_TPL_REPLACMENT["OG_AUDIO_ILINES"];
        } elseif(!empty($page_attr["og_audio"])) {
            $og_audio = $page_attr["og_audio"];
        }

        if(empty($og_image)) {
            $og_image = "https://www.imemo.ru/files/Image/BRANDBOOK/logo_rus.png";
        }

        ?>
        <meta name="keywords" content="<?=htmlspecialchars($keywords_seo)?>">
        <meta name="description" content="<?=htmlspecialchars($descr_seo)?>">
        <meta property="og:locale" content="ru_RU" />
        <meta property="og:site_name" content="»Ã›ÃŒ –¿Õ | ŒÙËˆË‡Î¸Ì˚È Ò‡ÈÚ" />
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="<?=htmlspecialchars($descr_seo)?>">
        <meta property="og:image" content="<?=$og_image?>">
        <meta property="og:video" content="<?=$og_video?>">
        <meta property="og:audio" content="<?=$og_audio?>">
        <meta property="og:url" content="<?=$cur_url?>">
    <?php else:

        $keywords_seo = $_TPL_REPLACMENT["KEYWORDS_EN"];

        if(!empty($_TPL_REPLACMENT["KEYWORDS_SEO_ILINES_EN"])) {
            $keywords_seo = $_TPL_REPLACMENT["KEYWORDS_SEO_ILINES_EN"];
        } elseif(!empty($page_attr["keywords_seo_en"])) {
            $keywords_seo = $page_attr["keywords_seo_en"];
        }

        $descr_seo = $_TPL_REPLACMENT["DESCRIPTION_EN"];

        if(!empty($_TPL_REPLACMENT["DESCR_SEO_ILINES_EN"])) {
            $descr_seo = $_TPL_REPLACMENT["DESCR_SEO_ILINES_EN"];
        } elseif(!empty($page_attr["descr_seo_en"])) {
            $descr_seo = $page_attr["descr_seo_en"];
        }

        $og_image = "";

        if(!empty($_TPL_REPLACMENT["OG_IMAGE_ILINES_EN"])) {
            if (!empty($_TPL_REPLACMENT["OG_IMAGE_ILINES_EN"]) && $_TPL_REPLACMENT["OG_IMAGE_ILINES_EN"] != '<p>&nbsp;</p>') {
                preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT["OG_IMAGE_ILINES_EN"], $imgSrc);

                $imgSrc = array_pop($imgSrc);
                if(!empty($imgSrc[0])) {
                    $og_image = $imgSrc[0];
                }
            }
        } elseif(!empty($page_attr["og_image_en"])) {
            if (!empty($page_attr["og_image_en"]) && $page_attr["og_image_en"] != '<p>&nbsp;</p>') {
                preg_match_all('@src="([^"]+)"@', $page_attr["og_image_en"], $imgSrc);

                $imgSrc = array_pop($imgSrc);
                if(!empty($imgSrc[0])) {
                    $og_image = $imgSrc[0];
                }
            }
        }
        if(empty($og_image)) {
            if (!empty($_TPL_REPLACMENT["OG_IMAGE_COMMON_EN"]) && $_TPL_REPLACMENT["OG_IMAGE_COMMON_EN"] != '<p>&nbsp;</p>') {
                preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT["OG_IMAGE_COMMON_EN"], $imgSrc);

                $imgSrc = array_pop($imgSrc);
                if(!empty($imgSrc[0])) {
                    $og_image = $imgSrc[0];
                }
            }
        }
        if(substr($og_image,0,1)=="/") {
            $og_image = "https://imemo.ru".$og_image;
        }


        $og_video = "";

        if(!empty($_TPL_REPLACMENT["OG_VIDEO_ILINES_EN"])) {
            $og_video = $_TPL_REPLACMENT["OG_VIDEO_ILINES_EN"];
        } elseif(!empty($page_attr["og_video_en"])) {
            $og_video = $page_attr["og_video_en"];
        }

        $og_audio = "";

        if(!empty($_TPL_REPLACMENT["OG_AUDIO_ILINES_EN"])) {
            $og_audio = $_TPL_REPLACMENT["OG_AUDIO_ILINES_EN"];
        } elseif(!empty($page_attr["og_audio_en"])) {
            $og_audio = $page_attr["og_audio_en"];
        }

        if(empty($og_image)) {
            $og_image = "https://www.imemo.ru/files/Image/BRANDBOOK/logo_en.png";
        }

        ?>
        <meta name="keywords" content="<?=htmlspecialchars($keywords_seo)?>">
        <meta name="description" content="<?=htmlspecialchars($descr_seo)?>">
        <meta property="og:locale" content="en_EN" />
        <meta property="og:site_name" content="IMEMO | Official Site" />
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="<?=htmlspecialchars($descr_seo)?>">
        <meta property="og:image" content="<?=$og_image?>">
        <meta property="og:video" content="<?=$og_video?>">
        <meta property="og:audio" content="<?=$og_audio?>">
        <meta property="og:url" content="<?=$cur_url?>">
    <?php endif;?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="">
        <?php
        if(!empty($_SESSION[jour])) {
            $mz=new Magazine();
            $jour0=$mz->getMagazineByArticleId($_REQUEST[id]);
            $article=$mz->getArticleById($_REQUEST[id]);
            if($_SESSION[lang]!="/en") {
                $jour_name = $jour0[0]['page_name'];
                $keyword = preg_replace("(<.+?>)","",$article[0]['keyword']);
                $annots = preg_replace("(<.+?>)","",$article[0]['annots']);
                $title = $article[0]['name'];
            } else {
                $jour_name = $jour0[0]['page_name_en'];
                $keyword = preg_replace("(<.+?>)","",$article[0]['keyword_en']);
                $annots = preg_replace("(<.+?>)","",$article[0]['annots_en']);
                $title = $article[0]['name_en'];
            }
            $vol_pos = strripos($article[0][number], "Ú.");
            if($vol_pos !== false) {
                $volume = substr($article[0][number], $vol_pos);
                if ($_SESSION[lang] == '/en')
                    $volume = str_replace("Ú.", "", $volume);
                else
                    $volume = str_replace("Ú.", "", $volume);
                $number = spliti(",", $article[0][number]);
                $number = $number[0];
            } else {
                $number = $article[0][number];
                $volume = $article[0][number];
            }
            if (!isset($_REQUEST[en]))
            {
                $people0=$mz->getAutors($article[0][people]);
            }
            else
            {
                $people0=$mz->getAutorsEn($article[0][people]);

            }
            if(!empty($article[0]['pages'])) {
                $jour_pages = spliti("-", $article[0]['pages']);
            }
            //var_dump($people0);
            if($page_attr[page_template]=="magazine_article") {
                ?>
                <meta name="citation_journal_title" content="<?=htmlspecialchars($jour_name)?>">
                <meta name="citation_publisher" content="<?=htmlspecialchars($jour0[0]['publisher'])?>">
                <?php foreach ($people0 as $people):?>
                    <?php if(!empty($people[id])):?>
                        <?php if($_SESSION[lang]!="/en"):?>
                            <meta name="citation_author" content="<?=htmlspecialchars($people[fio_full_meta])?>">
                        <?php else:?>
                            <meta name="citation_author" content="<?=htmlspecialchars($people[fio])?>">
                        <?php endif;?>
                        <meta name="citation_author_email" content="<?=$people[mail1]?>">
                    <?php endif;?>
                <?php endforeach;?>
                <meta name="citation_author_institution" content="">
                <meta name="citation_title" content="<?=htmlspecialchars($title)?>">
                <meta name="citation_abstract" content="<?=htmlspecialchars($annots)?>">
                <meta name="citation_publication_date" content="<?=substr($article[0]['date'],0,4)?>/<?=substr($article[0]['date'],4,2)?>/<?=substr($article[0]['date'],6,2)?>">
                <meta name="citation_abstract_html_url" content="https://www.imemo.ru/jour/<?=$_SESSION[jour_url]?>/index.php?page_id=<?=$_GET[page_id]?>&id=<?=$_GET[id]?>">
                <meta name="citation_online_date" content="<?=substr($article[0]['date'],0,4)?>/<?=substr($article[0]['date'],4,2)?>/<?=substr($article[0]['date'],6,2)?>">
                <meta name="citation_volume" content="<?=$volume?>">
                <meta name="citation_issue" content="<?=$number?>">
                <meta name="citation_firstpage" content="<?=$jour_pages[0]?>">
                <meta name="citation_lastpage" content="<?=$jour_pages[1]?>">
                <meta name="citation_doi" content="<?=$article[0]['doi']?>">
                <?php if($_SESSION[jour_url]!="meimo" || $article[0]['fulltext_open']==1):?>
                    <meta name="citation_fulltext_world_readable" content="">
                <?php endif;?>
                <meta name="citation_issn" content="<?=str_replace("ISSN ", "", $jour0[0]['issn'])?>">
                <meta name="citation_language" content="<?php if($_SESSION[lang]!="/en") echo "ru_RU"; else echo "en_EN";?>">
                <meta name="citation_keywords" content="<?=htmlspecialchars($keyword)?>">
                <?php
            }
        }

        ?>
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=zX7alnNkgg">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=zX7alnNkgg">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=zX7alnNkgg">
        <link rel="manifest" href="/site.webmanifest?v=zX7alnNkgg">
        <link rel="mask-icon" href="/safari-pinned-tab.svg?v=zX7alnNkgg" color="#002745">
        <link rel="shortcut icon" href="/favicon.ico?v=zX7alnNkgg">
        <meta name="apple-mobile-web-app-title" content="»Ã›ÃŒ –¿Õ">
        <meta name="application-name" content="»Ã›ÃŒ –¿Õ">
        <meta name="msapplication-TileColor" content="#002745">
        <meta name="theme-color" content="#ffffff">

    <?php if ($_SESSION[lang]!="/en"):
        $title_seo = $_TPL_REPLACMENT["TITLE"];

        if(!empty($_TPL_REPLACMENT["TITLE_SEO_ILINES"])) {
            $title_seo = $_TPL_REPLACMENT["TITLE_SEO_ILINES"];
        } elseif(!empty($page_attr["title_seo"])) {
            $title_seo = $page_attr["title_seo"];
        }

        ?>
        <title><?=preg_replace('/<.*>/iUs', "", $title_seo)?></title>
        <meta property="og:title" content="<?=htmlspecialchars($title_seo)?>">
    <?php else:
        if ($_TPL_REPLACMENT["TITLE_EN"]!="") {
            $title_seo = $_TPL_REPLACMENT["TITLE_EN"];
        } else {
            $title_seo = $_TPL_REPLACMENT["TITLE"];
        }

        if(!empty($_TPL_REPLACMENT["TITLE_SEO_ILINES_EN"])) {
            $title_seo = $_TPL_REPLACMENT["TITLE_SEO_ILINES_EN"];
        } elseif(!empty($page_attr["title_seo_en"])) {
            $title_seo = $page_attr["title_seo_en"];
        }

        ?>
        <title><?=preg_replace('/<.*>/iUs', "", $title_seo)?></title>
        <meta property="og:title" content="<?=htmlspecialchars($title_seo)?>">
    <?php endif ?>

        <!-- Bootstrap core CSS -->
        <link href="/newsite/css/bootstrap.min.css?v=2" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/newsite/css/dncalendar-skin.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/newsite/css/carousel.css">
        <link href="/newsite/css/product.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/product.css");?>" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="/pageflip/css/pageflip.css">
        <link type="text/css" rel="stylesheet" href="/pageflip/css/pageflip-custom.css">
        <?php
        if($_GET[debug_font]==1) {
            ?>
            <link href="https://fonts.googleapis.com/css?family=Arya:400,700|Istok+Web:400,400i,700,700i|Playfair+Display+SC:400,400i,700,700i|Playfair+Display:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i|Roboto:400,400i,700,700i|Stardos+Stencil:400,700&amp;subset=cyrillic" rel="stylesheet">
            <?php
        }
        ?>
        <script src="/newsite/js/jquery-3.3.1.min.js"></script>
        <?php
        if($_SESSION[jour_url]=='meimo') {
            ?>
            <script language="JavaScript">
                function exitMain (page,name, value, expires, path, domain, secure) {
                    var curCookie = name + "=" + "undefined" +
                        ((expires) ? "; expires=" + "Thu, 01-Jan-70 00:00:01 GMT" : "") +
                        ((path) ? "; path=" + path : "") +
                        ((domain) ? "; domain=" + domain : "") +
                        ((secure) ? "; secure" : "");

                    document.cookie = curCookie;

                    var curCookie = "userid_meimo_secure" + "=" + "undefined" +
                        ((expires) ? "; expires=" + "Thu, 01-Jan-70 00:00:01 GMT" : "") +
                        ((path) ? "; path=" + path : "") +
                        ((domain) ? "; domain=" + domain : "") +
                        ((secure) ? "; secure" : "");

                    document.cookie = curCookie;
                    location.replace("https://www.imemo.ru<?=$_SESSION[lang]?>/jour/meimo/index.php?page_id=682");
                    return false;

                }
            </script>
            <?
        }
        ?>
        <script src='https://www.google.com/recaptcha/api.js?hl=<?php if($_SESSION[lang]=="/en") echo "en"; else echo "ru";?>'></script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Website",
            "name": "<?=htmlspecialchars($title_seo)?>",
            "image": "<?=$og_image?>",
            "description": "<?=htmlspecialchars($descr_seo)?>"
        }
    </script>
    </head>
<body>
<?php
if($_GET[debug_font]==1) {
    ?>
    <div>
        <select class="form-control form-control-lg" id="debug-font">
            <option>-</option>
            <option>Roboto</option>
            <option>Roboto Condensed</option>
            <option>Playfair Display</option>
            <option>Playfair Display SC</option>
            <option>Istok Web</option>
            <option>Stardos Stencil</option>
            <option>Arya</option>
        </select>
    </div>
    <script>
        $('#debug-font').change(function() {
            if($(this).val()==="-") {
                $('body').css("font-family", "'PT Sans', sans-serif");
                $('.site-header').css("font-family", "'Open Sans Condensed', sans-serif");
            }
            if($(this).val()==="Roboto") {
                $('body').css("font-family", "'Roboto', sans-serif");
                $('.site-header').css("font-family", "'Roboto', sans-serif");
            }
            if($(this).val()==="Roboto Condensed") {
                $('body').css("font-family", "'Roboto Condensed', sans-serif");
                $('.site-header').css("font-family", "'Roboto Condensed', sans-serif");
            }
            if($(this).val()==="Playfair Display") {
                $('body').css("font-family", "'Playfair Display', serif");
                $('.site-header').css("font-family", "'Playfair Display', serif");
            }
            if($(this).val()==="Playfair Display SC") {
                $('body').css("font-family", "'Playfair Display SC', serif");
                $('.site-header').css("font-family", "'Playfair Display SC', serif");
            }
            if($(this).val()==="Istok Web") {
                $('body').css("font-family", "'Istok Web', sans-serif");
                $('.site-header').css("font-family", "'Istok Web', sans-serif");
            }
            if($(this).val()==="Stardos Stencil") {
                $('body').css("font-family", "'Stardos Stencil', cursive");
                $('.site-header').css("font-family", "'Stardos Stencil', cursive");
            }
            if($(this).val()==="Arya") {
                $('body').css("font-family", "'Arya', sans-serif");
                $('.site-header').css("font-family", "'Arya', sans-serif");
            }
        });
    </script>

    <?php
}

?>

<div class="on-top-button">
    <a class="btn btn-lg imemo-button text-uppercase arrowup" href="#" role="button"><i class="fas fa-arrow-up"></i></a>
</div>

<?php
if (empty($_SESSION[jour])) {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "menu");
} else {
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "menu_jour");
}
?>


<?php
	$dd=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
	if (!empty($_REQUEST[id]) && substr($dd[0][page_template],0,8)=='magazine' && $dd[0][page_template]!='magazine_author')
	{
	$pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,IFNULL(m.page_name,'') AS mname,IFNULL(m.page_name_en,'') AS mname_en FROM adm_pages AS p 
	 LEFT OUTER JOIN adm_magazine AS m ON m.page_id=".$_REQUEST[id].
	" WHERE p.page_id=".(int)$_REQUEST[page_id]);
	
	} 
	 else
	  $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,p.noright,p.notop,p.nobreadcrumbs,p.activatestat
	  FROM adm_pages AS p ".
	 
	" WHERE p.page_id=".(int)$_REQUEST[page_id]);
//print_r($pname); echo $_TPL_REPLACMENT["TITLE_EN"];

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
	$_TPL_REPLACMENT["TITLE"]='ÕÓ‚ÓÒÚË ‘¿ÕŒ –ÓÒÒËË';
}
//echo "___".$_TPL_REPLACMENT["TITLE"]." ".$pname[0][page_name_en];
$all_views = 0;
if($pname[0]['activatestat']==1) {
    $eng_stat = "";
    if($_SESSION[lang]=="/en")
        $eng_stat = "-en";
    //Statistic::theCounter("pageid-".(int)$_REQUEST[page_id].$eng_stat);
    Statistic::ajaxCounter("pageid",(int)$_REQUEST[page_id]);
    $all_views = Statistic::getAllViews("pageid-".(int)$_REQUEST[page_id].$eng_stat);
}

?>
<section>
    <div id="pageflip">
        <?php
        $pageflip = $DB->select("SELECT * FROM pdf_converted WHERE path=?","/home/imemon/html/files/File/magazines/puty_miru/2019/01/FullText_1_2019.pdf");
        echo $pageflip[0]['html'];

        ?>
        <div class='controlbar'>
    <div id="pageflip-controls">

        <div class="pf-right-buttons">
            <!--<div id="b-close" class="control-bar-button right" title="Close"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
    <g>
        <polygon points="17.479,8.5 15.5,6.52 11,11.02 6.5,6.52 4.52,8.5 9.02,13 4.52,17.5 6.5,19.479 11,14.979 15.5,19.479
            17.479,17.5 12.979,13 	"/>
    </g>
    </svg></div>-->
            <div id="b-fullscreen" class="pf-control-bar-button pf-right" title="Fullscreen On/Off"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve"><g><path d="M5.368,12.116v4.346h5.969v-4.346H5.368z M17,16c0,1.104-0.896,2-2,2H6c-1.104,0-2-0.896-2-2v-6c0-1.104,0.896-2,2-2h9 c1.104,0,2,0.896,2,2V16z"/></g></svg></div>
            <div id="b-fullscreenoff" class="pf-control-bar-button pf-right"title="Fullscreen On/Off" style="display: none;"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve"><g><path d="M5.368,9.538v3.351h5.882v3.573h4.382V9.538H5.368z M17,16c0,1.104-0.896,2-2,2H6c-1.104,0-2-0.896-2-2v-6 c0-1.104,0.896-2,2-2h9c1.104,0,2,0.896,2,2V16z"/></g>
</svg></div>
            <div id="b-thumbs" class="pf-control-bar-button pf-right" title="Thumbnails"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                              x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
<g>
    <rect x="3" y="7" width="3.3" height="3.3"/>
    <rect x="3" y="11" width="3.3" height="3.3"/>
    <rect x="3" y="15" width="3.3" height="3.3"/>
    <rect x="7" y="7" width="3.3" height="3.3"/>
    <rect x="7" y="11" width="3.3" height="3.3"/>
    <rect x="7" y="15" width="3.3" height="3.3"/>
    <rect x="11" y="7" width="3.3" height="3.3"/>
    <rect x="11" y="11" width="3.3" height="3.3"/>
    <rect x="11" y="15" width="3.3" height="3.3"/>
    <rect x="15" y="7" width="3.3" height="3.3"/>
    <rect x="15" y="11" width="3.3" height="3.3"/>
</g>
</svg></div>
            <!--<div id="b-index" class="control-bar-button right" title="Table of Contents"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
    <g>
        <circle cx="4.5" cy="9" r="1.5"/>
        <rect x="7" y="8" width="11" height="1.5"/>
        <circle cx="4.5" cy="13" r="1.5"/>
        <rect x="7" y="12" width="11" height="1.5"/>
        <circle cx="4.5" cy="17" r="1.5"/>
        <rect x="7" y="16" width="11" height="1.5"/>
    </g>
    </svg>
    </div>
            <div id="b-download" class="control-bar-button right" title="Download printable .pdf version"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
    <g>
        <path d="M2.75,17.889c0,0,4.35-2.535,7.25,0V9.016c-2.9-2.535-7.25,0-7.25,0V17.889z"/>
        <path d="M18.25,17.889c0,0-4.352-2.535-7.25,0V9.016c2.898-2.535,7.25,0,7.25,0V17.889z"/>
    </g>
    </svg></div>
            <div id="b-info" class="control-bar-button right" title="Info"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
    <g>
        <circle cx="10.5" cy="8" r="1.5"/>
        <polygon points="7,10.5 7,11.5 9,11.5 9,16.5 7,16.5 7,17.5 14,17.5 14,16.5 12,16.5 12,10.5 	"/>
    </g>
    </svg>
    </div>
            <div id="b-sound" class="control-bar-button right" title="Sound On/Off" style="display: none;"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
    <g>
        <g>
            <polygon points="4,11 4,16 7,16 10,19 10,8 7,11 		"/>
        </g>
        <g>
            <path d="M14.885,20.165l-0.813-0.517l0.259-0.407c1.116-1.757,1.707-3.742,1.707-5.741s-0.591-3.984-1.707-5.742l-0.259-0.407
                l0.813-0.517l0.258,0.407C16.358,9.154,17,11.318,17,13.5c0,2.183-0.642,4.347-1.857,6.259L14.885,20.165z"/>
        </g>
        <g>
            <path d="M13.285,19.107l-0.828-0.494l0.247-0.414c0.885-1.48,1.333-3.062,1.333-4.699s-0.448-3.219-1.333-4.699l-0.247-0.414
                l0.828-0.494l0.247,0.414C14.506,9.938,15,11.686,15,13.5c0,1.814-0.494,3.562-1.468,5.193L13.285,19.107z"/>
        </g>
        <g>
            <path d="M11.692,18.048l-0.846-0.462l0.231-0.423c0.637-1.166,0.96-2.398,0.96-3.663c0-1.264-0.323-2.497-0.96-3.663l-0.231-0.423
                l0.846-0.462l0.231,0.423C12.638,10.685,13,12.072,13,13.5s-0.362,2.815-1.077,4.124L11.692,18.048z"/>
        </g>
    </g>
    </svg></div>
            <div id="b-soundoff" class="control-bar-button right"title="Sound On/Off" ><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
    <g>
        <polygon points="4,11 4,16 7,16 10,19 10,8 7,11 	"/>
        <polygon points="17.047,11.039 16.252,10.244 14.126,12.37 12,10.244 11.205,11.039 13.331,13.165 11.205,15.291 12,16.086
            14.126,13.96 16.252,16.086 17.047,15.291 14.921,13.165 	"/>
    </g>
    </svg></div>-->
            <div id="b-play" class="pf-control-bar-button pf-right" title="Auto Flipping"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                               x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
<g>
    <polygon points="5,8 17,13 5,18 	"/>
</g>
</svg>
            </div>
            <div id="b-pause" class="pf-control-bar-button pf-right" title="Stop Auto Flipping" style="display: none;"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                                                            x="0px" y="0px" width="22px" height="26px" viewBox="0 0 22 26" xml:space="preserve">
<g>
    <path d="M10,16c0,1.104-0.896,2-2,2H7c-1.104,0-2-0.896-2-2v-6c0-1.104,0.896-2,2-2h1c1.104,0,2,0.896,2,2V16z"/>
    <path d="M17,16c0,1.104-0.896,2-2,2h-1c-1.104,0-2-0.896-2-2v-6c0-1.104,0.896-2,2-2h1c1.104,0,2,0.896,2,2V16z"/>
</g>
</svg>
            </div>
            <div id="b-zoomin" class="pf-control-bar-button pf-right" title="Zoom In"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                           x="0px" y="0px" width="26px" height="26px" viewBox="0 0 26 26" xml:space="preserve">
<g>
    <path d="M22.09,21.01l-4.643-4.641c0.609-0.98,0.967-2.133,0.967-3.369c0-3.537-2.877-6.414-6.414-6.414
	c-3.535,0-6.414,2.877-6.414,6.414c0,3.535,2.879,6.414,6.414,6.414c1.288,0,2.485-0.385,3.491-1.041l4.618,4.617L22.09,21.01z
	 M13,17h-2v-3H8v-2h3V9h2v3h3v2h-3V17z"/>
</g>
</svg></div>
            <div id="b-zoomout" class="pf-control-bar-button pf-right" title="Zoom Out" style="display: none;"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                                                    x="0px" y="0px" width="26px" height="26px" viewBox="0 0 26 26" xml:space="preserve">
<g>
    <path d="M22.09,21.01l-4.643-4.641c0.609-0.98,0.967-2.133,0.967-3.369c0-3.537-2.877-6.414-6.414-6.414
	c-3.535,0-6.414,2.877-6.414,6.414c0,3.535,2.879,6.414,6.414,6.414c1.288,0,2.485-0.385,3.491-1.041l4.618,4.617L22.09,21.01z
	 M8,14v-2h8v2H8z"/>
</g>
</svg>
            </div>
        </div>
        <div class="pf-centered-buttons">
            <div id="b-first" class="pf-control-bar-button pf-disabled"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" width="26px" height="26px" viewBox="0 0 26 26" xml:space="preserve">
<g>
    <polygon points="9,13 17,21 19,19 13,13 19,7 17,5 	"/>
    <rect x="6.2" y="6" width="2.8" height="14"/>
</g>
</svg></div>
            <div id="b-prev" class="pf-control-bar-button pf-disabled"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            x="0px" y="0px" width="26px" height="26px" viewBox="0 0 26 26" xml:space="preserve">
<g>
    <polygon points="7,13 17,23 19,21 11,13 19,5 17,3 	"/>
</g>
</svg></div>
            <form id="pf-pfpager" class="pf-control-bar-pager">
                <input type="text" name="pagerin" id="pf-pagerin">
            </form>
            <div id="b-next" class="pf-control-bar-button pf-disabled"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            x="0px" y="0px" width="26px" height="26px" viewBox="0 0 26 26" xml:space="preserve">
<g>
    <polygon points="20,13 10,23 8,21 16,13 8,5 10,3 	"/>
</g>
</svg>
            </div>
            <div id="b-last" class="pf-control-bar-button pf-disabled"><svg version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            x="0px" y="0px" width="26px" height="26px" viewBox="0 0 26 26" xml:space="preserve">
<g>
    <polygon points="17,13 9,21 7,19 13,13 7,7 9,5 	"/>
    <rect x="17" y="6" width="2.8" height="14"/>
</g>
</svg></div>
        </div>
    </div>
        </div>
    </div>
<!--    <iframe src="/pageflip/pageflip/pageflip5_package_(fulltext_1_2019)/" frameborder="0" style="width: 100%; height: 500px"></iframe>-->
</section>
<section class="pt-3 pb-5 bg-color-lightergray">
    <div class="container-fluid">
        <div class="row printables-row">
            <!-- left column -->
            <div class="<?php if($pname[0]['noright']=='1') echo 'col-xl-12'; else echo 'col-xl-9';?> col-xs-12 pt-3 pb-3 pr-xl-4">
                <div class="container-fluid left-column-container">
                    <div class="row shadow border bg-white printables">
                        <?php if($pname[0]['nobreadcrumbs']==0): ?>
                        <div class="col-12 pt-3 printable-none">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <?php
                                    if($_GET[debug]==2) {
                                        echo $_TPL_REPLACMENT[BREADCRUMBS];
                                    } else {
                                        include($_TPL_REPLACMENT[BREADCRUMBS]);
                                    }?>
                                </ol>
                            </nav>
                        </div>
                        <?php endif;?>
                        <?php if($pname[0]['notop']==0): ?>
                        <div class="col-12 pt-3 pb-3">
                            <div class="container-fluid">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-lg-9 col-xs-12 printable-center">
                                        <div class="author-img-section d-none">
                                            <div class="author-img mr-2 d-inline-block align-middle" style="background-image: url('/newsite/img/18309_3.png')"></div><div class="d-inline-block align-middle"><a href=""><b class="font-italic">c.Ì.Ò. ŒÎÂ„ ƒ‡‚˚‰Ó‚</b></a></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-12 mt-3 mt-lg-0 printable-none">
                                        <div class="text-lg-right text-center">
                                            <?php if ($_SESSION[lang] != "/en"): ?>
                                                <?php if ($pname[0][page_template] != 'experts'):?>
                                                <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#" onclick='event.preventDefault(); window.print();' role="button">–‡ÒÔÂ˜‡Ú‡Ú¸</a>
                                                <?php endif;?>
                                            <?php else:?>
                                                <a class="btn btn-lg imemo-button text-uppercase imemo-print-button" href="#" onclick='event.preventDefault(); window.print();' role="button">Print</a>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 small">
                                        <?php
                                        if($pname[0]['notop']==0) {
                                            if ($_SESSION[lang] != "/en") {
                                                echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\">" . $_TPL_REPLACMENT["TITLE"] . "</h3>";

                                            } else {
                                                if ($_TPL_REPLACMENT["TITLE_EN"] != '') {
                                                    if ($_TPL_REPLACMENT["TITLE_EN"] == "News in detail") {
                                                        if ($_TPL_REPLACMENT["TITLE"] != '')
                                                            echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\">" . $_TPL_REPLACMENT["TITLE"] . "</h3>";
                                                        else
                                                            echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\">" . $_TPL_REPLACMENT["TITLE_EN"] . "</h3>";
                                                    } else {
                                                        echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\"'>" . $_TPL_REPLACMENT["TITLE_EN"] . "</h3>";
                                                    }
                                                } else
                                                    echo "<h3 class=\"pl-2 pr-2 pb-2 text-center border-bottom\"'>" . $_TPL_REPLACMENT["TITLE"] . "</h3>";


                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-12 pl-lg-5 pr-lg-5 pl-md-3 pr-md-3 pl-xs-2 pr-xs-2 pb-5 border-bottom text-content">
                        <?php
                        if ($pname[0]['activatestat'] == 1) {
                            Statistic::getAjaxViews("pageid", (int)$_REQUEST[page_id]);
                            echo "<div style='text-align: right; color: #979797;'><img width='15px' style='vertical-align: middle' src='/img/eye.png'/> <span id='stat-views-counter' style='vertical-align: middle'>".$all_views."</span></div>";
                        }
                        ?>
