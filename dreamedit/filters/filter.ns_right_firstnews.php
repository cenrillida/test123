<?php

global $DB,$_CONFIG;

$news = new News();

$authorSelect = "";

if($_SESSION['lang']!="/en") {
    $headerText = "Актуальные комментарии";
} else {
    $headerText = "First news";
}

if(isset($_TPL_REPLACMENT["FIRSTNEWS_BY_AUTHORS"]) && $_TPL_REPLACMENT["FIRSTNEWS_BY_AUTHORS"]==1) {
    if(isset($_REQUEST['id'])) {
        $ilines = new Ilines();
        $newsElement = array();
        $newsElement[$_REQUEST['id']] = array();
        $newsElement = $ilines->appendContent($newsElement);

        $authors = explode("<br>",trim($newsElement[$_REQUEST['id']]['content']['PEOPLE']));
        //var_dump($authors);

        if($_SESSION['lang']!="/en") {
            $headerText = "Другие комментарии";
        } else {
            $headerText = "First news";
        }

        $authorSql = "";
        foreach($authors as $k=>$author)
        {
            if (!empty($author))
            {
                if (is_numeric($author))
                {
                    if(!empty($authorSql)) {
                        $authorSql.= " OR ";
                    }
                    $authorSql.="(p.icont_text LIKE '{$author}<br>%' OR p.icont_text LIKE '%<br>{$author}<br>%' OR p.icont_text LIKE '%<br>{$author}')";
                }
            }
        }
        if(!empty($authorSql)) {
            $authorSelect = " AND ({$authorSql}) AND c.el_id<>{$_REQUEST['id']}";
        }

        if(!empty($authorSelect)) {
            $firstNews = $news->getFirstNews(3, $authorSelect);
            if (!empty($firstNews)) {
                if ($_SESSION['lang'] != "/en") {
                    $headerText = "Другие комментарии автора";
                } else {
                    $headerText = "First news by author";
                }
            }
        }
    }

    ?>
    <div class="col-12 text-center mb-3">
        <h5 class="pl-2 pr-2 border-bottom text-uppercase"><?=$headerText?></h5>
    </div>
    <?php
}

$additionalSelect = "";

if(isset($_REQUEST['id']) && isset($_REQUEST['page_id']) && $_REQUEST['page_id']==1594) {
    $additionalSelect = " AND c.el_id<>{$_REQUEST['id']}";
}

if(empty($firstNews)) {
    $firstNews = $news->getFirstNews(3, $additionalSelect);
}

foreach ($firstNews as $key => $element) {
    $image = $element->getImageUrl();
    ?>
    <div class="col-12 col-md-4 col-xl-12 mb-3 text-center">
        <div class="card">
            <div class="position-relative">
                <?php if(!empty($image)):?>
                    <img class="card-img" src="<?=$image?>" alt="<?=$element->getImageAlt()?>">
                    <div class="position-absolute img-ton">
                        <div class="card-body text-white absolute-bottom w-100">
                            <a class="text-white" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$element->getId()?>"><h6 class="card-title card-comments-title"><?=$element->getTitle()?></h6></a>
                        </div>
                    </div>
                    <a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$element->getId()?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight hover-highlight-center-dark" draggable="true"></a>
                <?php else:?>
                    <div>
                        <div class="card-body w-100">
                            <a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$element->getId()?>"><h6 class="card-title card-comments-title"><?=$element->getTitle()?></h6></a>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php
}
?>