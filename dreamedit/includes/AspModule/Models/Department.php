<?php

namespace AspModule\Models;

/**
 * Class Department
 * @package AspModule\Models
 */
class Department {
    /** @var int */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $titleR;
    /** @var string */
    private $titleT;

    /**
     * Department constructor.
     * @param int $id
     * @param string $title
     * @param string $titleR
     * @param string $titleT
     */
    public function __construct($id, $title, $titleR, $titleT)
    {
        $this->id = $id;
        $this->title = $title;
        $this->titleR = $titleR;
        $this->titleT = $titleT;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getTitleR()
    {
        return $this->titleR;
    }

    /**
     * @return string
     */
    public function getTitleT()
    {
        return $this->titleT;
    }

}