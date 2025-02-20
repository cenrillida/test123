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
                $formBuilder = new QuestionnaireCreateFormBuilder("Опрос создан.", "", "", "Создать", false);

                $formBuilder->registerField(new \FormField("name", "text", true, "Название опроса", "Не введено название опроса"));
                $formBuilder->registerField(new \FormField("d_start", "date", false, "Дата начала опроса", ""));
                $formBuilder->registerField(new \FormField("t_start", "time", false, "Время начала опроса (формат 00:00)", ""));
                $formBuilder->registerField(new \FormField("d_end", "date", false, "Дата окончания опроса", ""));
                $formBuilder->registerField(new \FormField("t_end", "time", false, "Время окончания опроса (формат 00:00)", ""));
                $formBuilder->registerField(new \FormField("order_date", "date", false, "Дата приказа", ""));
                $formBuilder->registerField(new \FormField("order_number", "text", false, "Номер приказа", ""));
                $formBuilder->registerField(new \FormField("questionnaire_date", "date", false, "Дата заседания", ""));
                $formBuilder->registerField(new \FormField("questionnaire_question", "text", false, "По вопросу", ""));
                $formBuilder->registerField(new \FormField("secret", "checkbox", false, "Тайное голосование", "", "", false, "", "0", array(), array()));
                $formBuilder->registerField(new \FormField("protocol_number", "text", false, "Номер протокола", ""));
                $formBuilder->registerField(new \FormField("questionnaire_fio", "text", false, "Протокол (Ф.И.О.)", ""));
                $formBuilder->registerField(new \FormField("questionnaire_position", "text", false, "Протокол (Выдвигается к избранию в состав Ученого совета)", ""));
                $formBuilder->registerField(new \FormField("questionnaire_members_count", "text", false, "Количество членов ученого совета на данный момент (Вместо автоматических заполняемых данных)", ""));

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
            echo "Ошибка доступа";
        }
    }

}