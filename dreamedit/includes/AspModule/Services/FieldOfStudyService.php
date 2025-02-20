<?php

namespace AspModule\Services;

use AspModule\Models\FieldOfStudy;
use AspModule\Models\FieldOfStudyProfile;

class FieldOfStudyService {

    public function __construct()
    {
    }

    /**
     * @return FieldOfStudy[]
     */
    public function getFieldOfStudyList() {
        global $DB;

        $listArr = $DB->select("SELECT * FROM asp_field_of_study");

        $list = array();
        foreach ($listArr as $item) {
            $list[] = new FieldOfStudy($item['id'],$item['name']);
        }
        return $list;
    }

    /**
     * @return FieldOfStudyProfile[]
     */
    public function getFieldOfStudyProfileListByFieldOfStudyId($id) {
        global $DB;

        $listArr = $DB->select("SELECT * FROM asp_field_of_study_profile WHERE field_of_study_id=?d",$id);

        $list = array();
        foreach ($listArr as $item) {
            $list[] = new FieldOfStudyProfile($item['id'],$item['field_of_study_id'],$item['name']);
        }
        return $list;
    }

    /**
     * @return FieldOfStudy
     */
    public function getFieldOfStudyById($id) {
        global $DB;

        $listArr = $DB->selectRow("SELECT * FROM asp_field_of_study WHERE id=?d",$id);

        if(!empty($listArr)) {
            $item = new FieldOfStudy($listArr['id'],$listArr['name']);
            return $item;
        }
        return null;
    }

    /**
     * @return FieldOfStudyProfile
     */
    public function getFieldOfStudyProfileById($id) {
        global $DB;

        $listArr = $DB->selectRow("SELECT * FROM asp_field_of_study_profile WHERE id=?d",$id);

        if(!empty($listArr)) {
            $item = new FieldOfStudyProfile($listArr['id'],$listArr['field_of_study'],$listArr['name']);
            return $item;
        }
        return null;
    }
}