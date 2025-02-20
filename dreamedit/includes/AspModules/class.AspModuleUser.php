<?php

class AspModuleUser {

    /** @var int */
    private $id;
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $thirdName;
    /** @var string */
    private $email;
    /** @var string */
    private $password;
    /** @var string */
    private $fieldOfStudy;
    /** @var int */
    private $status;
    /** @var string */
    private $birthDate;
    /** @var string */
    private $phone;
    /** @var string */
    private $fioR;
    /** @var string */
    private $citizenship;
    /** @var string */
    private $nationality;
    /** @var string */
    private $passportSeries;
    /** @var string */
    private $passportNumber;
    /** @var string */
    private $passportDate;
    /** @var string */
    private $passportAddress;
    /** @var string */
    private $passportPlace;
    /** @var string */
    private $birthplace;
    /** @var string */
    private $gender;
    /** @var int */
    private $fieldOfStudyProfile;
    /** @var bool */
    private $willPay;
    /** @var bool */
    private $willBudget;
    /** @var string */
    private $prioritetFirst;
    /** @var string */
    private $prioritetSecond;
    /** @var string */
    private $university;
    /** @var string */
    private $universityYearEnd;
    /** @var string */
    private $diplom;
    /** @var string */
    private $diplomSeries;
    /** @var string */
    private $diplomNumber;
    /** @var string */
    private $diplomDate;
    /** @var string */
    private $exam;
    /** @var bool */
    private $examSpecCond;
    /** @var string */
    private $examSpecCondDiscipline;
    /** @var string */
    private $examSpecCondList;
    /** @var bool */
    private $obsh;
    /** @var array */
    private $universityList;
    /** @var string */
    private $homeAddressPhone;
    /** @var string */
    private $relatives;
    /** @var string */
    private $armyRank;
    /** @var string */
    private $armyStructure;
    /** @var string */
    private $armyType;
    /** @var array */
    private $abroadList;
    /** @var array */
    private $workList;
    /** @var string */
    private $govAwards;
    /** @var string */
    private $academicRank;
    /** @var string */
    private $academicDegree;
    /** @var string */
    private $languages;
    /** @var string */
    private $photo;
    /** @var string */
    private $education;
    /** @var string */
    private $scienceWorkAndInvents;
    /** @var int */
    private $attachmentCount;
    /** @var int */
    private $attachmentPages;
    /** @var string */
    private $pdfApplication;
    /** @var string */
    private $pdfPersonalDocument;
    /** @var string */
    private $pdfEducation;
    /** @var string */
    private $pdfAutoBiography;
    /** @var string */
    private $pdfPersonalSheet;
    /** @var string */
    private $pdfDisabledInfo;
    /** @var array */
    private $pdfIndividualAchievements;
    /** @var string */
    private $commentFromAdmin;
    /** @var string */
    private $pdfLastUploadDateTime;
    /** @var array */
    private $fieldsError;
    /** @var bool */
    private $willPayEntry;
    /** @var bool */
    private $willBudgetEntry;
    /** @var string */
    private $pdfApplyForEntry;

    /**
     * AspModuleUser constructor.
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $thirdName
     * @param string $email
     * @param string $password
     * @param string $fieldOfStudy
     * @param int $status
     * @param string $birthDate
     * @param string $phone
     * @param string $fioR
     * @param string $citizenship
     * @param string $nationality
     * @param string $passportSeries
     * @param string $passportNumber
     * @param string $passportDate
     * @param string $passportAddress
     * @param string $passportPlace
     * @param string $birthplace
     * @param string $gender
     * @param int $fieldOfStudyProfile
     * @param bool $willPay
     * @param bool $willBudget
     * @param string $prioritetFirst
     * @param string $prioritetSecond
     * @param string $university
     * @param string $universityYearEnd
     * @param string $diplom
     * @param string $diplomSeries
     * @param string $diplomNumber
     * @param string $diplomDate
     * @param string $exam
     * @param bool $examSpecCond
     * @param string $examSpecCondDiscipline
     * @param string $examSpecCondList
     * @param bool $obsh
     * @param array $universityList
     * @param string $homeAddressPhone
     * @param string $relatives
     * @param string $armyRank
     * @param string $armyStructure
     * @param string $armyType
     * @param array $abroadList
     * @param array $workList
     * @param string $govAwards
     * @param string $academicRank
     * @param string $academicDegree
     * @param string $languages
     * @param string $photo
     * @param string $education
     * @param string $scienceWorkAndInvents
     * @param int $attachmentCount
     * @param int $attachmentPages
     * @param string $pdfApplication
     * @param string $pdfPersonalDocument
     * @param string $pdfEducation
     * @param string $pdfAutoBiography
     * @param string $pdfPersonalSheet
     * @param string $pdfDisabledInfo
     * @param array $pdfIndividualAchievements
     * @param string $commentFromAdmin
     * @param string $pdfLastUploadDateTime
     * @param array $fieldsError
     * @param bool $willPayEntry
     * @param bool $willBudgetEntry
     * @param string $pdfApplyForEntry
     */
    public function __construct($id, $firstName, $lastName, $thirdName, $email, $password, $fieldOfStudy, $status, $birthDate, $phone, $fioR, $citizenship, $nationality, $passportSeries, $passportNumber, $passportDate, $passportAddress, $passportPlace, $birthplace, $gender, $fieldOfStudyProfile, $willPay, $willBudget, $prioritetFirst, $prioritetSecond, $university, $universityYearEnd, $diplom, $diplomSeries, $diplomNumber, $diplomDate, $exam, $examSpecCond, $examSpecCondDiscipline, $examSpecCondList, $obsh, array $universityList, $homeAddressPhone, $relatives, $armyRank, $armyStructure, $armyType, array $abroadList, array $workList, $govAwards, $academicRank, $academicDegree, $languages, $photo, $education, $scienceWorkAndInvents, $attachmentCount, $attachmentPages, $pdfApplication, $pdfPersonalDocument, $pdfEducation, $pdfAutoBiography, $pdfPersonalSheet, $pdfDisabledInfo, array $pdfIndividualAchievements, $commentFromAdmin, $pdfLastUploadDateTime, array $fieldsError, $willPayEntry, $willBudgetEntry, $pdfApplyForEntry)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->thirdName = $thirdName;
        $this->email = $email;
        $this->password = $password;
        $this->fieldOfStudy = $fieldOfStudy;
        $this->status = $status;
        $this->birthDate = $birthDate;
        $this->phone = $phone;
        $this->fioR = $fioR;
        $this->citizenship = $citizenship;
        $this->nationality = $nationality;
        $this->passportSeries = $passportSeries;
        $this->passportNumber = $passportNumber;
        $this->passportDate = $passportDate;
        $this->passportAddress = $passportAddress;
        $this->passportPlace = $passportPlace;
        $this->birthplace = $birthplace;
        $this->gender = $gender;
        $this->fieldOfStudyProfile = $fieldOfStudyProfile;
        $this->willPay = $willPay;
        $this->willBudget = $willBudget;
        $this->prioritetFirst = $prioritetFirst;
        $this->prioritetSecond = $prioritetSecond;
        $this->university = $university;
        $this->universityYearEnd = $universityYearEnd;
        $this->diplom = $diplom;
        $this->diplomSeries = $diplomSeries;
        $this->diplomNumber = $diplomNumber;
        $this->diplomDate = $diplomDate;
        $this->exam = $exam;
        $this->examSpecCond = $examSpecCond;
        $this->examSpecCondDiscipline = $examSpecCondDiscipline;
        $this->examSpecCondList = $examSpecCondList;
        $this->obsh = $obsh;
        $this->universityList = $universityList;
        $this->homeAddressPhone = $homeAddressPhone;
        $this->relatives = $relatives;
        $this->armyRank = $armyRank;
        $this->armyStructure = $armyStructure;
        $this->armyType = $armyType;
        $this->abroadList = $abroadList;
        $this->workList = $workList;
        $this->govAwards = $govAwards;
        $this->academicRank = $academicRank;
        $this->academicDegree = $academicDegree;
        $this->languages = $languages;
        $this->photo = $photo;
        $this->education = $education;
        $this->scienceWorkAndInvents = $scienceWorkAndInvents;
        $this->attachmentCount = $attachmentCount;
        $this->attachmentPages = $attachmentPages;
        $this->pdfApplication = $pdfApplication;
        $this->pdfPersonalDocument = $pdfPersonalDocument;
        $this->pdfEducation = $pdfEducation;
        $this->pdfAutoBiography = $pdfAutoBiography;
        $this->pdfPersonalSheet = $pdfPersonalSheet;
        $this->pdfDisabledInfo = $pdfDisabledInfo;
        $this->pdfIndividualAchievements = $pdfIndividualAchievements;
        $this->commentFromAdmin = $commentFromAdmin;
        $this->pdfLastUploadDateTime = $pdfLastUploadDateTime;
        $this->fieldsError = $fieldsError;
        $this->willPayEntry = $willPayEntry;
        $this->willBudgetEntry = $willBudgetEntry;
        $this->pdfApplyForEntry = $pdfApplyForEntry;
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
    public function getFirstName()
    {
        return $this->firstName;
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
    public function getThirdName()
    {
        return $this->thirdName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFieldOfStudy()
    {
        return $this->fieldOfStudy;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getFioR()
    {
        return $this->fioR;
    }

    /**
     * @return string
     */
    public function getCitizenship()
    {
        return $this->citizenship;
    }

    /**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @return string
     */
    public function getPassportSeries()
    {
        return $this->passportSeries;
    }

    /**
     * @return string
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }

    /**
     * @return string
     */
    public function getPassportDate()
    {
        return $this->passportDate;
    }

    /**
     * @return string
     */
    public function getPassportAddress()
    {
        return $this->passportAddress;
    }

    /**
     * @return string
     */
    public function getPassportPlace()
    {
        return $this->passportPlace;
    }

    /**
     * @return string
     */
    public function getBirthplace()
    {
        return $this->birthplace;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getFieldOfStudyProfile()
    {
        return $this->fieldOfStudyProfile;
    }

    /**
     * @return bool
     */
    public function isWillPay()
    {
        return $this->willPay;
    }

    /**
     * @return string
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * @return string
     */
    public function getUniversityYearEnd()
    {
        return $this->universityYearEnd;
    }

    /**
     * @return string
     */
    public function getDiplom()
    {
        return $this->diplom;
    }

    /**
     * @return string
     */
    public function getDiplomSeries()
    {
        return $this->diplomSeries;
    }

    /**
     * @return string
     */
    public function getDiplomNumber()
    {
        return $this->diplomNumber;
    }

    /**
     * @return string
     */
    public function getDiplomDate()
    {
        return $this->diplomDate;
    }

    /**
     * @return string
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * @return bool
     */
    public function isExamSpecCond()
    {
        return $this->examSpecCond;
    }

    /**
     * @return string
     */
    public function getExamSpecCondDiscipline()
    {
        return $this->examSpecCondDiscipline;
    }

    /**
     * @return string
     */
    public function getExamSpecCondList()
    {
        return $this->examSpecCondList;
    }

    /**
     * @return bool
     */
    public function isObsh()
    {
        return $this->obsh;
    }

    /**
     * @return array
     */
    public function getUniversityList()
    {
        return $this->universityList;
    }

    /**
     * @return string
     */
    public function getHomeAddressPhone()
    {
        return $this->homeAddressPhone;
    }

    /**
     * @return string
     */
    public function getRelatives()
    {
        return $this->relatives;
    }

    /**
     * @return string
     */
    public function getArmyRank()
    {
        return $this->armyRank;
    }

    /**
     * @return string
     */
    public function getArmyStructure()
    {
        return $this->armyStructure;
    }

    /**
     * @return string
     */
    public function getArmyType()
    {
        return $this->armyType;
    }

    /**
     * @return array
     */
    public function getAbroadList()
    {
        return $this->abroadList;
    }

    /**
     * @return array
     */
    public function getWorkList()
    {
        return $this->workList;
    }

    /**
     * @return string
     */
    public function getGovAwards()
    {
        return $this->govAwards;
    }

    /**
     * @return string
     */
    public function getAcademicRank()
    {
        return $this->academicRank;
    }

    /**
     * @return string
     */
    public function getAcademicDegree()
    {
        return $this->academicDegree;
    }

    /**
     * @return string
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @return string
     */
    public function getPrioritetFirst()
    {
        return $this->prioritetFirst;
    }

    /**
     * @return string
     */
    public function getPrioritetSecond()
    {
        return $this->prioritetSecond;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @return string
     */
    public function getScienceWorkAndInvents()
    {
        return $this->scienceWorkAndInvents;
    }

    /**
     * @return int
     */
    public function getAttachmentCount()
    {
        return $this->attachmentCount;
    }

    /**
     * @return int
     */
    public function getAttachmentPages()
    {
        return $this->attachmentPages;
    }

    /**
     * @return string
     */
    public function getPdfApplication()
    {
        return $this->pdfApplication;
    }

    /**
     * @return string
     */
    public function getPdfPersonalDocument()
    {
        return $this->pdfPersonalDocument;
    }

    /**
     * @return string
     */
    public function getPdfEducation()
    {
        return $this->pdfEducation;
    }

    /**
     * @return string
     */
    public function getPdfAutoBiography()
    {
        return $this->pdfAutoBiography;
    }

    /**
     * @return string
     */
    public function getPdfPersonalSheet()
    {
        return $this->pdfPersonalSheet;
    }

    /**
     * @return string
     */
    public function getPdfDisabledInfo()
    {
        return $this->pdfDisabledInfo;
    }

    /**
     * @return array
     */
    public function getPdfIndividualAchievements()
    {
        return $this->pdfIndividualAchievements;
    }

    /**
     * @return string
     */
    public function getCommentFromAdmin()
    {
        return $this->commentFromAdmin;
    }

    /**
     * @return string
     */
    public function getPdfLastUploadDateTime()
    {
        return $this->pdfLastUploadDateTime;
    }

    /**
     * @return array
     */
    public function getFieldsError()
    {
        return $this->fieldsError;
    }

    /**
     * @return bool
     */
    public function isWillBudget()
    {
        return $this->willBudget;
    }

    /**
     * @return bool
     */
    public function isWillBudgetEntry()
    {
        return $this->willBudgetEntry;
    }

    /**
     * @return bool
     */
    public function isWillPayEntry()
    {
        return $this->willPayEntry;
    }

    /**
     * @return string
     */
    public function getPdfApplyForEntry()
    {
        return $this->pdfApplyForEntry;
    }

}

class AspModuleUserManager {

    private $salt = "f4f@F(28f829h!f3";
    private $key = "eFH@u4bfi24bfuafbf$@f!";

    /** @var AspModuleUser */
    private $currentEditableUser = null;

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @return AspModuleUser
     */
    private function createUserFromDB($row,$secure = false) {
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

        $user = new AspModuleUser($row['id'],$row['firstname'],$row['lastname'],$row['thirdname'],$row['email'],$password,$row['field_of_study'],$row['status'], $row['birthdate'], $row['phone'], $row['fio_r'], $row['citizenship'], $row['nationality'], $row['passport_series'], $row['passport_number'], $row['passport_date'], $row['passport_address'], $row['passport_place'], $row['birthplace'], $row['gender'], $row['field_of_study_profile'], $row['will_pay'], $row['will_budget'], $row['prioritet_1'], $row['prioritet_2'], $row['university'], $row['university_year_end'], $row['diplom'], $row['diplom_series'], $row['diplom_number'], $row['diplom_date'], $row['exam'], $row['exam_spec_cond'], $row['exam_spec_cond_discipline'], $row['exam_spec_cond_list'], $row['obsh'], $universityList, $row['home_address_phone'], $row['relatives'], $row['army_rank'], $row['army_structure'], $row['army_type'], $abroadList, $workList, $row['gov_awards'], $row['academic_rank'], $row['academic_degree'], $row['languages'], $row['photo'], $row['education'], $row['science_work_and_invents'], $row['attachment_count'], $row['attachment_pages'], $row['pdf_application'],$row['pdf_personal_document'],$row['pdf_education'],$row['pdf_autobiography'],$row['pdf_personal_sheet'],$row['pdf_disabled_info'],$pdfAchievementsList,$row['comment_from_admin'],$row['pdf_last_upload_date'],$fieldsErrorList, $row['will_pay_entry'], $row['will_budget_entry'], $row['pdf_apply_for_entry']);
        return $user;
    }

    /**
     * @return AspModuleUser[]
     */
    public function getAllUsersWithStatus($statuses,$documentSendDateFrom="",$documentSendDateTo="",$sortField="lastname",$sortType="ASC",$sortField2="lastname",$sortType2="ASC",$sortField3="lastname",$sortType3="ASC") {
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
            $aspUsers[] = $this->createUserFromDB($item,true);
        }
        return $aspUsers;
    }

    /**
     * @return AspModuleUser[]
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
            $aspUsers[] = $this->createUserFromDB($item,true);
        }
        return $aspUsers;
    }

    /**
     * @return AspModuleUser
     */
    public function getUserById($id) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE id=?d",$id);

        if(!empty($userArr)) {
            $user = $this->createUserFromDB($userArr,true);
            return $user;
        }
        return null;
    }

    /**
     * @return AspModuleUser
     */
    public function getUserByEmail($email) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE email=?",$email);

        if(!empty($userArr)) {
            $user = $this->createUserFromDB($userArr,true);
            return $user;
        }
        return null;
    }

    /**
     * @return AspModuleUser
     */
    public function getUserByIdEmailPassword($id,$email,$password) {
        global $DB;

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE id=?d AND email=? AND password=?",$id,$email,$password);

        if(!empty($userArr)) {
            $user = $user = $this->createUserFromDB($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @return AspModuleUser
     */
    public function getUserByEmailAndPassword($email,$password) {
        global $DB;

        $password = hash_hmac('ripemd160',$this->salt.$password, $this->key);

        $userArr = $DB->selectRow("SELECT * FROM asp_users WHERE email=? AND password=?",$email,$password);
        if(!empty($userArr)) {
            $user = $user = $this->createUserFromDB($userArr);
            return $user;
        }
        return null;
    }

    /**
     * @return string
     */
    public function registerRequest($email,$password,$firstname,$lastname,$thirdname,$phone,$birthdate,$fieldOfStudy) {
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

        $code = '';
        $code = str_replace("@", "",str_replace(".","",$email))."_".UUID::v4();
        $code = $DB->cleanuserinput(mb_strtolower($code));
        //error_reporting(E_ALL);
        $DB->query('INSERT INTO asp_register_request(password, firstname,lastname,thirdname,email,code,phone,birthdate,field_of_study) VALUES(?,?,?,?,?,?,?,?,?)',$password,$firstname,$lastname,$thirdname,$email,$code,$phone,$birthdate,$fieldOfStudy);
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
            $code = $prefix."_".UUID::v4();
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
                    $DB->query('INSERT INTO asp_users(password, firstname, lastname,thirdname,email,phone,birthdate,field_of_study,status) VALUES(?,?,?,?,?,?,?,?,?)',$exist[0]['password'],$exist[0]['firstname'],$exist[0]['lastname'],$exist[0]['thirdname'],$exist[0]['email'],$exist[0]['phone'],$exist[0]['birthdate'],$exist[0]['field_of_study'],1);
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

            $data .= $nn . "Сообщаем, что статус Вашего заявления был изменен на: <b>" . $this->aspModule->getAspStatusManager()->getStatusText($statusId) ."</b>". $nn . $nn;

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН." . $nn;

            MailSend::send_mime_mail("Аспирантура ИМЭМО РАН", "info@imemo.ru", "", $email, "cp1251", "utf-8", "Изменение статуса заявления", $data);


            return true;
        }
        return false;
    }

    /**
     * @return AspModuleUser
     */
    public function getCurrentEditableUser()
    {
        return $this->currentEditableUser;
    }

    /**
     * @param AspModuleUser $currentEditableUser
     */
    public function setCurrentEditableUser($currentEditableUser)
    {
        $this->currentEditableUser = $currentEditableUser;
    }
}