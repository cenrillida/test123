<?php

namespace TelegramBot\Services;

use TelegramBot\TelegramBot;

class TelegramService {

    private $url = "https://api.telegram.org/bot";
    /** @var TelegramBot */
    private $telegramBot;

    /**
     * @param TelegramBot $telegramBot
     */
    public function __construct($telegramBot)
    {
        $this->telegramBot = $telegramBot;
        $this->url .= $telegramBot->getToken()."/";
    }

    public function performRequest($method, $params) {

        $url = $this->url.$method;

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($params)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            echo "POST ERROR";
        }

    }
}