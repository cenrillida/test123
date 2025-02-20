<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class CreateDocument implements PageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        if(empty($_GET['user_id'])) {
            $currentUser = $this->aspModule->getCurrentUser();
        } else {
            if($this->aspModule->getStatusService()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                $currentUser = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
            } else {
                echo "Ошибка доступа.";
                exit;
            }
        }
        $namePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());
        switch ($_GET['file']) {
            case 'scienceWork':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("scienceWork");
                $downloadFileName = "Список научных трудов";
                break;
            case 'applicationEmpty':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("application");
                $downloadFileName = "Заявление";
                break;
            case 'applicationDissertationEmpty':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("applicationDissertation");
                $downloadFileName = "Заявление";
                break;
            case 'personalSheetEmpty':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("personalSheet");
                $downloadFileName = "Личный листок учёта кадров";
                break;
            case 'applyForEntryEmpty':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("applyForEntry");
                $downloadFileName = "Заявление о согласии на зачисление";
                break;
            case 'consentDataProcessingEmpty':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("consentDataProcessing");
                $downloadFileName = "Согласие на обработку персональных данных";
                break;
            case 'consentDataProcessing':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("consentDataProcessing");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        try {
                            $dateTime = new \DateTime($date);
                            $dates[$k] = $dateTime->format('d.m.Y');
                        } catch (\Exception $e) {
                            $dates[$k] = "";
                        }
                    } else {
                        $dates[$k] = "";
                    }
                }

                $this->aspModule->getDocumentBuilder()->addField("{$currentUser->getLastName()} {$currentUser->getFirstName()} {$currentUser->getThirdName()}","fio",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportAddress(),"passport_address",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField("{$currentUser->getPassportSeries()} {$currentUser->getPassportNumber()}, {$dates['passport_date']} {$currentUser->getPassportPlace()}","passport",$namePrefix);

                if(!$currentUser->isForDissertationAttachment()) {
                    $this->aspModule->getDocumentBuilder()->addField("V","study",$namePrefix);
                } else {
                    $this->aspModule->getDocumentBuilder()->addField("V","dissertation",$namePrefix);
                }
                $this->aspModule->getDocumentBuilder()->addField("V","exam",$namePrefix);

                $downloadFileName = "Согласие на обработку персональных данных";
                break;
            case 'applyForEntry':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("applyForEntry");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                    "birthdate" => $currentUser->getBirthDate(),
                    "diplom_date" => $currentUser->getDiplomDate()
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        try {
                            $dateTime = new \DateTime($date);
                            $dates[$k] = $dateTime->format('d.m.Y');
                        } catch (\Exception $e) {
                            $dates[$k] = "";
                        }
                    } else {
                        $dates[$k] = "";
                    }
                }

                $this->aspModule->getDocumentBuilder()->addField($currentUser->getFioR(),"fio_r",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getCitizenship(),"citizenship",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($dates['birthdate'],"birthdate",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportSeries(),"passport_series",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportNumber(),"passport_number",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($dates['passport_date'] . " " . $currentUser->getPassportPlace(),"passport_place",$namePrefix);
                //$this->aspModule->getDocumentBuilder()->addField($dates['passport_date'],"passport_date",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportAddress(),"passport_address",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPhone(),"phone",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getEmail(),"email",$namePrefix);
                $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyById($currentUser->getFieldOfStudy());
                $fieldOfStudyProfile = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyProfileById($currentUser->getFieldOfStudyProfile());
                $this->aspModule->getDocumentBuilder()->addField($fieldOfStudy->getName(),"field_of_study",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($fieldOfStudyProfile->getName(),"field_of_study_profile",$namePrefix);
                if($currentUser->isWillPayEntry()) {
                    $this->aspModule->getDocumentBuilder()->addField("x","will_pay_entry",$namePrefix);
                }
                if($currentUser->isWillBudgetEntry()) {
                    $this->aspModule->getDocumentBuilder()->addField("x","will_budget_entry",$namePrefix);
                }
                $fio = $currentUser->getLastName();

                if($currentUser->getFirstName()!="") {
                    $fio .= " ".substr($currentUser->getFirstName(),0,1).".";
                }
                if($currentUser->getThirdName()!="") {
                    $fio .= " ".substr($currentUser->getThirdName(),0,1).".";
                }
                $this->aspModule->getDocumentBuilder()->addField($fio,"fio",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField(date('Y'),"c_year",$namePrefix);

                $downloadFileName = "Заявление о согласии на зачисление";
                break;
            case 'applicationDissertation':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("applicationDissertation");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                    "birthdate" => $currentUser->getBirthDate(),
                    "diplom_date" => $currentUser->getDiplomDate()
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        try {
                            $dateTime = new \DateTime($date);
                            $dates[$k] = $dateTime->format('d.m.Y');
                        } catch (\Exception $e) {
                            $dates[$k] = "";
                        }
                    } else {
                        $dates[$k] = "";
                    }
                }
//f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f f
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getFioR(),"fio_r",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getCitizenship(),"citizenship",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($dates['birthdate'],"birthdate",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportSeries(),"passport_series",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportNumber(),"passport_number",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportPlace(),"passport_place",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($dates['passport_date'],"passport_date",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportAddress(),"passport_address",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPhone(),"phone",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getEmail(),"email",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField("x","inform_type_{$currentUser->getInformType()}",$namePrefix);

                $this->aspModule->getDocumentBuilder()->addField("x","field_of_study_profile_{$currentUser->getFieldOfStudyProfile()}",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getUniversityYearEnd(),"university_year_end",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getUniversity(),"university",$namePrefix);
                if($currentUser->getDiplom()!="") {
                    $this->aspModule->getDocumentBuilder()->addField($currentUser->getDiplom() . " " . $currentUser->getDiplomSeries() . " " . $currentUser->getDiplomNumber() . " " . $dates['diplom_date'], "diplom_series_number", $namePrefix);
                }
//
//                "X документа(ов) на Y страницах"

                $awardsCount = $currentUser->getAttachmentCount();
                $awardsPages = $currentUser->getAttachmentPages();
                $awardsCountText = \Dreamedit::RusEnding($awardsCount, "документ", "документа", "документов");
                $awardsPagesText = \Dreamedit::RusEnding($awardsPages, "странице", "страницах", "страницах");

                if(!empty($awardsCount) && !empty($awardsPages)) {
                    $individualAwards = $awardsCount." ".$awardsCountText." на ".$awardsPages." ".$awardsPagesText;
                } else {
                    $individualAwards = "нет";
                }
                $this->aspModule->getDocumentBuilder()->addField($individualAwards,"individual_awards",$namePrefix);

                $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::LineBreakToSpace($currentUser->getDissertationTheme()),"dissertation_theme",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getDissertationSupervisor(),"dissertation_supervisor",$namePrefix);

                $department = "";
                $currentDepartmentId = $currentUser->getDissertationDepartment();
                if(!empty($currentDepartmentId) && is_numeric($currentDepartmentId)) {
                    $departmentEl = $this->aspModule->getDepartmentService()->getFullPathDepartment($currentDepartmentId);
                    if(!empty($departmentEl)) {
                        $department = $departmentEl->getTitle();
                    }
                }

                $this->aspModule->getDocumentBuilder()->addField($department,"dissertation_department",$namePrefix);

                $downloadFileName = "Заявление";

                break;
            case 'application':
                $this->aspModule->getDocumentBuilderManager()->setBuilder("application");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                    "birthdate" => $currentUser->getBirthDate(),
                    "diplom_date" => $currentUser->getDiplomDate()
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        try {
                            $dateTime = new \DateTime($date);
                            $dates[$k] = $dateTime->format('d.m.Y');
                        } catch (\Exception $e) {
                            $dates[$k] = "";
                        }
                    } else {
                        $dates[$k] = "";
                    }
                }

                $this->aspModule->getDocumentBuilder()->addField($currentUser->getFioR(),"fio_r",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getCitizenship(),"citizenship",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($dates['birthdate'],"birthdate",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportSeries(),"passport_series",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportNumber(),"passport_number",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($dates['passport_date'] . " " . $currentUser->getPassportPlace(),"passport_place",$namePrefix);
                //$this->aspModule->getDocumentBuilder()->addField($dates['passport_date'],"passport_date",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportAddress(),"passport_address",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPhone(),"phone",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getEmail(),"email",$namePrefix);
                $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyById($currentUser->getFieldOfStudy());
                $fieldOfStudyProfile = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyProfileById($currentUser->getFieldOfStudyProfile());
                //$this->aspModule->getDocumentBuilder()->addField($fieldOfStudy->getName(),"field_of_study",$namePrefix);
                //$this->aspModule->getDocumentBuilder()->addField($fieldOfStudyProfile->getName(),"field_of_study_profile",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField('x',"field_of_study_profile_id_".$fieldOfStudyProfile->getId(),$namePrefix);

                if($currentUser->isWillPay()) {
                    $this->aspModule->getDocumentBuilder()->addField("x","will_pay_1",$namePrefix);
                }
                if($currentUser->isWillBudget()) {
                    $this->aspModule->getDocumentBuilder()->addField("x","will_pay_0",$namePrefix);
                }
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPrioritetFirst(),"prioritet_1",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPrioritetSecond(),"prioritet_2",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getUniversityYearEnd(),"university_year_end",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getUniversity(),"university",$namePrefix);
                if($currentUser->getDiplom()!="") {
                    $this->aspModule->getDocumentBuilder()->addField($currentUser->getDiplom() . " " . $currentUser->getDiplomSeries() . " " . $currentUser->getDiplomNumber() . " " . $dates['diplom_date'], "diplom_series_number", $namePrefix);
                }
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPensionCertificate(),"pension_certificate",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField("x","send_back_type_{$currentUser->getSendBackType()}",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getExam(),"exam",$namePrefix);
                if($currentUser->isExamSpecCond()) {
                    $this->aspModule->getDocumentBuilder()->addField("x","exam_spec_cond_1",$namePrefix);
                } else {
                    $this->aspModule->getDocumentBuilder()->addField("x","exam_spec_cond_0",$namePrefix);
                }
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getExamSpecCondDiscipline(),"exam_spec_cond_discipline",$namePrefix);
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getExamSpecCondList(),"exam_spec_cond_list",$namePrefix);
                if($currentUser->isObsh()) {
                    $this->aspModule->getDocumentBuilder()->addField("x","obsh_1",$namePrefix);
                } else {
                    $this->aspModule->getDocumentBuilder()->addField("x","obsh_0",$namePrefix);
                }
//
//                "X документа(ов) на Y страницах"

                $awardsCount = $currentUser->getAttachmentCount();
                $awardsPages = $currentUser->getAttachmentPages();
                $awardsCountText = \Dreamedit::RusEnding($awardsCount, "документ", "документа", "документов");
                $awardsPagesText = \Dreamedit::RusEnding($awardsPages, "странице", "страницах", "страницах");

                if(!empty($awardsCount) && !empty($awardsPages)) {
                    $individualAwards = $awardsCount." ".$awardsCountText." на ".$awardsPages." ".$awardsPagesText;
                } else {
                    $individualAwards = "нет";
                }
                $this->aspModule->getDocumentBuilder()->addField($individualAwards,"individual_awards",$namePrefix);

                $downloadFileName = "Заявление";

                break;
            case "personalSheet":

                $this->aspModule->getDocumentBuilderManager()->setBuilder("personalSheet");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                    "birthdate" => $currentUser->getBirthDate()
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        try {
                            $dateTime = new \DateTime($date);
                            $dates[$k] = $dateTime->format('d.m.Y');
                        } catch (\Exception $e) {
                            $dates[$k] = "";
                        }
                    } else {
                        $dates[$k] = "";
                    }
                }

                $photo = $currentUser->getPhoto();
                if(!empty($photo)) {
                    $this->aspModule->getDocumentBuilder()->addPhoto($this->aspModule->getDownloadService()->getPhotoUploadPath().$photo,"photo");
                }

                $this->aspModule->getDocumentBuilder()->addField($currentUser->getLastName(),"lastname");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getFirstName(),"firstname");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getThirdName(),"thirdname");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getGender(),"gender");
                $this->aspModule->getDocumentBuilder()->addField($dates['birthdate'],"birthdate");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getBirthplace(),"birthplace");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getNationality(),"nationality");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getEducation(),"education");

                $counter = 1;

                foreach ($currentUser->getUniversityList() as $university) {
                    $this->aspModule->getDocumentBuilder()->addField($university['university_name_place'],"university_name_place".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($university['university_faculty'],"university_faculty".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($university['university_form'],"university_form".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($university['university_year_in'],"university_year_in".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($university['university_year_out'],"university_year_out".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($university['university_level_out'],"university_level_out".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($university['university_special_number'],"university_special_number".$counter);
                    $counter++;
                }

                $academicDegree = $currentUser->getAcademicDegree();
                $academicRank = $currentUser->getAcademicRank();
                $academicRankDegree = "";
                if(!empty($academicDegree)) {
                    if(!empty($academicRank)) {
                        $academicRankDegree = $academicDegree.", ".$academicRank;
                        if($academicRank=="не имею" && $academicDegree=="не имею") {
                            $academicRankDegree = "не имею";
                        }
                    } else {
                        $academicRankDegree = $academicDegree;
                    }
                } else {
                    if(!empty($academicRank)) {
                        $academicRankDegree = $academicRank;
                    }
                }
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getLanguages(),"languages");
                $this->aspModule->getDocumentBuilder()->addField($academicRankDegree,"academic_rank_degree");
                $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::LineBreakToComma($currentUser->getScienceWorkAndInvents()),"science_work_and_invents");

                $counter = 1;

                foreach ($currentUser->getWorkList() as $work) {
                    $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::rus_get_month_name($work['work_month_in'])." ".$work['work_year_in'],"work_in".$counter);
                    if($work['work_out']) {
                        $this->aspModule->getDocumentBuilder()->addField("По настоящее время","work_out".$counter);
                    } else {
                        $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::rus_get_month_name($work['work_month_out'])." ".$work['work_year_out'],"work_out".$counter);
                    }
                    $this->aspModule->getDocumentBuilder()->addField($work['work_position'],"work_position".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($work['work_place'],"work_place".$counter);
                    $counter++;
                }

                $counter = 1;

                foreach ($currentUser->getAbroadList() as $abroadTour) {
                    $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::rus_get_month_name($abroadTour['abroad_month_in'])." ".$abroadTour['abroad_year_in'],"abroad_in".$counter);
                    $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::rus_get_month_name($abroadTour['abroad_month_out'])." ".$abroadTour['abroad_year_out'],"abroad_out".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($abroadTour['abroad_country'],"abroad_country".$counter);
                    $this->aspModule->getDocumentBuilder()->addField($abroadTour['abroad_purpose'],"abroad_purpose".$counter);
                    $counter++;
                }

                $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::LineBreakToComma($currentUser->getGovAwards()),"gov_awards");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getArmyRank(),"army_rank");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getArmyStructure(),"army_structure");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getArmyType(),"army_type");
                $this->aspModule->getDocumentBuilder()->addField(\Dreamedit::LineBreakToComma($currentUser->getRelatives()),"relatives");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getHomeAddressPhone(),"home_address_phone");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportSeries(),"passport_series");
                $this->aspModule->getDocumentBuilder()->addField($currentUser->getPassportNumber(),"passport_number");
                $this->aspModule->getDocumentBuilder()->addField($dates['passport_date']." ".$currentUser->getPassportPlace(),"passport_place");


                $downloadFileName = "Личный листок учёта кадров";


                break;
            default:
                echo "Ошибка доступа";
                exit;
        }
        $this->aspModule->getDocumentBuilder()->getDocument($downloadFileName);
    }
}