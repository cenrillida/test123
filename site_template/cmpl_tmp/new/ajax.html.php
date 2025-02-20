<?php

if($_GET[ajax_get_elements_mode]=='announce') {
    $news = new News();
    $pg = new Pages();
    $announcements = $news->getAnnouncements();
    $result = array();
    foreach ($announcements as $k=>$v) {
        $result[$v[el_id]]['text'] = normJsonStr($v["content"]["PREV_TEXT"]);
    }
    echo json_encode($result);
}

if($_GET[ajax_get_elements_mode]=='keywords') {
    global $DB;
    header("Content-type: application/json");

    $m = new MongoClient();
    $visitsDb = $m->imemon;
    if($_GET['lang']=="en") {
        $collection = $visitsDb->publ_keywords_en;
    } else {
        $collection = $visitsDb->publ_keywords;
    }


    $cursor = $collection->aggregate(
        array('$project' => array('keyword' => '$keyword')),
        array('$match' => array(
            'keyword' => array( '$regex' => "^".$_GET['term'].".*", '$options' => 'i')
        )),
        array('$sort' =>
            array('keyword' => 1)),
        array('$limit' => 15)
    );
    $elmnts = array();
    $count=0;
    $used_ids = array();
    foreach($cursor['result'] as $value) {
        $elmnts[$count]['label'] = normJsonStr(mb_convert_encoding($value['keyword'],"windows-1251","utf-8"));
        $used_ids[] = $value['_id'];
        $count++;
    }
    $cursor = $collection->aggregate(
        array('$project' => array('keyword' => '$keyword')),
        array('$match' => array(
            'keyword' => array( '$regex' => $_GET['term'].".*", '$options' => 'i')
        )),
        array('$sort' =>
            array('keyword' => 1)),
        array('$limit' => 15)
    );
    foreach($cursor['result'] as $value) {
        if($count>15)
            break;
        if(in_array($value['_id'],$used_ids))
            break;
        $elmnts[$count]['label'] = normJsonStr(mb_convert_encoding($value['keyword'],"windows-1251","utf-8"));
        $count++;
    }

    echo json_encode($elmnts);
}

if($_GET[ajax_get_elements_mode]=='news_rating') {
    global $DB;
    header("Content-type: application/json");

    if($_SESSION[lang]!="/en") {
        $lang_prefix = "";
        $lang_prefix_down = "";
    } else {
        $lang_prefix = "-en";
        $lang_prefix_down = "_en";
    }

    $news = array(
        'day' => array(),
        'week' => array(),
        'month' => array()
    );
    $newsToday = Statistic::getTopNews('0', $lang_prefix, 5, true);
    $news['day']['html'] = getNewsHtml($newsToday);
    $newsWeek = Statistic::getTopNews('7', $lang_prefix, 5, true);
    $news['week']['html'] = getNewsHtml($newsWeek);
    $newsMonth = Statistic::getTopNews('30', $lang_prefix, 5, true);
    $news['month']['html'] = getNewsHtml($newsMonth);

    echo json_encode($news);
}


/**
 * @param $news
 * @return string
 */
function getNewsHtml($news)
{
    $newsHtml = '';
    if (empty($news)) {
        if ($_SESSION[lang] != "/en") {
            return '<div class="col">Нет просмотренных новостей</div>';
        } else {
            return '<div class="col">No news viewed</div>';
        }
    } else {
        foreach ($news as $value) {
            $news_more_page = 502;
            if ($value['type_id'] == 5) {
                $news_more_page = 503;
            }
            $value['news_id'] = str_replace('-en','',$value['news_id']);
            $newsHtml .= normJsonStr("<div class=\"col-12 pb-3\"><a class=\"font-size-sm\" style=\"font-size: 15px;\" href=\"{$_SESSION['lang']}/index.php?page_id={$news_more_page}&id={$value['news_id']}\">{$value['title']}</a></div>");
        }
    }
    return $newsHtml;
}

function normJsonStr($str){
    $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}