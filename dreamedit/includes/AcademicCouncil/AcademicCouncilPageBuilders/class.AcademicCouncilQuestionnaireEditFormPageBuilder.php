<?php

class AcademicCouncilQuestionnaireEditFormPageBuilder implements AcademicCouncilPageBuilder {
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build()
    {
        global $DB,$_CONFIG,$site_templater;

        if($this->academicCouncilModule->getAcademicCouncilAuthorizationService()->isAuthorized()) {

            $questionnaire = $this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->getQuestionnaireById($_GET['id']);
            if(!empty($questionnaire)) {
                if ($_SESSION[lang] != "/en") {
                    $formBuilder = new AcademicCouncilQuestionnaireEditFormBuilder("����� ��������������.", "", "", "��������");

                    $formBuilder->registerField(new FormField("name", "text", true, "�������� ������", "�� ������� �������� ������", "", false, "", $questionnaire->getName()));
                    $dStart = substr($questionnaire->getDtStart(),0,10);
                    $tStart = substr($questionnaire->getDtStart(),11,5);
                    $dEnd = substr($questionnaire->getDtEnd(),0,10);
                    $tEnd = substr($questionnaire->getDtEnd(),11,5);
                    $formBuilder->registerField(new FormField("d_start", "date", false, "���� ������ ������", "", "", false, "",$dStart));
                    $formBuilder->registerField(new FormField("t_start", "time", false, "����� ������ ������ (������ 00:00)", "", "", false, "",$tStart));
                    $formBuilder->registerField(new FormField("d_end", "date", false, "���� ��������� ������", "", "", false, "",$dEnd));
                    $formBuilder->registerField(new FormField("t_end", "time", false, "����� ��������� ������ (������ 00:00)", "","", false, "",$tEnd));
                    $formBuilder->registerField(new FormField("order_date", "date", false, "���� �������", "", "", false, "",$questionnaire->getOrderDate()));
                    $formBuilder->registerField(new FormField("order_number", "text", false, "����� �������", "", "", false, "",$questionnaire->getOrderNumber()));
                    $formBuilder->registerField(new FormField("questionnaire_date", "date", false, "���� ���������", "", "", false, "",$questionnaire->getQuestionnaireDate()));
                    $formBuilder->registerField(new FormField("questionnaire_question", "text", false, "�� �������", "", "", false, "",$questionnaire->getQuestionnaireQuestion()));
                    $posError = $formBuilder->processPostBuild();

                }
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            $exitPageId = $this->pages->getFirstPageIdByTemplate("ac_lk_login");
            ?>
            <div class="container-fluid">
                <div class="row justify-content-between mb-3">
                    <div>
                        <?php if(!empty($_GET['mode'])):?>
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                                   role="button">��������� � ������ �������</a>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="row justify-content-end">
                        <div class="mt-3 pl-2 pr-2">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                               role="button">�����</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php

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