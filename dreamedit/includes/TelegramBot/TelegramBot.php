<?php

namespace TelegramBot;

use TelegramBot\Mappers\CallbackQueryMapper;
use TelegramBot\Mappers\ChatMapper;
use TelegramBot\Mappers\CommandMapper;
use TelegramBot\Mappers\InlineKeyboardButtonMapper;
use TelegramBot\Mappers\KeyboardButtonMapper;
use TelegramBot\Mappers\MessageEntityMapper;
use TelegramBot\Mappers\MessageMapper;
use TelegramBot\Mappers\UpdateMapper;
use TelegramBot\Mappers\UserMapper;
use TelegramBot\Processors\CommandProcessor;
use TelegramBot\Processors\RequestProcessor;
use TelegramBot\Services\TelegramService;

class TelegramBot {

    private $token = "1261523529:AAGqg-z46JnDMz1GV5ZqdZBntCKubqMMPYE";
    private $id = 1261523529;
    /** @var TelegramBot */
    private static $_instance = null;
    /** @var UpdateMapper */
    private $updateMapper;
    /** @var MessageMapper */
    private $messageMapper;
    /** @var ChatMapper */
    private $chatMapper;
    /** @var UserMapper */
    private $userMapper;
    /** @var MessageEntityMapper */
    private $messageEntityMapper;
    /** @var CommandMapper */
    private $commandMapper;
    /** @var InlineKeyboardButtonMapper */
    private $inlineKeyboardButtonMapper;
    /** @var KeyboardButtonMapper */
    private $keyboardButtonMapper;
    /** @var CallbackQueryMapper */
    private $callbackQueryMapper;
    /** @var RequestProcessor */
    private $requestProcessor;
    /** @var CommandProcessor */
    private $commandProcessor;
    /** @var TelegramService */
    private $telegramService;

    private function __construct()
    {
        $this->updateMapper = new UpdateMapper($this);
        $this->messageMapper = new MessageMapper($this);
        $this->chatMapper = new ChatMapper($this);
        $this->userMapper = new UserMapper($this);
        $this->messageEntityMapper = new MessageEntityMapper($this);
        $this->commandMapper = new CommandMapper($this);
        $this->inlineKeyboardButtonMapper = new InlineKeyboardButtonMapper($this);
        $this->keyboardButtonMapper = new KeyboardButtonMapper($this);
        $this->callbackQueryMapper = new CallbackQueryMapper($this);
        $this->requestProcessor = new RequestProcessor($this);
        $this->commandProcessor = new CommandProcessor($this);
        $this->telegramService = new TelegramService($this);
    }

    /**
     * @return TelegramBot
     */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            self::$_instance = new TelegramBot();
        }
        return self::$_instance;
    }

    public function processRequest() {
                error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->requestProcessor->processRequest();
    }

    /**
     * @return bool
     */
    public function isTelegramRequest($url) {
        if($this->token === $url) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return UpdateMapper
     */
    public function getUpdateMapper()
    {
        return $this->updateMapper;
    }

    /**
     * @return MessageMapper
     */
    public function getMessageMapper()
    {
        return $this->messageMapper;
    }

    /**
     * @return ChatMapper
     */
    public function getChatMapper()
    {
        return $this->chatMapper;
    }

    /**
     * @return UserMapper
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }

    /**
     * @return MessageEntityMapper
     */
    public function getMessageEntityMapper()
    {
        return $this->messageEntityMapper;
    }

    /**
     * @return RequestProcessor
     */
    public function getRequestProcessor()
    {
        return $this->requestProcessor;
    }

    /**
     * @return CommandProcessor
     */
    public function getCommandProcessor()
    {
        return $this->commandProcessor;
    }

    /**
     * @return CommandMapper
     */
    public function getCommandMapper()
    {
        return $this->commandMapper;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return InlineKeyboardButtonMapper
     */
    public function getInlineKeyboardButtonMapper()
    {
        return $this->inlineKeyboardButtonMapper;
    }

    /**
     * @return TelegramService
     */
    public function getTelegramService()
    {
        return $this->telegramService;
    }

    /**
     * @return CallbackQueryMapper
     */
    public function getCallbackQueryMapper()
    {
        return $this->callbackQueryMapper;
    }

    /**
     * @return KeyboardButtonMapper
     */
    public function getKeyboardButtonMapper()
    {
        return $this->keyboardButtonMapper;
    }

}