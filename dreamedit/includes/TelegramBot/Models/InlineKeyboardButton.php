<?php

namespace TelegramBot\Models;

class InlineKeyboardButton {

    /** @var string */
    private $text;
    /** @var string */
    private $url = null;
    /** @var string */
    private $callbackData = null;

    /**
     * InlineKeyboardButton constructor.
     * @param string $text
     * @param string $url
     * @param string $callbackData
     */
    public function __construct($text, $url = null, $callbackData = null)
    {
        $this->text = $text;
        $this->url = $url;
        $this->callbackData = $callbackData;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCallbackData()
    {
        return $this->callbackData;
    }

}