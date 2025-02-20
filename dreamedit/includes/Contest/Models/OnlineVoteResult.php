<?php

namespace Contest\Models;

/**
 * Class OnlineVoteResult
 * @package Contest\Models
 */
class OnlineVoteResult {
    /** @var int */
    private $id;
    /** @var int */
    private $scienceResults;
    /** @var int */
    private $experience;
    /** @var int */
    private $interview;
    /** @var int */
    private $total;
    /** @var User */
    private $user;
    /** @var Applicant */
    private $applicant;

    /**
     * OnlineVoteResult constructor.
     * @param int $id
     * @param int $scienceResults
     * @param int $experience
     * @param int $interview
     * @param int $total
     * @param User $user
     * @param Applicant $applicant
     */
    public function __construct($id, $scienceResults, $experience, $interview, $total, User $user, Applicant $applicant)
    {
        $this->id = $id;
        $this->scienceResults = $scienceResults;
        $this->experience = $experience;
        $this->interview = $interview;
        $this->total = $total;
        $this->user = $user;
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
    public function getScienceResults()
    {
        return $this->scienceResults;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @return int
     */
    public function getInterview()
    {
        return $this->interview;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Applicant
     */
    public function getApplicant()
    {
        return $this->applicant;
    }


}