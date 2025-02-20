<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Models\Vote;

/**
 * Class VoteService
 * @package DissertationCouncils\Services
 */
class VoteService {

    /**
     * @var DissertationCouncils
     */
    private $dissertationCouncils;
    /**
     * VoteService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @param mixed[] $row
     * @return Vote
     */
    public function mapToVote($row) {

        $participantsIds = array();
        if(!empty($row['participants'])) {
            $participantsIds = unserialize($row['participants']);
        }
        $participants = array();
        foreach ($participantsIds as $participantId) {
            $participant = $this->dissertationCouncils->getUserService()->getUserById($participantId);
            if(!empty($participant)) {
                $participants[] = $participant;
            }
        }

        $vote = new Vote(
            $row['id'],
            $row['date'],
            $row['title'],
            $participants,
            $row['active'],
            $row['preview'],
            $row['dissertation_council_name'],
            $row['attended'],
            $row['with_technical_problem'],
            $row['dissertation_profile'],
            $row['chairman_name'],
            $row['chairman_position'],
            $row['secretary_name'],
            $row['secretary_position'],
            $row['doctors']
        );
        return $vote;
    }

    /**
     * @param Vote $vote
     * @return mixed[]
     */
    public function mapToArray($vote) {
        $row = array(
            "id" => $vote->getId(),
            "date" => $vote->getDate(),
            "active" => (int)$vote->isActive(),
            "preview" => (int)$vote->isPreview(),
            "dissertation_council_name" => $vote->getDissertationCouncilName(),
            "attended" => $vote->getAttended(),
            "with_technical_problem" => $vote->getWithTechnicalProblem(),
            "dissertation_profile" => $vote->getDissertationProfile(),
            "chairman_name" => $vote->getChairmanName(),
            "chairman_position" => $vote->getChairmanPosition(),
            "secretary_name" => $vote->getSecretaryName(),
            "secretary_position" => $vote->getSecretaryPosition(),
            "doctors" => $vote->getDoctors()
        );
        return $row;
    }

    /**
     * @param array $data
     * @return mixed[]
     */
    public function mapArrayToDb($data, $id = null) {
        $participants = $this->dissertationCouncils->getUserService()->getAllUsers("lastname","ASC");
        $participantArr = array();
        $currentParticipantsArr = array();
        if(!empty($id)) {
            $currentVoteId = $this->getVoteById($id);
            if(!empty($currentVoteId)) {
                $currentParticipantsArr = $currentVoteId->getParticipants();
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
     * @return Vote
     */
    public function getVoteById($id) {
        global $DB;

        $voteArr = $DB->selectRow("SELECT * FROM dissertation_councils_votes WHERE id=?d",$id);

        if(!empty($voteArr)) {
            $vote = $this->mapToVote($voteArr);
            return $vote;
        }
        return null;
    }

    /**
     * @return Vote[]
     */
    public function getAllVotes($sortField="id",$sortType="DESC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $voteArr = $DB->select("SELECT * FROM dissertation_councils_votes ORDER BY ".$sortField." ".$sortType);

        $votes = array();
        foreach ($voteArr as $item) {
            $votes[] = $this->mapToVote($item);
        }
        return $votes;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addVote($data) {
        global $DB;

        $data = $this->mapArrayToDb($data);

        $DB->query(
            "INSERT INTO dissertation_councils_votes(`date`,`participants`,`title`,`dissertation_council_name`,`attended`,`with_technical_problem`,`dissertation_profile`,`chairman_name`,`chairman_position`,`secretary_name`,`secretary_position`, `doctors`) 
                    VALUES(?,?,?,?,?d,?d,?,?,?,?,?,?d)",
            $data['date'],
            $data['participants'],
            $data['title'],
            $data['dissertation_council_name'],
            $data['attended'],
            $data['with_technical_problem'],
            $data['dissertation_profile'],
            $data['chairman_name'],
            $data['chairman_position'],
            $data['secretary_name'],
            $data['secretary_position'],
            $data['doctors']
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateVoteWithId($data, $id) {
        global $DB;

        $data = $this->mapArrayToDb($data, $id);

        //        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

        $DB->query(
            "UPDATE dissertation_councils_votes 
              SET `date`=?,`participants`=?, `title`=?, `dissertation_council_name`=?, `attended`=?d, `with_technical_problem`=?d, `dissertation_profile`=?, `chairman_name`=?, `chairman_position`=?, `secretary_name`=?, `secretary_position`=?, `doctors`=?d
              WHERE id=?d",
            $data['date'],
            $data['participants'],
            $data['title'],
            $data['dissertation_council_name'],
            $data['attended'],
            $data['with_technical_problem'],
            $data['dissertation_profile'],
            $data['chairman_name'],
            $data['chairman_position'],
            $data['secretary_name'],
            $data['secretary_position'],
            $data['doctors'],
            $id
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function stopVoteById($id) {
        global $DB;

        $vote = $this->getVoteById($id);
        if(!empty($vote)) {
            $DB->query("UPDATE dissertation_councils_votes SET active=0 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function startVoteById($id) {
        global $DB;

        $vote = $this->getVoteById($id);
        if(!empty($vote)) {
            $DB->query("UPDATE dissertation_councils_votes SET active=1 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function stopPreviewVoteById($id) {
        global $DB;

        $vote = $this->getVoteById($id);
        if(!empty($vote)) {
            $DB->query("UPDATE dissertation_councils_votes SET preview=0 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function startPreviewVoteById($id) {
        global $DB;

        $vote = $this->getVoteById($id);
        if(!empty($vote)) {
            $DB->query("UPDATE dissertation_councils_votes SET preview=1 WHERE id=?d", $id);
        }
    }

    /**
     * @param int $id
     */
    public function deleteVoteById($id) {
        global $DB;

        $vote = $this->getVoteById($id);
        if(!empty($vote)) {
            $DB->query("DELETE FROM dissertation_councils_votes WHERE id=?d", $id);
        }
    }

}