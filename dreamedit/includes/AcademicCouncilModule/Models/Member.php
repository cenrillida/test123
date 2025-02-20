<?php

namespace AcademicCouncilModule\Models;

class Member {

    /** @var int */
    private $id;
    /** @var int */
    private $userId;
    /** @var string */
    private $lastName;
    /** @var string */
    private $firstName;
    /** @var string */
    private $thirdName;
    /** @var string */
    private $code;
    /** @var string */
    private $meetingParticipation;
    /** @var string */
    private $voteResult;
    /** @var string */
    private $notes;
    /** @var string */
    private $email;
    /** @var bool */
    private $registrationCompleted;


    /**
     * Member constructor.
     * @param int $id
     * @param int $userId
     * @param string $lastName
     * @param string $firstName
     * @param string $thirdName
     * @param string $code
     * @param string $meetingParticipation
     * @param string $voteResult
     * @param string $notes
     * @param string $email
     * @param bool $registrationCompleted
     */
    public function __construct($id, $userId, $lastName, $firstName, $thirdName, $code, $meetingParticipation, $voteResult, $notes, $email, $registrationCompleted)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->thirdName = $thirdName;
        $this->code = $code;
        $this->meetingParticipation = $meetingParticipation;
        $this->voteResult = $voteResult;
        $this->notes = $notes;
        $this->email = $email;
        $this->registrationCompleted = $registrationCompleted;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
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
    public function getLastName()
    {
        return $this->lastName;
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
    public function getThirdName()
    {
        return $this->thirdName;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMeetingParticipation()
    {
        return $this->meetingParticipation;
    }

    /**
     * @return string
     */
    public function getVoteResult()
    {
        return $this->voteResult;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return bool
     */
    public function isRegistrationCompleted()
    {
        return $this->registrationCompleted;
    }

}