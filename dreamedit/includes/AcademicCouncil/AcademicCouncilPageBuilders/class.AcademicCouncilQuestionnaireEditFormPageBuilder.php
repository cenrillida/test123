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
                    $formBuilder = new AcademicCouncilQuestionnaireEditFormBuilder("Опрос отредактирован.", "", "", "Изменить");

                    $formBuilder->registerField(new FormField("name", "text", true, "Название опроса", "Не введено название опроса", "", false, "", $questionnaire->getName()));
                    $dStart = substr($questionnaire->getDtStart(),0,10);
                    $tStart = substr($questionnaire->getDtStart(),11,5);
                    $dEnd = substr($questionnaire->getDtEnd(),0,10);
                    $tEnd = substr($questionnaire->getDtEnd(),11,5);
                    $formBuilder->registerField(new FormField("d_start", "date", false, "Дата начала опроса", "", "", false, "",$dStart));
                    $formBuilder->registerField(new FormField("t_start", "time", false, "Время начала опроса (формат 00:00)", "", "", false, "",$tStart));
                    $formBuilder->registerField(new FormField("d_end", "date", false, "Дата окончания опроса", "", "", false, "",$dEnd));
                    $formBuilder->registerField(new FormField("t_end", "time", false, "Время окончания опроса (формат 00:00)", "","", false, "",$tEnd));
                    $formBuilder->registerField(new FormField("order_date", "date", false, "Дата приказа", "", "", false, "",$questionnaire->getOrderDate()));
                    $formBuilder->registerField(new FormField("order_number", "text", false, "Номер приказа", "", "", false, "",$questionnaire->getOrderNumber()));
                    $formBuilder->registerField(new FormField("questionnaire_date", "date", false, "Дата заседания", "", "", false, "",$questionnaire->getQuestionnaireDate()));
                    $formBuilder->registerField(new FormField("questionnaire_question", "text", false, "По вопросу", "", "", false, "",$questionnaire->getQuestionnaireQuestion()));
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
                                   role="button">Вернуться в личный кабинет</a>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="row justify-content-end">
                        <div class="mt-3 pl-2 pr-2">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                               role="button">Выход</a>
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
                echo "Ошибка доступа";
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            echo "Ошибка доступа";
        }
    }

}