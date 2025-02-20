<?php

namespace Contest\Models;

/**
 * Class OnlineVoteResult
 * @package Contest\Models
 */
class OpenVoteResult {
    /** @var int */
    private $id;
    /** @var int */
    private $for;
    /** @var int */
    private $against;
    /** @var int */
    private $abstained;
    /** @var Applicant */
    private $applicant;

    /**
     * OpenVoteResult constructor.
     * @param int $id
     * @param int $for
     * @param int $against
     * @param int $abstained
     * @param Applicant $applicant
     */
    public function __construct($id, $for, $against, $abstained, Applicant $applicant)
    {
        $this->id = $id;
        $this->for = $for;
        $this->against = $against;
        $this->abstained = $abstained;
        $this->applicant = $applicant;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getFor()
    {
        return $this->for;
    }

    /**
     * @return int
     */
    public function getAgainst()
    {
        return $this->against;
    }

    /**
     * @return int
     */
    public function getAbstained()
    {
        return $this->abstained;
    }

    /**
     * @return Applicant
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

}