<?php

namespace TelegramBot\Methods;

use TelegramBot\Models\Chat;
use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\Models\Message;
use TelegramBot\TelegramBot;

class SendMessage extends Method {


    /**
     * @param TelegramBot $telegramBot
     * @param Chat $chat
     * @param string $text
     */
    public function __construct($telegramBot, $chat, $text)
    {
        parent::__construct($telegramBot,$chat);
        $this->name = "sendMessage";
        $this->params['text'] = $text;
        $this->htmlFields[] = 'text';
    }

}