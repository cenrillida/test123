<?php

namespace Contest\Models;

/**
 * Class Position
 * @package Contest\Models
 */
class Position {
    /** @var int */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $titleR;
    /** @var string */
    private $departmentCase;

    /**
     * Position constructor.
     * @param int $id
     * @param string $title
     * @param string $titleR
     * @param string $departmentCase
     */
    public function __construct($id, $title, $titleR, $departmentCase)
    {
        $this->id = $id;
        $this->title = $title;
        $this->titleR = $titleR;
        $this->departmentCase = $departmentCase;
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
    public function getDepartmentCase()
    {
        return $this->departmentCase;
    }

}