<?php

namespace TelegramBot\Mappers;

use InvalidArgumentException;
use TelegramBot\Models\MessageEntity;
use TelegramBot\TelegramBot;

class MessageEntityMapper {

    /** @var TelegramBot */
    private $telegramBot;

    /**
     * @param TelegramBot $telegramBot
     */
    public function __construct($telegramBot)
    {
        $this->telegramBot = $telegramBot;
    }

    /**
     * @param int $id
     * @return MessageEntity
     */
    public function findById($id)
    {
        global $DB;

        $result = $DB->selectRow("SELECT * FROM tgram_messages_entities WHERE id=?d",$id);

        if (empty($result)) {
            throw new InvalidArgumentException("MessageEntity #$id not found");
        }

        return $this->mapRowToMessageEntity($result);
    }

    /**
     * @param int $messageId
     * @return MessageEntity[]
     */
    public function findByMessageId($messageId) {
        global $DB;

        $result = $DB->select("SELECT * FROM tgram_messages_entities WHERE message_id=?d",$messageId);

        if (empty($result)) {
            throw new InvalidArgumentException("MessageEntities from message #$messageId not found");
        }

        $messageEntities = array();
        foreach ($result as $row) {
            $messageEntities[] = $this->mapRowToMessageEntity($row);
        }

        return $messageEntities;
    }

    /**
     * @param array $row
     * @return MessageEntity
     */
    private function mapRowToMessageEntity($row)
    {
        return MessageEntity::fromState($row);
    }

    /**
     * @param MessageEntity[] $messageEntities
     */
    public function saveMessageEntities($messageEntities, $messageId) {
        global $DB;

        try {
            $this->findByMessageId($messageId);
            $DB->query(
                "DELETE FROM tgram_messages_entities WHERE message_id=?d",
                $messageId
            );
        } catch (InvalidArgumentException $exception) {

        }
        foreach ($messageEntities as $messageEntity) {
            $DB->query(
                "INSERT INTO tgram_messages_entities(message_id,`type`,offset,`length`,url) 
                  VALUES (?d,?,?,?,?)",
                $messageId,
                $messageEntity->getType(),
                $messageEntity->getOffset(),
                $messageEntity->getLength(),
                $messageEntity->getUrl()
            );
        }

    }

}