<?php

class AspDocumentApplicationPageBuilder implements AspPageBuilder {
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
        global $DB,$_CONFIG,$site_templater;

        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($admin->getStatus());
        if($status->isDocumentApplicationAllow() || $status->isEditDocumentApplicationAllow() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {

                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AspAdminEditFormBuilder("������ ������� ��������.","",__DIR__ . "/Documents/","��������");
                } else {
                    $currentUser = $admin;
                    $formBuilder = new AspDocumentApplicationFormBuilder("�� ������� ��������� ������.","","/files/File/graduate_school/","���������");
                }

                $fieldOfStudyProfiles = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyProfileListByFieldOfStudyId($currentUser->getFieldOfStudy());
                $fieldOfStudyProfileSelectArr = array();
                foreach ($fieldOfStudyProfiles as $fieldOfStudyProfile) {
                    $fieldOfStudyProfileSelectArr[] = new OptionField($fieldOfStudyProfile->getId(),$fieldOfStudyProfile->getName());
                }
                $yearSelectArr = array();
                $currentYear = date("Y");
                for ($i=$currentYear; $i>=1900; $i--) {
                    $yearSelectArr[] = new OptionField($i,$i);
                }
                $levelOutSelectArr = array();
                $levelOutSelectArr[] = new OptionField("","", true);
                for ($i=1; $i<=7; $i++) {
                    $levelOutSelectArr[] = new OptionField($i,$i);
                }

                $monthSelectArr = array();
                for ($i=1; $i<=12; $i++) {
                    $monthSelectArr[] = new OptionField($i,$i);
                }

//                $values = array();
//
//                $values['field_of_study_profile'] = $currentUser->getFieldOfStudyProfile();
//                $values['prioritet_1'] = $currentUser->getPrioritetFirst();
//                $values['prioritet_2'] = $currentUser->getPrioritetSecond();


                $willPayRadioArr = array();
                $willPayRadioArr[] = new RadioField(0,"�� ���� ��������� ������������ ������������ �������","will_pay_0",!$currentUser->isWillPay());
                $willPayRadioArr[] = new RadioField(1,"�� �������� �� �������� ������� ��������������� �����","will_pay_1",$currentUser->isWillPay());
                $willPayPrioritet = array();
                $willPayPrioritet[] = new OptionField("","");
                $willPayPrioritet[] = new OptionField("�� ���� ��������� ������������ ������������ �������","�� ���� ��������� ������������ ������������ �������");
                $willPayPrioritet[] = new OptionField("�� �������� �� �������� ������� ��������������� �����","�� �������� �� �������� ������� ��������������� �����");
                $diplomSelectArr = array();
                $diplomSelectArr[] = new OptionField("","");
                $diplomSelectArr[] = new OptionField("��������","��������");
                $diplomSelectArr[] = new OptionField("�����������","�����������");
                $examSelectArr = array();
                $examSelectArr[] = new OptionField("����������","���������� ����");
                $examSelectArr[] = new OptionField("���������","��������� ����");
                $examSelectArr[] = new OptionField("��������","�������� ����");
                $examSelectArr[] = new OptionField("�����������","����������� ����");
                $examSpecCondRadioArr = array();
                $examSpecCondRadioArr[] = new RadioField(0,"�� ��������","exam_spec_cond_0",!$currentUser->isExamSpecCond());
                $examSpecCondRadioArr[] = new RadioField(1,"��������","exam_spec_cond_1",$currentUser->isExamSpecCond());
                $examSpecCondDisciplineSelectArr = array();
                $examSpecCondDisciplineSelectArr[] = new OptionField("","");
                $examSpecCondDisciplineSelectArr[] = new OptionField("����������� ����������","����������� ����������");
                $examSpecCondDisciplineSelectArr[] = new OptionField("��������� � �������� ���������� �����","��������� � �������� ���������� �����");
                $examSpecCondDisciplineSelectArr[] = new OptionField("����������� ����","����������� ����");
                $obshRadioArr = array();
                $obshRadioArr[] = new RadioField(0,"�� ��������","obsh_0",!$currentUser->isObsh());
                $obshRadioArr[] = new RadioField(1,"��������","obsh_1",$currentUser->isObsh());
                $academicDegreeSelectArr = array();
                $academicDegreeSelectArr[] = new OptionField("�� ����","�� ����");
                $academicDegreeSelectArr[] = new OptionField("�������� ����","�������� ����");
                $academicDegreeSelectArr[] = new OptionField("������ ����","������ ����");
                $academicRankSelectArr = array();
                $academicRankSelectArr[] = new OptionField("�� ����","�� ����");
                $academicRankSelectArr[] = new OptionField("������","������");
                $academicRankSelectArr[] = new OptionField("���������","���������");
                $academicRankSelectArr[] = new OptionField("����-������������� (����-����.) �������� ����","����-������������� (����-����.) �������� ����");
                $academicRankSelectArr[] = new OptionField("�������������� ���� (��������) �������� ����","�������������� ���� (��������) �������� ����");



                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $willPay = "0";
                $willBudget = "0";

                if($currentUser->isWillPay()) {
                    $willPay = "1";
                }
                if($currentUser->isWillBudget()) {
                    $willBudget = "1";
                }

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "���������"));
                $fieldOfStudyProfileSelectArr = $formBuilder->setSelectedOptionArr($fieldOfStudyProfileSelectArr,$currentUser->getFieldOfStudyProfile());
                $formBuilder->registerField(new FormField("field_of_study_profile", "select", true, "�������(��������������)", "�� ������ �������","",false,"","",$fieldOfStudyProfileSelectArr));
                $formBuilder->registerField(new FormField("", "header-text", false, "������� �����������"));
                $formBuilder->registerField(new FormField("will_budget", "checkbox", false, "�� ���� ��������� ������������ ������������ �������", "","",false,"",$willBudget,array(),array()));
                $formBuilder->registerField(new FormField("will_pay", "checkbox", false, "�� �������� �� �������� ������� ��������������� �����", "","",false,"",$willPay,array(),array()));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "��������� �� ���������� ��������"));
                $willPayPrioritetFirst = $formBuilder->setSelectedOptionArr($willPayPrioritet,$currentUser->getPrioritetFirst());
                $formBuilder->registerField(new FormField("prioritet_1", "select", false, "� ������ ����������� �� ��������� �������� ����������� ����� ������������� ��������� �������� � ��������� �������������� ����������:<br> 1", "","",false,"","",$willPayPrioritetFirst));
                $willPayPrioritetSecond = $formBuilder->setSelectedOptionArr($willPayPrioritet,$currentUser->getPrioritetSecond());
                $formBuilder->registerField(new FormField("prioritet_2", "select", false, "2", "","",false,"","",$willPayPrioritetSecond));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "�����������"));
                $formBuilder->registerField(new FormField("education", "text", true, "�����������","�� ������� �����������","������",false,"",$currentUser->getEducation()));
                $formBuilder->registerField(new FormField("university", "text", true, "������������ ������� �������� ���������(� ������� �����)","�� ������ ���","����� ���",false,"",$currentUser->getUniversity()));
                $universityEndYear = $formBuilder->setSelectedOptionArr($yearSelectArr,$currentUser->getUniversityYearEnd());
                $formBuilder->registerField(new FormField("university_year_end", "select", true, "��� ���������","�� ������ ��� ���������","2000", false,"","",$universityEndYear));
                $diplom = $formBuilder->setSelectedOptionArr($diplomSelectArr,$currentUser->getDiplom());
                $formBuilder->registerField(new FormField("diplom", "select", false, "������ (����������� ��� ������� �� ������ ������ ����������)", "�� ������ ��� �������","",false,"","",$diplom));
                $formBuilder->registerField(new FormField("", "form-row", false, ""));
                $formBuilder->registerField(new FormField("diplom_series", "text", false, "����� �������","�� ������� ����� �������","123456", false,"",$currentUser->getDiplomSeries(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("diplom_number", "text", false, "����� �������","�� ������ ����� �������","1234567", false,"",$currentUser->getDiplomNumber(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("diplom_date", "date", false, "���� ������ �������","�� ������� ���� ������ �������","", false,"",$currentUser->getDiplomDate(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("", "form-row-end", false, ""));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "������ ���� ������� ��������� (� ��� ����� � ����������� ������)"));

                $studyFormSelectArr = array();
                $studyFormSelectArr[] = new OptionField("�����","�����");
                $studyFormSelectArr[] = new OptionField("����-�������","����-�������");
                $studyFormSelectArr[] = new OptionField("�������","�������");

                $universityComplexFields = array();
                $universityComplexFields[] = new FormField("", "form-row", false, "");
                $universityComplexFields[] = new FormField("university_name_place", "text", false, "�������� �������� ��������� � ��� ���������������","","����� ���", false,"","",array(),array(),"col-lg-8");
                $universityComplexFields[] = new FormField("university_faculty", "text", false, "��������� ��� ���������","","���������", false,"","",array(),array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_form", "select", false, "����� �������� ","","", false,"","",$studyFormSelectArr,array(),"col-lg-12");
                $universityComplexFields[] = new FormField("university_year_in", "select", false, "��� �����������","","2000", false,"","",$yearSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_year_out", "select", false, "��� ��������� ��� �����","","2000", false,"","",$yearSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_level_out", "select", false, "���� �� �������, �� � ������ ����� ����","","", false,"","",$levelOutSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_special_number", "text", false, "����� ������������� ������� � ���������� ��������� �������� ���������, ������� � ������� ��� �������������","","���������, 123456", false,"","",array(),array(),"col-lg-6");
                $universityComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("university_list", "complex-block", false, "�������� ������� ���������","","", false,"",$currentUser->getUniversityList(),array(),array(),"", $universityComplexFields));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "������ � ����������"));
                $formBuilder->registerField(new FormField("languages", "text", false, "������ ������������ ������� ��������","","���������� ����: ������ ��������, �������� ����: ����� � �������� �� ��������",false,"",$currentUser->getLanguages()));
                $academicDegree = $formBuilder->setSelectedOptionArr($academicDegreeSelectArr,$currentUser->getAcademicDegree());
                $formBuilder->registerField(new FormField("academic_degree", "select", false, "������ �������","","�������� ����, ������", false,"","",$academicDegree));
                $academicRank = $formBuilder->setSelectedOptionArr($academicRankSelectArr,$currentUser->getAcademicRank());
                $formBuilder->registerField(new FormField("academic_rank", "select", false, "������ ������","","�������� ����, ������", false,"","",$academicRank));
                $formBuilder->registerField(new FormField("gov_awards", "textarea", false, "����� ������ ����������������� ������� (����� � ��� ����������)","","", false,"",$currentUser->getGovAwards(),array(),array(),"", array(),10));
                $formBuilder->registerField(new FormField("science_work_and_invents", "textarea", false, "����� ������ ������� ����� � ����������� (����� ���������� ������� ������ � ��������� �� ������ ������ � �.�.)","","2 ������� ������ ����� ������� 1,8 �.�.", false,"",$currentUser->getScienceWorkAndInvents(),array(),array(),"", array(),5));
                $formBuilder->registerField(new FormField("attachment_count", "text", false, "���������� ����������� ������ �� ���������� �� �������������� �����������","","4",false,"",$currentUser->getAttachmentCount()));
                $formBuilder->registerField(new FormField("attachment_pages", "text", false, "����� ���� ������� � ����������� ������ �� ���������� �� �������������� �����������","","25",false,"",$currentUser->getAttachmentPages()));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "����������� ������ � ������ �������� ������������ (������� ����� � ������ � ������� ����������� ������� ����������, ������� ������, ������� � ������������ ������� � ������ �� ����������������)"));
                $formBuilder->registerField(new FormField("", "header-text", false, "��� ���������� ������� ������ ����������, ����������� � ����������� ���������� ��������� ���, ��� ��� ���������� � ���� �����, ������� ������ ���������� � ��������� ���������."));

                $workComplexFields = array();
                $workComplexFields[] = new FormField("", "form-row", false, "");
                $workComplexFields[] = new FormField("work_month_in", "select", false, "����� ����������","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_year_in", "select", false, "��� ����������","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_month_out", "select", false, "����� �����","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_year_out", "select", false, "��� �����","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_position", "text", false, "��������� � ��������� ����������, �����������, �����������, � ����� ������������ (���������)","","���������", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new FormField("work_place", "text", false, "��������������� ����������, �����������, �����������","","�. ������", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("work_list", "complex-block", false, "�������� ������","","", false,"",$currentUser->getWorkList(),array(),array(),"", $workComplexFields));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "���������� �� ��������"));

                $abroadPurposeSelectArr = array();
                $abroadPurposeSelectArr[] = new OptionField("������","������");
                $abroadPurposeSelectArr[] = new OptionField("��������� ������������","��������� ������������");
                $abroadPurposeSelectArr[] = new OptionField("������","������");

                $abroadComplexFields = array();
                $abroadComplexFields[] = new FormField("", "form-row", false, "");
                $abroadComplexFields[] = new FormField("abroad_month_in", "select", false, "����� ������ �������","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_year_in", "select", false, "��� ������ �������","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_month_out", "select", false, "����� ����� �������","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_year_out", "select", false, "��� ����� �������","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_country", "text", false, "� ����� ������","","��������", false,"","",array(),array(),"col-lg-12");
                $abroadComplexFields[] = new FormField("abroad_purpose", "select", false, "���� ���������� �� ��������","","", false,"","",$abroadPurposeSelectArr,array(),"col-lg-12");
                $abroadComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("abroad_list", "complex-block", false, "�������� �������","","", false,"",$currentUser->getAbroadList(),array(),array(),"", $abroadComplexFields));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "�������� �����������"));
                $formBuilder->registerField(new FormField("army_rank", "text", false, "��������� � �������� ����������� � �������� ������","","",false,"",$currentUser->getArmyRank()));
                $formBuilder->registerField(new FormField("army_structure", "text", false, "������","","",false,"",$currentUser->getArmyStructure()));
                $formBuilder->registerField(new FormField("army_type", "text", false, "��� �����","","", false,"",$currentUser->getArmyType()));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "������������� ���������"));
                $formBuilder->registerField(new FormField("exam", "select", true, "����� �������������� ���������", "�� ������� ������������� ���������","",false,"","",$examSelectArr));
                $formBuilder->registerField(new FormField("exam_spec_cond", "radio", false, "� �������� ����������� ������� ��� ���������� ������������� ��������� � ����� � ������������� ������������� � �������������","","",false,"","",array(),$examSpecCondRadioArr));
                $specCondDiscipline = $formBuilder->setSelectedOptionArr($examSpecCondDisciplineSelectArr,$currentUser->getExamSpecCondDiscipline());
                $formBuilder->registerField(new FormField("exam_spec_cond_discipline", "select", false, "������������ ���������� ��� ����������� �������","", "","",false,"",$specCondDiscipline));
                $formBuilder->registerField(new FormField("exam_spec_cond_list", "text", false, "�������� ����������� �������","","",false,"",$currentUser->getExamSpecCondList()));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "���������"));
                $formBuilder->registerField(new FormField("obsh", "radio", false, "� ��������� �� ������ ��������","","",false,"","",array(),$obshRadioArr));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "�������� ��������� � �����"));
                $formBuilder->registerField(new FormField("relatives", "textarea", true, "�������� ��������� � ������ ���������� ������� ������ (����������� ������ ����� � ��������� ���� ��������)","�� ��������� �������� ���������","", false,"",$currentUser->getRelatives(),array(),array(),"", array(),5));
                $formBuilder->registerField(new FormField("home_address_phone", "text", true, "�������� ����� � �������� �������","�� �������� �������� �����","�. ������, ��. �����������, ��� 23, �������� 2, +74950000000", false,"",$currentUser->getHomeAddressPhone()));

                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        $exitPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_login");
        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-1">
                <div class="text-danger">��������! ��������� ��������� ��������� ������ ����� ������� �� ������ "������ ���������".</div>
            </div>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode'])):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                               role="button">��������� � ������ �������</a>
                        </div>
                    <?php endif;?>
                    <?php if(!empty($currentUser) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$currentUser->getId()?>"
                               role="button">��������� � ������ ������������</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">���������� �� ������ � ������ ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                           role="button">����������� ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">�����</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!$status->isDocumentApplicationAllow() && !$status->isEditDocumentApplicationAllow() && !$status->isAdminAllow()) {
            echo "������ �������.";
        } else {
            if (!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $posError ?>
                </div>
                <?php
            }
            $formBuilder->build();
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}