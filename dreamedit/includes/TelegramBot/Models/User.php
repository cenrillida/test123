<?php

namespace TelegramBot\Models;

class User {

    /** @var int */
    private $id;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName = null;
    /** @var string */
    private $userName = null;

    /**
     * @param array $state
     * @return User
     */
    public static function fromState($state)
    {
        return new self(
            $state['id'],
            $state['first_name'],
            $state['last_name'],
            $state['username']
        );
    }

    /**
     * User constructor.
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $userName
     */
    public function __construct($id, $firstName, $lastName = null, $userName = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userName = $userName;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

}