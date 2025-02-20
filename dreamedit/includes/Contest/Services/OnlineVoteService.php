<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Models\OnlineVoteResult;
use Contest\Models\User;

/**
 * Class OnlineVoteService
 * @package Contest\Services
 */
class OnlineVoteService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * OnlineVoteService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param mixed[] $row
     * @return OnlineVoteResult
     */
    public function mapToOnlineVoteResult($row) {
        $onlineVoteResult = new OnlineVoteResult(
            $row['id'],
            $row['science_results'],
            $row['experience'],
            $row['interview'],
            $row['total'],
            $this->contest->getUserService()->getUserById($row['user_id']),
            $this->contest->getApplicantService()->getApplicantById($row['applicant_id'])
        );
        return $onlineVoteResult;
    }

    /**
     * @param OnlineVoteResult $onlineVoteResult
     * @return mixed[]
     */
    public function mapToArray($onlineVoteResult) {
        $row = array(
            "id" => $onlineVoteResult->getId(),
            "science_results" => $onlineVoteResult->getScienceResults(),
            "experience" => $onlineVoteResult->getExperience(),
            "interview" => $onlineVoteResult->getInterview(),
            "total" => $onlineVoteResult->getTotal(),
            "user_id" => $onlineVoteResult->getUser()->getId(),
            "applicant_id" => $onlineVoteResult->getApplicant()->getId()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return OnlineVoteResult
     */
    public function getOnlineVoteResultById($id) {
        global $DB;

        $onlineVoteResultArr = $DB->selectRow("SELECT * FROM contest_online_vote_results WHERE id=?d",$id);

        if(!empty($onlineVoteResultArr)) {
            $onlineVoteResult = $this->mapToOnlineVoteResult($onlineVoteResultArr);
            return $onlineVoteResult;
        }
        return null;
    }

    /**
     * @return OnlineVoteResult[]
     */
    public function getAllOnlineVoteResultsByApplicantId($applicantId, $sortField="id",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $onlineVoteResultArr = $DB->select(
            "SELECT * 
              FROM contest_online_vote_results 
              WHERE applicant_id=?d
              ORDER BY ".$sortField." ".$sortType,
            $applicantId
        );

        $onlineVoteResults = array();
        foreach ($onlineVoteResultArr as $item) {
            $onlineVoteResults[] = $this->mapToOnlineVoteResult($item);
        }
        return $onlineVoteResults;
    }

    /**
     * @return OnlineVoteResult[]
     */
    public function getAllOnlineVoteResultsByContestId($contestId, $sortField="id",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $onlineVoteResultArr = $DB->select(
            "SELECT * 
              FROM contest_online_vote_results 
              WHERE contest_id=?d
              ORDER BY ".$sortField." ".$sortType,
            $contestId
        );

        $onlineVoteResults = array();
        foreach ($onlineVoteResultArr as $item) {
            $onlineVoteResults[] = $this->mapToOnlineVoteResult($item);
        }
        return $onlineVoteResults;
    }

    /**
     * @return OnlineVoteResult[]
     */
    public function getAllOnlineVoteResultsByContestIdAndUserId($contestId, $userId, $sortField="id",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $onlineVoteResultArr = $DB->select(
            "SELECT * 
              FROM contest_online_vote_results 
              WHERE contest_id=?d AND user_id=?d
              ORDER BY ".$sortField." ".$sortType,
            $contestId,
            $userId
        );

        $onlineVoteResults = array();
        foreach ($onlineVoteResultArr as $item) {
            $onlineVoteResults[] = $this->mapToOnlineVoteResult($item);
        }
        return $onlineVoteResults;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addOnlineVoteResults($data) {
        global $DB;

        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();
        if($currentUser->getStatus()->isCanVote() && !empty($_GET['contest_id'])) {
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if (!empty($contest)) {
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById(
                    $contest->getContestGroupId()
                );
                if(!empty($contestGroup)) {
                    if(in_array($currentUser, $contestGroup->getParticipants())) {

                        $onlineVoteResult = $this->getAllOnlineVoteResultsByContestIdAndUserId(
                            $_GET['contest_id'],
                            $currentUser->getId()
                        );

                        foreach ($onlineVoteResult as $item) {
                            $this->deleteOnlineVoteResultById($item->getId());
                        }

                        foreach ($contest->getApplicants() as $applicant) {
                            $applicantData = array();
                            $applicantData['science_results'] = $data[$applicant->getId()."__science_results"];
                            $applicantData['experience'] = $data[$applicant->getId()."__experience"];
                            $applicantData['interview'] = $data[$applicant->getId()."__interview"];
                            $interviewForTotal = $applicantData['interview'] > 0 ? $applicantData['interview'] : 0;
                            $applicantData['total'] = $applicantData['science_results'] + $applicantData['experience'] + $interviewForTotal;

                            $this->addOnlineVoteResult(
                                $applicantData,$contest->getId(),$currentUser->getId(),$applicant->getId()
                            );
                        }
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addOnlineVoteResult($data, $contestId, $userId, $applicantId) {
        global $DB;


        $DB->query(
            "INSERT INTO contest_online_vote_results(`science_results`,`experience`,`interview`,`total`,`user_id`,`applicant_id`, `contest_id`) 
                    VALUES(?,?,?,?,?,?,?)",
            $data['science_results'],
            $data['experience'],
            $data['interview'],
            $data['total'],
            $userId,
            $applicantId,
            $contestId
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateOnlineVoteResultWithId($data, $id, $contestId, $userId, $applicantId) {
        global $DB;

        $DB->query(
            "UPDATE contest_online_vote_results 
              SET `science_results`=?,`experience`=?,`interview`=?,`total`=?,`user_id`=?,`applicant_id`=?,`contest_id`=?
              WHERE id=?d",
            $data['science_results'],
            $data['experience'],
            $data['interview'],
            $data['total'],
            $userId,
            $applicantId,
            $contestId,
            $id
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function deleteOnlineVoteResultById($id) {
        global $DB;

        $onlineVoteResult = $this->getOnlineVoteResultById($id);
        if(!empty($onlineVoteResult)) {
            $DB->query("DELETE FROM contest_online_vote_results WHERE id=?d", $id);
        }
    }

}