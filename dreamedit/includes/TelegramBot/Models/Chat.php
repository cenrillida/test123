<?php

namespace TelegramBot\Models;

class Chat {

    /** @var int */
    private $id;
    /** @var string */
    private $type;
    /** @var string */
    private $title = null;
    /** @var string */
    private $userName = null;
    /** @var string */
    private $firstName = null;
    /** @var string */
    private $lastName = null;
    /** @var bool */
    private $allMembersAreAdministrators = false;

    /**
     * @param array $state
     * @return Chat
     */
    public static function fromState($state)
    {
        return new self(
            $state['id'],
            $state['type'],
            $state['title'],
            $state['username'],
            $state['first_name'],
            $state['last_name'],
            $state['all_members_are_administrators']
        );
    }

    /**
     * Chat constructor.
     * @param int $id
     * @param string $type
     * @param string $title
     * @param string $userName
     * @param string $firstName
     * @param string $lastName
     * @param bool $allMembersAreAdministrators
     */
    public function __construct($id,
                                $type,
                                $title = null,
                                $userName = null,
                                $firstName = null,
                                $lastName = null,
                                $allMembersAreAdministrators = false)
    {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->allMembersAreAdministrators = $allMembersAreAdministrators;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
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
     * @return bool
     */
    public function isAllMembersAreAdministrators()
    {
        return $this->allMembersAreAdministrators;
    }

}