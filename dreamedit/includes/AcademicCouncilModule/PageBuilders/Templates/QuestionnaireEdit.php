<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireCreateFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireEditFormBuilder;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class QuestionnaireEdit implements PageBuilder {
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
            if(!empty($questionnaire)) {
                if ($_SESSION['lang'] != "/en") {
                    $formBuilder = new QuestionnaireEditFormBuilder("����� ��������������.", "", "", "��������", false);

                    $formBuilder->registerField(new \FormField("name", "text", true, "�������� ������", "�� ������� �������� ������", "", false, "", $questionnaire->getName()));
                    $dStart = substr($questionnaire->getDtStart(),0,10);
                    $tStart = substr($questionnaire->getDtStart(),11,5);
                    $dEnd = substr($questionnaire->getDtEnd(),0,10);
                    $tEnd = substr($questionnaire->getDtEnd(),11,5);
                    $formBuilder->registerField(new \FormField("d_start", "date", false, "���� ������ ������", "", "", false, "",$dStart));
                    $formBuilder->registerField(new \FormField("t_start", "time", false, "����� ������ ������ (������ 00:00)", "", "", false, "",$tStart));
                    $formBuilder->registerField(new \FormField("d_end", "date", false, "���� ��������� ������", "", "", false, "",$dEnd));
                    $formBuilder->registerField(new \FormField("t_end", "time", false, "����� ��������� ������ (������ 00:00)", "","", false, "",$tEnd));
                    $formBuilder->registerField(new \FormField("order_date", "date", false, "���� �������", "", "", false, "",$questionnaire->getOrderDate()));
                    $formBuilder->registerField(new \FormField("order_number", "text", false, "����� �������", "", "", false, "",$questionnaire->getOrderNumber()));
                    $formBuilder->registerField(new \FormField("questionnaire_date", "date", false, "���� ���������", "", "", false, "",$questionnaire->getQuestionnaireDate()));
                    $formBuilder->registerField(new \FormField("questionnaire_question", "text", false, "�� �������", "", "", false, "",$questionnaire->getQuestionnaireQuestion()));
                    $formBuilder->registerField(new \FormField("protocol_number", "text", false, "����� ���������", "", "", false, "",$questionnaire->getProtocolNumber()));
                    $formBuilder->registerField(new \FormField("questionnaire_fio", "text", false, "�������� (�.�.�.)", "", "", false, "",$questionnaire->getQuestionnaireFio()));
                    $formBuilder->registerField(new \FormField("questionnaire_position", "text", false, "�������� (����������� � �������� � ������ ������� ������)", "", "", false, "",$questionnaire->getQuestionnairePosition()));
                    $formBuilder->registerField(new \FormField("questionnaire_members_count", "text", false, "���������� ������ ������� ������ �� ������ ������ (������ �������������� ����������� ������)", "", "",false, "",$questionnaire->getQuestionnaireMembersCount()));


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
                $formBuilder->build();
            } else {
                echo "������ �������";
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            echo "������ �������";
        }
    }

}