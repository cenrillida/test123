<?php

namespace TelegramBot\Models;

class MessageEntity {

    /** @var string */
    private $type;
    /** @var int */
    private $offset;
    /** @var int */
    private $length;
    /** @var string */
    private $url = null;

    /**
     * @param array $state
     * @return MessageEntity
     */
    public static function fromState($state)
    {
        return new self(
            $state['type'],
            $state['offset'],
            $state['length'],
            $state['url']
        );
    }

    /**
     * MessageEntity constructor.
     * @param string $type
     * @param int $offset
     * @param int $length
     * @param string $url
     */
    public function __construct($type, $offset, $length, $url = null)
    {
        $this->type = $type;
        $this->offset = $offset;
        $this->length = $length;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

}