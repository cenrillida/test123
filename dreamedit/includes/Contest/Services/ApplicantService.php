<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Models\Applicant;

/**
 * Class ApplicantService
 * @package Contest\Services
 */
class ApplicantService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * ApplicantService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param mixed[] $row
     * @return Applicant
     */
    public function mapToApplicant($row) {

        $documents = array();
        if(!empty($row['documents'])) {
            $documents = unserialize($row['documents']);
        }

        $applicant = new Applicant(
            $row['id'],
            $row['firstname'],
            $row['lastname'],
            $row['thirdname'],
            $row['firstname_r'],
            $row['lastname_r'],
            $row['thirdname_r'],
            $documents,
            $row['online_vote_manual_total']
        );
        return $applicant;
    }

    /**
     * @param Applicant $applicant
     * @return mixed[]
     */
    public function mapToArray($applicant) {
        $row = array(
            "id" => $applicant->getId(),
            "firstname" => $applicant->getFirstName(),
            "lastname" => $applicant->getLastName(),
            "thirdname" => $applicant->getThirdName(),
            "firstname_r" => $applicant->getFirstNameR(),
            "lastname_r" => $applicant->getLastNameR(),
            "thirdname_r" => $applicant->getThirdNameR(),
            "documents" => $applicant->getDocuments(),
            "online_vote_manual_total" => $applicant->getOnlineVoteManualTotal()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return Applicant
     */
    public function getApplicantById($id) {
        global $DB;

        $applicantArr = $DB->selectRow("SELECT * FROM contest_applicants WHERE id=?d",$id);

        if(!empty($applicantArr)) {
            $applicant = $this->mapToApplicant($applicantArr);
            return $applicant;
        }
        return null;
    }

    /**
     * @return Applicant[]
     */
    public function getApplicantsByContestId($contestId, $sortField="lastname",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $applicantArr = $DB->select(
            "SELECT * FROM contest_applicants WHERE contest_id=?d ORDER BY ".$sortField." ".$sortType, $contestId
        );

        $applicants = array();
        foreach ($applicantArr as $item) {
            $applicants[] = $this->mapToApplicant($item);
        }
        return $applicants;
    }

    /**
     * @param int $applicantId
     * @param int $onlineVoteManualTotal
     * @return bool
     */
    public function setOnlineVoteManualTotal($applicantId, $onlineVoteManualTotal = null) {
        global $DB;

        $DB->query(
            "UPDATE contest_applicants 
              SET `online_vote_manual_total`=?
              WHERE id=?d",
            $onlineVoteManualTotal,
            $applicantId
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateApplicantWithId($data, $id) {
        global $DB;

        $DB->query(
            "UPDATE contest_applicants 
              SET `firstname`=?,`lastname`=?,`thirdname`=?, `firstname_r`=?,`lastname_r`=?,`thirdname_r`=?, `documents`=?, `contest_id`=?, `online_vote_manual_total`=? 
              WHERE id=?d",
            $data['firstname'],
            $data['lastname'],
            $data['thirdname'],
            $data['firstname_r'],
            $data['lastname_r'],
            $data['thirdname_r'],
            $data['documents'],
            $data['contest_id'],
            $data['online_vote_manual_total'],
            $id
        );

        return true;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function addApplicant($data) {
        global $DB;

        $DB->query(
            "INSERT INTO contest_applicants(`firstname`,`lastname`,`thirdname`,`firstname_r`,`lastname_r`,`thirdname_r`, `documents`, `contest_id`, `online_vote_manual_total`) 
                    VALUES(?,?,?,?,?,?,?,?,?)",
            $data['firstname'],
            $data['lastname'],
            $data['thirdname'],
            $data['firstname_r'],
            $data['lastname_r'],
            $data['thirdname_r'],
            $data['documents'],
            $data['contest_id'],
            $data['online_vote_manual_total']
        );

        return true;
    }

    /**
     * @param int $id
     */
    public function deleteApplicantById($id) {
        global $DB;

        $applicant = $this->getApplicantById($id);
        if(!empty($applicant)) {
            foreach ($applicant->getDocuments() as $document) {
                if(is_file(__DIR__."/../Documents/Uploaded/".$document['document'])) {
                    unlink(__DIR__."/../Documents/Uploaded/".$document['document']);
                }
            }
            foreach (
                $this->
                contest->
                getOnlineVoteService()->
                getAllOnlineVoteResultsByApplicantId($applicant->getId()) as $onlineVoteResult
            ) {
                $this->contest->getOnlineVoteService()->deleteOnlineVoteResultById($onlineVoteResult->getId());
            }
            foreach (
                $this->
                contest->
                getOpenVoteService()->
                getAllOpenVoteResultsByApplicantId($applicant->getId()) as $openVoteResult
            ) {
                $this->contest->getOpenVoteService()->deleteOpenVoteResultById($openVoteResult->getId());
            }
            $DB->query("DELETE FROM contest_applicants WHERE id=?d", $id);
        }
    }

}