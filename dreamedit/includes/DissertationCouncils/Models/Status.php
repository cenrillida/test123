<?php

namespace DissertationCouncils\Models;

/**
 * Class Status
 * @package DissertationCouncils\Models
 */
class Status {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $text;
    /**
     * @var bool
     */
    private $admin;
    /**
     * @var bool
     */
    private $canVote;

    /**
     * Status constructor.
     * @param int $id
     * @param string $text
     * @param bool $admin
     * @param bool $canVote
     */
    public function __construct($id, $text, $admin, $canVote)
    {
        $this->id = $id;
        $this->text = $text;
        $this->admin = $admin;
        $this->canVote = $canVote;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @return bool
     */
    public function isCanVote()
    {
        return $this->canVote;
    }

}