<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireCreateFormBuilder;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class QuestionnaireCreate implements PageBuilder {
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
            if ($_SESSION[lang] != "/en") {
                $formBuilder = new QuestionnaireCreateFormBuilder("����� ������.", "", "", "�������", false);

                $formBuilder->registerField(new \FormField("name", "text", true, "�������� ������", "�� ������� �������� ������"));
                $formBuilder->registerField(new \FormField("d_start", "date", false, "���� ������ ������", ""));
                $formBuilder->registerField(new \FormField("t_start", "time", false, "����� ������ ������ (������ 00:00)", ""));
                $formBuilder->registerField(new \FormField("d_end", "date", false, "���� ��������� ������", ""));
                $formBuilder->registerField(new \FormField("t_end", "time", false, "����� ��������� ������ (������ 00:00)", ""));
                $formBuilder->registerField(new \FormField("order_date", "date", false, "���� �������", ""));
                $formBuilder->registerField(new \FormField("order_number", "text", false, "����� �������", ""));
                $formBuilder->registerField(new \FormField("questionnaire_date", "date", false, "���� ���������", ""));
                $formBuilder->registerField(new \FormField("questionnaire_question", "text", false, "�� �������", ""));
                $formBuilder->registerField(new \FormField("secret", "checkbox", false, "������ �����������", "", "", false, "", "0", array(), array()));
                $formBuilder->registerField(new \FormField("protocol_number", "text", false, "����� ���������", ""));
                $formBuilder->registerField(new \FormField("questionnaire_fio", "text", false, "�������� (�.�.�.)", ""));
                $formBuilder->registerField(new \FormField("questionnaire_position", "text", false, "�������� (����������� � �������� � ������ ������� ������)", ""));
                $formBuilder->registerField(new \FormField("questionnaire_members_count", "text", false, "���������� ������ ������� ������ �� ������ ������ (������ �������������� ����������� ������)", ""));

                $posError = $formBuilder->processPostBuild();

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

            $formBuilder->build();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            echo "������ �������";
        }
    }

}