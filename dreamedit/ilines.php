<?php
//Для дублирования ilines по типу
//    include_once dirname(__FILE__)."/_include.php";
//    $copy_array = $DB->select("SELECT ae.el_id AS el_id, ac.icont_var AS icont_var, ac.icont_text AS icont_text FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ae.el_id=ac.el_id WHERE ae.itype_id=19");
//
//    foreach ($copy_array as $k => $v) {
//        $temp_array[$v['el_id']][$v['icont_var']] = $v['icont_text'];
//    }
//
//    var_dump($copy_array);
//
//    foreach($temp_array as $k => $v)
//    {
//        $lid = $DB->query("INSERT INTO adm_ilines_element SET itype_id = 43, el_date = UNIX_TIMESTAMP()");
//
//        foreach ($temp_array[$k] as $field => $val) {
//            $DB->query("INSERT INTO adm_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, $field, $val);
//        }
//
//    }
//Для дублирования headers по типу
/*include_once dirname(__FILE__)."/_include.php";
$copy_array = $DB->select("SELECT ae.el_id AS el_id, ac.icont_var AS icont_var, ac.icont_text AS icont_text FROM adm_headers_element AS ae INNER JOIN adm_headers_content AS ac ON ae.el_id=ac.el_id WHERE ae.itype_id=80");

foreach ($copy_array as $k => $v) {
    $temp_array[$v['el_id']][$v['icont_var']] = $v['icont_text'];
}

var_dump($copy_array);

foreach($temp_array as $k => $v)
{
    $lid = $DB->query("INSERT INTO adm_headers_element SET itype_id = 103, el_date = UNIX_TIMESTAMP()");

    foreach ($temp_array[$k] as $field => $val) {
        $DB->query("INSERT INTO adm_headers_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, $field, $val);
    }

}*/
//Для удаления по году и типу
    /*include_once dirname(__FILE__)."/_include.php";
    $delete_ids= $DB->select("SELECT ac.el_id FROM `adm_ilines_content` AS ac
INNER JOIN adm_ilines_element AS ae ON ac.el_id=ae.el_id
WHERE ae.itype_id=9 AND (SUBSTR(ac.icont_text,1,7)='2017.01' OR SUBSTR(ac.icont_text,1,7)='2017.02' OR SUBSTR(ac.icont_text,1,7)='2017.03' OR SUBSTR(ac.icont_text,1,7)='2017.04' OR SUBSTR(ac.icont_text,1,7)='2017.05' OR SUBSTR(ac.icont_text,1,7)='2017.06') AND ac.icont_var='date'");

    foreach ($delete_ids as $k => $v) {
        $DB->query("DELETE FROM adm_ilines_content WHERE el_id=".$v['el_id']);
        $DB->query("DELETE FROM adm_ilines_element WHERE el_id=".$v['el_id']);
    }*/

    // Для ссылок в "СМИ о примаковских чтениях"
/*include_once dirname(__FILE__)."/_include.php";

$links = $DB->select("SELECT ac.el_id, ac.icont_text as full_text FROM `adm_ilines_content` AS ac
INNER JOIN adm_ilines_element AS ae ON ac.el_id=ae.el_id
WHERE ae.itype_id=29 AND ac.icont_var='full_text'");

foreach ($links as $link) {
    $match = array();
    $url   = preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $link['full_text'], $match);
    //var_dump($url);
    //var_dump($link[el_id]);
    //var_dump($match[2][0]);
    $start_symbol = mb_strpos($link['full_text'],'<p><a href=');
    if(!$start_symbol) {
        $start_symbol = mb_strpos($link['full_text'],'<p>&nbsp;<a href=');
        if(!$start_symbol) {
            $start_symbol = mb_strpos($link['full_text'],'<div><a href=');
            if(!$start_symbol)
                $start_symbol = mb_strpos($link['full_text'],'<div>&nbsp;<a href=');
        }
    }
    //var_dump(mb_substr($link['full_text'],$start_symbol));
    //$DB->query("UPDATE adm_ilines_content SET icont_text = ? WHERE icont_var = 'full_text' AND el_id = ?", mb_substr($link['full_text'],0,$start_symbol), $link[el_id]);
    //var_dump($start_symbol);
    //$DB->query("UPDATE adm_ilines_content SET icont_text = ? WHERE icont_var = 'link' AND el_id = ?", $match[2][0], $link[el_id]);
    //$DB->query("INSERT INTO adm_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $link[el_id], "link", $match[2][0]);
}*/

//Профиль в Orcid
/*
include_once dirname(__FILE__)."/_include.php";

$profiles = $DB->select("SELECT id,about FROM persons WHERE about COLLATE cp1251_general_cs LIKE '%Профиль автора в Orcid%'");

foreach ($profiles as $profile) {
    $new_about = str_replace("Профиль автора в Orcid","Профиль автора в ORCID", $profile[about]);
    var_dump($new_about);
    //var_dump(mb_substr($link['full_text'],$start_symbol));
    $DB->query("UPDATE persons SET about = ? WHERE id = ?", $new_about, $profile[id] );
    //var_dump($start_symbol);
    //$DB->query("UPDATE adm_ilines_content SET icont_text = ? WHERE icont_var = 'link' AND el_id = ?", $match[2][0], $link[el_id]);
    //$DB->query("INSERT INTO adm_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $link[el_id], "link", $match[2][0]);
}*/

// ТОП новостей
/*include_once dirname(__FILE__)."/_include.php";

function getTopNews($interval,$lang="") {
    global $DB;
    if($lang=="-en") {
        $not = "";
    } else {
        $not = " NOT";
    }
    $news = $DB->select("SELECT mv.magazine,SUM(mv.views) AS sumviews,SUBSTR(mv.magazine,10) AS news_id
                        FROM magazine_visits AS mv
                        INNER JOIN adm_ilines_content AS ac ON SUBSTR(mv.magazine,10)=ac.el_id AND ac.icont_var='status'
                        WHERE mv.magazine LIKE 'newsfull-%' AND mv.magazine".$not." LIKE '%-en' AND mv.date>=DATE_SUB(CURDATE(), INTERVAL ".$interval." DAY) AND ac.icont_text='1'
                        GROUP BY mv.magazine 
                        ORDER BY sumviews DESC 
                        LIMIT 5");

    $counter=1;
    foreach ($news as $news_element) {
        $DB->query("INSERT INTO page_rating SET news_id = ?d, page_type = ?, interval_days = ?d, place = ?d", $news_element['news_id'], "newsfull".$lang, $interval, $counter);
        $counter++;
    }
}

$DB->query("TRUNCATE TABLE page_rating");

getTopNews(30);
getTopNews(7);
getTopNews(0);
getTopNews(30,"-en");
getTopNews(7,"-en");
getTopNews(0,"-en");*/



//Для дублирования ilines видео
/*
include_once dirname(__FILE__)."/_include.php";
$copy_array = $DB->select("SELECT ae.el_id AS el_id, ac.icont_var AS icont_var, ac.icont_text AS icont_text FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ae.el_id=ac.el_id WHERE ae.itype_id=11");

$all_titles_find = $DB->select("SELECT ae.el_id,t.icont_text,yu.icont_text AS url FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS t ON ae.el_id=t.el_id AND t.icont_var='title' INNER JOIN adm_ilines_content AS yu ON ae.el_id=yu.el_id AND yu.icont_var='youtube_url' WHERE ae.itype_id=11");
$all_titles = $DB->select("SELECT ae.el_id AS ARRAY_KEY,t.icont_text,yu.icont_text AS url FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS t ON ae.el_id=t.el_id AND t.icont_var='title' INNER JOIN adm_ilines_content AS yu ON ae.el_id=yu.el_id AND yu.icont_var='youtube_url' WHERE ae.itype_id=10");

//var_dump($all_titles);

$excludes = array();

foreach ($all_titles_find as $item) {
    foreach ($all_titles as $title) {
        if($title['icont_text']==$item['icont_text'] && $title['url']==$item['url']) {
            $excludes[] = $item['el_id'];
        }
    }
}
//var_dump(in_array("22552",$excludes));

foreach ($copy_array as $k => $v) {
    if(in_array($v['el_id'],$excludes)) {
        continue;
    }
    $temp_array[$v['el_id']][$v['icont_var']] = $v['icont_text'];
}

//var_dump($copy_array);

foreach($temp_array as $k => $v)
{
    $lid = $DB->query("INSERT INTO adm_ilines_element SET itype_id = 10, el_date = UNIX_TIMESTAMP()");

    foreach ($temp_array[$k] as $field => $val) {
        $DB->query("INSERT INTO adm_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, $field, $val);
    }
    $DB->query("INSERT INTO adm_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, "people", "1<br>");

}


//Для person  в видео
/*include_once dirname(__FILE__)."/_include.php";
$copy_array = $DB->select("SELECT ae.el_id AS el_id, ac.icont_var AS icont_var, ac.icont_text AS icont_text FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ae.el_id=ac.el_id WHERE ae.itype_id=10");

$videos = $DB->select("SELECT ae.el_id,t.icont_text,yu.icont_text AS url FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS t ON ae.el_id=t.el_id AND t.icont_var='url' INNER JOIN adm_ilines_content AS yu ON ae.el_id=yu.el_id AND yu.icont_var='youtube_url' WHERE ae.itype_id=10");

//var_dump($all_titles);

$excludes = array();


foreach ($videos as $item) {
    preg_match_all("/&id=(\d+)/i",$item['icont_text'],$ids);
    if(!empty($ids[1][0])) {
        $news = $DB->select("SELECT ft.icont_text FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ft ON ft.el_id=ae.el_id AND ft.icont_var='full_text' WHERE ae.el_id=".$ids[1][0]);
        preg_match_all("/page_id=555&(amp;)?id=(\d+)/i",$news[0]['icont_text'],$persons);
        $personDB = "";
        foreach ($persons[2] as $person) {
            $personDB.=$person."<br>";
        }
        if(!empty($personDB))
            $DB->query("INSERT INTO adm_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $item['el_id'], "persons", $personDB);
        //var_dump($personDB);
        //var_dump($persons);
    }
    //echo $item['icont_text']."<br>";
}
foreach ($copy_array as $k => $v) {
    $temp_array[$v['el_id']][$v['icont_var']] = $v['icont_text'];
}

//var_dump($copy_array);

/*foreach($temp_array as $k => $v)
{
    $lid = $DB->query("INSERT INTO adm_ilines_element SET itype_id = 31, el_date = UNIX_TIMESTAMP()");

    foreach ($temp_array[$k] as $field => $val) {
        $DB->query("INSERT INTO adm_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, $field, $val);
    }

}*/

//для переноса спецрубрик
/*include_once dirname(__FILE__)."/_include.php";

$rows = $DB->select("SELECT * FROM `adm_ilines_content` WHERE icont_var='specrubric' AND icont_text<>''");

$replacmentArr = array(5787 => 1581,
                       5816 => 1582,
                        5634 => 1583,
                        5070 => 1584,
                        4429 => 1585,
                        2296 => 1586,
                        2830 => 1587,
                        3588 => 1588,
                        2147 => 1589);

foreach ($rows as $row) {
    $newrub = "";
    if(!empty($replacmentArr[$row['icont_text']])) {
        $newrub = $replacmentArr[$row['icont_text']];
        $DB->query("INSERT INTO adm_ilines_content(el_id,icont_var,icont_text) VALUES(?d,?,?)", $row['el_id'],"specrubric_page", $newrub);
    }

}*/

//для переназначения журналов

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

//
//include_once dirname(__FILE__)."/_include.php";
//
//function createUrlArticle($data, $page_id) {
//    global $pages;
//    $page_url_name = "";
//    $urlPagesArr = array();
//    if(!empty($pages)) {
//        $pages_urls = explode("/", $data);
//        $pages_urls = array_reverse($pages_urls);
//        $k = $page_id;
//        $countWhile=0;
//        while(true) {
//            if($pages[$k]['page_parent']!=0 && !empty($pages[$k]['page_parent'])) {
//                $k = $pages[$k]['page_parent'];
//                $parent_pages_urls = explode("/", $pages[$k]['article_url']);
//                $parent_pages_urls = array_reverse($parent_pages_urls);
//                if (!empty($pages[$k]['article_url'])) {
//                    $urlPagesArr[] = $parent_pages_urls[0];
//                }
//            } else {
//                break;
//            }
//
//            $countWhile++;
//            if($countWhile>1000) {
//                var_dump(1111);
//                exit;
//            }
//        }
//        $urlPagesArr = array_reverse($urlPagesArr);
//        $urlPagesStr = implode("/",$urlPagesArr);
//        if($urlPagesStr!="") {
//            $url = $urlPagesStr . "/" . $pages_urls[0];
//        } else {
//            $url = $pages_urls[0];
//        }
//        unset($pages_urls);
//        unset($parent_pages_urls);
//        return $url;
//    }
//    return $data;
//}
//
//function operateWithPageParent($page_parent) {
//    global $pages;
//    include_once dirname(__FILE__)."/_include.php";
//    global $DB;
//    $rows = $DB->select("SELECT * FROM `adm_article` WHERE page_parent=?d",$page_parent);
//
//    $countFor = 0;
//    foreach ($rows as $row) {
//
//        if($page_parent!=0) {
//
//            if($row['page_template']=="jrubric") {
//                if (!empty($row["name_en"])) {
//                    $latName = Dreamedit::cyrToLat($row["name_en"]);
//                } else {
//                    $latName = Dreamedit::cyrToLat($row["page_name"]);
//                }
//            }
//            elseif($row['page_template']=="jarticle") {
//                if (!empty($row["name_en"])) {
//                    $latName = Dreamedit::cyrToLat($row["name_en"]);
//                } else {
//                    $latName = Dreamedit::cyrToLat($row["name"]);
//                }
//            }
//            else {
//                if (!empty($row["page_name_en"])) {
//                    $latName = Dreamedit::cyrToLat($row["page_name_en"]);
//                } else {
//                    $latName = Dreamedit::cyrToLat($row["page_name"]);
//                }
//            }
//
//            $latName = preg_replace("/[^a-zA-Z-\d ]/", "", $latName);
//            $latName = preg_replace("/ +/", " ", $latName);
//
//            $latName = ltrim(rtrim($latName));
//            $latName = str_replace(" ", "-", $latName);
//            $latName = str_replace("---", "-", $latName);
//            $latName = mb_strtolower($latName);
//
//            $countWhile = 0;
//            while (true) {
//                $used = $DB->select("SELECT * FROM adm_article WHERE article_url=? AND page_id<>?d AND journal_new=?d",$latName,$row['page_id'],$row['journal_new']);
//
//                if (!empty($used)) {
//                    $latName .= "-" . $row['page_id'];
//                } else {
//                    break;
//                }
//
//                $countWhile++;
//                if($countWhile>1000) {
//                    var_dump(111);
//                    exit;
//                }
//            }
//
//            $data = createUrlArticle($latName, $row['page_id']);
//
//            $DB->query("UPDATE adm_article SET article_url = ? WHERE page_id=?d",$data,$row['page_id']);
//            $pages[$row['page_id']]['article_url'] = $data;
//        }
//
//        operateWithPageParent($row['page_id']);
//        $countFor++;
//        if($countFor>10000) {
//            var_dump(11111);
//            exit;
//        }
//    }
//}
//set_time_limit ( 0 );
////ini_set('max_execution_time', '0');
//ini_set('memory_limit', '512M');
//global $DB;
//$pages = $DB->select("SELECT page_id AS ARRAY_KEY,adm_article.* FROM adm_article");
//operateWithPageParent(0);

//stat publ
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
//set_time_limit ( 0 );
////ini_set('max_execution_time', '0');
//ini_set('memory_limit', '512M');
//
//include_once dirname(__FILE__)."/_include.php";
//
//
//$current = 20000;
////while(true) {
//    $rows = $DB->select("SELECT *, SUM( publ_count )
//                        FROM `publ_stat`
//                        WHERE `module`<>'article'
//                        GROUP BY `publ_id` , `year` , `month`
//                        ORDER BY `publ_stat`.`id` DESC LIMIT ?d,10000",$current);
//
//    //$current+=10000;
//
//    if(empty($rows)) {
//        break;
//    }
//    if($current>300000) {
//        var_dump($rows);
//        exit;
//    }
//    foreach ($rows as $publ_stat) {
//        $cal = cal_days_in_month(CAL_GREGORIAN,(int)$publ_stat['month'],(int)$publ_stat['year']);
//
//        if($publ_stat['publ_count']<$cal) {
//            for($i=1;$i<=$publ_stat['publ_count'];$i++) {
//                if($i>=1 && $i<=9) {
//                    $day = "0".$i;
//                } else {
//                    $day = "".$i;
//                }
//                $DB->query("INSERT INTO publ_visits_test(`date`,`hosts`,`views`,`magazine`) VALUES(?,?,?,?)",$publ_stat['year']."-".$publ_stat['month']."-".$day,1,1,"publ-".$publ_stat['publ_id']);
//            }
//        } else {
//            $averageDayCount = $publ_stat['publ_count']/$cal;
//            $mod = $publ_stat['publ_count'] % $cal;
//            $averageDayCount = (int)$averageDayCount;
//            for($i=1;$i<=$cal;$i++) {
//                if($i>=1 && $i<=9) {
//                    $day = "0".$i;
//                } else {
//                    $day = "".$i;
//                }
//                $append = 0;
//                if($i<=$mod) {
//                    $append = 1;
//                }
//                $DB->query("INSERT INTO publ_visits_test(`date`,`hosts`,`views`,`magazine`) VALUES(?,?,?,?)",$publ_stat['year']."-".$publ_stat['month']."-".$day,1,$averageDayCount.$append,"publ-".$publ_stat['publ_id']);
//            }
//        }
//
//    }
////}
///

//
//include_once dirname(__FILE__)."/_include.php";
//
//$podrs = $DB->select(
//    "SELECT p.*, t.cv_text AS 'title', tr.cv_text AS 'title_r'
//FROM adm_pages AS p
//INNER JOIN adm_pages_content AS t ON t.page_id=p.page_id AND t.cv_name='TITLE'
//INNER JOIN adm_pages_content AS tr ON tr.page_id=p.page_id AND tr.cv_name='TITLE_R'
//WHERE p.page_template='podr' AND p.page_status=1"
//);
//echo "<pre>";
//foreach ($podrs as $podr) {
//    var_dump($podr['page_id'],$podr['title_r']);
////    $podr_r = str_replace("Группа", "Группы",str_replace("Сектор", "Сектора",str_replace("Лаборатория", "Лаборатории",str_replace("Отдел", "Отдела",str_replace("Центр", "Центра",$podr['title'])))));
////    $podr_t = str_replace("Группа", "Группой",str_replace("Сектор", "Сектором",str_replace("Лаборатория", "Лабораторией",str_replace("Отдел", "Отделом",str_replace("Центр", "Центром",$podr['title'])))));
////    var_dump($podr_r,$podr_t);
////    $DB->query("DELETE FROM adm_pages_content WHERE page_id=?d AND (cv_name='TITLE_R' OR cv_name='TITLE_T')",$podr['page_id']);
////    $DB->query("INSERT INTO adm_pages_content(`page_id`,`cv_name`,`cv_text`) VALUES (?,?,?)",$podr['page_id'],"TITLE_R",$podr_r);
////    $DB->query("INSERT INTO adm_pages_content(`page_id`,`cv_name`,`cv_text`) VALUES (?,?,?)",$podr['page_id'],"TITLE_T",$podr_t);
//}
//echo "</pre>";


//include_once dirname(__FILE__)."/_include.php";
//
//$podrs = $DB->select(
//    "SELECT ac . *
//FROM `adm_pages_content` AS ac
//INNER JOIN adm_pages AS ap ON ap.page_id = ac.page_id
//WHERE ap.page_template = 'podr'
//AND ac.cv_name = 'CONTENT_EN'"
//);
//echo "<pre>";
//foreach ($podrs as $podr) {
//    var_dump($podr['page_id'],$podr['cv_text']);
//    $cv_text = str_replace("<p><strong>Field of Research:</strong></p>","",$podr['cv_text']);
//    $cv_text = str_replace("<p><strong>Field of Research: </strong></p>","",$cv_text);
//    $cv_text = str_replace("<p><strong>Field of research: </strong></p>","",$cv_text);
//    $cv_text = str_replace("<p><strong>Field of research:</strong></p>","",$cv_text);
//    //var_dump($cv_text);
//    $DB->query("UPDATE adm_pages_content SET cv_text=? WHERE page_id=?d AND cv_name=?",$cv_text,$podr['page_id'],$podr['cv_name']);
////    $podr_r = str_replace("Группа", "Группы",str_replace("Сектор", "Сектора",str_replace("Лаборатория", "Лаборатории",str_replace("Отдел", "Отдела",str_replace("Центр", "Центра",$podr['title'])))));
////    $podr_t = str_replace("Группа", "Группой",str_replace("Сектор", "Сектором",str_replace("Лаборатория", "Лабораторией",str_replace("Отдел", "Отделом",str_replace("Центр", "Центром",$podr['title'])))));
////    var_dump($podr_r,$podr_t);
////    $DB->query("DELETE FROM adm_pages_content WHERE page_id=?d AND (cv_name='TITLE_R' OR cv_name='TITLE_T')",$podr['page_id']);
////    $DB->query("INSERT INTO adm_pages_content(`page_id`,`cv_name`,`cv_text`) VALUES (?,?,?)",$podr['page_id'],"TITLE_R",$podr_r);
////    $DB->query("INSERT INTO adm_pages_content(`page_id`,`cv_name`,`cv_text`) VALUES (?,?,?)",$podr['page_id'],"TITLE_T",$podr_t);
//}
//echo "</pre>";
//
//include_once dirname(__FILE__)."/_include.php";
//
//$ilines = new \Ilines();
//
//$v = $ilines->getLimitedElementById(7063);
//
//var_dump($v);

//include_once dirname(__FILE__)."/_include.php";
//
//global $DB, $DBH;
//
//error_reporting(E_ALL);
//
////$arr = array(
////    "id" => "2"
////);
////
////$rows = $DB->select("SELECT * FROM publ WHERE ?a", $arr);
////
////var_dump($rows);
//
//
//$id = 2;
//
////$ids = array(1,2,3);
////$in  = str_repeat('?,', count($ids) - 1) . '?';
////$sql = "SELECT * FROM table WHERE column IN ($in)";
////$stm = $db->prepare($sql);
////$stm->execute($ids);
////$data = $stm->fetchAll();
//
//$STH = $DBH->prepare("SELECT * FROM publ WHERE id=:id OR id=?");
//$STH->bindParam(":id",$id, PDO::PARAM_INT);
//$STH->execute(array(15));
//$rows = $STH->fetchAll(PDO::FETCH_ASSOC);
//
//var_dump(array(":id" => 2, 15),$rows);
//
//var_dump($STH->errorInfo());
////
//
//while($row = $STH->fetch()) {
//    //var_dump($row);
//}

//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$persons = $DB->select("SELECT * FROM persons");
//echo "<pre>";
//foreach ($persons as $person) {
//    preg_match_all('@href="([^"]+orcid.org[^"]+)"@', $person['about'], $orcidLink);
//    $orcidLink = array_pop($orcidLink);
//
//    if(!empty($orcidLink[0])) {
//        $orcidLink = $orcidLink[0];
//        $orcidLink = str_replace("http://","https://",$orcidLink);
//        $orcidLink = str_replace("https://orcid.org/","",$orcidLink);
//        var_dump($person['id']);
//        var_dump($orcidLink);
//        var_dump($person['orcid']);
//        //$DB->query("UPDATE persons SET orcid=? WHERE id=?d",$orcidLink,$person['id']);
//    } else {
//        $orcidLink = "";
//    }
//}
//echo "</pre>";

//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
////$articles = $DB->select("
////SELECT *
////FROM `adm_article`
////WHERE `annots` LIKE '%Статья поступила в редакцию%' OR `annots` LIKE '%Рецензия поступила в редакцию%' OR `annots` LIKE '%Обзор поступил в редакцию%' OR `annots` LIKE '%Статья принята к печати%'
////");
//
//$articles = $DB->select("
//SELECT *
//FROM `adm_article`
//WHERE `published_date_text` <>''
//");
//
//$arExist = array();
//
//echo "<pre>";
//foreach ($articles as $article) {
//
//    preg_match_all('@<p.*>.*((Статья принята к печати)|(Статья поступила в редакцию)|(Рецензия поступила в редакцию)|(Обзор поступил в редакцию)).*(\d\d\.\d\d\.\d\d\d\d).*<\/p>@', $article['annots'], $link);
//    preg_match_all('@<p.*>.*(Received).*(\d\d\.\d\d\.\d\d\d\d).*<\/p>@', $article['annots_en'], $linkEn);
//
//    var_dump($link[0][0],$linkEn[0][0]);
//
//    $annots = $article['annots'];
//    $publishedDate = "";
//    if(!empty($link[0][0])) {
//        $annots = str_replace($link[0][0],"",$article['annots']);
//        $publishedDate = $link[0][0];
//    }
//    $annotsEn = $article['annots_en'];
//    $publishedDateEn = "";
//    if(!empty($linkEn[0][0])) {
//        $publishedDateEn = $linkEn[0][0];
//        $annotsEn = str_replace($linkEn[0][0],"",$article['annots_en']);
//    }
//
//    //$DB->query("UPDATE adm_article SET annots=?, annots_en=?,published_date_text=?,published_date_text_en=? WHERE page_id=?d",$annots,$annotsEn,$publishedDate,$publishedDateEn,$article['page_id']);
//
//
//    $arExist[] = $article['page_id'];
//    echo $article['annots'];
//    echo $article['annots_en'];
//    echo "<hr>";
//}
//echo "</pre>";

//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$persons = $DB->select("SELECT * FROM persons");
//echo "<pre>";
//foreach ($persons as $person) {
//    preg_match_all('@href="([^"]+orcid.org[^"]+)"@', $person['about_en'], $orcidLink);
//    $orcidLink = array_pop($orcidLink);
//
//    if(!empty($orcidLink[0])) {
//        var_dump($person['id']);
//        var_dump($person['about_en']);
//        $aboutNew = preg_replace('@<p.*>.*href="(?:[^"]+orcid.org[^"]+)".*<\/p>@', '', $person['about_en']);
//        $aboutNew = preg_replace('@<div.*>.*href="(?:[^"]+orcid.org[^"]+)".*<\/div>@', '', $aboutNew);
//        preg_match_all('@<p.*>.*href="(?:[^"]+orcid.org[^"]+)".*<\/p>@', $person['about_en'], $orcidPBlock);
//        preg_match_all('@<div.*>.*href="(?:[^"]+orcid.org[^"]+)".*<\/div>@', $person['about_en'], $orcidDivBlock);
//
//        //var_dump($aboutNew);
//        var_dump($orcidPBlock,$orcidDivBlock);
//        //$DB->query("UPDATE persons SET about_en=? WHERE id=?d",$aboutNew,$person['id']);
//    } else {
//        $orcidLink = "";
//    }
//}
//echo "</pre>";

//include_once dirname(__FILE__)."/_include.php";
//include_once dirname(__FILE__)."/includes/class.MailSend.php";

//MailSend::send_mime_mail("Ученый совет ИМЭМО РАН", "academic_council@imemo.ru", "Test", "alexqw1@yandex.ru", "cp1251", "utf-8", "Test","Здравствуйте, Сергей Александрович!\r\n<br>Прошу согласовать внесение изменений в Устав ИМЭМО РАН. Проект Изменений подготовлен на основании предписания Минобрнауки России привести текст устава в соответствие с вступившими в силу федеральными законами ФЗ-157, 159, 517 на основе подготовленного Минобрнауки России шаблона. Проект Изменений согласован c юристом ИМЭМО РАН М.В. Демьянцем. Проект Изменений и действующий Устав ИМЭМО РАН во вложении.\r\n<br>Ссылка для прохождения опроса: <a href=\"https://www.imemo.ru/index.php?page_id=1662&amp;code=301637510548ce640b14-7540-401a-b680-8b75bdc2a86e17d433c0a53&questionnaire_id=20\" target=\"_blank\" data-link-id=\"3\" rel=\"noopener noreferrer\">Открыть</a>\r\n<br>С уважением,\r\n<br>Т.А. Карлова, ученый секретарь ИМЭМО РАН");

// Для дублирования англ поля в инф. лентах
//include_once dirname(__FILE__)."/_include.php";
//
//$news = $DB->select("
//SELECT *
//FROM adm_ilines_content AS ac
//INNER JOIN adm_ilines_element AS ae ON ac.el_id = ae.el_id
//WHERE ae.itype_id = 5 AND icont_var = 'status_en'
//ORDER BY ac.el_id DESC
//");
//
//foreach ($news as $newsEl) {
//    //var_dump($newsEl['el_id'],$newsEl['icont_text']);
//
////    if(empty($newsEl['icont_text']) || $newsEl['icont_text']==0) {
////        $DB->query("INSERT INTO adm_ilines_content VALUES (?,'status_en',NULL)", $newsEl['el_id']);
////    } elseif($newsEl['icont_text'] == 1) {
////        $DB->query("INSERT INTO adm_ilines_content VALUES (?,'status_en',1)", $newsEl['el_id']);
////    }
//
//}
//
//
//
//var_dump($news);

// Разделение аннотации и финансирования в статьях
//include_once dirname(__FILE__)."/_include.php";
//
//$articles = $DB->select("
//SELECT *
//FROM adm_article
//WHERE page_template='jarticle' AND (adm_article.add_text_en <>'')
//");
//
//echo "<pre>";
//
//var_dump(count($articles));
//
//foreach ($articles as $article) {
//    var_dump($article['page_id']);
//
//    $article['annots_en'] = str_replace("<p>&nbsp;</p>","",$article['annots_en']);
//    $article['annots_en'] = str_replace("<div>&nbsp;</div>","",$article['annots_en']);
//
//    preg_match_all('@<(?:p|(?:div)).*#7f8c8d.*<\/(?:p|(?:div))>@', $article['annots_en'], $financeField);
//    $newAnnots = preg_replace("@<(?:p|(?:div)).*#7f8c8d.*<\/(?:p|(?:div))>@", "", $article['annots_en']);
//
//    $finance = implode("",$financeField[0]);
//
//    //var_dump($article['annots_en'],$newAnnots,$finance);
//
//    //$DB->query("UPDATE adm_article SET add_text_en=?, annots_en=? WHERE page_id=?d",$finance,$newAnnots,$article['page_id']);
//
//    echo "---------------";
//}
//
//echo "</pre>";

// Удаление точек в конце инф. лент

//include_once dirname(__FILE__)."/_include.php";
//
//$news = $DB->select("
//SELECT ae.el_id, RTRIM(txt.icont_text) AS txt, TRIM(TRAILING '.' FROM RTRIM(txt.icont_text)) AS txt_trimmed, LENGTH(RTRIM(txt.icont_text)), LENGTH(TRIM(TRAILING '.' FROM RTRIM(txt.icont_text)))
//FROM adm_ilines_element AS ae
//INNER JOIN adm_ilines_content AS txt ON txt.el_id = ae.el_id AND txt.icont_var = 'title'
//WHERE (ae.itype_id =1 OR ae.itype_id = 4)
//    AND LENGTH(RTRIM(txt.icont_text))<>LENGTH(TRIM(TRAILING '.' FROM RTRIM(txt.icont_text)))
//    AND ae.el_id NOT IN (129,7372,5640,3458,3217,3092,2939,1707,1658,1610,1469,72,1268)
//ORDER BY ae.el_id DESC
//");
//echo "<pre>";
////foreach ($news as $key=>$value) {
////    if(substr($value['txt'],-3,1) == '.') {
////        var_dump($value);
////    }
////}
//
//$news = array_filter($news, function ($value) {
//    return substr($value['txt'],-2) != 'г.';
//});
//
//foreach ($news AS $value) {
//    //$DB->query("UPDATE adm_ilines_content SET icont_text=? WHERE el_id=?d AND icont_var='title'", $value['txt_trimmed'], $value['el_id']);
//    //var_dump($DB->select("SELECT ?,adm_ilines_content.* FROM adm_ilines_content WHERE el_id=?d AND icont_var='title'", $value['txt_trimmed'], $value['el_id']));
//}
//
//
//var_dump($news);
//echo "</pre>";

// Удаление точек в конце инф. лент (en)

//include_once dirname(__FILE__)."/_include.php";
//
//$news = $DB->select("
//SELECT ae.el_id, RTRIM(txt.icont_text) AS txt, TRIM(TRAILING '.' FROM RTRIM(txt.icont_text)) AS txt_trimmed, LENGTH(RTRIM(txt.icont_text)), LENGTH(TRIM(TRAILING '.' FROM RTRIM(txt.icont_text)))
//FROM adm_ilines_element AS ae
//INNER JOIN adm_ilines_content AS txt ON txt.el_id = ae.el_id AND txt.icont_var = 'title_en'
//WHERE (ae.itype_id =1 OR ae.itype_id = 4)
//    AND LENGTH(RTRIM(txt.icont_text))<>LENGTH(TRIM(TRAILING '.' FROM RTRIM(txt.icont_text)))
//ORDER BY ae.el_id DESC
//");
//echo "<pre>";
////foreach ($news as $key=>$value) {
////    if(substr($value['txt'],-3,1) == '.') {
////        var_dump($value);
////    }
////}
//
//$news = array_filter($news, function ($value) {
//    return substr($value['txt'],-2) != 'г.';
//});
//
//foreach ($news AS $value) {
//    $DB->query("UPDATE adm_ilines_content SET icont_text=? WHERE el_id=?d AND icont_var='title_en'", $value['txt_trimmed'], $value['el_id']);
//    //var_dump($DB->select("SELECT ?,adm_ilines_content.* FROM adm_ilines_content WHERE el_id=?d AND icont_var='title'", $value['txt_trimmed'], $value['el_id']));
//}
//
//
//var_dump($news);
//echo "</pre>";

//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$persons = $DB->select("SELECT * FROM persons");
//$profiles = $DB->select("SELECT id,about FROM persons WHERE about_en COLLATE cp1251_general_cs LIKE '%Profile in ResearcherID%'");
//
//
//echo "<pre>";
//
//$linkCount = 0;
//foreach ($persons as $person) {
//    preg_match_all('@src="([^"]+researcherid[^"]+)"@', $person['about_en'], $orcidLink);
//    $orcidLink = array_pop($orcidLink);
//
//    if(!empty($orcidLink[0])) {
//        var_dump($person['id']);
//        var_dump($person['about_en']);
//        $aboutNew = preg_replace('@<img.*src="(?:[^"]+researcherid[^"]+)".*>@U', '<img alt="" src="/files/Image/rinc/Publons.jpg" style="width: 107px; height: 32px;">', $person['about_en']);
//        $aboutNew = str_replace("Профиль автора в ResearcherID","Профиль автора в Publons (ResearcherID)",$aboutNew);
//
//        preg_match_all('@<img.*src="(?:[^"]+researcherid[^"]+)".*>@U', $person['about_en'], $researcherIdLinks);
//
//        var_dump($researcherIdLinks);
//
//        //var_dump($aboutNew);
//        var_dump('---------');
//        //var_dump($orcidPBlock,$orcidDivBlock);
//        //$DB->query("UPDATE persons SET about=? WHERE id=?d",$aboutNew,$person['id']);
//        $linkCount++;
//    } else {
//        $orcidLink = "";
//    }
//}
//var_dump($linkCount);
//echo "</pre>";

//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$ilines = $DB->select("SELECT * FROM adm_ilines_content WHERE icont_var='REPORT_TEXT_EN' AND icont_text LIKE '%dinkin%'");
//
//foreach ($ilines as $iline) {
//    $replaced = str_replace("Fedor Voitolovskiy", "Feodor Voitolovsky",$iline['icont_text']);
//    $replaced = str_replace("Voitolovskiy", "Voitolovsky",$replaced);
//    //$replaced = str_replace("Fedor", "Feodor",$replaced);
//    var_dump($replaced);
//
//    //$DB->query("UPDATE adm_ilines_content SET icont_text=? WHERE el_id=?d AND icont_var=?",$replaced,$iline['el_id'],$iline['icont_var']);
//}
//
//var_dump($ilines);
//
//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$pages = $DB->select("SELECT * FROM adm_pages WHERE page_template='mag_index'");
//
//foreach ($pages as $page) {
//    $DB->query("INSERT INTO adm_pages_content(`page_id`,`cv_name`,`cv_text`) VALUES (?d,?,?)", $page['page_id'], 'BOTTOM_ID_LINK', '1');
//}
//
//
//
//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$articles = $DB->select("
//SELECT *
//FROM `adm_article`
//WHERE `article_url` LIKE '%department-of-imemo%'
//");
//
//echo '<pre>';
//foreach ($articles as $article) {
//    var_dump($article['page_id']);
//    var_dump($article['article_url']);
//    $newUrl = str_replace('department-of-imemo','department-of-memo-journal', $article['article_url']);
//    var_dump($newUrl);
//    $DB->query("
//    UPDATE adm_article
//    SET article_url=?
//    WHERE page_id=?d
//    ", $newUrl, $article['page_id']);
//}
//echo '</pre>';

//$m = new MongoClient();
//$visitsDb = $m->imemon;
//$ipVisitsTimeCollection = $visitsDb->ip_visits_time;
//$ipVisitsCollection = $visitsDb->ip_visits;
//$visitsDailyCollection = $visitsDb->visits_daily;
//$visitsMonthCollection = $visitsDb->visits;
//
//$visitsDailyCollection->createIndex(array('views' => 1));
//$visitsDailyCollection->createIndex(array('magazine' => 1));
//$visitsMonthCollection->createIndex(array('year' => 1));
//$visitsMonthCollection->createIndex(array('month' => 1));
//$visitsMonthCollection->createIndex(array('magazine' => 1));
//
//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
//$afjPages = $DB->select("SELECT page_name FROM afjourn.adm_pages WHERE page_template='article'");
//
//foreach ($afjPages as $afjPage) {
//    $firstTemp = $afjPage['page_name'].'%';
//    $secondTemp = '%'.$afjPage['page_name'].'%';
//    $thirdTemp = '%'.$afjPage['page_name'];
//    $publ = $DB->select("SELECT * FROM publ WHERE name LIKE ? OR name LIKE ? or name LIKE ?", $firstTemp, $secondTemp, $thirdTemp);
//    foreach ($publ as $value) {
//        var_dump($value['id']);
//        $DB->query("UPDATE publ SET status=0 WHERE id=?d", $value['id']);
//    }
//}