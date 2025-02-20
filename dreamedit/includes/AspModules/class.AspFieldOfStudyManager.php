<?php

class AspFieldOfStudy {

    /** @var int */
    private $id;
    /** @var string */
    private $name;

    /**
     * AspFieldOfStudy constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}

class AspFieldOfStudyProfile {

    /** @var int */
    private $id;
    /** @var int */
    private $fieldOfStudyId;
    /** @var string */
    private $name;

    /**
     * AspFieldOfStudyProfile constructor.
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

class AspFieldOfStudyManager {
    public function __construct()
    {
    }

    /**
     * @return AspFieldOfStudy[]
     */
    public function getFieldOfStudyList() {
        global $DB;

        $listArr = $DB->select("SELECT * FROM asp_field_of_study");

        $list = array();
        foreach ($listArr as $item) {
            $list[] = new AspFieldOfStudy($item['id'],$item['name']);
        }
        return $list;
    }

    /**
     * @return AspFieldOfStudyProfile[]
     */
    public function getFieldOfStudyProfileListByFieldOfStudyId($id) {
        global $DB;

        $listArr = $DB->select("SELECT * FROM asp_field_of_study_profile WHERE field_of_study_id=?d",$id);

        $list = array();
        foreach ($listArr as $item) {
            $list[] = new AspFieldOfStudyProfile($item['id'],$item['field_of_study_id'],$item['name']);
        }
        return $list;
    }

    /**
     * @return AspFieldOfStudy
     */
    public function getFieldOfStudyById($id) {
        global $DB;

        $listArr = $DB->selectRow("SELECT * FROM asp_field_of_study WHERE id=?d",$id);

        if(!empty($listArr)) {
            $item = new AspFieldOfStudy($listArr['id'],$listArr['name']);
            return $item;
        }
        return null;
    }

    /**
     * @return AspFieldOfStudyProfile
     */
    public function getFieldOfStudyProfileById($id) {
        global $DB;

        $listArr = $DB->selectRow("SELECT * FROM asp_field_of_study_profile WHERE id=?d",$id);

        if(!empty($listArr)) {
            $item = new AspFieldOfStudyProfile($listArr['id'],$listArr['field_of_study'],$listArr['name']);
            return $item;
        }
        return null;
    }
}