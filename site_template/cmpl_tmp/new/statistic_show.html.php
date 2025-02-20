<?
global $_CONFIG, $site_templater, $DB;

?>
    <style>
        div#stats {
            text-align: center;
            padding: 100px;
            background-color: CCCCCC;
            margin: 0 300;
            /* vertical-align: middle; */
            display: block;
            border: 4px solid black;
            border-radius: 20px;
        }
        body {
            padding-top: 100px;
        }
        .rubrics_stats {
            text-align: center;
            padding: 20px 50px;
            background-color: CCCCCC;
            margin: 10px 15px;
            border: 4px solid black;
            border-radius: 20px;
        }
    </style>
<?php
$eng_stat = "";
//if($_GET[lang]=="en")
//    $eng_stat = "-en";
$date = date("Y-m-d");
if(!empty($_GET[stat_page])) {
    $page = $DB->select("SELECT page_id,page_name FROM adm_pages WHERE page_id=".(int)$_GET[stat_page]);
    Statistic::theStat("pageid-".(int)$_GET[stat_page].$eng_stat, $page);
}
elseif(!empty($_GET[stat_news_full])) {
    $page = $DB->select("SELECT ae.el_id AS newsfull_id,acn.icont_text AS page_name FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS acn ON ae.el_id=acn.el_id AND acn.icont_var='title' WHERE ae.el_id=".(int)$_GET[stat_news_full]);
    Statistic::theStat("newsfull-".(int)$_GET[stat_news_full].$eng_stat, $page);
}
elseif(!empty($_GET[stat_magarticle])) {
    $page = $DB->select("SELECT aa.page_id AS magarticle_id,aa.name AS page_name, aa.page_name AS reserve_name FROM adm_article AS aa WHERE aa.page_id=".(int)$_GET[stat_magarticle]);
    Statistic::theStat("magarticle-".(int)$_GET[stat_magarticle].$eng_stat, $page);
}
elseif(!empty($_GET[magazineid])) {
    $page = $DB->select("SELECT page_name, page_journame FROM adm_magazine WHERE page_id=".(int)$_GET[magazineid]." AND page_parent=0");
    Statistic::theStat($page[0]['page_journame'].$eng_stat, $page);
}
elseif(!empty($_GET[mainpage])) {
    $page[0]['page_name'] = "Общая статистика сайта";
    Statistic::theStat("all-web-site".$eng_stat, $page);
}

elseif(!empty($_GET[presscenter])) {
    $page[0]['page_name'] = "Статистика пресс-центра";
    Statistic::theStat("presscenter", $page);
}
elseif(!empty($_GET[stat_cerspecrub])) {
    $page = $DB->select("SELECT id AS cerspecrub_id,title AS page_name FROM cer_specrub WHERE id=".(int)$_GET[stat_cerspecrub]);
    Statistic::theStat("cerspecrub-".(int)$_GET[stat_cerspecrub].$eng_stat, $page);
}
else {
    echo '<div class="rubrics_stats">';
    echo "<p><b><a href=\"/index.php?page_id=".(int)$_GET[page_id]."&mainpage=1\">Общая статистика сайта</a></b></p>";
    echo "<br>";
    $pages = $DB->select("SELECT ap.page_id AS page_id, ap.page_name AS page_name FROM `magazine_visits` AS mv
							INNER JOIN adm_pages AS ap ON SUBSTRING(mv.magazine,8)=ap.page_id
							WHERE mv.magazine LIKE 'pageid-%' GROUP BY ap.page_id ORDER BY ap.page_name,ap.page_id");
    echo "<p><b>Страницы: </b></p>";
    echo "<br>";
    foreach ($pages as $key => $value) {
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET[page_id]."&stat_page=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
    }
    $magazines = $DB->select("SELECT page_name, page_id
								FROM  `adm_magazine` 
								WHERE page_parent =0
								AND page_journame !=  '' ORDER BY page_name, page_id");
    echo "<br>";
    echo "<p><b>Журналы: </b></p>";
    echo "<br>";
    foreach ($magazines as $key => $value) {
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET[page_id]."&magazineid=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
    }
    echo "<br>";
    echo "<p><b>Другое(в новой вкладке): </b></p>";
    echo "<br>";
    echo "<p><a target=\"_blank\" href=\"/index.php?page_id=1171\">Спецрубрики</a></p>";
    //echo "<p><a target=\"_blank\" href=\"/presscenter/?statistic=1\">Пресс-центр</a></p>";
    echo "<p><a href=\"/index.php?page_id=".(int)$_GET[page_id]."&presscenter=1\">Пресс-центр</a></p>";
    echo "<p><a target=\"_blank\" href=\"/energyeconomics/?statistic=1\">Центр энергетических исследований</a></p>";
    echo "<br>";
    echo "<p><b>Спецрубрики ЦЭИ: </b></p>";
    echo "<br>";
    $cer_specrub = $DB->select("SELECT id AS page_id, title AS page_name FROM cer_specrub ORDER BY title,id");
    foreach ($cer_specrub as $key => $value) {
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET[page_id]."&stat_cerspecrub=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
    }
    echo "<br>";
    echo "<p><b>Новости: </b></p>";
    echo "<br>";
    ?>
    <form method="get">
        <input type="hidden" name="page_id" value="<?=(int)$_GET[page_id]?>"/>
        <label for="stat_news_full">ID новости:</label>
        <input type="text" name="stat_news_full"/>
        <input type="submit"/>
    </form>

<?php
    echo "<br>";
    echo "<p><b>Статьи в журнале: </b></p>";
    echo "<br>";
    ?>
    <form method="get">
        <input type="hidden" name="page_id" value="<?=(int)$_GET[page_id]?>"/>
        <label for="stat_magarticle">ID статьи:</label>
        <input type="text" name="stat_magarticle"/>
        <input type="submit"/>
    </form>

    <?php
//    $newsfull = $DB->select("SELECT aci.el_id AS page_id, aci.icont_text AS page_name FROM `magazine_visits` AS mv
//							INNER JOIN adm_ilines_content AS aci ON SUBSTRING(mv.magazine,10)=aci.el_id AND aci.icont_var='title'
//							WHERE mv.magazine LIKE 'newsfull-%' GROUP BY aci.el_id ORDER BY aci.icont_text,aci.el_id LIMIT 10");
//    echo "<p><b>Новости: </b></p>";
//    echo "<br>";
//    foreach ($newsfull as $key => $value) {
//        echo "<p><a href=\"/index.php?page_id=".(int)$_GET[page_id]."&stat_news_full=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
//    }
//    echo "<br>";
//    $magarticle = $DB->select("SELECT aci.page_id AS page_id, aci.name AS page_name, aci.page_name AS reserve_name FROM `magazine_visits` AS mv
//							INNER JOIN adm_article AS aci ON SUBSTRING(mv.magazine,12)=aci.page_id
//							WHERE mv.magazine LIKE 'magarticle-%' GROUP BY aci.page_id ORDER BY aci.name,aci.page_id LIMIT 10");
//    echo "<p><b>Статьи в журнале: </b></p>";
//    echo "<br>";
//    foreach ($magarticle as $key => $value) {
//        if(empty($value[page_name])) $value[page_name]=$value[reserve_name];
//        echo "<p><a href=\"/index.php?page_id=".(int)$_GET[page_id]."&stat_magarticle=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
//    }
    echo '</div>';
}


