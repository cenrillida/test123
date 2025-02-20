<?php

namespace Contest\Models;

/**
 * Class Applicant
 * @package Contest\Models
 */
class Applicant {
    /** @var int */
    private $id;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $thirdName;
    /** @var string */
    private $firstNameR;
    /** @var string */
    private $lastNameR;
    /** @var string */
    private $thirdNameR;
    /** @var array */
    private $documents;
    /** @var int */
    private $onlineVoteManualTotal;

    /**
     * Applicant constructor.
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $thirdName
     * @param string $firstNameR
     * @param string $lastNameR
     * @param string $thirdNameR
     * @param array $documents
     * @param int $onlineVoteManualTotal
     */
    public function __construct($id, $firstName, $lastName, $thirdName, $firstNameR, $lastNameR, $thirdNameR, array $documents, $onlineVoteManualTotal)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->thirdName = $thirdName;
        $this->firstNameR = $firstNameR;
        $this->lastNameR = $lastNameR;
        $this->thirdNameR = $thirdNameR;
        $this->documents = $documents;
        $this->onlineVoteManualTotal = $onlineVoteManualTotal;
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
     * @return array
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return string
     */
    public function getFirstNameR()
    {
        return $this->firstNameR;
    }

    /**
     * @return string
     */
    public function getLastNameR()
    {
        return $this->lastNameR;
    }

    /**
     * @return string
     */
    public function getThirdNameR()
    {
        return $this->thirdNameR;
    }

    /**
     * @return int
     */
    public function getOnlineVoteManualTotal()
    {
        return $this->onlineVoteManualTotal;
    }
}