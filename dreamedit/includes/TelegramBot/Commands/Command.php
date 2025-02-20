<?php

namespace TelegramBot\Commands;

use TelegramBot\Models\Chat;
use TelegramBot\Models\User;
use TelegramBot\TelegramBot;

abstract class Command {

    /** @var TelegramBot */
    protected $telegramBot;

    /**
     * @param TelegramBot $telegramBot
     */
    public function __construct($telegramBot)
    {
        $this->telegramBot = $telegramBot;
    }

    /**
     * @param Chat $chat
     * @param User $from
     */
    public function execute($chat, $from) {

    }
}