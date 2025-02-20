<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Models\Position;

/**
 * Class PositionService
 * @package Contest\Services
 */
class PositionService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * PositionService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param mixed[] $row
     * @return Position
     */
    public function mapToPosition($row) {
        $position = new Position(
            $row['id'],
            $row['title'],
            $row['title_r'],
            $row['department_case']
        );
        return $position;
    }

    /**
     * @param Position $position
     * @return mixed[]
     */
    public function mapToArray($position) {
        $row = array(
            "id" => $position->getId(),
            "title" => $position->getTitle(),
            "title_r" => $position->getTitleR(),
            "department_case" => $position->getDepartmentCase()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return Position
     */
    public function getPositionById($id) {
        global $DB;

        $positionArr = $DB->selectRow("SELECT * FROM contest_positions WHERE id=?d",$id);

        if(!empty($positionArr)) {
            $position = $this->mapToPosition($positionArr);
            return $position;
        }
        return null;
    }

    /**
     * @return Position[]
     */
    public function getAllPositions($sortField="title",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $positionArr = $DB->select("SELECT * FROM contest_positions ORDER BY ".$sortField." ".$sortType);

        $positions = array();
        foreach ($positionArr as $item) {
            $positions[] = $this->mapToPosition($item);
        }
        return $positions;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addPosition($data) {
        global $DB;

        $DB->query(
            "INSERT INTO contest_positions(`title`,`title_r`,`department_case`) 
                    VALUES(?,?,?)",
            $data['title'],
            $data['title_r'],
            $data['department_case']
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updatePositionWithId($data, $id) {
        global $DB;

        $DB->query(
            "UPDATE contest_positions 
              SET `title`=?,`title_r`=?,`department_case`=?
              WHERE id=?d",
            $data['title'],
            $data['title_r'],
            $data['department_case'],
            $id
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function deletePositionById($id) {
        global $DB;

        $position = $this->getPositionById($id);
        if(!empty($position)) {
            $DB->query("DELETE FROM contest_positions WHERE id=?d", $id);
        }
    }

}