<?php

namespace Contest\Models;

/**
 * Class ContestGroup
 * @package Contest\Models
 */
class ContestGroup {

    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $active;
    /**
     * @var Contest[]
     */
    private $contests;
    /**
     * @var string
     */
    private $date;
    /**
     * @var User[]
     */
    private $participants;
    /**
     * @var bool
     */
    private $preview;

    /**
     * ContestGroup constructor.
     * @param int $id
     * @param bool $active
     * @param Contest[] $contests
     * @param string $date
     * @param User[] $participants
     * @param bool $preview
     */
    public function __construct($id, $active, array $contests, $date, array $participants, $preview)
    {
        $this->id = $id;
        $this->active = $active;
        $this->contests = $contests;
        $this->date = $date;
        $this->participants = $participants;
        $this->preview = $preview;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return Contest[]
     */
    public function getContests()
    {
        return $this->contests;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
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
    public function isPreview()
    {
        return $this->preview;
    }

}