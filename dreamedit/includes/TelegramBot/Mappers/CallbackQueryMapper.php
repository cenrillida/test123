<?php

namespace TelegramBot\Mappers;

use InvalidArgumentException;
use TelegramBot\Models\CallbackQuery;
use TelegramBot\TelegramBot;

class CallbackQueryMapper {

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
     * @param string $id
     * @return CallbackQuery
     */
    public function findById($id)
    {
        global $DB;

        $result = $DB->selectRow("SELECT * FROM tgram_callback_queries WHERE id=?",$id);

        if (empty($result)) {
            throw new InvalidArgumentException("Callback Query #$id not found");
        }

        return $this->mapRowToCallbackQuery($result);
    }

    /**
     * @param array $row
     * @return CallbackQuery
     */
    private function mapRowToCallbackQuery($row)
    {
        if(!empty($row['message_id'])) {
            $row['message'] = $this->telegramBot->getMessageMapper()->findById($row['message_id']);
        }
        if(!empty($row['from_id'])) {
            $row['from'] = $this->telegramBot->getUserMapper()->findById($row['from_id']);
        }
        return CallbackQuery::fromState($row);
    }

    /**
     * @param CallbackQuery $callbackQuery
     */
    public function saveCallbackQuery($callbackQuery) {
        global $DB;

        try {
            $this->findById($callbackQuery->getId());
            $DB->query(
                "UPDATE tgram_callback_queries SET from_id=?, `data`=?, message_id=?, inline_message_id=?  WHERE id=?",
                ($callbackQuery->getFrom() !== null) ? $callbackQuery->getFrom()->getId() : null,
                $callbackQuery->getData(),
                ($callbackQuery->getMessage() !== null) ? $callbackQuery->getMessage()->getId() : null,
                $callbackQuery->getInlineMessageId(),
                $callbackQuery->getId()
            );
        } catch (InvalidArgumentException $exception) {
            $DB->query(
                "INSERT INTO tgram_callback_queries(id,from_id,`data`,message_id,inline_message_id) VALUES (?,?,?,?,?)",
                $callbackQuery->getId(),
                ($callbackQuery->getFrom() !== null) ? $callbackQuery->getFrom()->getId() : null,
                $callbackQuery->getData(),
                ($callbackQuery->getMessage() !== null) ? $callbackQuery->getMessage()->getId() : null,
                $callbackQuery->getInlineMessageId()
            );
        }

    }

}