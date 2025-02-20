<?php

ini_set('memory_limit', '256M');
include_once dirname(__FILE__)."/_include.php";
require_once "includes/TelegramBot/Autoloader.php";

if(!empty($_GET['id'])) {
    $DB->query("SET NAMES utf8");


    $chat = new \TelegramBot\Models\Chat("@imemo_ran", "channel");


    global $_CONFIG, $page_id, $_TPL_REPLACMENT, $page_content;

    $pg = new \Pages();
    $ilines = new \Ilines();

    $homeContent = $pg->getContentByPageId(1);

    $iline = $DB->selectRow("SELECT * FROM adm_ilines_element WHERE el_id=?d",$_GET['id']);


    if($iline['itype_id']==1 || $iline['itype_id']==4) {

        $v = $ilines->getLimitedElementById($_GET['id']);

        if (!empty($v)) {
            $text = "";
            if (!empty($v['url'])) {
                $url = "https://www.imemo.ru" . $pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"]) . "/" . $v['url'];
            } else {
                $url = "https://www.imemo.ru" .
                    $pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"], array("id" => $v['el_id']));
            }
            $text = $v["final_text"];

            $sendMessage = new \TelegramBot\Methods\SendMessage(
                \TelegramBot\TelegramBot::getInstance(),
                $chat,
                "$text \n<a href=\"" . $url . "\">" .
                mb_convert_encoding("Подробнее", "UTF-8", "windows-1251") . "</a>");
            $sendMessage->setHTMLStyle();

            $sendMessage->execute();
            echo "<span style='color: green'>Успешно</span>";
        } else {
            echo "<span style='color: red'>Не найден элемент</span>";
        }
    }

    if($iline['itype_id']==3) {
        $news = new \News();
        $element = $news->getFirstNewsById($_GET['id']);

        $image = "https://www.imemo.ru".$element->getImageUrl();
        $url = "https://www.imemo.ru/index.php?page_id=1594&id=".$element->getId();
        $title = $element->getTitle();

        $sendPhoto = new \TelegramBot\Methods\SendPhoto(
            \TelegramBot\TelegramBot::getInstance(),
            $chat,
            $image,
            "$title \n<a href=\"".$url."\">".
            mb_convert_encoding("Подробнее","UTF-8","windows-1251")."</a>");
        $sendPhoto->setHTMLStyle();

        $sendPhoto->execute();
        echo "<span style='color: green'>Успешно</span>";
    }

    if($iline['itype_id']==5) {

        $v = $ilines->getPublSmiById($_GET['id']);

        if (!empty($v)) {
            $text = "";
            if (!empty($v['url'])) {
                $url = "https://www.imemo.ru" . $pg->getPageUrl($homeContent["FULL_SMI_ID"]) . "/" . $v['url'];
            } else {
                $url = "https://www.imemo.ru" .
                    $pg->getPageUrl($homeContent["FULL_SMI_ID"], array("id" => $v['el_id']));
            }
            $text = $v["final_text"];

            $sendMessage = new \TelegramBot\Methods\SendMessage(
                \TelegramBot\TelegramBot::getInstance(),
                $chat,
                "$text \n<a href=\"" . $url . "\">" .
                mb_convert_encoding("Подробнее", "UTF-8", "windows-1251") . "</a>");
            $sendMessage->setHTMLStyle();

            $sendMessage->execute();
            echo "<span style='color: green'>Успешно</span>";
        } else {
            echo "<span style='color: red'>Не найден элемент</span>";
        }
    }

} else {
    echo "<span style='color: red'>Не найден элемент</span>";
}