<?php

namespace TelegramBot\Models;

class CallbackQuery {

    /** @var string */
    private $id;
    /** @var User */
    private $from;
    /** @var string */
    private $data;
    /** @var Message */
    private $message = null;
    /** @var string */
    private $inlineMessageId = null;

    /**
     * @param array $state
     * @return CallbackQuery
     */
    public static function fromState($state)
    {
        return new self(
            $state['id'],
            $state['from'],
            $state['data'],
            $state['message'],
            $state['inline_message_id']
        );
    }

    /**
     * CallbackQuery constructor.
     * @param string $id
     * @param User $from
     * @param string $data
     * @param Message $message
     * @param string $inlineMessageId
     */
    public function __construct($id, User $from, $data, Message $message = null, $inlineMessageId = null)
    {
        $this->id = $id;
        $this->from = $from;
        $this->data = $data;
        $this->message = $message;
        $this->inlineMessageId = $inlineMessageId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getInlineMessageId()
    {
        return $this->inlineMessageId;
    }

}