<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Models\ContestGroup;

/**
 * Class ContestGroupService
 * @package Contest\Services
 */
class ContestGroupService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * ContestGroupService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param mixed[] $row
     * @return ContestGroup
     */
    public function mapToContestGroup($row) {

        $participantsIds = array();
        if(!empty($row['participants'])) {
            $participantsIds = unserialize($row['participants']);
        }
        $participants = array();
        foreach ($participantsIds as $participantId) {
            $participant = $this->contest->getUserService()->getUserById($participantId);
            if(!empty($participant)) {
                $participants[] = $participant;
            }
        }

        $contestGroup = new ContestGroup(
            $row['id'],
            $row['active'],
            $this->contest->getContestService()->getAllContestsByContestGroupId($row['id']),
            $row['date'],
            $participants,
            $row['preview']
        );
        return $contestGroup;
    }

    /**
     * @param ContestGroup $contestGroup
     * @return mixed[]
     */
    public function mapToArray($contestGroup) {
        $row = array(
            "id" => $contestGroup->getId(),
            "date" => $contestGroup->getDate(),
            "active" => (int)$contestGroup->isActive(),
            "preview" => (int)$contestGroup->isPreview()
        );
        return $row;
    }

    /**
     * @param array $data
     * @return mixed[]
     */
    public function mapArrayToDb($data, $id = null) {
        $participants = $this->contest->getUserService()->getAllUsers("lastname","ASC");
        $participantArr = array();
        $currentParticipantsArr = array();
        if(!empty($id)) {
            $currentContestGroupId = $this->getContestGroupById($id);
            if(!empty($currentContestGroupId)) {
                $currentParticipantsArr = $currentContestGroupId->getParticipants();
            }
        }
        foreach ($participants as $participant) {
            if ($participant->getStatus()->isCanVote() || in_array($participant,$currentParticipantsArr)) {
                if($data[$participant->getId()."__participant"]==1) {
                    $participantArr[] = $participant->getId();
                }
            }
        }
        $data['participants'] = serialize($participantArr);

        return $data;
    }

    /**
     * @param int $id
     * @return ContestGroup
     */
    public function getContestGroupById($id) {
        global $DB;

        $contestGroupArr = $DB->selectRow("SELECT * FROM contests_group WHERE id=?d",$id);

        if(!empty($contestGroupArr)) {
            $contestGroup = $this->mapToContestGroup($contestGroupArr);
            return $contestGroup;
        }
        return null;
    }

    /**
     * @return ContestGroup[]
     */
    public function getAllContestsGroups($sortField="id",$sortType="DESC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $contestGroupsArr = $DB->select("SELECT * FROM contests_group ORDER BY ".$sortField." ".$sortType);

        $contestsGroups = array();
        foreach ($contestGroupsArr as $item) {
            $contestsGroups[] = $this->mapToContestGroup($item);
        }
        return $contestsGroups;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addContestGroup($data) {
        global $DB;

        $data = $this->mapArrayToDb($data);

        $DB->query(
            "INSERT INTO contests_group(`date`,`participants`) 
                    VALUES(?,?)",
            $data['date'],
            $data['participants']
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateContestGroupWithId($data, $id) {
        global $DB;

        $data = $this->mapArrayToDb($data, $id);

        $DB->query(
            "UPDATE contests_group 
              SET `date`=?,`participants`=?
              WHERE id=?d",
            $data['date'],
            $data['participants'],
            $id
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function stopContestGroupById($id) {
        global $DB;

        $contestGroup = $this->getContestGroupById($id);
        if(!empty($contestGroup)) {
            $DB->query("UPDATE contests_group SET active=0 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function startContestGroupById($id) {
        global $DB;

        $contestGroup = $this->getContestGroupById($id);
        if(!empty($contestGroup)) {
            $DB->query("UPDATE contests_group SET active=1 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function stopPreviewContestGroupById($id) {
        global $DB;

        $contestGroup = $this->getContestGroupById($id);
        if(!empty($contestGroup)) {
            $DB->query("UPDATE contests_group SET preview=0 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function startPreviewContestGroupById($id) {
        global $DB;

        $contestGroup = $this->getContestGroupById($id);
        if(!empty($contestGroup)) {
            $DB->query("UPDATE contests_group SET preview=1 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function deleteContestGroupById($id) {
        global $DB;

        $contestGroup = $this->getContestGroupById($id);
        if(!empty($contestGroup)) {
            foreach ($contestGroup->getContests() as $contest) {
                $this->contest->getContestService()->deleteContestById($contest->getId());
            }
            $DB->query("DELETE FROM contests_group WHERE id=?d", $id);
        }
    }

}