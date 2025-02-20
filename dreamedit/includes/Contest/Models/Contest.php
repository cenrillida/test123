<?php

namespace Contest\Models;

/**
 * Class Contest
 * @package Contest\Models
 */
class Contest {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $positionR;
    /**
     * @var string
     */
    private $protocol;
    /**
     * @var Applicant[]
     */
    private $applicants;
    /**
     * @var string
     */
    private $position;
    /**
     * @var string
     */
    private $date;
    /**
     * @var int
     */
    private $contestGroupId;
    /**
     * @var bool
     */
    private $onlineVote;
    /**
     * @var User
     */
    private $chairman;
    /**
     * @var User
     */
    private $viceChairman;
    /**
     * @var User
     */
    private $secretary;
    /**
     * @var Applicant
     */
    private $firstPlace;
    /**
     * @var Applicant
     */
    private $secondPlace;
    /**
     * @var string
     */
    private $contractTerm;
    /**
     * @var string
     */
    private $numberOfPeoplePresented;

    /**
     * Contest constructor.
     * @param int $id
     * @param string $positionR
     * @param string $protocol
     * @param Applicant[] $applicants
     * @param string $position
     * @param string $date
     * @param int $contestGroupId
     * @param bool $onlineVote
     * @param User $chairman
     * @param User $viceChairman
     * @param User $secretary
     * @param Applicant $firstPlace
     * @param Applicant $secondPlace
     * @param string $contractTerm
     * @param string $numberOfPeoplePresented
     */
    public function __construct($id, $positionR, $protocol, array $applicants, $position, $date, $contestGroupId, $onlineVote, $chairman, $viceChairman, $secretary, $firstPlace, $secondPlace, $contractTerm, $numberOfPeoplePresented)
    {
        $this->id = $id;
        $this->positionR = $positionR;
        $this->protocol = $protocol;
        $this->applicants = $applicants;
        $this->position = $position;
        $this->date = $date;
        $this->contestGroupId = $contestGroupId;
        $this->onlineVote = $onlineVote;
        $this->chairman = $chairman;
        $this->viceChairman = $viceChairman;
        $this->secretary = $secretary;
        $this->firstPlace = $firstPlace;
        $this->secondPlace = $secondPlace;
        $this->contractTerm = $contractTerm;
        $this->numberOfPeoplePresented = $numberOfPeoplePresented;
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
    public function getPositionR()
    {
        return $this->positionR;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @return Applicant[]
     */
    public function getApplicants()
    {
        return $this->applicants;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getContestGroupId()
    {
        return $this->contestGroupId;
    }

    /**
     * @return bool
     */
    public function isOnlineVote()
    {
        return $this->onlineVote;
    }

    /**
     * @return User
     */
    public function getChairman()
    {
        return $this->chairman;
    }

    /**
     * @return User
     */
    public function getViceChairman()
    {
        return $this->viceChairman;
    }

    /**
     * @return User
     */
    public function getSecretary()
    {
        return $this->secretary;
    }

    /**
     * @return Applicant
     */
    public function getFirstPlace()
    {
        return $this->firstPlace;
    }

    /**
     * @return Applicant
     */
    public function getSecondPlace()
    {
        return $this->secondPlace;
    }

    /**
     * @return string
     */
    public function getContractTerm()
    {
        return $this->contractTerm;
    }

    /**
     * @return string
     */
    public function getNumberOfPeoplePresented()
    {
        return $this->numberOfPeoplePresented;
    }

}