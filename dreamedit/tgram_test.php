<?php
//
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
//
include_once dirname(__FILE__)."/_include.php";
//
//$DB->query("TRUNCATE tgram");
//$DB->query("TRUNCATE tgram_messages");
//$DB->query("TRUNCATE tgram_chats");
//$DB->query("TRUNCATE tgram_messages_entities");
//$DB->query("TRUNCATE tgram_users");
//
//        exit;

require_once "includes/TelegramBot/Autoloader.php";

$DB->query("SET NAMES utf8");

//$sendCommands = new \TelegramBot\Methods\SetMyCommands(\TelegramBot\TelegramBot::getInstance());
//
//$sendCommands->execute();

$chat = new \TelegramBot\Models\Chat("@test_test_im","channel");

//$sendMessage = new \TelegramBot\Methods\SendMessage(\TelegramBot\TelegramBot::getInstance(),$chat,"test");
//
//$sendMessage->execute();


global $_CONFIG, $page_id, $_TPL_REPLACMENT, $page_content;

$pg = new \Pages();
$ilines = new \Ilines();

$homeContent = $pg->getContentByPageId(1);

//$rows =
//    $ilines->
//    getLimitedElementsMultiSortMainNewFunc(
//        $homeContent["NEWS_BLOCK_LINE"],
//        1,
//        1,
//        "DATE",
//        "DESC",
//        "status"
//    );
//
//$text = "";
//foreach ($rows as $k => $v) {
//    if(!empty($v['url'])) {
//        $url = "https://www.imemo.ru".$pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"])."/".$v['url'];
//    } else {
//        $url = "https://www.imemo.ru".
//            $pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"], array("id" => $v['el_id']));
//    }
//    $text = $v["final_text"];
//}


$v = $ilines->getLimitedElementById(6334);

$text = "";
if(!empty($v['url'])) {
    $url = "https://www.imemo.ru".$pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"])."/".$v['url'];
} else {
    $url = "https://www.imemo.ru".
        $pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"], array("id" => $v['el_id']));
}
$text = $v["final_text"];

$sendMessage = new \TelegramBot\Methods\SendMessage(\TelegramBot\TelegramBot::getInstance(), $chat,"$text \n<a href=\"".$url."\">".
    mb_convert_encoding("Подробнее","UTF-8","windows-1251")."</a>");
$sendMessage->setHTMLStyle();

$sendMessage->execute();