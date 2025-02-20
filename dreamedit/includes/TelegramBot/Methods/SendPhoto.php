<?php

namespace TelegramBot\Methods;

use TelegramBot\Models\Chat;
use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\Models\Message;
use TelegramBot\TelegramBot;

class SendPhoto extends Method {


    /**
     * @param TelegramBot $telegramBot
     * @param Chat $chat
     * @param string $photo
     * @param string $caption
     */
    public function __construct($telegramBot, $chat, $photo, $caption = null)
    {
        parent::__construct($telegramBot,$chat);
        $this->name = "sendPhoto";
        $this->params['photo'] = $photo;
        if(!empty($caption)) {
            $this->params['caption'] = $caption;
            $this->htmlFields[] = 'caption';
        }
    }

}