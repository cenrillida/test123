<?php

namespace TelegramBot\Processors;

use TelegramBot\Models\CallbackQuery;
use TelegramBot\Models\Chat;
use TelegramBot\Models\Message;
use TelegramBot\Models\MessageEntity;
use TelegramBot\Models\User;
use TelegramBot\TelegramBot;
use TelegramBot\Models\Update;

class RequestProcessor {

    /** @var TelegramBot */
    private $telegramBot;

    /**
     * @param TelegramBot $telegramBot
     */
    public function __construct($telegramBot)
    {
        $this->telegramBot = $telegramBot;
    }

    private function checkRepeatRequest($updateId) {
        if(!empty($updateId)) {
            try {
                $this->telegramBot->getUpdateMapper()->findById($updateId);
                return true;
            } catch (\InvalidArgumentException $exception) {
                return false;
            }
        } else {
            throw new \InvalidArgumentException("Update ID is empty");
        }
    }

    public function processRequest() {
        global $DB;
        $DB->query("SET NAMES utf8");
        $update = json_decode(file_get_contents("php://input"), TRUE);

        ob_start();

        var_dump($update);
            //возможно это както завернуть в абстрактный класс
        try {
            if (!$this->checkRepeatRequest($update['update_id'])) {

                if (!empty($update['update_id']) && !empty($update['message']['from'])) {
                    $from = User::fromState($update['message']['from']);
                    $update['message']['from'] = $from;
                    $this->telegramBot->getUserMapper()->saveUser($from);
                }
                if (!empty($update['update_id']) && !empty($update['message']['chat'])) {
                    $chat = Chat::fromState($update['message']['chat']);
                    $update['message']['chat'] = $chat;
                    $this->telegramBot->getChatMapper()->saveChat($chat);
                }
                if (!empty($update['update_id']) && !empty($update['message']['entities'])) {
                    $entitiesNewArray = array();
                    foreach ($update['message']['entities'] as $entity) {
                        $messageEntity = MessageEntity::fromState($entity);
                        $entitiesNewArray[] = $messageEntity;
                    }
                    $this->
                    telegramBot->
                    getMessageEntityMapper()->
                    saveMessageEntities($entitiesNewArray,$update['message']['message_id']);
                    $update['message']['entities'] = $entitiesNewArray;
                }
                if (!empty($update['update_id']) && !empty($update['message'])) {
                    $message = Message::fromState($update['message']);
                    $update['message'] = $message;
                    $this->telegramBot->getMessageMapper()->saveMessage($message);
                }

                if(!empty($update['update_id']) && !empty($update['callback_query']['from'])) {
                    $from = User::fromState($update['callback_query']['from']);
                    $update['callback_query']['from'] = $from;
                    $this->telegramBot->getUserMapper()->saveUser($from);
                }
                if(!empty($update['update_id']) && !empty($update['callback_query']['message']['from'])) {
                    $from = User::fromState($update['callback_query']['message']['from']);
                    $update['callback_query']['message']['from'] = $from;
                    $this->telegramBot->getUserMapper()->saveUser($from);
                }
                if (!empty($update['update_id']) && !empty($update['callback_query']['message']['chat'])) {
                    $chat = Chat::fromState($update['callback_query']['message']['chat']);
                    $update['callback_query']['message']['chat'] = $chat;
                    $this->telegramBot->getChatMapper()->saveChat($chat);
                }
                if (!empty($update['update_id']) && !empty($update['callback_query']['message'])) {
                    $message = Message::fromState($update['callback_query']['message']);
                    $update['callback_query']['message'] = $message;
                    $this->telegramBot->getMessageMapper()->saveMessage($message);
                }
                if (!empty($update['update_id']) && !empty($update['callback_query'])) {
                    $callBackQuery = CallbackQuery::fromState($update['callback_query']);
                    $update['callback_query'] = $callBackQuery;
                    $this->telegramBot->getCallbackQueryMapper()->saveCallbackQuery($callBackQuery);
                }

                if (!empty($update['update_id'])) {
                    $updateObject = Update::fromState($update);
                    $this->telegramBot->getUpdateMapper()->saveUpdate($updateObject);
                }
                if(!empty($message)) {
                    if ($message->getFrom()->getId() != $this->telegramBot->getId()) {
                        if($message->getEntities() != null) {
                            foreach ($message->getEntities() as $entity) {
                                $commandName = substr($message->getText(), $entity->getOffset(), $entity->getLength());
                                $this->
                                telegramBot->
                                getCommandProcessor()->
                                processCommand($commandName, $message->getChat(), $message->getFrom());
                            }
                        }
                    }
                }
                if(!empty($callBackQuery)) {
                    if($callBackQuery->getMessage() != null) {
                        $this->telegramBot->getCommandProcessor()->processCommand(
                            $callBackQuery->getData(),
                            $callBackQuery->getMessage()->getChat(),
                            $callBackQuery->getFrom()
                        );
                    }
                }
            }
        } catch (\InvalidArgumentException $exception) {
            echo $exception->getMessage();
        }

        $html_index = ob_get_clean();

        $uniqid = time() . ".log";

        $handle = fopen($_SERVER["DOCUMENT_ROOT"] . "/tgram-log/".$uniqid, "w");
        fwrite($handle, $html_index);
        fclose($handle);
    }

}