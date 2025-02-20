<?php

namespace TelegramBot\Commands;

use TelegramBot\Methods\SendMessage;
use TelegramBot\Models\Chat;
use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\Models\KeyboardButton;
use TelegramBot\Models\User;

class Start extends Command {

    /**
     * @param Chat $chat
     * @param User $from
     */
    public function execute($chat, $from) {
//        $sendMessage = new SendMessage($this->telegramBot, $chat,mb_convert_encoding("Здравствуйте! \n\nВыберите одно из доступных действий:","UTF-8","windows-1251"));
//        // TODO: придумать класс для работы с этими элементами
//        $inlineKeyboardArray = array();
//        $inlineKeyboardArray[0] = array();
//        $inlineKeyboardArray[0][0] = new InlineKeyboardButton(mb_convert_encoding("Актуальный комментарий","UTF-8","windows-1251"),null,"/actual_comment");
//        $inlineKeyboardArray[1] = array();
//        $inlineKeyboardArray[1][0] = new InlineKeyboardButton(mb_convert_encoding("Свежая новость","UTF-8","windows-1251"),null,"/news");
//        $inlineKeyboardArray[2] = array();
//        $inlineKeyboardArray[2][0] = new InlineKeyboardButton(mb_convert_encoding("Сайт ИМЭМО РАН","UTF-8","windows-1251"),"https://www.imemo.ru");
//        $sendMessage->addInlineKeyboardMarkup($inlineKeyboardArray);
//        $sendMessage->execute();
        $commandsStr = "";
        $commands = $this->telegramBot->getCommandMapper()->getCommandListDescription();
        foreach ($commands as $key=>$command) {
            $commandsStr.=$command['command']." - ".$command['description']."\n";
        }
        $sendMessage = new SendMessage(
            $this->telegramBot,
            $chat,
            mb_convert_encoding(
                "Здравствуйте! \n\nВыберите одно из доступных действий:\n\n".$commandsStr."\n",
                "UTF-8",
                "windows-1251")
        );
        $inlineKeyboardArray = array();
        $inlineKeyboardArray[0] = array();
        $inlineKeyboardArray[0][0] = new InlineKeyboardButton(
            mb_convert_encoding(
                "Сайт ИМЭМО РАН",
                "UTF-8",
                "windows-1251"
            ),
            "https://www.imemo.ru"
        );
        $sendMessage->addInlineKeyboardMarkup($inlineKeyboardArray);
//        $keyboardArray = array();
//        $keyboardArray[0] = array();
//        $keyboardArray[0][0] = new KeyboardButton(
//            mb_convert_encoding(
//                "/news",
//                "UTF-8",
//                "windows-1251"
//            )
//        );
//        $keyboardArray[1][0] = new KeyboardButton(
//            mb_convert_encoding(
//                "/actual_comment",
//                "UTF-8",
//                "windows-1251"
//            )
//        );
        //$sendMessage->addReplyKeyboardMarkup($keyboardArray);
        $sendMessage->execute();
        parent::execute($chat, $from);
    }

}