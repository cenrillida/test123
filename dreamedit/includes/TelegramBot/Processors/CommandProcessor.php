<?php

namespace TelegramBot\Processors;

use TelegramBot\Methods\SendMessage;
use TelegramBot\Models\Chat;
use TelegramBot\Models\User;
use TelegramBot\TelegramBot;

class CommandProcessor {

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
     * @param Chat $chat
     * @param User $from
     */
    public function processCommand($commandName, $chat, $from) {
        $command = $this->telegramBot->getCommandMapper()->getCommandByName($commandName);

        if(!empty($command)) {
            $command->execute($chat,$from);
        } else {
            $sendMessage = new SendMessage(
                $this->telegramBot,
                $chat,
                mb_convert_encoding(
                    "Неизвестная команда",
                    "UTF-8",
                    "windows-1251"
                )
            );
            $sendMessage->execute();
        }

    }

}