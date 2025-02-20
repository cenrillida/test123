<?php
    global $_CONFIG, $site_templater;

$cur_url = "https://";
// Append the host(domain name, ip) to the URL.
$cur_url.= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$cur_url.= $_SERVER['REQUEST_URI'];


$pg = new Pages();
$page_attr = $pg->getPageById($_REQUEST["page_id"]);
?>
<!DOCTYPE html>
<html lang="en" class="mdl-js"><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if($_SESSION["lang"]!="/en"):

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
        <meta name="sputnik-verification" content="h1w66kh0r6NSGwpt" />
        <meta name="yandex-verification" content="5981118f5fce54e6" />
        <meta name="keywords" content="<?=htmlspecialchars($keywords_seo)?>">
        <meta name="description" content="<?=htmlspecialchars($descr_seo)?>">
        <meta property="og:locale" content="ru_RU" />
        <meta property="og:site_name" content="ИМЭМО РАН | Официальный сайт" />
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

        if($page_attr['page_template']!='mag_archive') {
            ?>
            <meta name="keywords" content="<?=htmlspecialchars($keywords_seo)?>">
            <meta name="description" content="<?=htmlspecialchars($descr_seo)?>">
            <?php
        }

        if(empty($og_image)) {
            $og_image = "https://www.imemo.ru/files/Image/BRANDBOOK/logo_en.png";
        }

        ?>
        <meta property="og:locale" content="en_EN" />
        <meta property="og:site_name" content="IMEMO | Official Site" />
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="<?=htmlspecialchars($descr_seo)?>">
        <meta property="og:image" content="<?=$og_image?>">
        <meta property="og:video" content="<?=$og_video?>">
        <meta property="og:audio" content="<?=$og_audio?>">
        <meta property="og:url" content="<?=$cur_url?>">
    <?php endif;?>
    <meta name="author" content="">
    <?php
        if(!empty($_SESSION["jour"])) {

            $mz=new Magazine();

            $jour0=$mz->getMagazineByArticleId($_REQUEST["id"]);
            $article=$mz->getArticleById($_REQUEST["id"]);
            if($_SESSION["lang"]!="/en") {
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
            $vol_pos = strripos($article[0]["number"], "т.");
            if($vol_pos !== false) {
                $volume = substr($article[0]["number"], $vol_pos);
                if ($_SESSION["lang"] == '/en')
                    $volume = str_replace("т.", "", $volume);
                else
                    $volume = str_replace("т.", "", $volume);
                $number = spliti(",", $article[0]["number"]);
                $number = $number[0];
            } else {
                $number = $article[0]["number"];
                $volume = $article[0]["number"];
            }
            if (!isset($_REQUEST["en"]))
            {
                $people0=$mz->getAutors($article[0]["people"]);
            }
            else
            {
                $people0=$mz->getAutorsEn($article[0]["people"]);

            }
            if(!empty($article[0]['pages'])) {
                $jour_pages = spliti("-", $article[0]['pages']);
            }
            //var_dump($people0);
            if($page_attr["page_template"]=="magazine_article") {
                ?>
                <meta name="citation_journal_title" content="<?=htmlspecialchars($jour_name)?>">
                <meta name="citation_publisher" content="<?=htmlspecialchars($jour0[0]['publisher'])?>">
                <?php foreach ($people0 as $people):?>
                <?php if(!empty($people["id"])):?>
                        <?php if($_SESSION["lang"]!="/en"):?>
                <meta name="citation_author" content="<?=htmlspecialchars($people["fio_full_meta"])?>">
                        <?php else:?>
                            <meta name="citation_author" content="<?=htmlspecialchars($people["fio"])?>">
                        <?php endif;?>
                        <meta name="citation_author_email" content="<?=$people["mail1"]?>">
                <?php endif;?>
                <?php endforeach;?>
                <meta name="citation_author_institution" content="">
                <meta name="citation_title" content="<?=htmlspecialchars($title)?>">
                <meta name="citation_abstract" content="<?=htmlspecialchars($annots)?>">
                <meta name="citation_publication_date" content="<?=substr($article[0]['date'],0,4)?>/<?=substr($article[0]['date'],4,2)?>/<?=substr($article[0]['date'],6,2)?>">
                <meta name="citation_abstract_html_url" content="https://www.imemo.ru/jour/<?=$_SESSION["jour_url"]?>/index.php?page_id=<?=$_GET["page_id"]?>&id=<?=$_GET["id"]?>">
                <meta name="citation_online_date" content="<?=substr($article[0]['date'],0,4)?>/<?=substr($article[0]['date'],4,2)?>/<?=substr($article[0]['date'],6,2)?>">
                <meta name="citation_volume" content="<?=$volume?>">
                <meta name="citation_issue" content="<?=$number?>">
                <meta name="citation_firstpage" content="<?=$jour_pages[0]?>">
                <meta name="citation_lastpage" content="<?=$jour_pages[1]?>">
                <meta name="citation_doi" content="<?=$article[0]['doi']?>">
                <?php if($_SESSION["jour_url"]!="meimo" || $article[0]['fulltext_open']==1):?>
                <meta name="citation_fulltext_world_readable" content="">
                <?php endif;?>
                <meta name="citation_issn" content="<?=str_replace("ISSN ", "", $jour0[0]['issn'])?>">
                <meta name="citation_language" content="<?php if($_SESSION["lang"]!="/en") echo "ru_RU"; else echo "en_EN";?>">
                <meta name="citation_keywords" content="<?=htmlspecialchars($keyword)?>">
                <?php
            }
        }
    if($page_attr['page_template']=='mag_archive') {

        if(!empty($_REQUEST['article_id'])) {

            $article = new Article();

            $articleEl = $article->getPageById((int)$_REQUEST['article_id'],1);


            if(!empty($articleEl) && $articleEl['journal_new']==$_TPL_REPLACMENT["MAIN_JOUR_ID"] && $articleEl['page_template']=='jarticle') {
                $mz=new MagazineNew();

                $jour0=$mz->getMagazineByArticleId($_REQUEST["article_id"],null,null,null,$_TPL_REPLACMENT["MAIN_JOUR_ID"]);
                $article=$mz->getArticleById($_REQUEST["article_id"]);
                if($_SESSION["lang"]!="/en") {
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
                $vol_pos = strripos($article[0]["number"], "т.");
                if($vol_pos !== false) {
                    $volume = substr($article[0]["number"], $vol_pos);
                    if ($_SESSION["lang"] == '/en')
                        $volume = str_replace("т.", "", $volume);
                    else
                        $volume = str_replace("т.", "", $volume);
                    $number = spliti(",", $article[0]["number"]);
                    $number = $number[0];
                } else {
                    $number = $article[0]["number"];
                    $volume = $article[0]["number"];
                }
                if (!isset($_REQUEST["en"]))
                {
                    $people0=$mz->getAutors($article[0]["people"]);
                }
                else
                {
                    $people0=$mz->getAutorsEn($article[0]["people"]);

                }
                if(!empty($article[0]['pages'])) {
                    $jour_pages = spliti("-", $article[0]['pages']);
                }
                //var_dump($people0);
                    ?>
                    <meta name="citation_journal_title" content="<?=htmlspecialchars($jour_name)?>">
                    <meta name="citation_publisher" content="<?=htmlspecialchars($jour0[0]['publisher'])?>">
                    <?php foreach ($people0 as $people):?>
                        <?php if(!empty($people["id"])):?>
                            <?php if($_SESSION["lang"]!="/en"):?>
                                <meta name="citation_author" content="<?=htmlspecialchars($people["fio_full_meta"])?>">
                            <?php else:?>
                                <meta name="citation_author" content="<?=htmlspecialchars($people["fio"])?>">
                            <?php endif;?>
                            <meta name="citation_author_email" content="<?=$people["mail1"]?>">
                        <?php endif;?>
                    <?php endforeach;?>
                    <meta name="citation_author_institution" content="">
                    <meta name="citation_title" content="<?=htmlspecialchars($title)?>">
                    <meta name="citation_abstract" content="<?=htmlspecialchars($annots)?>">
                    <meta name="citation_publication_date" content="<?=substr($article[0]['date'],0,4)?>/<?=substr($article[0]['date'],4,2)?>/<?=substr($article[0]['date'],6,2)?>">
                    <meta name="citation_abstract_html_url" content="https://www.imemo.ru/index.php?page_id=<?=$_REQUEST["page_id"]?>&article_id=<?=$_GET["article_id"]?>">
                    <meta name="citation_online_date" content="<?=substr($article[0]['date'],0,4)?>/<?=substr($article[0]['date'],4,2)?>/<?=substr($article[0]['date'],6,2)?>">
                    <meta name="citation_volume" content="<?=$volume?>">
                    <meta name="citation_issue" content="<?=$number?>">
                    <meta name="citation_firstpage" content="<?=$jour_pages[0]?>">
                    <meta name="citation_lastpage" content="<?=$jour_pages[1]?>">
                    <meta name="citation_doi" content="<?=$article[0]['doi']?>">
                    <?php if($_TPL_REPLACMENT["MAIN_JOUR_ID"]!=1614 || $article[0]['fulltext_open']==1):?>
                        <meta name="citation_fulltext_world_readable" content="">
                    <?php endif;?>
                    <meta name="citation_issn" content="<?=str_replace("ISSN ", "", $jour0[0]['issn'])?>">
                    <meta name="citation_language" content="<?php if($_SESSION["lang"]!="/en") echo "ru_RU"; else echo "en_EN";?>">
                    <meta name="citation_keywords" content="<?=htmlspecialchars($keyword)?>">
                    <meta name="keywords" content="<?=htmlspecialchars($keyword)?>">
                    <meta name="description" content="<?=htmlspecialchars($annots." DOI: ".$article[0]['doi'])?>">
                    <?php

            } else {
                ?>
                <meta name="keywords" content="<?=htmlspecialchars($keywords_seo)?>">
                <meta name="description" content="<?=htmlspecialchars($descr_seo)?>">
                <?php
            }


        }

    }

    ?>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=zX7alnNkgg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=zX7alnNkgg">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=zX7alnNkgg">
    <link rel="manifest" href="/site.webmanifest?v=zX7alnNkgg">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=zX7alnNkgg" color="#002745">
    <link rel="shortcut icon" href="/favicon.ico?v=zX7alnNkgg">
    <meta name="apple-mobile-web-app-title" content="ИМЭМО РАН">
    <meta name="application-name" content="ИМЭМО РАН">
    <meta name="msapplication-TileColor" content="#002745">
    <meta name="theme-color" content="#ffffff">

    <?php if ($_SESSION["lang"]!="/en"):
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

    <link rel="stylesheet" href="/newsite/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="/newsite/photoswipe/default-skin/default-skin.css">
    <link rel="stylesheet" href="/newsite/css/swiper-bundle.min.css" />
    <link href="/newsite/css/start/jquery-ui.min.css" rel="stylesheet">
    <link href="/newsite/css/start/theme.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="/newsite/css/bootstrap.min.css?v=2" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="/newsite/css/dncalendar-skin.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/newsite/css/carousel.css">
    <link href="/newsite/css/product.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/product.css");?>" rel="stylesheet">
    <?php if(!empty($_TPL_REPLACMENT['CUSTOM_LOGO'])):
        preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT['CUSTOM_LOGO'], $customLogo);

        $customLogo = array_pop($customLogo);
        if(!empty($customLogo[0])) {
            $customLogo = $customLogo[0];
        }

        preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT['CUSTOM_LOGO_S'], $customLogoSmall);

        $customLogoSmall = array_pop($customLogoSmall);
        if(!empty($customLogoSmall[0])) {
            $customLogoSmall = $customLogoSmall[0];
        }
        ?>
        <style>
            .menu-logo-jour span {
                background-image: url('<?=$customLogoSmall?>');
                width: <?=$_TPL_REPLACMENT['CUSTOM_LOGO_S_W']?>px;
            }
            @media (min-width: <?php echo $_TPL_REPLACMENT['CUSTOM_LOGO_W']+100;?>px) {
                .menu-logo-jour span {
                    background-image: url('<?=$customLogo?>');
                    width: <?=$_TPL_REPLACMENT['CUSTOM_LOGO_W']?>px;
                }
            }
        </style>
    <?php endif;?>
    <?php if(!empty($_TPL_REPLACMENT['MENU_GRADIENT_1']) && !empty($_TPL_REPLACMENT['MENU_GRADIENT_2'])):?>
        <style>
            .site-header {
                background-image: -webkit-linear-gradient(top,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
                background-image: -o-linear-gradient(top,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
                background-image: -webkit-gradient(linear,left top,left bottom,from(<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?>),to(<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?>));
                background-image: linear-gradient(to bottom,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
            }
            .site-header-gray {
                background: #e8e8e8;
            }

            .site-header a.active {
                background-image: -webkit-linear-gradient(top,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
                background-image: -o-linear-gradient(top,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
                background-image: -webkit-gradient(linear,left top,left bottom,from(<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?>),to(<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?>));
                background-image: linear-gradient(to bottom,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
            }
            .site-header a:hover {
                color: #fff;
                text-decoration: none;
                background-image: -webkit-linear-gradient(top,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
                background-image: -o-linear-gradient(top,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
                background-image: -webkit-gradient(linear,left top,left bottom,from(<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?>),to(<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?>));
                background-image: linear-gradient(to bottom,<?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> 0,<?=$_TPL_REPLACMENT['MENU_GRADIENT_2']?> 100%);
            }

            .site-header-gray a:hover {
                background-image: -webkit-linear-gradient(top,#b7b7b7 0,#d2d2d2 100%);
                background-image: -o-linear-gradient(top,#b7b7b7 0,#d2d2d2 100%);
                background-image: -webkit-gradient(linear,left top,left bottom,from(#b7b7b7),to(#d2d2d2));
                background-image: linear-gradient(to bottom,#b7b7b7 0,#d2d2d2 100%);
            }
            .b-page_newyear {
                background-color: <?=$_TPL_REPLACMENT['MENU_GRADIENT_1']?> !important;
            }
        </style>
    <?php endif;?>
    <?php if(!empty($_TPL_REPLACMENT['MENU_IMAGE'])):?>
        <style>
            .site-header-main {
                background-image: url('<?=$_TPL_REPLACMENT['MENU_IMAGE']?>') !important;
            }
        </style>
    <?php endif;?>
    <?php if(!empty($_TPL_REPLACMENT['MENU_TEXT_COLOR'])):?>
        <style>
            .site-header a {
                color: <?=$_TPL_REPLACMENT['MENU_TEXT_COLOR']?>;
            }
            .site-header a:hover {
                color: <?=$_TPL_REPLACMENT['MENU_TEXT_COLOR']?>;
            }
        </style>
    <?php endif;?>
    <?php if(!empty($_TPL_REPLACMENT['MENU_CUSTOM_FONT'])):?>
        <style>
            .site-header a {
                font-family: <?=$_TPL_REPLACMENT['MENU_CUSTOM_FONT']?>;
            }
        </style>
    <?php endif;?>
    <?php if(!empty($_TPL_REPLACMENT['MENU_CUSTOM_FONT_SIZE'])):?>
        <style>
            .site-header a {
                font-size: <?=$_TPL_REPLACMENT['MENU_CUSTOM_FONT_SIZE']?>px;
            }
        </style>
    <?php endif;?>
    <?php if($_GET["newyear"]==1):?>
    <link href="/newsite/css/snow.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/snow.css");?>" rel="stylesheet">
    <link href="/newsite/style.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/style.css");?>" rel="stylesheet">
    <?php endif;?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <?php
    if($_GET["debug_font"]==1) {
        ?>
        <link href="https://fonts.googleapis.com/css?family=Arya:400,700|Istok+Web:400,400i,700,700i|Playfair+Display+SC:400,400i,700,700i|Playfair+Display:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i|Roboto:400,400i,700,700i|Stardos+Stencil:400,700&amp;subset=cyrillic" rel="stylesheet">
        <?php
    }

    ?>
    <script src="/newsite/js/jquery-3.3.1.min.js"></script>
    <script src="/newsite/js/jquery-ui.min.js"></script>
    <script src="/newsite/js/funcs.js"></script>
    <?php
    if($_SESSION["jour_url"]=='meimo') {
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
                location.replace("https://www.imemo.ru<?=$_SESSION["lang"]?>/jour/meimo/index.php?page_id=682");
                return false;

            }
        </script>
        <?
    }
    ?>
    <script src='https://www.google.com/recaptcha/api.js?hl=<?php if($_SESSION["lang"]=="/en") echo "en"; else echo "ru";?>'></script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Website",
            "name": "<?=htmlspecialchars($title_seo)?>",
            "image": "<?=$og_image?>",
            "description": "<?=htmlspecialchars($descr_seo)?>"
        }
    </script>
    <script src="/newsite/js/top.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/top.js");?>"></script>
</head>
<body>
<?php if($_GET["newyear"]==1):?>
    <!-- новогодняя мотня 2.1 -->
    <div class="b-page_newyear">
        <div class="b-page__content">
            <i class="b-head-decor">
                <i class="b-head-decor__inner b-head-decor__inner_n1">
                    <div class="b-ball b-ball_n1 b-ball_bounce" data-note="0"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n2 b-ball_bounce" data-note="1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n3 b-ball_bounce" data-note="2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n4 b-ball_bounce" data-note="3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n5 b-ball_bounce" data-note="4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n6 b-ball_bounce" data-note="5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n7 b-ball_bounce" data-note="6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n8 b-ball_bounce" data-note="7"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n9 b-ball_bounce" data-note="8"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                </i>
                <i class="b-head-decor__inner b-head-decor__inner_n2">
                    <div class="b-ball b-ball_n1 b-ball_bounce" data-note="9"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n2 b-ball_bounce" data-note="10"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n3 b-ball_bounce" data-note="11"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n4 b-ball_bounce" data-note="12"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n5 b-ball_bounce" data-note="13"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n6 b-ball_bounce" data-note="14"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n7 b-ball_bounce" data-note="15"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n8 b-ball_bounce" data-note="16"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n9 b-ball_bounce" data-note="17"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                </i>
                <i class="b-head-decor__inner b-head-decor__inner_n3">
                    <div class="b-ball b-ball_n1 b-ball_bounce" data-note="18"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n2 b-ball_bounce" data-note="19"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n3 b-ball_bounce" data-note="20"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n4 b-ball_bounce" data-note="21"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n5 b-ball_bounce" data-note="22"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n6 b-ball_bounce" data-note="23"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n7 b-ball_bounce" data-note="24"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n8 b-ball_bounce" data-note="25"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n9 b-ball_bounce" data-note="26"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                </i>
                <i class="b-head-decor__inner b-head-decor__inner_n4">
                    <div class="b-ball b-ball_n1 b-ball_bounce" data-note="27"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n2 b-ball_bounce" data-note="28"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n3 b-ball_bounce" data-note="29"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n4 b-ball_bounce" data-note="30"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n5 b-ball_bounce" data-note="31"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n6 b-ball_bounce" data-note="32"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n7 b-ball_bounce" data-note="33"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n8 b-ball_bounce" data-note="34"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n9 b-ball_bounce" data-note="35"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                </i>
                <i class="b-head-decor__inner b-head-decor__inner_n5">
                    <div class="b-ball b-ball_n1 b-ball_bounce" data-note="0"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n2 b-ball_bounce" data-note="1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n3 b-ball_bounce" data-note="2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n4 b-ball_bounce" data-note="3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n5 b-ball_bounce" data-note="4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n6 b-ball_bounce" data-note="5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n7 b-ball_bounce" data-note="6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n8 b-ball_bounce" data-note="7"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n9 b-ball_bounce" data-note="8"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                </i>
                <i class="b-head-decor__inner b-head-decor__inner_n6">
                    <div class="b-ball b-ball_n1 b-ball_bounce" data-note="9"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n2 b-ball_bounce" data-note="10"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n3 b-ball_bounce" data-note="11"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n4 b-ball_bounce" data-note="12"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n5 b-ball_bounce" data-note="13"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n6 b-ball_bounce" data-note="14"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n7 b-ball_bounce" data-note="15"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n8 b-ball_bounce" data-note="16"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n9 b-ball_bounce" data-note="17"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                </i>
                <i class="b-head-decor__inner b-head-decor__inner_n7">
                    <div class="b-ball b-ball_n1 b-ball_bounce" data-note="18"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n2 b-ball_bounce" data-note="19"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n3 b-ball_bounce" data-note="20"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n4 b-ball_bounce" data-note="21"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n5 b-ball_bounce" data-note="22"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n6 b-ball_bounce" data-note="23"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n7 b-ball_bounce" data-note="24"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n8 b-ball_bounce" data-note="25"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_n9 b-ball_bounce" data-note="26"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i1"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i2"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i3"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i4"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i5"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                    <div class="b-ball b-ball_i6"><div class="b-ball__right"></div><div class="b-ball__i"></div></div>
                </i>
            </i>
        </div>
    </div>
<?php endif;?>
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

if($_TPL_REPLACMENT['NO_MENU']!=1) {
    if (empty($_SESSION["jour"])) {
        if(!empty($_TPL_REPLACMENT['MAG_HEADER'])) {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "menu");
        } else {
            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "menu");
        }

    } else {
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "menu_jour");
    }
}


?>