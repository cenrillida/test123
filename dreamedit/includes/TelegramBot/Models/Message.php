<?php

namespace TelegramBot\Models;

class Message {

    /** @var int */
    private $id;
    /** @var int */
    private $date;
    /** @var Chat */
    private $chat;
    /** @var User */
    private $from = null;
    /** @var string */
    private $text = null;
    /** @var MessageEntity[] */
    private $entities = null;

    /**
     * @param array $state
     * @return Message
     */
    public static function fromState($state)
    {
        return new self(
            $state['message_id'],
            $state['date'],
            $state['chat'],
            $state['from'],
            $state['text'],
            $state['entities']
        );
    }

    /**
     * Message constructor.
     * @param int $id
     * @param int $date
     * @param Chat $chat
     * @param User $from
     * @param string $text
     * @param MessageEntity[] $entities
     */
    public function __construct($id, $date, $chat, $from = null, $text = null, $entities = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->chat = $chat;
        $this->from = $from;
        $this->text = $text;
        $this->entities = $entities;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return Chat
     */
    public function getChat()
    {
        return $this->chat;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return MessageEntity[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

}