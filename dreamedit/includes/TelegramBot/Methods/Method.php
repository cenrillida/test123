<?php

namespace TelegramBot\Methods;

use TelegramBot\Models\Chat;
use TelegramBot\Models\InlineKeyboardButton;
use TelegramBot\Models\KeyboardButton;
use TelegramBot\Models\Message;
use TelegramBot\TelegramBot;

abstract class Method {

    /** @var string name */
    protected $name;
    /** @var mixed array */
    protected $params;
    /** @var string[] */
    protected $htmlFields = array();
    /** @var TelegramBot */
    protected $telegramBot;

    /**
     * @param TelegramBot $telegramBot
     * @param Chat $chat
     */
    public function __construct($telegramBot, $chat = null)
    {
        $this->telegramBot = $telegramBot;
        if(!empty($chat)) {
            $this->params['chat_id'] = $chat->getId();
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    public function execute() {
        $this->telegramBot->getTelegramService()->performRequest($this->name,$this->params);
    }

    /**
     * @param InlineKeyboardButton[][] $inlineKeyboardMarkup
     */
    public function addInlineKeyboardMarkup($inlineKeyboardMarkup) {

        $inlineKeyboardArray = array();
        foreach ($inlineKeyboardMarkup as $k => $x) {
            $inlineKeyboardArray[$k] = array();
            foreach ($x as $y) {
                $inlineKeyboardArray[$k][] = $this->telegramBot->getInlineKeyboardButtonMapper()->toArray($y);
            }
        }

        $inlineKeyboard = array(
            "inline_keyboard" => $inlineKeyboardArray
        );
        $this->params['reply_markup'] = json_encode($inlineKeyboard);
    }

    /**
     * @param KeyboardButton[][] $keyboardMarkup
     */
    public function addReplyKeyboardMarkup($keyboardMarkup) {

        $keyboardArray = array();
        foreach ($keyboardMarkup as $k => $x) {
            $keyboardArray[$k] = array();
            foreach ($x as $y) {
                $keyboardArray[$k][] = $this->telegramBot->getKeyboardButtonMapper()->toArray($y);
            }
        }

        $replyKeyboardMarkup = array(
            "keyboard" => $keyboardArray
        );
        $this->params['reply_markup'] = json_encode($replyKeyboardMarkup);
    }

    public function setHTMLStyle() {
        foreach ($this->htmlFields as $htmlField) {
            $this->params[$htmlField] = $this->cleanTextHtml($this->params[$htmlField]);
        }
        $this->params['parse_mode'] = "HTML";
    }

    public function setMarkdownStyle() {
        $this->params['parse_mode'] = "Markdown";
    }

    /**
     * @param Message $message
     */
    public function addReplyToMessage($message) {
        $this->params['reply_to_message_id'] = $message->getId();
    }

    private function cleanTextHtml($text) {
        $text = str_replace("&nbsp;"," ",$text);
        $text = str_replace("&laquo;","\"",$text);
        $text = str_replace("&raquo;","\"",$text);
        $text = str_replace("&ndash;","-",$text);
        $text = preg_replace(
            "/<(?!\/?(s|strike|del|code|pre|u|ins|i|b|em|strong|a)(>|\s))[^<]+?>/i",
            "",
            $text
        );
        $text = preg_replace("/&(?!(quot|lt|gt|amp))[^ ;]+?;/i","",$text);
        return $text;
    }

}