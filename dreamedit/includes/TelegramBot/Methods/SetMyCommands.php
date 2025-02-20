<?php

namespace TelegramBot\Methods;

use TelegramBot\Models\Chat;
use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\Models\Message;
use TelegramBot\TelegramBot;

class SetMyCommands extends Method {


    /**
     * @param TelegramBot $telegramBot
     * @param Chat $chat
     * @param string $text
     */
    public function __construct($telegramBot)
    {
        parent::__construct($telegramBot);
        $this->name = "setMyCommands";
        $commands = $telegramBot->getCommandMapper()->getCommandListDescription();
        $commandsUtf = array();
        foreach ($commands as $key=>$command) {
            $commandsUtf[$key] = array(
                mb_convert_encoding("command","UTF-8","windows-1251") =>
                    mb_convert_encoding($command['command'],"UTF-8","windows-1251"),
                mb_convert_encoding("description","UTF-8","windows-1251") =>
                    mb_convert_encoding($command['description'],"UTF-8","windows-1251")
            );
        }
        $this->params['commands'] = json_encode($commandsUtf);
    }

}