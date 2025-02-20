<?php

class AcademicCouncilQuestionnaireCreateFormPageBuilder implements AcademicCouncilPageBuilder {
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
            if ($_SESSION[lang] != "/en") {
                $formBuilder = new AcademicCouncilQuestionnaireCreateFormBuilder("Опрос создан.", "", "", "Создать");

                $formBuilder->registerField(new FormField("name", "text", true, "Название опроса", "Не введено название опроса"));
                $formBuilder->registerField(new FormField("d_start", "date", false, "Дата начала опроса", ""));
                $formBuilder->registerField(new FormField("t_start", "time", false, "Время начала опроса (формат 00:00)", ""));
                $formBuilder->registerField(new FormField("d_end", "date", false, "Дата окончания опроса", ""));
                $formBuilder->registerField(new FormField("t_end", "time", false, "Время окончания опроса (формат 00:00)", ""));
                $formBuilder->registerField(new FormField("order_date", "date", false, "Дата приказа", ""));
                $formBuilder->registerField(new FormField("order_number", "text", false, "Номер приказа", ""));
                $formBuilder->registerField(new FormField("questionnaire_date", "date", false, "Дата заседания", ""));
                $formBuilder->registerField(new FormField("questionnaire_question", "text", false, "По вопросу", ""));
                $posError = $formBuilder->processPostBuild();

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

            $formBuilder->build();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            echo "Ошибка доступа";
        }
    }

}