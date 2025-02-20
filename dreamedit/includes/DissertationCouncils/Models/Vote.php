<?php

namespace DissertationCouncils\Models;

/**
 * Class Vote
 * @package DissertationCouncils\Models
 */
class Vote {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    private $title;
    /**
     * @var User[]
     */
    private $participants;
    /**
     * @var bool
     */
    private $active;
    /**
     * @var bool
     */
    private $preview;
    /**
     * @var string
     */
    private $dissertationCouncilName;
    /**
     * @var int
     */
    private $attended;
    /**
     * @var int
     */
    private $withTechnicalProblem;
    /**
     * @var string
     */
    private $dissertationProfile;
    /**
     * @var string
     */
    private $chairmanName;
    /**
     * @var string
     */
    private $chairmanPosition;
    /**
     * @var string
     */
    private $secretaryName;
    /**
     * @var string
     */
    private $secretaryPosition;
    /**
     * @var int
     */
    private $doctors;

    /**
     * @param int $id
     * @param string $date
     * @param string $title
     * @param User[] $participants
     * @param bool $active
     * @param bool $preview
     * @param string $dissertationCouncilName
     * @param int $attended
     * @param int $withTechnicalProblem
     * @param string $dissertationProfile
     * @param string $chairmanName
     * @param string $chairmanPosition
     * @param string $secretaryName
     * @param string $secretaryPosition
     * @param int $doctors
     */
    public function __construct(
        $id,
        $date,
        $title,
        array $participants,
        $active,
        $preview,
        $dissertationCouncilName,
        $attended,
        $withTechnicalProblem,
        $dissertationProfile,
        $chairmanName,
        $chairmanPosition,
        $secretaryName,
        $secretaryPosition,
        $doctors
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->title = $title;
        $this->participants = $participants;
        $this->active = $active;
        $this->preview = $preview;
        $this->dissertationCouncilName = $dissertationCouncilName;
        $this->attended = $attended;
        $this->withTechnicalProblem = $withTechnicalProblem;
        $this->dissertationProfile = $dissertationProfile;
        $this->chairmanName = $chairmanName;
        $this->chairmanPosition = $chairmanPosition;
        $this->secretaryName = $secretaryName;
        $this->secretaryPosition = $secretaryPosition;
        $this->doctors = $doctors;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return User[]
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isPreview()
    {
        return $this->preview;
    }

    /**
     * @return string
     */
    public function getDissertationCouncilName()
    {
        return $this->dissertationCouncilName;
    }

    /**
     * @return int
     */
    public function getAttended()
    {
        return $this->attended;
    }

    /**
     * @return int
     */
    public function getWithTechnicalProblem()
    {
        return $this->withTechnicalProblem;
    }

    /**
     * @return string
     */
    public function getDissertationProfile()
    {
        return $this->dissertationProfile;
    }

    /**
     * @return string
     */
    public function getChairmanName()
    {
        return $this->chairmanName;
    }

    /**
     * @return string
     */
    public function getChairmanPosition()
    {
        return $this->chairmanPosition;
    }

    /**
     * @return string
     */
    public function getSecretaryName()
    {
        return $this->secretaryName;
    }

    /**
     * @return string
     */
    public function getSecretaryPosition()
    {
        return $this->secretaryPosition;
    }

    /**
     * @return int
     */
    public function getDoctors()
    {
        return $this->doctors;
    }

}