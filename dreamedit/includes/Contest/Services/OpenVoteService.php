<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Models\OpenVoteResult;
use Contest\Models\User;

/**
 * Class OpenVoteService
 * @package Contest\Services
 */
class OpenVoteService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * OpenVoteService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param mixed[] $row
     * @return OpenVoteResult
     */
    public function mapToOpenVoteResult($row) {
        $openVoteResult = new OpenVoteResult(
            $row['id'],
            $row['for'],
            $row['against'],
            $row['abstained'],
            $this->contest->getApplicantService()->getApplicantById($row['applicant_id'])
        );
        return $openVoteResult;
    }

    /**
     * @param OpenVoteResult $openVoteResult
     * @return mixed[]
     */
    public function mapToArray($openVoteResult) {
        $row = array(
            "id" => $openVoteResult->getId(),
            "for" => $openVoteResult->getFor(),
            "against" => $openVoteResult->getAgainst(),
            "abstained" => $openVoteResult->getAbstained(),
            "applicant_id" => $openVoteResult->getApplicant()->getId()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return OpenVoteResult
     */
    public function getOpenVoteResultById($id) {
        global $DB;

        $openVoteResultArr = $DB->selectRow("SELECT * FROM contest_open_vote_results WHERE id=?d",$id);

        if(!empty($openVoteResultArr)) {
            $openVoteResult = $this->mapToOpenVoteResult($openVoteResultArr);
            return $openVoteResult;
        }
        return null;
    }

    /**
     * @return OpenVoteResult[]
     */
    public function getAllOpenVoteResultsByApplicantId($applicantId, $sortField="id",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $openVoteResultArr = $DB->select(
            "SELECT * 
              FROM contest_open_vote_results 
              WHERE applicant_id=?d
              ORDER BY ".$sortField." ".$sortType,
            $applicantId
        );

        $openVoteResults = array();
        foreach ($openVoteResultArr as $item) {
            $openVoteResults[] = $this->mapToOpenVoteResult($item);
        }
        return $openVoteResults;
    }

    /**
     * @return OpenVoteResult[]
     */
    public function getAllOpenVoteResultsByContestId($contestId, $sortField="id",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $openVoteResultArr = $DB->select(
            "SELECT * 
              FROM contest_open_vote_results 
              WHERE contest_id=?d
              ORDER BY ".$sortField." ".$sortType,
            $contestId
        );

        $openVoteResults = array();
        foreach ($openVoteResultArr as $item) {
            $openVoteResults[] = $this->mapToOpenVoteResult($item);
        }
        return $openVoteResults;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addOpenVoteResults($data) {
        global $DB;

        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['contest_id']) && is_numeric($_GET['contest_id'])) {
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contest)) {
                $this->contest->getContestService()->addContestAdditional($data);

                $openVoteResults = $this->getAllOpenVoteResultsByContestId($contest->getId());

                foreach ($openVoteResults as $openVoteResult) {
                    $this->deleteOpenVoteResultById($openVoteResult->getId());
                }

                foreach ($contest->getApplicants() as $applicant) {
                    $applicantData = array();
                    $applicantData['for'] = $data[$applicant->getId()."__for"];
                    $applicantData['against'] = $data[$applicant->getId()."__against"];
                    $applicantData['abstained'] = $data[$applicant->getId()."__abstained"];

                    $this->addOpenVoteResult(
                        $applicantData,$contest->getId(),$applicant->getId()
                    );
                }
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addOpenVoteResult($data, $contestId, $applicantId) {
        global $DB;


        $DB->query(
            "INSERT INTO contest_open_vote_results(
                    `for`,
                    `against`,
                    `abstained`,
                    `applicant_id`, 
                    `contest_id`
                    ) 
                    VALUES(?,?,?,?,?)",
            $data['for'],
            $data['against'],
            $data['abstained'],
            $applicantId,
            $contestId
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function deleteOpenVoteResultById($id) {
        global $DB;

        $openVoteResult = $this->getOpenVoteResultById($id);
        if(!empty($openVoteResult)) {
            $DB->query("DELETE FROM contest_open_vote_results WHERE id=?d", $id);
        }
    }

}