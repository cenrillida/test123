<?
global $DB,$_CONFIG, $site_templater;
//echo $_TPL_REPLACMENT["TITLE_EN"];

$cur_url = "https://";
// Append the host(domain name, ip) to the URL.
$cur_url.= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$cur_url.= $_SERVER['REQUEST_URI'];


$pg = new Pages();
$page_attr = $pg->getPageById($_REQUEST["page_id"]);
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
        <meta property="og:site_name" content="ÈÌÝÌÎ ÐÀÍ | Îôèöèàëüíûé ñàéò" />
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
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=zX7alnNkgg">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=zX7alnNkgg">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=zX7alnNkgg">
        <link rel="manifest" href="/site.webmanifest?v=zX7alnNkgg">
        <link rel="mask-icon" href="/safari-pinned-tab.svg?v=zX7alnNkgg" color="#002745">
        <link rel="shortcut icon" href="/favicon.ico?v=zX7alnNkgg">
        <meta name="apple-mobile-web-app-title" content="ÈÌÝÌÎ ÐÀÍ">
        <meta name="application-name" content="ÈÌÝÌÎ ÐÀÍ">
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

        <link rel="stylesheet" type="text/css" href="/newsite/css/jcarousel.connected-carousels.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/jcarousel.connected-carousels.css");?>">
        <link href="/newsite/css/product.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/product.css");?>" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <?php
        if($_GET[debug_font]==1) {
            ?>
            <link href="https://fonts.googleapis.com/css?family=Arya:400,700|Istok+Web:400,400i,700,700i|Playfair+Display+SC:400,400i,700,700i|Playfair+Display:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i|Roboto:400,400i,700,700i|Stardos+Stencil:400,700&amp;subset=cyrillic" rel="stylesheet">
            <?php
        }
        ?>
        <script src="/newsite/js/jquery-3.3.1.min.js"></script>
    <script src="/newsite/js/funcs.js"></script>

        <script type="text/javascript" src="/newsite/js/jquery.jcarousel.min.js"></script>
        <script type="text/javascript" src="/newsite/js/jcarousel.connected-carousels.js"></script>
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
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "menu_presscenter");
?>

<?php



$dd=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
if (!empty($_REQUEST[id]) && substr($dd[0][page_template],0,8)=='magazine' && $dd[0][page_template]!='magazine_author')
{
    $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,IFNULL(m.page_name,'') AS mname,IFNULL(m.page_name_en,'') AS mname_en FROM adm_pages AS p 
	 LEFT OUTER JOIN adm_magazine AS m ON m.page_id=".(int)$_REQUEST[id].
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
        $_TPL_REPLACMENT["TITLE"]='Íîâîñòè ÔÀÍÎ Ðîññèè';
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
//Statistic::theCounter("presscenter");
Statistic::ajaxCounter("presscenter");
$all_views = Statistic::getAllViews("presscenter");

?>