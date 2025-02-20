<?php

class AspCreateDocumentPageBuilder implements AspPageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build()
    {
        if(empty($_GET['user_id'])) {
            $currentUser = $this->aspModule->getCurrentUser();
        } else {
            if($this->aspModule->getAspStatusManager()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                $currentUser = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
            } else {
                echo "Ошибка доступа.";
                exit;
            }
        }
        $namePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());
        switch ($_GET['file']) {
            case 'applicationEmpty':
                $this->aspModule->getAspDocumentTemplaterManager()->setTemplater("application");
                $downloadFileName = "Заявление";
                break;
            case 'personalSheetEmpty':
                $this->aspModule->getAspDocumentTemplaterManager()->setTemplater("personalSheet");
                $downloadFileName = "Личный листок учёта кадров";
                break;
            case 'applyForEntryEmpty':
                $this->aspModule->getAspDocumentTemplaterManager()->setTemplater("applyForEntry");
                $downloadFileName = "Заявление о согласии на зачисление";
                break;
            case 'applyForEntry':
                $this->aspModule->getAspDocumentTemplaterManager()->setTemplater("applyForEntry");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                    "birthdate" => $currentUser->getBirthDate(),
                    "diplom_date" => $currentUser->getDiplomDate()
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        $dateTime = new DateTime($date);
                        $dates[$k] = $dateTime->format('d.m.Y');
                    } else {
                        $dates[$k] = "";
                    }
                }

                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getFioR(),"fio_r",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getCitizenship(),"citizenship",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($dates['birthdate'],"birthdate",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportSeries(),"passport_series",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportNumber(),"passport_number",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportPlace(),"passport_place",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($dates['passport_date'],"passport_date",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportAddress(),"passport_address",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPhone(),"phone",$namePrefix);
                $fieldOfStudy = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyById($currentUser->getFieldOfStudy());
                $fieldOfStudyProfile = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyProfileById($currentUser->getFieldOfStudyProfile());
                $this->aspModule->getAspDocumentTemplater()->addField($fieldOfStudy->getName(),"field_of_study",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($fieldOfStudyProfile->getName(),"field_of_study_profile",$namePrefix);
                if($currentUser->isWillPayEntry()) {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","will_pay_entry",$namePrefix);
                }
                if($currentUser->isWillBudgetEntry()) {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","will_budget_entry",$namePrefix);
                }
                $fio = $currentUser->getLastName();

                if($currentUser->getFirstName()!="") {
                    $fio .= " ".substr($currentUser->getFirstName(),0,1).".";
                }
                if($currentUser->getThirdName()!="") {
                    $fio .= " ".substr($currentUser->getThirdName(),0,1).".";
                }
                $this->aspModule->getAspDocumentTemplater()->addField($fio,"fio",$namePrefix);

                $downloadFileName = "Заявление о согласии на зачисление";
                break;
            case 'application':
                $this->aspModule->getAspDocumentTemplaterManager()->setTemplater("application");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                    "birthdate" => $currentUser->getBirthDate(),
                    "diplom_date" => $currentUser->getDiplomDate()
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        $dateTime = new DateTime($date);
                        $dates[$k] = $dateTime->format('d.m.Y');
                    } else {
                        $dates[$k] = "";
                    }
                }

                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getFioR(),"fio_r",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getCitizenship(),"citizenship",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($dates['birthdate'],"birthdate",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportSeries(),"passport_series",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportNumber(),"passport_number",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportPlace(),"passport_place",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($dates['passport_date'],"passport_date",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportAddress(),"passport_address",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPhone(),"phone",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getEmail(),"email",$namePrefix);
                $fieldOfStudy = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyById($currentUser->getFieldOfStudy());
                $fieldOfStudyProfile = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyProfileById($currentUser->getFieldOfStudyProfile());
                $this->aspModule->getAspDocumentTemplater()->addField($fieldOfStudy->getName(),"field_of_study",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($fieldOfStudyProfile->getName(),"field_of_study_profile",$namePrefix);
                if($currentUser->isWillPay()) {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","will_pay_1",$namePrefix);
                }
                if($currentUser->isWillBudget()) {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","will_pay_0",$namePrefix);
                }
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPrioritetFirst(),"prioritet_1",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPrioritetSecond(),"prioritet_2",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getUniversityYearEnd(),"university_year_end",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getUniversity(),"university",$namePrefix);
                if($currentUser->getDiplom()!="") {
                    $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getDiplom() . " " . $currentUser->getDiplomSeries() . " " . $currentUser->getDiplomNumber() . " " . $dates['diplom_date'], "diplom_series_number", $namePrefix);
                }
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getExam(),"exam",$namePrefix);
                if($currentUser->isExamSpecCond()) {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","exam_spec_cond_1",$namePrefix);
                } else {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","exam_spec_cond_0",$namePrefix);
                }
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getExamSpecCondDiscipline(),"exam_spec_cond_discipline",$namePrefix);
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getExamSpecCondList(),"exam_spec_cond_list",$namePrefix);
                if($currentUser->isObsh()) {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","obsh_1",$namePrefix);
                } else {
                    $this->aspModule->getAspDocumentTemplater()->addField("x","obsh_0",$namePrefix);
                }
//
//                "X документа(ов) на Y страницах"

                $awardsCount = $currentUser->getAttachmentCount();
                $awardsPages = $currentUser->getAttachmentPages();
                $awardsCountText = Dreamedit::RusEnding($awardsCount, "документ", "документа", "документов");
                $awardsPagesText = Dreamedit::RusEnding($awardsPages, "странице", "страницах", "страницах");

                if(!empty($awardsCount) && !empty($awardsPages)) {
                    $individualAwards = $awardsCount." ".$awardsCountText." на ".$awardsPages." ".$awardsPagesText;
                } else {
                    $individualAwards = "нет";
                }
                $this->aspModule->getAspDocumentTemplater()->addField($individualAwards,"individual_awards",$namePrefix);

                $downloadFileName = "Заявление";

                break;
            case "personalSheet":

                $this->aspModule->getAspDocumentTemplaterManager()->setTemplater("personalSheet");

                $dates = array(
                    "passport_date" => $currentUser->getPassportDate(),
                    "birthdate" => $currentUser->getBirthDate()
                );

                foreach ($dates as $k => $date) {
                    if(!empty($date) && $date!="0000-00-00") {
                        $dateTime = new DateTime($date);
                        $dates[$k] = $dateTime->format('d.m.Y');
                    } else {
                        $dates[$k] = "";
                    }
                }

                $photo = $currentUser->getPhoto();
                if(!empty($photo)) {
                    $this->aspModule->getAspDocumentTemplater()->addPhoto($this->aspModule->getAspDownloadService()->getPhotoUploadPath().$photo,"photo");
                }

                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getLastName(),"lastname");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getFirstName(),"firstname");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getThirdName(),"thirdname");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getGender(),"gender");
                $this->aspModule->getAspDocumentTemplater()->addField($dates['birthdate'],"birthdate");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getBirthplace(),"birthplace");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getNationality(),"nationality");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getEducation(),"education");

                $counter = 1;

                foreach ($currentUser->getUniversityList() as $university) {
                    $this->aspModule->getAspDocumentTemplater()->addField($university['university_name_place'],"university_name_place".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($university['university_faculty'],"university_faculty".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($university['university_form'],"university_form".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($university['university_year_in'],"university_year_in".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($university['university_year_out'],"university_year_out".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($university['university_level_out'],"university_level_out".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($university['university_special_number'],"university_special_number".$counter);
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
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getLanguages(),"languages");
                $this->aspModule->getAspDocumentTemplater()->addField($academicRankDegree,"academic_rank_degree");
                $this->aspModule->getAspDocumentTemplater()->addField(Dreamedit::LineBreakToComma($currentUser->getScienceWorkAndInvents()),"science_work_and_invents");

                $counter = 1;

                foreach ($currentUser->getWorkList() as $work) {
                    $this->aspModule->getAspDocumentTemplater()->addField(Dreamedit::rus_get_month_name($work['work_month_in'])." ".$work['work_year_in'],"work_in".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField(Dreamedit::rus_get_month_name($work['work_month_out'])." ".$work['work_year_out'],"work_out".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($work['work_position'],"work_position".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($work['work_place'],"work_place".$counter);
                    $counter++;
                }

                $counter = 1;

                foreach ($currentUser->getAbroadList() as $abroadTour) {
                    $this->aspModule->getAspDocumentTemplater()->addField(Dreamedit::rus_get_month_name($abroadTour['abroad_month_in'])." ".$abroadTour['abroad_year_in'],"abroad_in".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField(Dreamedit::rus_get_month_name($abroadTour['abroad_month_out'])." ".$abroadTour['abroad_year_out'],"abroad_out".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($abroadTour['abroad_country'],"abroad_country".$counter);
                    $this->aspModule->getAspDocumentTemplater()->addField($abroadTour['abroad_purpose'],"abroad_purpose".$counter);
                    $counter++;
                }

                $this->aspModule->getAspDocumentTemplater()->addField(Dreamedit::LineBreakToComma($currentUser->getGovAwards()),"gov_awards");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getArmyRank(),"army_rank");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getArmyStructure(),"army_structure");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getArmyType(),"army_type");
                $this->aspModule->getAspDocumentTemplater()->addField(Dreamedit::LineBreakToComma($currentUser->getRelatives()),"relatives");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getHomeAddressPhone(),"home_address_phone");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportSeries(),"passport_series");
                $this->aspModule->getAspDocumentTemplater()->addField($currentUser->getPassportNumber(),"passport_number");
                $this->aspModule->getAspDocumentTemplater()->addField($dates['passport_date']." ".$currentUser->getPassportPlace(),"passport_place");


                $downloadFileName = "Личный листок учёта кадров";


                break;
            default:
                echo "Ошибка доступа";
                exit;
        }
        $this->aspModule->getAspDocumentTemplater()->getDocument($downloadFileName);
    }
}