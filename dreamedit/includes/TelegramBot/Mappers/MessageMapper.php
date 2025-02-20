<?php

namespace TelegramBot\Mappers;

use InvalidArgumentException;
use TelegramBot\Models\Message;
use TelegramBot\TelegramBot;

class MessageMapper {

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
     * @return Message
     */
    public function findById($id)
    {
        global $DB;

        $result = $DB->selectRow("SELECT * FROM tgram_messages WHERE message_id=?d",$id);

        if (empty($result)) {
            throw new InvalidArgumentException("Message #$id not found");
        }

        return $this->mapRowToMessage($result);
    }

    /**
     * @param array $row
     * @return Message
     */
    private function mapRowToMessage($row)
    {
        if(!empty($row['from_id'])) {
            $row['from'] = $this->telegramBot->getUserMapper()->findById($row['from_id']);
        }
        try {
            $row['entities'] = $this->telegramBot->getMessageEntityMapper()->findByMessageId($row['message_id']);
        } catch (InvalidArgumentException $exception) {
            $row['entities'] = null;
        }
        $row['chat'] = $this->telegramBot->getChatMapper()->findById($row['chat_id']);
        return Message::fromState($row);
    }

    /**
     * @param Message $message
     */
    public function saveMessage($message) {
        global $DB;

        try {
            $this->findById($message->getId());
            $DB->query(
                "UPDATE tgram_messages 
                  SET `from_id`=?, `date`=?, chat_id=?, text=? WHERE message_id=?d",
                ($message->getFrom() !== null) ? $message->getFrom()->getId() : null,
                $message->getDate(),
                $message->getChat()->getId(),
                $message->getText(),
                $message->getId()
            );
        } catch (InvalidArgumentException $exception) {
            $DB->query(
                "INSERT INTO tgram_messages(message_id,`from_id`,`date`,chat_id,text) 
                  VALUES (?d,?,?,?,?)",
                $message->getId(),
                ($message->getFrom() !== null) ? $message->getFrom()->getId() : null,
                $message->getDate(),
                $message->getChat()->getId(),
                $message->getText()
            );
        }

    }

}