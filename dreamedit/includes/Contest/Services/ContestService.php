<?php

namespace Contest\Services;

use Contest\Contest;

/**
 * Class ContestService
 * @package Contest\Services
 */
class ContestService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * ContestService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param mixed[] $row
     * @return \Contest\Models\Contest
     */
    public function mapToContest($row) {
        $contest = new \Contest\Models\Contest(
            $row['id'],
            $row['position_r'],
            $row['protocol'],
            $this->contest->getApplicantService()->getApplicantsByContestId($row['id']),
            $row['position'],
            $row['date'],
            $row['contest_group_id'],
            $row['online_vote'],
            $this->contest->getUserService()->getUserById($row['chairman_id']),
            $this->contest->getUserService()->getUserById($row['vice_chairman_id']),
            $this->contest->getUserService()->getUserById($row['secretary_id']),
            $this->contest->getApplicantService()->getApplicantById($row['first_place']),
            $this->contest->getApplicantService()->getApplicantById($row['second_place']),
            $row['contract_term'],
            $row['number_of_people_presented']
        );
        return $contest;
    }

    /**
     * @param \Contest\Models\Contest $contest
     * @return mixed[]
     */
    public function mapToArray($contest) {
        $row = array(
            "id" => $contest->getId(),
            "position_r" => $contest->getPositionR(),
            "protocol" => $contest->getProtocol(),
            "applicants" => $contest->getApplicants(),
            "position" => $contest->getPosition(),
            "date" => $contest->getDate(),
            "contest_group_id" => $contest->getContestGroupId(),
            "online_vote" => (int)$contest->isOnlineVote(),
            "chairman_id" => $contest->getChairman()->getId(),
            "vice_chairman_id" => $contest->getViceChairman()->getId(),
            "secretary_id" => $contest->getSecretary()->getId(),
            "first_place" => $contest->getFirstPlace()->getId(),
            "second_place" => $contest->getSecondPlace()->getId(),
            "contract_term" => $contest->getContractTerm(),
            "number_of_people_presented" => $contest->getNumberOfPeoplePresented()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return \Contest\Models\Contest
     */
    public function getContestById($id) {
        global $DB;

        $contestArr = $DB->selectRow("SELECT * FROM contests WHERE id=?d",$id);

        if(!empty($contestArr)) {
            $contest = $this->mapToContest($contestArr);
            return $contest;
        }
        return null;
    }

    /**
     * @return \Contest\Models\Contest[]
     */
    public function getAllActiveContests($sortField="id",$sortType="DESC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $contestArr = $DB->select(
            "SELECT c.* FROM contests AS c
              INNER JOIN contests_groups AS cg ON c.contest_group_id=cg.id
              WHERE cg.active=1
              ORDER BY c.".$sortField." ".$sortType
        );

        $contests = array();
        foreach ($contestArr as $item) {
            $contests[] = $this->mapToContest($item);
        }
        return $contests;
    }

    /**
     * @return \Contest\Models\Contest[]
     */
    public function getAllContestsByContestGroupId($contestGroupId, $sortField="id",$sortType="DESC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $contestArr = $DB->select(
            "SELECT * FROM contests WHERE contest_group_id=?d ORDER BY ".$sortField." ".$sortType,
            $contestGroupId
        );

        $contests = array();
        foreach ($contestArr as $item) {
            $contests[] = $this->mapToContest($item);
        }
        return $contests;
    }

    /**
     * @param int $contestId
     * @param int $firstPlaceId
     * @return bool
     */
    public function setFirstPlaceWithId($contestId, $firstPlaceId = null) {
        global $DB;

        if(!empty($firstPlaceId)) {
            $applicant = $this->contest->getApplicantService()->getApplicantById($firstPlaceId);
            if(!empty($applicant)) {
                $DB->query(
                    "UPDATE contests 
                      SET `first_place`=?
                      WHERE id=?d",
                    $firstPlaceId,
                    $contestId
                );
            }
        } else {
            $DB->query(
                "UPDATE contests 
                      SET `first_place`= NULL 
                      WHERE id=?d",
                $contestId
            );
        }

        return true;
    }

    /**
     * @param int $contestId
     * @param int $secondPlaceId
     * @return bool
     */
    public function setSecondPlaceWithId($contestId, $secondPlaceId = null) {
        global $DB;

        if(!empty($secondPlaceId)) {
            $applicant = $this->contest->getApplicantService()->getApplicantById($secondPlaceId);
            if(!empty($applicant)) {
                $DB->query(
                    "UPDATE contests 
                      SET `second_place`=?
                      WHERE id=?d",
                    $secondPlaceId,
                    $contestId
                );
            }
        } else {
            $DB->query(
                "UPDATE contests 
                      SET `second_place`= NULL 
                      WHERE id=?d",
                $contestId
            );
        }

        return true;
    }

    /**
     * @param int $contestId
     * @param string $numberOfPeoplePresented
     * @return bool
     */
    public function setNumberOfPeoplePresented($contestId, $numberOfPeoplePresented = "") {
        global $DB;

        $DB->query(
            "UPDATE contests 
              SET `number_of_people_presented`=?
              WHERE id=?d",
            $numberOfPeoplePresented,
            $contestId
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addContestAdditional($data) {
        global $DB;
        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['contest_id']) && is_numeric($_GET['contest_id'])) {
            $contest = $this->getContestById($_GET['contest_id']);
            if (!empty($contest)) {
                if (!empty($data['first_place'])) {
                    $this->setFirstPlaceWithId($contest->getId(), $data['first_place']);
                } else {
                    $this->setFirstPlaceWithId($contest->getId());
                }
                if (!empty($data['second_place'])) {
                    $this->setSecondPlaceWithId($contest->getId(), $data['second_place']);
                } else {
                    $this->setSecondPlaceWithId($contest->getId());
                }
                if(!empty($data['number_of_people_presented'])) {
                    $this->setNumberOfPeoplePresented(
                        $contest->getId(),$data['number_of_people_presented']
                    );
                } else {
                    $this->setNumberOfPeoplePresented(
                        $contest->getId()
                    );
                }
                foreach ($contest->getApplicants() as $applicant) {
                    if(!empty( $data[$applicant->getId()."__online_vote_manual_total"])) {
                        $this->contest->getApplicantService()->setOnlineVoteManualTotal(
                            $applicant->getId(),
                            $data[$applicant->getId()."__online_vote_manual_total"]
                        );
                    } else {
                        $this->contest->getApplicantService()->setOnlineVoteManualTotal(
                            $applicant->getId()
                        );
                    }
                }
            }
        }
        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addContest($data) {
        global $DB;

        if(!empty($data['position_select'])) {
            $position = $this->contest->getPositionService()->getPositionById($data['position_select']);
            if(!empty($position)) {
                $data['position'] = $position->getTitle();
                $data['position_r'] = $position->getTitleR();
            }
        }

        if(!empty($data['department_select'])) {
            $department = $this->contest->getDepartmentService()->getFullPathDepartment($data['department_select']);
            if(!empty($department)) {
                if(!empty($position)) {
                    $data['position'] .= " ";
                    $data['position_r'] .= " ";
                    switch ($position->getDepartmentCase()) {
                        case "R":
                            $data['position'] .= $department->getTitleR();
                            $data['position_r'] .= $department->getTitleR();
                            break;
                        case "T":
                            $data['position'] .= $department->getTitleT();
                            $data['position_r'] .= $department->getTitleT();
                            break;
                        default:
                            $data['position'] .= $department->getTitle();
                            $data['position_r'] .= $department->getTitle();
                    }
                } else {
                    $data['position'] = $department->getTitle();
                    $data['position_r'] = $department->getTitleR();
                }
            }
        }

        $DB->query(
            "INSERT INTO contests(`position_r`,`protocol`,`position`,`date`, `contest_group_id`,`online_vote`,`chairman_id`,`vice_chairman_id`,`secretary_id`,`contract_term`) 
                    VALUES(?,?,?,?,?,?,?,?,?,?)",
            $data['position_r'],
            $data['protocol'],
            $data['position'],
            $data['date'],
            $data['contest_group_id'],
            $data['online_vote'],
            $data['chairman_id'],
            $data['vice_chairman_id'],
            $data['secretary_id'],
            $data['contract_term']
        );

        return true;
    }


    /**
     * @param mixed $data
     * @return bool
     */
    public function updateContestWithId($data, $id) {
        global $DB;

        $DB->query(
            "UPDATE contests 
              SET `position_r`=?,`protocol`=?,`position`=?,`date`=?,`contest_group_id`=?,`online_vote`=?,`chairman_id`=?,`vice_chairman_id`=?,`secretary_id`=?,`contract_term`=?
              WHERE id=?d",
            $data['position_r'],
            $data['protocol'],
            $data['position'],
            $data['date'],
            $data['contest_group_id'],
            $data['online_vote'],
            $data['chairman_id'],
            $data['vice_chairman_id'],
            $data['secretary_id'],
            $data['contract_term'],
            $id
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function deleteContestById($id) {
        global $DB;

        $contest = $this->getContestById($id);
        if(!empty($contest)) {
            foreach ($contest->getApplicants() as $applicant) {
                $this->contest->getApplicantService()->deleteApplicantById($applicant->getId());
            }
            $DB->query("DELETE FROM contests WHERE id=?d", $id);
        }
    }

}