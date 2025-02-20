<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireCreateFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireEditFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireMailerFormBuilder;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class QuestionnaireMailer implements PageBuilder {
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        if($this->academicCouncilModule->getAuthorizationService()->isAuthorized()) {

            $questionnaire = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireById($_GET['id']);
            $questionnairePageId = $this->pages->getFirstPageIdByTemplate("ac_questionnaire");

            $closed = false;
//            if($questionnaire->isSecret()) {
//                $secretCodes = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireSecretMembersListById($questionnaire->getId());
//
//                if(!empty($secretCodes)) {
//                    $closed = true;
//                }
//            }

            if(!empty($questionnaire) && !$closed) {
                if ($_SESSION[lang] != "/en") {
                    $formBuilder = new QuestionnaireMailerFormBuilder("������ ����������.", "", "", "���������", false);

                    foreach ($questionnaire->getMembers() as $member) {
                        $formBuilder->registerField(new \FormField("", "header", false, $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName()));
                        if(!$questionnaire->isSecret()) {
                            $formBuilder->registerField(new \FormField("", "header-text", false, "<a target=\"_blank\" href=\"https://www.imemo.ru/index.php?page_id=".$questionnairePageId."&code=".$member->getCode()."&questionnaire_id=".$questionnaire->getId()."\">������ ������</a>"));
                        }
                        $formBuilder->registerField(new \FormField("", "form-row", false, ""));
                        $fioField = new \FormField("fio-".$member->getUserId(), "text", true, "���", "�� ������� ���", "", false, "", $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName(),array(),array(),"col-lg-6");
                        $fioField->setReadOnly(true);
                        $formBuilder->registerField($fioField);
                        $formBuilder->registerField(new \FormField("mail-".$member->getUserId(), "text", true, "E-mail", "�� ������� �����", "", false, "�������� �����", $member->getEmail(),array(),array(),"col-lg-6"));
                        $formBuilder->registerField(new \FormField("", "form-row-end", false, ""));
                    }

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("mail_subject", "text", true, "���� ���������", "�� ������� ���� ���������",""));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "{FIO} � {LINK} - ��� ������������. �� �� ������ ������������� ���������� ������ ��� � ������."));
                    $formBuilder->registerField(new \FormField("mail_text", "textarea", true, "����� ���������", "","", false, "","������������, {FIO}!\n\n������ ��� ����������� ������: {LINK}\n\n� ���������,\n����� ���",array(),array(),"",array(),10));
                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "���������� �����"));

                    $attachmentsComplexFields = array();
                    $attachmentsFile = new \FileField(array(),__DIR__."/../../Documents/Uploads/",array(),10240 * 1024,"","");
                    $attachmentsComplexFields[] = new \FormField("attachment", "file", false, "���������� ���� (�� ����� 10�����)","","������� ����", false,"","",array(),array(),"",array(),2,$attachmentsFile);

                    $formBuilder->registerField(new \FormField("attachments", "complex-block", false, "�������� ����","","", false,"","",array(),array(),"", $attachmentsComplexFields));



                    $posError = $formBuilder->processPostBuild();

                }
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("top");
            $this->academicCouncilModule->getPageBuilder()->build(array("main_back" => true));

            if (!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $posError ?>
                </div>
                <?php
            }
            if(!empty($questionnaire)) {
                if($closed) {
                    echo "<p>�� ��� ���������� ���� ��� �����������. ��-�� ����� ����������� ���������� �������� ��������� ����, ��� ��� ����������, ���� ��������� ��� ���� ����������.</p>";
                    echo "<p>������ ���������������� �����:</p>";

//                    foreach ($secretCodes as $secretCode) {
//                        if($secretCode->getMeetingParticipation()=="" && $secretCode->getVoteResult()=="") {
//                            echo "<div><a target=\"_blank\" href=\"https://www.imemo.ru/index.php?page_id=".$questionnairePageId."&code=".$secretCode->getCode()."&questionnaire_id=".$questionnaire->getId()."\">{$secretCode->getCode()}</a></div>";
//                        }
//                    }
                } else {
                    $formBuilder->build();
                }

            } else {
                echo "������ �������";
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            echo "������ �������";
        }
    }

}