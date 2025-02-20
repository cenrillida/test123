<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\UserNotFoundException;
use DissertationCouncils\Models\VoteResult;
use DissertationCouncils\Models\User;

/**
 * Class VoteResultService
 * @package DissertationCouncils\Services
 */
class VoteResultService {

    /**
     * @var DissertationCouncils
     */
    private $dissertationCouncils;
    /**
     * VoteResultService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @param mixed[] $row
     * @return VoteResult
     * @throws UserNotFoundException
     */
    public function mapToVoteResult($row) {
        $user = $this->dissertationCouncils->getUserService()->getUserById($row['user_id']);

        if(empty($user)) {
            throw new UserNotFoundException("Один из участников голосования был удален");
        }

        $voteResult = new VoteResult(
            $row['id'],
            $row['result'],
            $user
        );
        return $voteResult;
    }

    /**
     * @param VoteResult $voteResult
     * @return mixed[]
     */
    public function mapToArray($voteResult) {
        $row = array(
            "id" => $voteResult->getId(),
            "result" => $voteResult->getResult(),
            "user_id" => $voteResult->getUser()->getId()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return VoteResult
     */
    public function getVoteResultById($id) {
        global $DB;

        $voteResultArr = $DB->selectRow("SELECT * FROM dissertation_councils_vote_results WHERE id=?d",$id);

        if(!empty($voteResultArr)) {
            $voteResult = $this->mapToVoteResult($voteResultArr);
            return $voteResult;
        }
        return null;
    }

    /**
     * @return VoteResult[]
     */
    public function getAllVoteResultsByVoteId($voteId, $sortField="id",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $voteResultArr = $DB->select(
            "SELECT * 
              FROM dissertation_councils_vote_results 
              WHERE vote_id=?d
              GROUP BY user_id
              ORDER BY ".$sortField." ".$sortType,
            $voteId
        );

        $voteResults = array();
        foreach ($voteResultArr as $item) {
            $voteResults[] = $this->mapToVoteResult($item);
        }
        return $voteResults;
    }

    /**
     * @return VoteResult[]
     */
    public function getAllVoteResultsByVoteIdAndUserId($voteId, $userId, $sortField="id",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $voteResultArr = $DB->select(
            "SELECT * 
              FROM dissertation_councils_vote_results 
              WHERE vote_id=?d AND user_id=?d
              ORDER BY ".$sortField." ".$sortType,
            $voteId,
            $userId
        );

        $voteResults = array();
        foreach ($voteResultArr as $item) {
            $voteResults[] = $this->mapToVoteResult($item);
        }
        return $voteResults;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addVoteResult($data) {
        global $DB;

        $currentUser = $this->dissertationCouncils->getAuthorizationService()->getCurrentUser();
        if($currentUser->getStatus()->isCanVote() && !empty($_GET['vote_id'])) {
            $vote = $this->dissertationCouncils->getVoteService()->getVoteById($_GET['vote_id']);
            if (!empty($vote)) {
                if(in_array($currentUser, $vote->getParticipants())) {

                    if($data['result'] != "Да" && $data['result'] != "Нет" && $data['result'] != "Воздержался") {
                        return false;
                    }

                    $voteResult = $this->getAllVoteResultsByVoteIdAndUserId(
                        $_GET['vote_id'],
                        $currentUser->getId()
                    );

                    foreach ($voteResult as $item) {
                        $this->deleteVoteResultById($item->getId());
                    }

                    $DB->query(
                        "INSERT INTO dissertation_councils_vote_results(`result`,`user_id`, `vote_id`) 
                    VALUES(?,?,?)",
                        $data['result'],
                        $currentUser->getId(),
                        $_GET['vote_id']
                    );

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param int $id
     */
    public function deleteVoteResultById($id) {
        global $DB;

        $voteResult = $this->getVoteResultById($id);
        if(!empty($voteResult)) {
            $DB->query("DELETE FROM dissertation_councils_vote_results WHERE id=?d", $id);
        }
    }

    /**
     * @return int
     */
    public function getParticipatedCountByVoteId($voteId) {
        global $DB;

        $results = $this->getAllVoteResultsByVoteId($voteId);
        if(!empty($results)) {
            return count($results);
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getVoteForCountByVoteId($voteId) {
        global $DB;

        $results = $DB->select(
            "SELECT * 
              FROM dissertation_councils_vote_results 
              WHERE vote_id=?d AND result='Да'
              GROUP BY user_id",
            $voteId
        );
        if(!empty($results)) {
            return count($results);
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getVoteAgainstCountByVoteId($voteId) {
        global $DB;

        $results = $DB->select(
            "SELECT * 
              FROM dissertation_councils_vote_results 
              WHERE vote_id=?d AND result='Нет'
              GROUP BY user_id",
            $voteId
        );
        if(!empty($results)) {
            return count($results);
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getVoteAbstainedCountByVoteId($voteId) {
        global $DB;

        $results = $DB->select(
            "SELECT * 
              FROM dissertation_councils_vote_results 
              WHERE vote_id=?d AND result='Воздержался'
              GROUP BY user_id",
            $voteId
        );
        if(!empty($results)) {
            return count($results);
        }
        return 0;
    }

}