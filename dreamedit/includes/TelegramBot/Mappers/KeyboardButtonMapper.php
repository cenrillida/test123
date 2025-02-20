<?php

namespace TelegramBot\Mappers;

use TelegramBot\Models\KeyboardButton;
use TelegramBot\TelegramBot;

class KeyboardButtonMapper {

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
     * @param KeyboardButton $keyboardButton
     * @return array
     */
    public function toArray($keyboardButton) {
        return array(
            "text" => $keyboardButton->getText(),
            ($keyboardButton->isRequestContact() != null) ? "request_contact" : null =>
                $keyboardButton->isRequestContact(),
            ($keyboardButton->isRequestLocation() != null) ? "request_location" : null =>
                $keyboardButton->isRequestLocation()
        );
    }

}