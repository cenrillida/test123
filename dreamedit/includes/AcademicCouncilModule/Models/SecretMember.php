<?php

namespace AcademicCouncilModule\Models;

class SecretMember {

    /** @var int */
    private $id;
    /** @var string */
    private $code;
    /** @var string */
    private $meetingParticipation;
    /** @var string */
    private $voteResult;
    /** @var string */
    private $notes;
    /** @var int */
    private $userId;

    /**
     * SecretMember constructor.
     * @param int $id
     * @param string $code
     * @param string $meetingParticipation
     * @param string $voteResult
     * @param string $notes
     * @param int $userId
     */
    public function __construct($id, $code, $meetingParticipation, $voteResult, $notes, $userId)
    {
        $this->id = $id;
        $this->code = $code;
        $this->meetingParticipation = $meetingParticipation;
        $this->voteResult = $voteResult;
        $this->notes = $notes;
        $this->userId = $userId;
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
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

}