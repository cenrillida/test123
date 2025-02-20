<?php

namespace TelegramBot\Mappers;

use InvalidArgumentException;
use TelegramBot\Models\Update;
use TelegramBot\TelegramBot;

class UpdateMapper {

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
     * @return Update
     */
    public function findById($id)
    {
        global $DB;

        $result = $DB->selectRow("SELECT * FROM tgram WHERE update_id=?d",$id);

        if (empty($result)) {
            throw new InvalidArgumentException("Update #$id not found");
        }

        return $this->mapRowToUpdate($result);
    }

    /**
     * @param array $row
     * @return Update
     */
    private function mapRowToUpdate($row)
    {
        if(!empty($row['message_id'])) {
            $row['message'] = $this->telegramBot->getMessageMapper()->findById($row['message_id']);
        }
        if(!empty($row['callback_query_id'])) {
            $row['callback_query'] = $this->telegramBot->getCallbackQueryMapper()->findById($row['callback_query_id']);
        }
        return Update::fromState($row);
    }

    /**
     * @param Update $update
     */
    public function saveUpdate($update) {
        global $DB;

        try {
            $this->findById($update->getId());
            $DB->query(
                "UPDATE tgram SET message_id=?d, callback_query_id=?  WHERE update_id=?d",
                ($update->getMessage() !== null) ? $update->getMessage()->getId() : null,
                ($update->getCallbackQuery() !== null) ? $update->getCallbackQuery()->getId() : null,
                $update->getId()
            );
        } catch (InvalidArgumentException $exception) {
            $DB->query(
                "INSERT INTO tgram(update_id,message_id,callback_query_id) VALUES (?d,?d,?)",
                $update->getId(),
                ($update->getMessage() !== null) ? $update->getMessage()->getId() : null,
                ($update->getCallbackQuery() !== null) ? $update->getCallbackQuery()->getId() : null
            );
        }

    }

}