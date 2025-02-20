<?php

namespace TelegramBot\Mappers;

use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\TelegramBot;

class InlineKeyboardButtonMapper {

    /** @var TelegramBot */
    private $telegramBot;

    /**
     * @param TelegramBot $telegramBot
     */
    public function __construct($telegramBot)
    {
        $this->telegramBot = $telegramBot;
    }

    /**
     * @param InlineKeyboardButton $inlineKeyboardButton
     * @return array
     */
    public function toArray($inlineKeyboardButton) {
        return array(
            "text" => $inlineKeyboardButton->getText(),
            ($inlineKeyboardButton->getUrl() != null) ? "url" : null => $inlineKeyboardButton->getUrl(),
            ($inlineKeyboardButton->getCallbackData() != null) ? "callback_data" : null =>
                $inlineKeyboardButton->getCallbackData()
        );
    }

}