<?php

namespace AspModule\Services;

use AspModule\AspModule;
use AspModule\Models\User;

class UserService {
    private $salt = "f4f@F(28f829h!f3";
    private $key = "eFH@u4bfi24bfuafbf$@f!";

    /** @var User */
    private $currentEditableUser = null;

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @return User
     */
    private function mapToUser($row,$secure = false) {
        if($secure) {
            $password = "";
        } else {
            $password = $row['password'];
        }
        $universityList = array();
        if(!empty($row['university_list'])) {
            $universityList = unserialize($row['university_list']);
        }
        $abroadList = array();
        if(!empty($row['abroad_list'])) {
            $abroadList = unserialize($row['abroad_list']);
        }
        $workList = array();
        if(!empty($row['work_list'])) {
            $workList = unserialize($row['work_list']);
        }
        $pdfAchievementsList = array();
        if(!empty($row['pdf_individual_achievements'])) {
            $pdfAchievementsList = unserialize($row['pdf_individual_achievements']);
        }
        $fieldsErrorList = array();
        if(!empty($row['fields_error'])) {
            $fieldsErrorList = unserialize($row['fields_error']);
        }
        $scienceWorkList = array();
        if(!empty($row['science_work_list'])) {
            $scienceWorkList = unserialize($row['science_work_list']);
        }

        $applicationsYear = $this->aspModule->getApplicationsYearService()->getApplicationsYearById(0);
        if(!empty($row['application_year'])) {
            $applicationsYear = $this->aspModule->getApplicationsYearService()->getApplicationsYearById($row['application_year']);
        }

        $user = new User($row['id'],$row['firstname'],$row['lastname'],$row['thirdname'],$row['email'],$password,$row['field_of_study'],$row['status'], $row['birthdate'], $row['phone'], $row['fio_r'], $row['citizenship'], $row['nationality'], $row['passport_series'], $row['passport_number'], $row['passport_date'], $row['passport_address'], $row['passport_place'], $row['birthplace'], $row['gender'], $row['field_of_study_profile'], $row['will_pay'], $row['will_budget'], $row['prioritet_1'], $row['prioritet_2'], $row['university'], $row['university_year_end'], $row['diplom'], $row['diplom_series'], $row['diplom_number'], $row['diplom_date'], $row['exam'], $row['exam_spec_cond'], $row['exam_spec_cond_discipline'], $row['exam_spec_cond_list'], $row['obsh'], $universityList, $row['home_address_phone'], $row['relatives'], $row['army_rank'], $row['army_structure'], $row['army_type'], $abroadList, $workList, $row['gov_awards'], $row['academic_rank'], $row['academic_degree'], $row['languages'], $row['photo'], $row['education'], $row['science_work_and_invents'], $row['attachment_count'], $row['attachment_pages'], $row['pdf_application'],$row['pdf_personal_document'],$row['pdf_education'],$row['pdf_autobiography'],$row['pdf_personal_sheet'],$row['pdf_disabled_info'],$pdfAchievementsList,$row['comment_from_admin'],$row['pdf_last_upload_date'],$fieldsErrorList, $row['will_pay_entry'], $row['will_budget_entry'], $row['pdf_apply_for_entry'], $row['for_dissertation_attachment'], $row['dissertation_theme'], $row['dissertation_supervisor'], $row['dissertation_department'], $row['pdf_education_period_reference'],$applicationsYear, $row['pension_certificate'], $row['send_back_type'], $row['pdf_pension_certificate'], $row['inform_type'], $scienceWorkList, $row['pdf_science_work_list'], $row['special_code'], $row['pdf_consent_data_processing'], $row['pension_certificate_dont_have'], $row['word_essay']);
        return $user;
    }

    /**
     * @return User[]
     */
    public function getAllUsersWithStatus($statuses,$documentSendDateFrom="",$documentSendDateTo="",$sortField="lastname",$sortType="ASC",$sortField2="lastname",$sortType2="ASC",$sortField3="lastname",$sortType3="ASC", $applicationsYearId = -1) {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        if(!empty($documentSendDateFrom) && !empty($documentSendDateTo)) {
            $userArr = $DB->select("SELECT * FROM asp_users WHERE status IN(?a) AND DATE_FORMAT(pdf_last_upload_date,'%Y-%m-%d')>=? AND DATE_FORMAT(pdf_last_upload_date,'%Y-%m-%d')<=? ORDER BY " . $sortField . " " . $sortType.", ".$sortField2." ".$sortType2.", ".$sortField3." ".$sortType3, $statuses,$documentSendDateFrom,$documentSendDateTo);
        } else {
            $userArr = $DB->select("SELECT * FROM asp_users WHERE status IN(?a) ORDER BY " . $sortField . " " . $sortType.", ".$sortField2." ".$sortType2.", ".$sortField3." ".$sortType3, $statuses);
        }
        $aspUsers = array();
        foreach ($userArr as $item) {
            if($applicationsYearId != -1) {
                if($item['application_year'] != $applicationsYearId) {
                    continue;
                }
            }
            $aspUsers[] = $this->mapToUser($item,true);
        }
        return $aspUsers;
    }

    /**
     * @return User[]
     */
    public function getAllUsers($sortField="lastname",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $userArr = $DB->select("SELECT * FROM asp_users ORDER BY ".$sortField." ".$sortType);

        $aspUsers = array();
        foreach ($userArr as $item) {
            $aspUsers[] = $this->mapToUser($item,true);
        }
        return $aspUsers;
    }

    /**
     * @return User[]
     */
    public function getAllUsersByApplicationsYearId($applicationsYearId, $sortField="lastname",$sortType="ASC") {
        global $DB;

        $sortField = str_replace(" ","",$sortField);
        if($sortType!="ASC" && $sortType!="DESC") {
            return null;
        }

        $userArr = $DB->select("SELECT * FROM asp_users WHERE application_year=?d ORDER BY ".$sortField." ".$sortType, $applicationsYearId);

        $aspUsers = array();
        foreach ($userArr as $item) {
            $aspUsers[] = $this->mapToUser($item,true);
        }
        return $aspUsers;
    }

    /**
     * @return User
     */
    public function getUserById($id) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE id=?d",$id);

        if(!empty($userArr)) {
            $user = $this->mapToUser($userArr,true);
            return $user;
        }
        return null;
    }

    /**
     * @return User
     */
    public function getUserByEmail($email) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE email=?",$email);

        if(!empty($userArr)) {
            $user = $this->mapToUser($userArr,true);
            return $user;
        }
        return null;
    }

    /**
     * @return User
     */
    public function getUserByIdEmailPassword($id,$email,$password) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE id=?d AND email=? AND password=?",$id,$email,$password);

        if(!empty($userArr)) {
            $user = $user = $this->mapToUser($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @return User
     */
    public function getUserByEmailAndPassword($email,$password) {
        global $DB;

        $password = hash_hmac('ripemd160',$this->salt.$password, $this->key);

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE email=? AND password=?",$email,$password);
        if(!empty($userArr)) {
            $user = $user = $this->mapToUser($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @return string
     */
    public function registerRequest($email,$password,$firstname,$lastname,$thirdname,$phone,$birthdate,$fieldOfStudy,$forDissertationAttachment) {
        global $DB;

        $request_exist = $DB->select('SELECT id, code FROM asp_register_request WHERE email = ?', $email);

        if(!empty($request_exist)) {
            $DB->query("DELETE FROM asp_register_request WHERE id=?",$request_exist[0]['id']);
        }

        $password = hash_hmac('ripemd160',$this->salt.$password, $this->key);

        if(empty($firstname)) $firstname = '';
        if(empty($lastname)) $lastname = '';
        if(empty($thirdname)) $thirdname = '';
        if(empty($phone)) $phone = '';
        if(empty($birthdate)) $birthdate = '';
        if(empty($fieldOfStudy)) $fieldOfStudy = '';
        if(empty($forDissertationAttachment)) $forDissertationAttachment = 0;

        $code = '';
        $code = str_replace("@", "",str_replace(".","",$email))."_".\UUID::v4();
        $code = $DB->cleanuserinput(mb_strtolower($code));
        //error_reporting(E_ALL);
        $DB->query('INSERT INTO asp_register_request(password, firstname,lastname,thirdname,email,code,phone,birthdate,field_of_study,for_dissertation_attachment) VALUES(?,?,?,?,?,?,?,?,?,?)',$password,$firstname,$lastname,$thirdname,$email,$code,$phone,$birthdate,$fieldOfStudy,$forDissertationAttachment);
        return $code;
    }

    /**
     * @return string
     */
    public function getResetCode($email) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE email=?",$email);

        if(!empty($userArr)) {
            $DB->query("DELETE FROM asp_password_reset_request WHERE email=?",$email);
            $prefix = preg_replace("/[^a-z0-9]/i","",$email);
            $code = $prefix."_".\UUID::v4();
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $DB->query('INSERT INTO asp_password_reset_request(email,code) VALUES(?,?)',$email,$code);
            return $code;
        }
        return "";
    }

    /**
     * @return bool
     */
    public function checkResetCode($email, $code) {
        global $DB;

        $resetCodeArr = $DB->selectRow("SELECT * FROM asp_password_reset_request WHERE email=? AND code=?",$email,$code);
        if(empty($resetCodeArr)) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function updatePassword($email, $code, $password) {
        global $DB;

        if(!empty($code)) {
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $exist = $DB->select('SELECT * FROM asp_password_reset_request WHERE code = ? AND email = ?', $code,$email);
            if(!empty($exist)) {
                $password = hash_hmac('ripemd160',$this->salt.$password, $this->key);
                $DB->query('UPDATE asp_users SET password=? WHERE email=?',$password,$email);
                $DB->query('DELETE FROM asp_password_reset_request WHERE code = ? AND email = ?', $code, $email);
                return "1";
            } else {
                return 'Запрос не найден';
            }
        }
        return "Запрос не найден";
    }

    /**
     * @return boolean
     */
    public function checkSpecialCodeExists($code) {
        global $DB;

        $users = $DB->select('SELECT * FROM asp_users WHERE special_code = ?', $code);

        return !empty($users);
    }

    public function tryToGenerateUidCode($additionalNumbersCount = 0) {
        global $DB;

        $uid = (string)mt_rand(10000000,99999999);

        for ($i=0; $i < $additionalNumbersCount; $i++) {
            $uid .= mt_rand(0,9);
        }

        return $this->checkSpecialCodeExists($uid) ?
            $this->tryToGenerateUidCode($additionalNumbersCount+1) : $uid;
    }

    /**
     * @return string
     */
    public function createUser($fields) {
        global $DB;

        $DB->query("LOCK TABLES asp_users as t2 READ, asp_users WRITE");
        $code = $this->tryToGenerateUidCode();
        $DB->query('INSERT INTO asp_users(firstname, lastname,thirdname,email, status,special_code, for_dissertation_attachment) VALUES(?,?,?,?,?,?,?)',$fields['firstname'],$fields['lastname'],$fields['thirdname'],$fields['email'],14,$code,$fields['for_dissertation_attachment']);
        $DB->query("UNLOCK TABLES");
        return "Пользователь зарегистрирован.";
    }

    /**
     * @return string
     */
    public function createUserFromRequest($code) {
        global $DB;

        if(!empty($code)) {
            $code = $DB->cleanuserinput(mb_strtolower($code));
            $exist = $DB->select('SELECT * FROM asp_register_request WHERE code = ?', $code);
            if(!empty($exist)) {
                $DB->query('DELETE FROM asp_register_request WHERE code = ?', $code);
                $exist_user = $DB->select('SELECT * FROM asp_users WHERE email = ?', $exist[0]['email']);
                if(!empty($exist_user)) {
                    return "Вы уже зарегистрированы";
                } else {
                    $DB->query("LOCK TABLES asp_users as t2 READ, asp_users WRITE");
                    $code = $this->tryToGenerateUidCode();
                    $DB->query('INSERT INTO asp_users(password, firstname, lastname,thirdname,email,phone,birthdate,field_of_study,for_dissertation_attachment,status,special_code) VALUES(?,?,?,?,?,?,?,?,?,?,?)',$exist[0]['password'],$exist[0]['firstname'],$exist[0]['lastname'],$exist[0]['thirdname'],$exist[0]['email'],$exist[0]['phone'],$exist[0]['birthdate'],$exist[0]['field_of_study'],$exist[0]['for_dissertation_attachment'],1,$code);
                    $DB->query("UNLOCK TABLES");
                    return "Вы успешно зарегистрировались.";
                }
            } else {
                return 'Запрос не найден';
            }
        }
        return "Запрос не найден";
    }

    /**
     * @return bool
     */
    public function updateData($id,$email,$data) {
        global $DB;

        $selectUser = $DB->selectRow("SELECT * FROM asp_users WHERE id=?d AND email=?",$id,$email);
        if(!empty($selectUser)) {
            $DB->query("UPDATE asp_users SET ?a WHERE id=?d AND email=?",$data,$id,$email);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateStatus($id,$email,$statusId) {
        global $DB;

        $selectUser = $DB->selectRow("SELECT * FROM asp_users WHERE id=?d AND email=?",$id,$email);
        if(!empty($selectUser)) {
            $DB->query("UPDATE asp_users SET status=?d WHERE id=?d AND email=?",$statusId,$id,$email);


            $nn = "<br>";
            $name = $selectUser['firstname'];
            $thirdName = $selectUser['thirdname'];
            if(!empty($thirdName)) {
                $name = $name." ".$thirdName;
            }

            $data = "Здравствуйте, ".$name."!" . $nn;

            $data .= $nn . "Сообщаем, что статус Вашего заявления был изменен на: <b>" . $this->aspModule->getStatusService()->getStatusText($statusId) ."</b>". $nn . $nn;

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН" . $nn;

            \MailSend::send_mime_mail("Аспирантура ИМЭМО РАН", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "Изменение статуса заявления", $data);


            return true;
        }
        return false;
    }

    /**
     * @return User
     */
    public function getCurrentEditableUser()
    {
        return $this->currentEditableUser;
    }

    /**
     * @param User $currentEditableUser
     */
    public function setCurrentEditableUser($currentEditableUser)
    {
        $this->currentEditableUser = $currentEditableUser;
    }

    /**
     * @return int
     */
    public function getSendBackTypeText($sendBackType)
    {
        switch ($sendBackType) {
            case 1:
                return "Передать лично или доверенному лицу";
            case 2:
                return "Направить через операторов почтовой связи общего пользования";
            default:
                return "";
        }
    }

    /**
     * @return int
     */
    public function getInformTypeText($informType)
    {
        switch ($informType) {
            case 1:
                return "Через операторов почтовой связи";
            case 2:
                return "В электронной форме";
            default:
                return "";
        }
    }

    /**
     * @param int $id
     */
    public function deleteUserById($id) {
        global $DB;

        $user = $this->getUserById($id);
        if(!empty($user)) {
            if($user->getId() != 1) {
                $DB->query("DELETE FROM asp_users WHERE id=?d", $id);
            }
        }
    }

}