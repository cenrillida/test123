<?php

namespace TelegramBot\Commands;

use TelegramBot\Methods\SendMessage;
use TelegramBot\Methods\SendPhoto;
use TelegramBot\Models\Chat;
use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\Models\User;

class ActualComment extends Command {

    /**
     * @param Chat $chat
     * @param User $from
     */
    public function execute($chat, $from) {

        $news = new \News();
        $firstNews = $news->getFirstNews(1);

        foreach ($firstNews as $key => $element) {
            $image = "https://www.imemo.ru".$element->getImageUrl();
            $url = "https://www.imemo.ru/index.php?page_id=1594&id=".$element->getId();
            $title = $element->getTitle();
        }

        $sendPhoto = new SendPhoto($this->telegramBot, $chat, $image, "$title \n<a href=\"".$url."\">".
            mb_convert_encoding("Подробнее","UTF-8","windows-1251")."</a>");
        $sendPhoto->setHTMLStyle();

        $sendPhoto->execute();
        parent::execute($chat, $from);
    }

}