<?php

namespace AspModule\Models;

class User {

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
    /** @var bool */
    private $forDissertationAttachment;
    /** @var string */
    private $dissertationTheme;
    /** @var string */
    private $dissertationSupervisor;
    /** @var string */
    private $dissertationDepartment;
    /** @var string */
    private $pdfEducationPeriodReference;
    /** @var ApplicationsYear */
    private $applicationsYear;
    /** @var string */
    private $pensionCertificate;
    /** @var int */
    private $sendBackType;
    /** @var string */
    private $pdfPensionCertificate;
    /** @var int */
    private $informType;
    /** @var array */
    private $scienceWorkList;
    /** @var string */
    private $pdfScienceWorkList;
    /** @var string */
    private $specialCode;
    /** @var string */
    private $pdfConsentDataProcessing;
    /** @var bool */
    private $pensionCertificateDontHave;
    /** @var string */
    private $wordEssay;

    /**
     * User constructor.
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
     * @param bool $forDissertationAttachment
     * @param string $dissertationTheme
     * @param string $dissertationSupervisor
     * @param string $dissertationDepartment
     * @param string $pdfEducationPeriodReference
     * @param ApplicationsYear $applicationsYear
     * @param string $pensionCertificate
     * @param int $sendBackType
     * @param string $pdfPensionCertificate
     * @param int $informType
     * @param array $scienceWorkList
     * @param string $pdfScienceWorkList
     * @param string $specialCode
     * @param string $pdfConsentDataProcessing
     * @param bool $pensionCertificateDontHave
     * @param string $wordEssay
     */
    public function __construct($id, $firstName, $lastName, $thirdName, $email, $password, $fieldOfStudy, $status, $birthDate, $phone, $fioR, $citizenship, $nationality, $passportSeries, $passportNumber, $passportDate, $passportAddress, $passportPlace, $birthplace, $gender, $fieldOfStudyProfile, $willPay, $willBudget, $prioritetFirst, $prioritetSecond, $university, $universityYearEnd, $diplom, $diplomSeries, $diplomNumber, $diplomDate, $exam, $examSpecCond, $examSpecCondDiscipline, $examSpecCondList, $obsh, array $universityList, $homeAddressPhone, $relatives, $armyRank, $armyStructure, $armyType, array $abroadList, array $workList, $govAwards, $academicRank, $academicDegree, $languages, $photo, $education, $scienceWorkAndInvents, $attachmentCount, $attachmentPages, $pdfApplication, $pdfPersonalDocument, $pdfEducation, $pdfAutoBiography, $pdfPersonalSheet, $pdfDisabledInfo, array $pdfIndividualAchievements, $commentFromAdmin, $pdfLastUploadDateTime, array $fieldsError, $willPayEntry, $willBudgetEntry, $pdfApplyForEntry, $forDissertationAttachment, $dissertationTheme, $dissertationSupervisor, $dissertationDepartment, $pdfEducationPeriodReference, $applicationsYear, $pensionCertificate, $sendBackType, $pdfPensionCertificate, $informType, array $scienceWorkList, $pdfScienceWorkList, $specialCode, $pdfConsentDataProcessing, $pensionCertificateDontHave, $wordEssay)
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
        $this->forDissertationAttachment = $forDissertationAttachment;
        $this->dissertationTheme = $dissertationTheme;
        $this->dissertationSupervisor = $dissertationSupervisor;
        $this->dissertationDepartment = $dissertationDepartment;
        $this->pdfEducationPeriodReference = $pdfEducationPeriodReference;
        $this->applicationsYear = $applicationsYear;
        $this->pensionCertificate = $pensionCertificate;
        $this->sendBackType = $sendBackType;
        $this->pdfPensionCertificate = $pdfPensionCertificate;
        $this->informType = $informType;
        $this->scienceWorkList = $scienceWorkList;
        $this->pdfScienceWorkList = $pdfScienceWorkList;
        $this->specialCode = $specialCode;
        $this->pdfConsentDataProcessing = $pdfConsentDataProcessing;
        $this->pensionCertificateDontHave = $pensionCertificateDontHave;
        $this->wordEssay = $wordEssay;
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

    /**
     * @return bool
     */
    public function isForDissertationAttachment()
    {
        return $this->forDissertationAttachment;
    }

    /**
     * @return string
     */
    public function getDissertationTheme()
    {
        return $this->dissertationTheme;
    }

    /**
     * @return string
     */
    public function getDissertationSupervisor()
    {
        return $this->dissertationSupervisor;
    }

    /**
     * @return string
     */
    public function getDissertationDepartment()
    {
        return $this->dissertationDepartment;
    }

    /**
     * @return string
     */
    public function getPdfEducationPeriodReference()
    {
        return $this->pdfEducationPeriodReference;
    }

    /**
     * @return ApplicationsYear
     */
    public function getApplicationsYear()
    {
        return $this->applicationsYear;
    }

    /**
     * @return string
     */
    public function getPensionCertificate()
    {
        return $this->pensionCertificate;
    }

    /**
     * @return int
     */
    public function getSendBackType()
    {
        return $this->sendBackType;
    }

    /**
     * @return string
     */
    public function getPdfPensionCertificate()
    {
        return $this->pdfPensionCertificate;
    }

    /**
     * @return int
     */
    public function getInformType()
    {
        return $this->informType;
    }

    /**
     * @return array
     */
    public function getScienceWorkList()
    {
        return $this->scienceWorkList;
    }

    /**
     * @return string
     */
    public function getPdfScienceWorkList()
    {
        return $this->pdfScienceWorkList;
    }

    /**
     * @return string
     */
    public function getSpecialCode()
    {
        return $this->specialCode;
    }

    /**
     * @return string
     */
    public function getPensionCertificateOrCode()
    {
        return $this->pensionCertificate != '' ? $this->pensionCertificate : $this->specialCode;
    }

    /**
     * @return string
     */
    public function getPdfConsentDataProcessing()
    {
        return $this->pdfConsentDataProcessing;
    }

    /**
     * @return bool
     */
    public function isPensionCertificateDontHave()
    {
        return $this->pensionCertificateDontHave;
    }

    /**
     * @return string
     */
    public function getWordEssay()
    {
        return $this->wordEssay;
    }

    public function cantSendDocuments()
    {
        return $this->getPdfConsentDataProcessing()=="" ||
            $this->getPdfApplication()=="" ||
            $this->getPdfPersonalSheet()=="" ||
            $this->getPdfPersonalDocument()=="" ||
            $this->getPdfAutoBiography()=="" ||
            ($this->getPensionCertificate()!=""
                && $this->getPdfPensionCertificate()==""
                && !$this->isForDissertationAttachment()
            ) ||
            ($this->getWordEssay()=="" && !$this->isForDissertationAttachment()) ||
            ($this->getPdfScienceWorkList()=="" && $this->isForDissertationAttachment());
    }

}