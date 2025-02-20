<?php

namespace AspModule\Services;

use AspModule\Models\ApplicationsYear;

class ApplicationsYearService {

    /**
     * @var ApplicationsYear[]
     */
    public $loadedIds = array();

    public function __construct()
    {
    }

    /**
     * @param mixed[] $row
     * @return ApplicationsYear
     */
    public function mapToApplicationsYear($row) {
        $applicationsYear = new ApplicationsYear(
          $row['id'],
          $row['name']
        );
        return $applicationsYear;
    }

    /**
     * @return ApplicationsYear[]
     */
    public function getApplicationsYearList() {
        global $DB;

        $listArr = $DB->select("SELECT * FROM asp_years ORDER BY id DESC");

        $list = array();
        foreach ($listArr as $item) {
            $list[] = $this->mapToApplicationsYear($item);
        }
        return $list;
    }

    /**
     * @return ApplicationsYear
     */
    public function getApplicationsYearById($id) {
        global $DB;

        if($id == 0) {
            return new ApplicationsYear(0,"Не определен");
        }

        if(!empty($this->loadedIds[$id])) {
            return $this->loadedIds[$id];
        }

        $listArr = $DB->selectRow("SELECT * FROM asp_years WHERE id=?d",$id);

        if(!empty($listArr)) {
            $item = $this->mapToApplicationsYear($listArr);
            $this->loadedIds[$id] = $item;
            return $item;
        }
        return null;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addApplicationsYear($data) {
        global $DB;

        $DB->query(
            "INSERT INTO asp_years(`name`) 
                    VALUES(?)",
            $data['name']
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateApplicationsYearWithId($data, $id) {
        global $DB;

        $DB->query(
            "UPDATE asp_years 
              SET `name`=?
              WHERE id=?d",
            $data['name'],
            $id
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function deleteApplicationsYearById($id) {
        global $DB;

        $applicationYear = $this->getApplicationsYearById($id);
        if(!empty($applicationYear)) {
            $DB->query("DELETE FROM asp_years WHERE id=?d", $id);
        }
    }

}