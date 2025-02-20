<?php

namespace TelegramBot\Mappers;

use InvalidArgumentException;
use TelegramBot\Models\User;
use TelegramBot\TelegramBot;

class UserMapper {

    /** @var TelegramBot */
    private $telegramBot;

    /**
     * @param TelegramBot $id
     */
    public function __construct($telegramBot)
    {
        $this->telegramBot = $telegramBot;
    }

    /**
     * @param int $id
     * @return User
     */
    public function findById($id)
    {
        global $DB;

        $result = $DB->selectRow("SELECT * FROM tgram_users WHERE id=?d",$id);

        if (empty($result)) {
            throw new InvalidArgumentException("User #$id not found");
        }

        return $this->mapRowToUser($result);
    }

    /**
     * @param array $row
     * @return User
     */
    private function mapRowToUser($row)
    {
        return User::fromState($row);
    }

    /**
     * @param User $user
     */
    public function saveUser($user) {
        global $DB;

        try {
            $this->findById($user->getId());
            $DB->query(
                "UPDATE tgram_users SET first_name=?, last_name=?, username=? WHERE id=?d",
                $user->getFirstName(),
                $user->getLastName(),
                $user->getUserName(),
                $user->getId()
            );
        } catch (InvalidArgumentException $exception) {
            $DB->query(
                "INSERT INTO tgram_users(id,first_name,last_name,username) VALUES (?d,?,?,?)",
                $user->getId(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getUserName()
            );
        }

    }

}