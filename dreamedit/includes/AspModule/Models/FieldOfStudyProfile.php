<?php

namespace AspModule\Models;

class FieldOfStudyProfile {

    /** @var int */
    private $id;
    /** @var int */
    private $fieldOfStudyId;
    /** @var string */
    private $name;

    /**
     * FieldOfStudyProfile constructor.
     * @param int $id
     * @param int $fieldOfStudyId
     * @param string $name
     */
    public function __construct($id, $fieldOfStudyId, $name)
    {
        $this->id = $id;
        $this->fieldOfStudyId = $fieldOfStudyId;
        $this->name = $name;
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
    public function getFieldOfStudyId()
    {
        return $this->fieldOfStudyId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}