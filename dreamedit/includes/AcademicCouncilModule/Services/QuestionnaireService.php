<?php

namespace AcademicCouncilModule\Services;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\Models\Member;
use AcademicCouncilModule\Models\Questionnaire;
use AcademicCouncilModule\Models\SecretMember;


class QuestionnaireService {

    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->pages = $pages;
        $this->academicCouncilModule = $academicCouncilModule;
    }

    /**
     * @return bool
     */
    public function sendRegistrationData($fields) {
        global $DB;

        $questionnaire = $this->getQuestionnaireById($fields['questionnaire_id']);
        if(!empty($questionnaire)) {
            if($questionnaire->isSecret()) {
                //$selectUser = $DB->selectRow("SELECT * FROM ac_questionnaire_members WHERE questionnaire_id=?d AND code=?",$questionnaire->getId(),$fields['code']);
                $member = $this->getMemberByCode($fields['code'],$questionnaire->getId());
                if(!empty($member)) {
                    if(!empty($fields['fio'])) {
                        unset($fields['fio']);
                    }
                    $fields['registration_completed'] = 1;
                    $DB->query("LOCK TABLES ac_questionnaire_secret WRITE READ");
                    $DB->query("UPDATE ac_questionnaire_members SET ?a WHERE questionnaire_id=?d AND code=?",$fields,$questionnaire->getId(),$fields['code']);

                    $questionnairePageId = $this->pages->getFirstPageIdByTemplate("ac_questionnaire");

                    $code = $this->createSecretCode($questionnaire->getId(),$member->getUserId());
                    $DB->query("UNLOCK TABLES");
                    $text = "Вы успешно зарегистрировались в голосовании.<br><br>Ваша ссылка для голосования: <a target=\"_blank\" href=\"https://www.imemo.ru/index.php?page_id=".$questionnairePageId."&secret_code=".$code."&questionnaire_id=".$questionnaire->getId()."\">Открыть</a><br><br>С уважением,<br>ИМЭМО РАН";

                    \MailSend::send_mime_mail("Ученый совет ИМЭМО РАН", "noreply@imemo.ru", $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName(), $member->getEmail(), "cp1251", "utf-8", "Регистрация в голосовании", $text);

                    return true;
                }

//                $selectUser = $DB->selectRow("SELECT * FROM ac_questionnaire_secret WHERE questionnaire_id=?d AND code=?",$questionnaire->getId(),$fields['code']);
//                if(!empty($selectUser)) {
//                    $DB->query("UPDATE ac_questionnaire_secret SET ?a WHERE questionnaire_id=?d AND code=?",$fields,$questionnaire->getId(),$fields['code']);
//                    return true;
//                }
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function sendData($fields) {
        global $DB;

        $questionnaire = $this->getQuestionnaireById($fields['questionnaire_id']);
        if(!empty($questionnaire)) {
            if($fields['vote_result']!="да" && $fields['vote_result']!="нет" && $fields['vote_result']!="воздержался" && $fields['vote_result']!="") {
                $fields['vote_result'] = "воздержался";
            }
            if($questionnaire->isSecret()) {
                $selectUser = $DB->selectRow("SELECT * FROM ac_questionnaire_secret WHERE questionnaire_id=?d AND code=?",$questionnaire->getId(),$fields['code']);
                if(!empty($selectUser)) {
                    $DB->query("UPDATE ac_questionnaire_secret SET ?a WHERE questionnaire_id=?d AND code=?",$fields,$questionnaire->getId(),$fields['code']);
                    return true;
                }
            } else {
                $selectUser = $DB->selectRow("SELECT * FROM ac_questionnaire_members WHERE questionnaire_id=?d AND code=?",$questionnaire->getId(),$fields['code']);
                if(!empty($selectUser)) {
                    if(!empty($fields['fio'])) {
                        unset($fields['fio']);
                    }
                    $DB->query("UPDATE ac_questionnaire_members SET ?a WHERE questionnaire_id=?d AND code=?",$fields,$questionnaire->getId(),$fields['code']);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return Questionnaire[]
     */
    public function getQuestionnairesList() {
        global $DB;
        $questionnairesArr = $DB->select("SELECT * FROM ac_questionnaire ORDER BY id DESC");
        $questionnaires = array();
        foreach ($questionnairesArr as $questionnaire) {
            $members = $this->getQuestionnaireMembersListById($questionnaire['id']);
            $questionnaires[] = $this->createQuestionnaireFromDB($questionnaire,$members);
        }
        return $questionnaires;
    }

    /**
     * @return Questionnaire
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
     * @return Member[]
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
     * @return SecretMember[]
     */
    public function getQuestionnaireSecretMembersListById($id) {
        global $DB;

        $questionnaireMembersArr = $DB->select("SELECT * FROM ac_questionnaire_secret
                                                WHERE questionnaire_id=?d ORDER BY code",$id);

        $questionnaireMembers = array();

        foreach ($questionnaireMembersArr as $item) {
            $questionnaireMembers[] = $this->createSecretMemberFromDB($item);
        }
        return $questionnaireMembers;
    }

    /**
     * @return int
     */
    public function getQuestionnaireMembersCountById($id) {
        global $DB;

        $questionnaireCount = $DB->selectRow("SELECT COUNT(*) AS cnt FROM `ac_questionnaire_members` WHERE `questionnaire_id`=?d",$id);
        if(!empty($questionnaireCount)) {
            return (int)$questionnaireCount['cnt'];
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getQuestionnaireRegistrationCountById($id) {
        global $DB;

        $questionnaireCount = $DB->selectRow("SELECT COUNT(*) AS cnt FROM `ac_questionnaire_members` WHERE `questionnaire_id`=?d AND `registration_completed`=1",$id);
        if(!empty($questionnaireCount)) {
            return (int)$questionnaireCount['cnt'];
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getQuestionnaireParticipateCountById($id) {
        global $DB;

        $questionnaireCount = $DB->selectRow("SELECT COUNT(*) AS cnt FROM `ac_questionnaire_members` WHERE `questionnaire_id`=?d AND `meeting_participation`='принял участие'",$id);
        if(!empty($questionnaireCount)) {
            return (int)$questionnaireCount['cnt'];
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getQuestionnaireSecretAllCountById($id) {
        global $DB;

        $questionnaireCount = $DB->selectRow("SELECT COUNT(*) AS cnt FROM `ac_questionnaire_secret` WHERE `questionnaire_id`=?d AND `vote_result`<>''",$id);
        if(!empty($questionnaireCount)) {
            return (int)$questionnaireCount['cnt'];
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getQuestionnaireSecretForCountById($id) {
        global $DB;

        $questionnaireCount = $DB->selectRow("SELECT COUNT(*) AS cnt FROM `ac_questionnaire_secret` WHERE `questionnaire_id`=?d AND `vote_result`='да'",$id);
        if(!empty($questionnaireCount)) {
            return (int)$questionnaireCount['cnt'];
        }
        return 0;
    }
    /**
     * @return int
     */
    public function getQuestionnaireSecretAgainstCountById($id) {
        global $DB;

        $questionnaireCount = $DB->selectRow("SELECT COUNT(*) AS cnt FROM `ac_questionnaire_secret` WHERE `questionnaire_id`=?d AND `vote_result`='нет'",$id);
        if(!empty($questionnaireCount)) {
            return (int)$questionnaireCount['cnt'];
        }
        return 0;
    }
    /**
     * @return int
     */
    public function getQuestionnaireSecretAbstainedCountById($id) {
        global $DB;

        $questionnaireCount = $DB->selectRow("SELECT COUNT(*) AS cnt FROM `ac_questionnaire_secret` WHERE `questionnaire_id`=?d AND `vote_result`='воздержался'",$id);
        if(!empty($questionnaireCount)) {
            return (int)$questionnaireCount['cnt'];
        }
        return 0;
    }

    /**
     * @return Questionnaire
     */
    private function createQuestionnaireFromDB($arr,$members) {
        $arr['name'] = htmlspecialchars($arr['name']);
        $arr['questionnaire_question'] = htmlspecialchars($arr['questionnaire_question']);
        $arr['questionnaire_position'] = htmlspecialchars($arr['questionnaire_position']);
        return new Questionnaire($arr['id'],$members,$arr['name'],$arr['dt_start'],$arr['dt_end'],$arr['order_date'],$arr['order_number'],$arr['questionnaire_date'],$arr['questionnaire_question'],$arr['secret'],$arr['protocol_number'],$arr['questionnaire_fio'],$arr['questionnaire_position'], $arr['questionnaire_members_count']);
    }

    /**
     * @return Member
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
        $arr['notes'] = htmlspecialchars($arr['notes']);
        return new Member($arr['id'],$arr['userId'],$arr['lastname'],$arr['firstname'],$arr['thirdname'],$arr['code'],$arr['meeting_participation'],$arr['vote_result'],$arr['notes'],$email, $arr['registration_completed']);
    }

    /**
     * @return Member
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
     * @return SecretMember
     */
    private function createSecretMemberFromDB($arr) {
        $arr['notes'] = htmlspecialchars($arr['notes']);
        return new SecretMember($arr['id'],$arr['code'],$arr['meeting_participation'],$arr['vote_result'],$arr['notes'],$arr['userId']);
    }

    /**
     * @return SecretMember
     */
    public function getSecretMemberByCode($code, $questionnaireId) {
        global $DB;

        $code = $DB->cleanuserinput(mb_strtolower($code));

        $memberArr = $DB->selectRow("SELECT aq.* FROM ac_questionnaire_secret AS aq
                                    WHERE aq.code=? AND aq.questionnaire_id=?d",$code,$questionnaireId);
        if(!empty($memberArr)) {
            return $this->createSecretMemberFromDB($memberArr);
        }
        return null;
    }

    /**
     * @return SecretMember
     */
    public function getSecretMemberByUserId($userId, $questionnaireId) {
        global $DB;

        $memberArr = $DB->selectRow("SELECT aq.* FROM ac_questionnaire_secret AS aq
                                    WHERE aq.userId=? AND aq.questionnaire_id=?d",$userId,$questionnaireId);
        if(!empty($memberArr)) {
            return $this->createSecretMemberFromDB($memberArr);
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

    public function updateQuestionnaire($id,$name,$dStart,$tStart,$dEnd,$tEnd,$orderDate,$orderNumber,$questionnaireDate,$questionnaireQuestion, $protocolNumber, $questionnaireFio, $questionnairePosition, $questionnaireMembersCount) {
        global $DB;
        $updateArr = array();
        $updateArr['name'] = $name;
        $updateArr['dt_start'] = $dStart." ".$tStart;
        $updateArr['dt_end'] = $dEnd." ".$tEnd;
        $updateArr['order_date'] = $orderDate;
        $updateArr['order_number'] = $orderNumber;
        $updateArr['questionnaire_date'] = $questionnaireDate;
        $updateArr['questionnaire_question'] = $questionnaireQuestion;
        $updateArr['protocol_number'] = $protocolNumber;
        $updateArr['questionnaire_fio'] = $questionnaireFio;
        $updateArr['questionnaire_position'] = $questionnairePosition;
        $updateArr['questionnaire_members_count'] = $questionnaireMembersCount;

        $DB->query("UPDATE ac_questionnaire SET ?a WHERE id=?",$updateArr,$id);
    }

    public function createQuestionnaire($name,$dStart,$tStart,$dEnd,$tEnd,$orderDate,$orderNumber,$questionnaireDate,$questionnaireQuestion, $secret, $protocolNumber, $questionnaireFio, $questionnairePosition) {
        global $DB;

       if(empty($secret)) {
           $secret = 0;
       }

        $questionnaireId = $DB->query("INSERT INTO ac_questionnaire(name,dt_start,dt_end,order_date,order_number,questionnaire_date,questionnaire_question,secret,protocol_number,questionnaire_fio,questionnaire_position) VALUES (?,?,?,?,?,?,?,?,?,?,?)",$name,$dStart." ".$tStart,$dEnd." ".$tEnd,$orderDate,$orderNumber,$questionnaireDate,$questionnaireQuestion,$secret, $protocolNumber, $questionnaireFio, $questionnairePosition);

        $persons=$DB->select("SELECT p.id AS id, p.surname AS lastname, p.name AS firstname, p.fname AS thirdname, p.mail1 AS email1, p.mail2 AS email2, p.emails_for_mailing AS emails_for_mailing, p.emails_for_ac_mailing AS emails_for_ac_mailing, s.sort AS sort
                   FROM Admin AS s
                   INNER JOIN persons AS p ON p.id=s.persona
				   WHERE s.type=200
                   ORDER BY s.sort");

        if($_GET['test']==1) {
            $persons = $DB->select("SELECT p.id AS id, p.surname AS lastname, p.name AS firstname, p.fname AS thirdname, p.mail1 AS email1, p.mail2 AS email2, p.emails_for_mailing AS emails_for_mailing, p.emails_for_ac_mailing AS emails_for_ac_mailing, p.id AS sort
                   FROM persons AS p
				   WHERE p.id=69");
        }

        $counterPrefix = 1;
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
//            $prefix = preg_replace("/[^a-z0-9]/i","",$email);
            $guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
            $code = $counterPrefix.time().$guid.dechex( microtime(true) * 1000 );
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $DB->query("INSERT INTO ac_questionnaire_members(userId,code,sort,questionnaire_id, notes) VALUES(?d,?,?,?,'')",$person['id'],$code,$person['sort'],$questionnaireId);
            $counterPrefix++;
        }
    }

    public function createSecretCode($questionnaireId, $userId) {
        global $DB;

        $currentSecretMember = $this->getSecretMemberByUserId($userId, $questionnaireId);

        if(!empty($currentSecretMember)) {
            $code = $currentSecretMember->getCode();
        } else {
            $guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
            $code = $questionnaireId.$guid.dechex( microtime(true) * 1000 );
            $code = $DB->cleanuserinput(mb_strtolower($code));

            $existCode = $DB->query("SELECT * FROM ac_questionnaire_secret WHERE code=?",$code);
            if(empty($existCode)) {
                $DB->query("INSERT INTO ac_questionnaire_secret(code,questionnaire_id, notes, userId) VALUES (?,?,'',?)", $code, $questionnaireId, $userId);
            } else {
                return $this->createSecretCode($questionnaireId, $userId);
            }
        }

        return $code;
    }

    public function deleteQuestionnaireById($id) {
        global $DB;

        if(!empty($id)) {
            $DB->query("DELETE FROM ac_questionnaire WHERE id=?",$id);
            $DB->query("DELETE FROM ac_questionnaire_members WHERE questionnaire_id=?",$id);
            $DB->query("DELETE FROM ac_questionnaire_secret WHERE questionnaire_id=?",$id);
        }
    }

    /**
     * @return bool
     */
    public function sendMails($data) {
        global $DB;

        $questionnaire = $this->getQuestionnaireById($_GET['id']);
        $questionnairePageId = $this->pages->getFirstPageIdByTemplate("ac_questionnaire");

        $DB->query("LOCK TABLES ac_questionnaire_secret WRITE READ");
        if($questionnaire->isSecret()) {
            $secretCodes = $this->getQuestionnaireSecretMembersListById($questionnaire->getId());

            if(!empty($secretCodes)) {
                $DB->query("UNLOCK TABLES");
                return false;
            }
        }
        if(!empty($questionnaire)) {
            $attachments = unserialize($data['attachments']);
            foreach ($questionnaire->getMembers() as $member) {
                $text = $data['mail_text'];
                $text = str_replace("{FIO}",$member->getFirstName()." ".$member->getThirdName(),$text);
//                if($questionnaire->isSecret()) {
//                    $code = $this->createSecretCode($questionnaire->getId());
//                    $text = str_replace("{LINK}","<a target=\"_blank\" href=\"https://www.imemo.ru/index.php?page_id=".$questionnairePageId."&code=".$code."&questionnaire_id=".$questionnaire->getId()."\">Открыть</a>",$text);
//                } else {
                $text = str_replace("{LINK}","<a target=\"_blank\" href=\"https://www.imemo.ru/index.php?page_id=".$questionnairePageId."&code=".$member->getCode()."&questionnaire_id=".$questionnaire->getId()."\">Открыть</a>",$text);
//                }
                $email = $data['mail-'.$member->getUserId()];
                $email = str_replace(" ","",$email);

                if(!empty($email)) {
                    $DB->query("UPDATE persons SET emails_for_ac_mailing=? WHERE id=?d",$email,$member->getUserId());
                }
                $text = \Dreamedit::LineBreakPlusBrAll($text);
                if(empty($attachments)) {
                    \MailSend::send_mime_mail("Ученый совет ИМЭМО РАН", "noreply@imemo.ru", $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName(), $email, "cp1251", "utf-8", $data['mail_subject'], $text);
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

                    \MailSend::send_mime_mail_attachments("Ученый совет ИМЭМО РАН", "noreply@imemo.ru", $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName(), $email, "cp1251", "utf-8",  $data['mail_subject'], $text, $files,__DIR__."/../Documents/Uploads");
                }
            }
            foreach ($attachments as $attachment) {
                if(is_file(__DIR__."/../Documents/Uploads/".$attachment["attachment"])) {
                    unlink(__DIR__."/../Documents/Uploads/".$attachment["attachment"]);
                }
            }
        }
        $DB->query("UNLOCK TABLES");
        return true;
    }
}