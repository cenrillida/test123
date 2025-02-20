<?php

namespace TelegramBot\Commands;

use TelegramBot\Methods\SendMessage;
use TelegramBot\Models\Chat;
use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\Models\User;

class News extends Command {

    /**
     * @param Chat $chat
     * @param User $from
     */
    public function execute($chat, $from) {

        global $_CONFIG, $page_id, $_TPL_REPLACMENT, $page_content;

        $pg = new \Pages();
        $ilines = new \Ilines();

        $homeContent = $pg->getContentByPageId(1);

        $rows =
            $ilines->
            getLimitedElementsMultiSortMainNewFunc(
                $homeContent["NEWS_BLOCK_LINE"],
                1,
                1,
                "DATE",
                "DESC",
                "status"
            );

        $text = "";
        foreach ($rows as $k => $v) {
            if(!empty($v['url'])) {
                $url = "https://www.imemo.ru".$pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"])."/".$v['url'];
            } else {
                $url = "https://www.imemo.ru".
                    $pg->getPageUrl($homeContent["NEWS_BLOCK_PAGE"], array("id" => $v['el_id']));
            }
            $text = $v["final_text"];
        }

        $sendMessage = new SendMessage($this->telegramBot, $chat,"$text \n<a href=\"".$url."\">".
            mb_convert_encoding("Подробнее","UTF-8","windows-1251")."</a>");
        $sendMessage->setHTMLStyle();

        $sendMessage->execute();
        //some start answer
        parent::execute($chat, $from);
    }

}