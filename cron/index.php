<?php

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

$_SERVER["DOCUMENT_ROOT"]='/home/imemon/html';

$_CONFIG = array();

// берем конфиг системы если конфиг не найден - выходим
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/../dreamedit/_config.ini", true);
if(empty($_CONFIG["global"]))
    die("Файл конфигурации системы не найден");
// подключаем заголовк?страни?
include_once dirname(__FILE__)."/../dreamedit/includes/headers.php";
// подключаем файл соединен? ?базо?
include_once dirname(__FILE__)."/../dreamedit/includes/connect.php";
// подключаем файл соединен? ?базо?
include_once dirname(__FILE__)."/../dreamedit/includes/site.fns.php";
include_once dirname(__FILE__)."/../dreamedit/includes/class.Statistic.php";
global $DB;

$m = new MongoClient();

$visitsDb = $m->imemon;
$ipVisitsTimeCollection = $visitsDb->ip_visits_time;
$ipVisitsTimeCollection->drop();

$rows = $DB->select('SELECT ac.el_id AS id, act.icont_text AS ctext, acti.icont_text AS title FROM `adm_ilines_content` AS ac
INNER JOIN adm_ilines_content AS acq ON ac.el_id=acq.el_id AND acq.icont_var=\'newsletter_queue\'
INNER JOIN adm_ilines_content AS act ON ac.el_id=act.el_id AND act.icont_var=\'prev_text\'
INNER JOIN adm_ilines_content AS acti ON ac.el_id=acti.el_id AND acti.icont_var=\'title\'
WHERE acq.icont_text=1 GROUP BY ac.el_id');
$mail_text = '';
foreach ($rows AS $row) {
    $mail_text.="<h2>".$row['title']."</h2>".$row['ctext'].'<a href="https://www.imemo.ru/index.php?page_id=502&id='.$row['id'].'">Подробнее</a><br><br>';
}

if(!empty($mail_text)) {
    $DB->query('UPDATE `adm_ilines_content` SET icont_text=0 WHERE icont_var=\'newsletter_queue\'');
    $users = $DB->select('SELECT * FROM newsletter_users');
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
    $headers .= 'From: '.'=?WINDOWS-1251?B?'.base64_encode('Рассылка ИМЭМО РАН').'?='.' <newsletter@imemo.ru>' . "\r\n";
    foreach ($users AS $user) {
        mail($user['email'], '=?WINDOWS-1251?B?'.base64_encode('Рассылка новостей').'?=', $mail_text."<a href=\"https://imemo.ru/newsletter_cancel.php?code=".$user['cancel_code']."\">Отписаться от рассылки</a>",	$headers);
    }
}

/*$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: '.'=?UTF-8?B?'.base64_encode('ИМЭМО РАН').'?='.' <newsletter@imemo.ru>' . "\r\n";
mail($_GET[email], '=?UTF-8?B?'.base64_encode('Рассылка новостей').'?=', "Здравствуйте, ".iconv("cp1251", "utf-8", $_GET[fio])."!<br><br>Сообщаем Вам, что Ваш материал \"".iconv("cp1251", "utf-8", $_GET[name])."\" дошел до редакции.<br><br>С уважением,<br>imemo.ru",	$headers);
header("Location: ".$_GET[file]);*/

function insertPhotosFromPhotoset($id) {
    global $DB;
    $json = file_get_contents('https://www.flickr.com/services/rest?method=flickr.photosets.getPhotos&api_key=3988023e15f45c8d4ef5590261b1dc53&page=1&format=json&nojsoncallback=1&extras=url_m&photoset_id='.$id);
    $obj = json_decode($json);
    $photo_array = $obj->photoset->photo;
    if(count($photo_array)>4) {

        do {
            $rand = mt_rand(0, count($photo_array)-1);
            $random_numbers[$rand] = $rand;
        } while( count($random_numbers) < 4 );

        $random_numbers = array_values($random_numbers); // This strips the keys

        foreach ($random_numbers as $number) {
            $DB->query("INSERT INTO flickr_main(link) VALUES (?)", $obj->photoset->photo[$number]->url_m);
        }
    } else {
        foreach ($obj->photoset->photo as $photo) {
            $DB->query("INSERT INTO flickr_main(link) VALUES (?)", $photo->url_m);
        }
    }
}

$flickr_photosets_json = file_get_contents('https://www.flickr.com/services/rest?method=flickr.photosets.getList&api_key=3988023e15f45c8d4ef5590261b1dc53&user_id=152126910@N03&format=json&nojsoncallback=1');
$flickr_photosets = json_decode($flickr_photosets_json);

if(!empty($flickr_photosets->photosets->photoset)) {
    $DB->query("TRUNCATE TABLE flickr_main");
    insertPhotosFromPhotoset($flickr_photosets->photosets->photoset[0]->id);
    insertPhotosFromPhotoset($flickr_photosets->photosets->photoset[1]->id);
    insertPhotosFromPhotoset($flickr_photosets->photosets->photoset[2]->id);
}

$youtubeUploadVideosJson = file_get_contents('https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=UUhbPkDspJgogVB0J4kWDt_w&maxResults=5&key=AIzaSyC5q_FJQpW8HwP2vadCchTBoLqiIqagSF8');
$youtubeUploadVideos = json_decode($youtubeUploadVideosJson);

if(!empty($youtubeUploadVideos->items)) {
    $DB->query("TRUNCATE TABLE youtube_videos");
    foreach ($youtubeUploadVideos->items as $item) {
        $title = mb_convert_encoding($item->snippet->title, "windows-1251", "UTF-8");
        $description = mb_convert_encoding($item->snippet->description, "windows-1251", "UTF-8");
        $thumbnailUrl = "";
        if(!empty($item->snippet->thumbnails->maxres->url)) {
            $thumbnailUrl = $item->snippet->thumbnails->maxres->url;
        } elseif(!empty($item->snippet->thumbnails->standard->url)) {
            $thumbnailUrl = $item->snippet->thumbnails->standard->url;
        } elseif(!empty($item->snippet->thumbnails->high->url)) {
            $thumbnailUrl = $item->snippet->thumbnails->high->url;
        }
        if(!empty($thumbnailUrl)) {
            $DB->query("INSERT INTO youtube_videos(title,description,thumbnail,url) VALUES(?,?,?,?)", $title, $description, $thumbnailUrl, $item->snippet->resourceId->videoId);
        }
    }
}

//
//$DB->query("LOCK TABLES page_rating WRITE,magazine_visits AS mv WRITE,adm_ilines_content AS ac WRITE");
//$DB->query("TRUNCATE TABLE page_rating");
//
//Statistic::saveTopNews("30");
//Statistic::saveTopNews("7");
//Statistic::saveTopNews("0");
//Statistic::saveTopNews("30","-en");
//Statistic::saveTopNews("7","-en");
//Statistic::saveTopNews("0","-en");
//$DB->query("UNLOCK TABLES");


$keywords = $DB->select("SELECT id, keyword FROM publ");

$keywordsExploded = array();

foreach ($keywords AS $keyword) {
    $keywordExploded = explode(";",$keyword['keyword']);
    foreach ($keywordExploded as $value) {
        $keywordTrimmed = ltrim(rtrim($value, " \t\n\r"), " \t\n\r");
        if(strlen($keywordTrimmed)>1) {
            if (substr($keywordTrimmed,0,1) == "«") {
                $keywordTrimmed = mb_strtoupper(substr($keywordTrimmed,0,2),"windows-1251").substr($keywordTrimmed,2);
            } else {
                $keywordTrimmed = mb_strtoupper(substr($keywordTrimmed,0,1),"windows-1251").substr($keywordTrimmed,1);
            }
        }
        if(!empty($keywordTrimmed) && !in_array($keywordTrimmed,$keywordsExploded)) {
            $keywordsExploded[] = $keywordTrimmed;
        }
    }
}
sort($keywordsExploded);


$collection = $visitsDb->publ_keywords;
$collection->drop();

foreach ($keywordsExploded as $keywordExploded) {
    $collection->insert(array("keyword" => mb_convert_encoding($keywordExploded, "utf-8", "windows-1251")));
}

$keywords = $DB->select("SELECT id, keyword_en FROM publ");

$keywordsExploded = array();

foreach ($keywords AS $keyword) {
    $keywordExploded = explode(";",$keyword['keyword_en']);
    foreach ($keywordExploded as $value) {
        $keywordTrimmed = ltrim(rtrim($value, " \t\n\r"), " \t\n\r");
        if(strlen($keywordTrimmed)>1) {
            if (substr($keywordTrimmed,0,1) == "«") {
                $keywordTrimmed = mb_strtoupper(substr($keywordTrimmed,0,2),"windows-1251").substr($keywordTrimmed,2);
            } else {
                $keywordTrimmed = mb_strtoupper(substr($keywordTrimmed,0,1),"windows-1251").substr($keywordTrimmed,1);
            }
        }
        if(!empty($keywordTrimmed) && !in_array($keywordTrimmed,$keywordsExploded)) {
            $keywordsExploded[] = $keywordTrimmed;
        }
    }
}
sort($keywordsExploded);

$collection = $visitsDb->publ_keywords_en;
$collection->drop();

foreach ($keywordsExploded as $keywordExploded) {
    $collection->insert(array("keyword" => mb_convert_encoding($keywordExploded, "utf-8", "windows-1251")));
}


$DB->query("INSERT INTO cron_test(`date`) VALUES (?)",date("Y-m-d H:i:s"));

?>