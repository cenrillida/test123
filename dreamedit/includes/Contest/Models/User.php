<?php

namespace Contest\Models;

/**
 * Class User
 * @package Contest\Models
 */
class User {
    /** @var int */
    private $id;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $thirdName;
    /** @var string */
    private $email;
    /** @var string */
    private $password;
    /** @var Status */
    private $status;
    /** @var string */
    private $sign;
    /** @var string */
    private $position;

    /**
     * User constructor.
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $thirdName
     * @param string $email
     * @param string $password
     * @param Status $status
     * @param string $sign
     * @param string $position
     */
    public function __construct($id, $firstName, $lastName, $thirdName, $email, $password, Status $status, $sign, $position)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->thirdName = $thirdName;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
        $this->sign = $sign;
        $this->position = $position;
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
    public function getThirdName()
    {
        return $this->thirdName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }
    
}