<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Models\DissertationCouncil;

/**
 * Class DissertationCouncilService
 * @package Contest\Services
 */
class DissertationCouncilService {

    /**
     * @var DissertationCouncils
     */
    private $dissertationCouncils;
    /**
     * DissertationCouncilService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @param mixed[] $row
     * @return DissertationCouncil
     */
    public function mapToDissertationCouncil($row) {

        $teamIds = array();
        if(!empty($row['team'])) {
            $teamIds = unserialize($row['team']);
        }
        $team = array();
        foreach ($teamIds as $teamId) {
            $teamMember = $this->dissertationCouncils->getUserService()->getUserById($teamId);
            if(!empty($teamMember)) {
                $team[] = $teamMember;
            }
        }

        $dissertationCouncil = new DissertationCouncil(
            $row['id'],
            $row['name'],
            $team
        );
        return $dissertationCouncil;
    }

    /**
     * @param DissertationCouncil $dissertationCouncil
     * @return mixed[]
     */
    public function mapToArray($dissertationCouncil) {
        $row = array(
            "id" => $dissertationCouncil->getId(),
            "name" => $dissertationCouncil->getName(),
        );
        return $row;
    }

    /**
     * @param array $data
     * @return mixed[]
     */
    public function mapArrayToDb($data, $id = null) {
        $team = $this->dissertationCouncils->getUserService()->getAllUsers("lastname","ASC");
        $teamArr = array();
        $currentTeamArr = array();
        if(!empty($id)) {
            $currentTeamId = $this->getDissertationCouncilById($id);
            if(!empty($currentTeamId)) {
                $currentTeamArr = $currentTeamId->getTeam();
            }
        }
        foreach ($team as $teamMember) {
            if ($teamMember->getStatus()->isCanVote() || in_array($teamMember,$currentTeamArr)) {
                if($data[$teamMember->getId()."__team-member"]==1) {
                    $teamArr[] = $teamMember->getId();
                }
            }
        }
        $data['team'] = serialize($teamArr);

        return $data;
    }

    /**
     * @param int $id
     * @return DissertationCouncil
     */
    public function getDissertationCouncilById($id) {
        global $DB;

        $dissertationCouncilArr = $DB->selectRow("SELECT * FROM dissertation_councils_list WHERE id=?d",$id);

        if(!empty($dissertationCouncilArr)) {
            $dissertationCouncil = $this->mapToDissertationCouncil($dissertationCouncilArr);
            return $dissertationCouncil;
        }
        return null;
    }

    /**
     * @return DissertationCouncil[]
     */
    public function getAllDissertationCouncils($sortField="name",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $dissertationCouncilArr = $DB->select("SELECT * FROM dissertation_councils_list ORDER BY ".$sortField." ".$sortType);

        $dissertationCouncils = array();
        foreach ($dissertationCouncilArr as $item) {
            $dissertationCouncils[] = $this->mapToDissertationCouncil($item);
        }
        return $dissertationCouncils;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addDissertationCouncil($data) {
        global $DB;

        $data = $this->mapArrayToDb($data);

        $DB->query(
            "INSERT INTO dissertation_councils_list(`name`,`team`) 
                    VALUES(?,?)",
            $data['name'],
            $data['team']
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateDissertationCouncilWithId($data, $id) {
        global $DB;

        $data = $this->mapArrayToDb($data);

        $DB->query(
            "UPDATE dissertation_councils_list 
              SET `name`=?,`team`=?
              WHERE id=?d",
            $data['name'],
            $data['team'],
            $id
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function deleteDissertationCouncilById($id) {
        global $DB;

        $dissertationCouncil = $this->getDissertationCouncilById($id);
        if(!empty($dissertationCouncil)) {
            $DB->query("DELETE FROM dissertation_councils_list WHERE id=?d", $id);
        }
    }

}