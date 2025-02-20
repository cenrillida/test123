<?php

namespace TelegramBot\Mappers;

use InvalidArgumentException;
use TelegramBot\Models\Chat;
use TelegramBot\TelegramBot;

class ChatMapper {

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
     * @return Chat
     */
    public function findById($id)
    {
        global $DB;

        $result = $DB->selectRow("SELECT * FROM tgram_chats WHERE id=?d",$id);

        if (empty($result)) {
            throw new InvalidArgumentException("Chat #$id not found");
        }

        return $this->mapRowToChat($result);
    }

    /**
     * @param array $row
     * @return Chat
     */
    private function mapRowToChat($row)
    {
        return Chat::fromState($row);
    }

    /**
     * @param Chat $chat
     */
    public function saveChat($chat) {
        global $DB;

        try {
            $this->findById($chat->getId());
            $DB->query(
                "UPDATE tgram_chats 
                  SET `type`=?, first_name=?, last_name=?, username=?, title=?, all_members_are_administrators=?
                  WHERE id=?d",
                $chat->getId(),
                $chat->getType(),
                $chat->getFirstName(),
                $chat->getLastName(),
                $chat->getUserName(),
                $chat->getTitle(),
                $chat->isAllMembersAreAdministrators(),
                $chat->getId()
            );
        } catch (InvalidArgumentException $exception) {
            $DB->query(
                "INSERT INTO tgram_chats(id,`type`,first_name,last_name,username,title,all_members_are_administrators) 
                  VALUES (?d,?,?,?,?,?,?)",
                $chat->getId(),
                $chat->getType(),
                $chat->getFirstName(),
                $chat->getLastName(),
                $chat->getUserName(),
                $chat->getTitle(),
                $chat->isAllMembersAreAdministrators()
            );
        }

    }

}