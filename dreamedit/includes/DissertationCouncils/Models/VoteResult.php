<?php

namespace DissertationCouncils\Models;

/**
 * Class VoteResult
 * @package DissertationCouncils\Models
 */
class VoteResult {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $result;
    /**
     * @var User
     */
    private $user;

    /**
     * @param int $id
     * @param string $result
     * @param User $user
     */
    public function __construct($id, $result, User $user)
    {
        $this->id = $id;
        $this->result = $result;
        $this->user = $user;
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
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

}