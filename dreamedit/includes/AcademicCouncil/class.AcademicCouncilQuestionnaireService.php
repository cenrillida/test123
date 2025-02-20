<?php

class AcademicCouncilMember {

    /** @var int */
    private $id;
    /** @var int */
    private $userId;
    /** @var string */
    private $lastName;
    /** @var string */
    private $firstName;
    /** @var string */
    private $thirdName;
    /** @var string */
    private $code;
    /** @var string */
    private $meetingParticipation;
    /** @var string */
    private $voteResult;
    /** @var string */
    private $notes;
    /** @var string */
    private $email;

    /**
     * AcademicCouncilMember constructor.
     * @param int $id
     * @param int $userId
     * @param string $lastName
     * @param string $firstName
     * @param string $thirdName
     * @param string $code
     * @param string $meetingParticipation
     * @param string $voteResult
     * @param string $notes
     * @param string $email
     */
    public function __construct($id, $userId, $lastName, $firstName, $thirdName, $code, $meetingParticipation, $voteResult, $notes, $email)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->thirdName = $thirdName;
        $this->code = $code;
        $this->meetingParticipation = $meetingParticipation;
        $this->voteResult = $voteResult;
        $this->notes = $notes;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getThirdName()
    {
        return $this->thirdName;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMeetingParticipation()
    {
        return $this->meetingParticipation;
    }

    /**
     * @return string
     */
    public function getVoteResult()
    {
        return $this->voteResult;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

}

class AcademicCouncilQuestionnaire {

    /** @var int */
    private $id;
    /** @var AcademicCouncilMember[] */
    private $members;
    /** @var string */
    private $name;
    /** @var string */
    private $dtStart;
    /** @var string */
    private $dtEnd;
    /** @var string */
    private $orderDate;
    /** @var string */
    private $orderNumber;
    /** @var string */
    private $questionnaireDate;
    /** @var string */
    private $questionnaireQuestion;

    /**
     * AcademicCouncilQuestionnaire constructor.
     * @param int $id
     * @param AcademicCouncilMember[] $members
     * @param string $name
     * @param string $dtStart
     * @param string $dtEnd
     * @param string $orderDate
     * @param string $orderNumber
     * @param string $questionnaireDate
     * @param string $questionnaireQuestion
     */
    public function __construct($id, array $members, $name, $dtStart, $dtEnd, $orderDate, $orderNumber, $questionnaireDate, $questionnaireQuestion)
    {
        $this->id = $id;
        $this->members = $members;
        $this->name = $name;
        $this->dtStart = $dtStart;
        $this->dtEnd = $dtEnd;
        $this->orderDate = $orderDate;
        $this->orderNumber = $orderNumber;
        $this->questionnaireDate = $questionnaireDate;
        $this->questionnaireQuestion = $questionnaireQuestion;
    }

    /**
     * @return AcademicCouncilMember[]
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDtEnd()
    {
        return $this->dtEnd;
    }

    /**
     * @return string
     */
    public function getDtStart()
    {
        return $this->dtStart;
    }

    /**
     * @return string
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getQuestionnaireDate()
    {
        return $this->questionnaireDate;
    }

    /**
     * @return string
     */
    public function getQuestionnaireQuestion()
    {
        return $this->questionnaireQuestion;
    }
}

class AcademicCouncilQuestionnaireService {

    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->pages = $pages;
        $this->academicCouncilModule = $academicCouncilModule;
    }

    /**
     * @return bool
     */
    public function sendData($fields) {
        global $DB;

        $selectUser = $DB->selectRow("SELECT * FROM ac_questionnaire_members WHERE questionnaire_id=?d AND code=?",$fields['questionnaire_id'],$fields['code']);
        if(!empty($selectUser)) {
            if(!empty($fields['fio'])) {
                unset($fields['fio']);
            }
            $DB->query("UPDATE ac_questionnaire_members SET ?a WHERE questionnaire_id=?d AND code=?",$fields,$fields['questionnaire_id'],$fields['code']);
            return true;
        }
        return false;
    }

    /**
     * @return AcademicCouncilQuestionnaire[]
     */
    public function getQuestionnairesList() {
        global $DB;
        $questionnairesArr = $DB->select("SELECT * FROM ac_questionnaire ORDER BY id");
        $questionnaires = array();
        foreach ($questionnairesArr as $questionnaire) {
            $members = $this->getQuestionnaireMembersListById($questionnaire['id']);
            $questionnaires[] = $this->createQuestionnaireFromDB($questionnaire,$members);
        }
        return $questionnaires;
    }

    /**
     * @return AcademicCouncilQuestionnaire
     */
    public function getQuestionnaireById($id) {
        global $DB;
        $questionnairesArr = $DB->selectRow("SELECT * FROM ac_questionnaire WHERE id=?d",$id);

        if(!empty($questionnairesArr)) {
            $members = $this->getQuestionnaireMembersListById($questionnairesArr['id']);
            return $this->createQuestionnaireFromDB($questionnairesArr,$members);
        }
        return null;
    }

    /**
     * @return AcademicCouncilMember[]
     */
    public function getQuestionnaireMembersListById($id) {
        global $DB;
        $questionnaireMembersArr = $DB->select("SELECT aq.*,p.surname AS lastname, p.name AS firstname, p.fname AS thirdname, p.mail1 AS email1, p.mail2 AS email2, p.emails_for_mailing AS emails_for_mailing, p.emails_for_ac_mailing AS emails_for_ac_mailing FROM ac_questionnaire_members AS aq 
                                                INNER JOIN persons AS p ON aq.userId=p.id
                                                WHERE aq.questionnaire_id=?d ORDER BY sort",$id);

        $questionnaireMembers = array();

        foreach ($questionnaireMembersArr as $item) {
            $questionnaireMembers[] = $this->createMemberFromDB($item);
        }
        return $questionnaireMembers;
    }

    /**
     * @return AcademicCouncilQuestionnaire
     */
    private function createQuestionnaireFromDB($arr,$members) {
        return new AcademicCouncilQuestionnaire($arr['id'],$members,$arr['name'],$arr['dt_start'],$arr['dt_end'],$arr['order_date'],$arr['order_number'],$arr['questionnaire_date'],$arr['questionnaire_question']);
    }

    /**
     * @return AcademicCouncilMember
     */
    private function createMemberFromDB($arr) {
        $email = "";
        if(!empty($arr['email1'])) {
            $email = $arr['email1'];
        }
        if(!empty($arr['email2'])) {
            $email = $arr['email2'];
        }
        if(!empty($arr['emails_for_mailing'])) {
            $email = $arr['emails_for_mailing'];
        }
        if(!empty($arr['emails_for_ac_mailing'])) {
            $email = $arr['emails_for_ac_mailing'];
        }
        return new AcademicCouncilMember($arr['id'],$arr['userId'],$arr['lastname'],$arr['firstname'],$arr['thirdname'],$arr['code'],$arr['meeting_participation'],$arr['vote_result'],$arr['notes'],$email);
    }

    /**
     * @return AcademicCouncilMember
     */
    public function getMemberByCode($code, $questionnaireId) {
        global $DB;

        $code = $DB->cleanuserinput(mb_strtolower($code));

        $memberArr = $DB->selectRow("SELECT aq.*,p.surname AS lastname, p.name AS firstname, p.fname AS thirdname, p.mail1 AS email1, p.mail2 AS email2, p.emails_for_mailing AS emails_for_mailing, p.emails_for_ac_mailing AS emails_for_ac_mailing FROM ac_questionnaire_members AS aq
                                    INNER JOIN persons AS p ON aq.userId=p.id
                                    WHERE aq.code=? AND aq.questionnaire_id=?d",$code,$questionnaireId);
        if(!empty($memberArr)) {
            return $this->createMemberFromDB($memberArr);
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isActive($questionnaireId) {
        global $DB;

        $questionnaire = $DB->selectRow("SELECT * FROM ac_questionnaire WHERE id=?d AND dt_start<=NOW() AND dt_end>=NOW()",$questionnaireId);
        if(!empty($questionnaire)) {
            return true;
        }
        return false;
    }

    public function updateQuestionnaire($id,$name,$dStart,$tStart,$dEnd,$tEnd,$orderDate,$orderNumber,$questionnaireDate,$questionnaireQuestion) {
        global $DB;
        $updateArr = array();
        $updateArr['name'] = $name;
        $updateArr['dt_start'] = $dStart." ".$tStart;
        $updateArr['dt_end'] = $dEnd." ".$tEnd;
        $updateArr['order_date'] = $orderDate;
        $updateArr['order_number'] = $orderNumber;
        $updateArr['questionnaire_date'] = $questionnaireDate;
        $updateArr['questionnaire_question'] = $questionnaireQuestion;
        $DB->query("UPDATE ac_questionnaire SET ?a WHERE id=?",$updateArr,$id);
    }

    public function createQuestionnaire($name,$dStart,$tStart,$dEnd,$tEnd,$orderDate,$orderNumber,$questionnaireDate,$questionnaireQuestion) {
        global $DB;

        $questionnaireId = $DB->query("INSERT INTO ac_questionnaire(name,dt_start,dt_end,order_date,order_number,questionnaire_date,questionnaire_question) VALUES (?,?,?,?,?,?,?)",$name,$dStart." ".$tStart,$dEnd." ".$tEnd,$orderDate,$orderNumber,$questionnaireDate,$questionnaireQuestion);

        $persons=$DB->select("SELECT p.id AS id, p.surname AS lastname, p.name AS firstname, p.fname AS thirdname, p.mail1 AS email1, p.mail2 AS email2, p.emails_for_mailing AS emails_for_mailing, p.emails_for_ac_mailing AS emails_for_ac_mailing, s.sort AS sort
                   FROM Admin AS s
                   INNER JOIN persons AS p ON p.id=s.persona
				   WHERE s.type=200
                   ORDER BY s.sort");

        foreach ($persons as $person) {
            $email = "";
            if(!empty($person['email1'])) {
                $email = $person['email1'];
            }
            if(!empty($person['email2'])) {
                $email = $person['email2'];
            }
            if(!empty($person['emails_for_mailing'])) {
                $email = $person['emails_for_mailing'];
            }
            if(!empty($person['emails_for_ac_mailing'])) {
                $email = $person['emails_for_ac_mailing'];
            }
            $prefix = preg_replace("/[^a-z0-9]/i","",$email);
            $guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
            $code = $prefix.$person['id'].$guid.dechex( microtime(true) * 1000 );
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $DB->query("INSERT INTO ac_questionnaire_members(userId,code,sort,questionnaire_id) VALUES(?d,?,?,?)",$person['id'],$code,$person['sort'],$questionnaireId);
        }
    }

    public function deleteQuestionnaireById($id) {
        global $DB;

        if(!empty($id)) {
            $DB->query("DELETE FROM ac_questionnaire WHERE id=?",$id);
            $DB->query("DELETE FROM ac_questionnaire_members WHERE questionnaire_id=?",$id);
        }
    }

    /**
     * @return bool
     */
    public function sendMails($data) {
        global $DB;

        $questionnaire = $this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->getQuestionnaireById($_GET['id']);
        $questionnairePageId = $this->pages->getFirstPageIdByTemplate("ac_questionnaire");
        if(!empty($questionnaire)) {
            $attachments = unserialize($data['attachments']);
            foreach ($questionnaire->getMembers() as $member) {
                $text = $data['mail_text'];
                $text = str_replace("{FIO}",$member->getFirstName()." ".$member->getThirdName(),$text);
                $text = str_replace("{LINK}","<a target=\"_blank\" href=\"https://www.imemo.ru/index.php?page_id=".$questionnairePageId."&code=".$member->getCode()."&questionnaire_id=".$questionnaire->getId()."\">Открыть</a>",$text);
                $email = $data['mail-'.$member->getUserId()];
                $email = str_replace(" ","",$email);

                if(!empty($email)) {
                    $DB->query("UPDATE persons SET emails_for_ac_mailing=? WHERE id=?d",$email,$member->getUserId());
                }
                $text = Dreamedit::LineBreakToBrAll($text);
                if(empty($attachments)) {
                    MailSend::send_mime_mail("Ученый совет ИМЭМО РАН", "academic_council@imemo.ru", $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName(), $email, "cp1251", "utf-8", $data['mail_subject'], $text);
                } else {
                    $counter=1;
                    $files = array();
                    foreach ($attachments as $attachment) {
                        $file = array();
                        $file['fileName'] = $attachment["attachment"];
                        $file['emailFileName'] = $_FILES['attachment'.$counter]['name'];
                        $files[] = $file;
                        $counter++;
                    }

                    MailSend::send_mime_mail_attachments("Ученый совет ИМЭМО РАН", "academic_council@imemo.ru", $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName(), $email, "cp1251", "utf-8",  $data['mail_subject'], $text, $files,__DIR__."/Documents/Uploads/");
                }
            }
            foreach ($attachments as $attachment) {
                if(is_file(__DIR__."/Documents/Uploads/".$attachment["attachment"])) {
                    unlink(__DIR__."/Documents/Uploads/".$attachment["attachment"]);
                }
            }
        }
        return true;
    }
}