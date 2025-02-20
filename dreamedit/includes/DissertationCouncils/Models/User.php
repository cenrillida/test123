<?php

namespace DissertationCouncils\Models;

/**
 * Class User
 * @package DissertationCouncils\Models
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
    private $phone;

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $thirdName
     * @param string $email
     * @param string $password
     * @param Status $status
     * @param string $phone
     */
    public function __construct($id, $firstName, $lastName, $thirdName, $email, $password, Status $status, $phone)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->thirdName = $thirdName;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
        $this->phone = $phone;
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
    public function getPhone()
    {
        return $this->phone;
    }
    
}