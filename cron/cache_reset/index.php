<?php

$_SERVER["DOCUMENT_ROOT"]='/home/imemon/html';

$_CONFIG = array();

// áåğåì êîíôèã ñèñòåìû åñëè êîíôèã íå íàéäåí - âûõîäèì
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/../../dreamedit/_config.ini", true);
if(empty($_CONFIG["global"]))
    die("Ôàéë êîíôèãóğàöèè ñèñòåìû íå íàéäåí");
// ïîäêëş÷àåì çàãîëîâê?ñòğàíè?
include_once dirname(__FILE__)."/../../dreamedit/includes/headers.php";
// ïîäêëş÷àåì ôàéë ñîåäèíåí? ?áàçî?
include_once dirname(__FILE__)."/../../dreamedit/includes/connect.php";
// ïîäêëş÷àåì ôàéë ñîåäèíåí? ?áàçî?
include_once dirname(__FILE__)."/../../dreamedit/includes/site.fns.php";


include_once dirname(__FILE__)."/../../dreamedit/includes/class.Pages.php";
include_once dirname(__FILE__)."/../../dreamedit/includes/class.Ilines.php";
include_once dirname(__FILE__)."/../../dreamedit/includes/class.News.php";

include_once dirname(__FILE__)."/../../dreamedit/includes/class.Statistic.php";
include_once dirname(__FILE__)."/../../dreamedit/includes/class.CacheEngine.php";

global $DB;

$currentNews = $DB->select("SELECT * FROM cached_news");

$news = new News();

$announcements = $news->getAnnouncements();

$result = array();

foreach ($announcements as $k=>$v) {
    $result[$v['el_id']]['content'] = $v["content"]["PREV_TEXT"];
    $result[$v['el_id']]['type'] = "announce";
}

$ilines = new Ilines();

$rows = $ilines->getLimitedElementsMultiSortMainNewFunc($page_content["NEWS_BLOCK_LINE"], 5, 1,"DATE", "DESC", "status");

foreach ($rows as $k => $v) {
    $result[$v['el_id']]['content'] = $v["final_text"];
    $result[$v['el_id']]['type'] = "news";
}

$DB->query("LOCK TABLES cached_news WRITE");
$DB->query('DELETE FROM cached_news');
$DB->query("UNLOCK TABLES");

foreach ($result as $k => $v) {
    $DB->query("INSERT INTO cached_news(id,content,type) VALUES (?d,?,?)", $k, $v['content'], $v['type']);
}

$updatedNews = $DB->select("SELECT * FROM cached_news");

if($currentNews!=$updatedNews) {
    $cacheEngine = new CacheEngine();
    $cacheEngine->reset();
}