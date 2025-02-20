<?php

namespace DissertationCouncils\Models;

/**
 * Class DissertationCouncil
 * @package DissertationCouncils\Models
 */
class DissertationCouncil {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var User[]
     */
    private $team;

    /**
     * @param int $id
     * @param string $name
     * @param User[] $team
     */
    public function __construct($id, $name, array $team)
    {
        $this->id = $id;
        $this->name = $name;
        $this->team = $team;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return User[]
     */
    public function getTeam()
    {
        return $this->team;
    }

}