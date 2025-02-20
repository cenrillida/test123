<?php

namespace TelegramBot\Models;

class Update {

    /** @var int */
    private $id;
    /** @var Message */
    private $message = null;
    /** @var CallbackQuery */
    private $callbackQuery = null;

    /**
     * @param array $state
     * @return Update
     */
    public static function fromState($state)
    {
        return new self(
            $state['update_id'],
            $state['message'],
            $state['callback_query']
        );
    }

    /**
     * Update constructor.
     * @param int $id
     * @param Message $message
     * @param CallbackQuery $callbackQuery
     */
    public function __construct($id, $message = null, $callbackQuery = null)
    {
        $this->id = $id;
        $this->message = $message;
        $this->callbackQuery = $callbackQuery;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return CallbackQuery
     */
    public function getCallbackQuery()
    {
        return $this->callbackQuery;
    }

}