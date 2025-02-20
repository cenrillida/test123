<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";
global $DB;

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
        .rubrics_stats {
            text-align: center;
            padding: 20px 50px;
            background-color: CCCCCC;
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
    Statistic::theStatAdmin("pageid-".(int)$_GET[stat_page].$eng_stat, $page);
}
elseif(!empty($_GET[stat_news_full])) {
    $page = $DB->select("SELECT ae.el_id AS newsfull_id,acn.icont_text AS page_name FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS acn ON ae.el_id=acn.el_id AND acn.icont_var='title' WHERE ae.el_id=".(int)$_GET[stat_news_full]);
    Statistic::theStatAdmin("newsfull-".(int)$_GET[stat_news_full].$eng_stat, $page);
}
elseif(!empty($_GET[stat_magarticle])) {
    $page = $DB->select("SELECT aa.page_id AS magarticle_id,aa.name AS page_name, aa.page_name AS reserve_name FROM adm_article AS aa WHERE aa.page_id=".(int)$_GET[stat_magarticle]);
    Statistic::theStatAdmin("magarticle-".(int)$_GET[stat_magarticle].$eng_stat, $page);
}
elseif(!empty($_GET[magazineid])) {
    $page = $DB->select("SELECT page_name, page_journame FROM adm_magazine WHERE page_id=".(int)$_GET[magazineid]." AND page_parent=0");
    Statistic::theStatAdmin($page[0]['page_journame'].$eng_stat, $page);
}
elseif(!empty($_GET[mainpage])) {
    $page[0]['page_name'] = "Общая статистика сайта";
    Statistic::theStatAdmin("all-web-site".$eng_stat, $page);
}

elseif(!empty($_GET[presscenter])) {
    $page[0]['page_name'] = "Статистика пресс-центра";
    Statistic::theStatAdmin("presscenter", $page);
}
elseif(!empty($_GET[stat_specrub])) {
    $page = $DB->select("SELECT ae.el_id AS specrub_id,acn.icont_text AS page_name FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS acn ON ae.el_id=acn.el_id AND acn.icont_var='title' WHERE ae.el_id=".(int)$_GET[stat_specrub]);
    Statistic::theStatAdmin("specrub-".(int)$_GET[stat_specrub].$eng_stat, $page);
}
elseif(!empty($_GET[stat_cerspecrub])) {
    $page = $DB->select("SELECT id AS cerspecrub_id,title AS page_name FROM cer_specrub WHERE id=".(int)$_GET[stat_cerspecrub]);
    Statistic::theStatAdmin("cerspecrub-".(int)$_GET[stat_cerspecrub].$eng_stat, $page);
}
elseif(!empty($_GET[stat_os])) {
    echo "<p><a href=\"/dreamedit/index.php?mod=statistic\">К списку страниц</a></p>";
    Statistic::thePieOs("1");
    Statistic::thePieOs("2",true);
    Statistic::thePieDevice("3");
    Statistic::thePieBrowser("4");
}
elseif(!empty($_GET[count_stat])) {
    echo "<p><a href=\"/dreamedit/index.php?mod=statistic\">К списку страниц</a></p>";
    Statistic::theActiveElementsCount();
}
else {

    echo '<div class="rubrics_stats">';
    echo "<p><b><a href=\"/dreamedit/index.php?mod=statistic&count_stat=1\">Количество активных элементов</a></b></p>";
    echo "<p><b><a href=\"/dreamedit/index.php?mod=statistic&stat_os=1\">Статистика по устройствам и браузерам</a></b></p>";
    echo "<p><b><a href=\"/dreamedit/index.php?mod=statistic&mainpage=1\">Общая статистика сайта</a></b></p>";
    echo "<br>";
    $pages = Statistic::getPagesList();
    echo "<p><b>Страницы: </b></p>";
    echo "<br>";
    foreach ($pages as $key => $value) {
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic&stat_page=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
    }
    $magazines = $DB->select("SELECT page_name, page_id
								FROM  `adm_magazine` 
								WHERE page_parent =0
								AND page_journame !=  '' ORDER BY page_name, page_id");
    echo "<br>";
    echo "<p><b>Журналы: </b></p>";
    echo "<br>";
    foreach ($magazines as $key => $value) {
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic&magazineid=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
    }
    echo "<br>";
    echo "<p><b>Другое(в новой вкладке): </b></p>";
    echo "<br>";
    //echo "<p><a target=\"_blank\" href=\"/presscenter/?statistic=1\">Пресс-центр</a></p>";
    echo "<p><a href=\"/dreamedit/index.php?mod=statistic&presscenter=1\">Пресс-центр</a></p>";
    echo "<p><a target=\"_blank\" href=\"/energyeconomics/?statistic=1\">Центр энергетических исследований</a></p>";
    echo "<br>";
    echo "<p><b>Спецрубрики: </b></p>";
    echo "<br>";
    $specrubrics = $DB->select("SELECT page_id AS ARRAY_KEY, page_id AS id,page_name AS rubric
                FROM adm_pages
               WHERE page_template='specrub_page'
                 ORDER BY page_name");
    foreach ($specrubrics as $key => $value) {
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic&stat_specrub=".$value[id]."\">".$value[rubric]." (ID: ".$value[id].")</a></p>";
    }
    echo "<br>";
    echo "<p><b>Спецрубрики (старые): </b></p>";
    echo "<br>";
//    $specrubrics = $DB->select("SELECT l.el_id AS ARRAY_KEY, l.el_id AS id,l.icont_text AS rubric
//                FROM adm_ilines_type AS c
//               INNER JOIN adm_ilines_element AS e ON e.itype_id=c.itype_id AND e.itype_id=13
//               INNER JOIN adm_ilines_content AS l ON l.el_id=e.el_id AND l.icont_var= 'title'
//               INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var= 'sort'
//                 ORDER BY l.icont_text");
//    echo "<div>";
//    foreach ($specrubrics as $key => $value) {
//        echo "<p><a href=\"/dreamedit/index.php?mod=statistic&stat_specrub=".$value[id]."\">".$value[rubric]." (ID: ".$value[id].")</a></p>";
//    }
//    echo "</div>";
    ?>
    <div><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=2296">Актуальные тенденции Европейского союза (ID: 2296)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=2830">Африка: комментарий эксперта (рубрика создана в сотрудничестве с Институтом Африки РАН) (ID: 2830)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=3588">Библиотека Пагуошского комитета (ID: 3588)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=5070">Выборы в Европарламент  (ID: 5070)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=5816">Мировой рынок нефти (ID: 5816)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=5787">Пандемия коронавируса  COVID-19 (ID: 5787)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=2147">Президентские выборы в США 2016 (ID: 2147)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=5634">США: выборы 2020 (ID: 5634)</a></p><p><a href="/dreamedit/index.php?mod=statistic&amp;stat_specrub=4429">Тихоокеанская Азия в фокусе внимания (ID: 4429)</a></p></div>
    <?php
    echo "<br>";
    echo "<p><b>Спецрубрики ЦЭИ: </b></p>";
    echo "<br>";
    $cer_specrub = $DB->select("SELECT id AS page_id, title AS page_name FROM cer_specrub ORDER BY title,id");
    foreach ($cer_specrub as $key => $value) {
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic&stat_cerspecrub=".$value[page_id]."\">".$value[page_name]." (ID: ".$value[page_id].")</a></p>";
    }
    echo "<br>";
    echo "<p><b>Новости: </b></p>";
    echo "<br>";
    ?>
    <form method="get">
        <input type="hidden" name="mod" value="statistic"/>
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
        <input type="hidden" name="mod" value="statistic"/>
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
