<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\LoginFormBuilder;
use DissertationCouncils\FormBuilders\Templates\RegisterFormBuilder;
use DissertationCouncils\FormBuilders\Templates\UpdatePasswordFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class UpdatePassword implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * UpdatePassword constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        if($this->dissertationCouncils->getRegistrationService()->checkResetCode($_GET['email'],$_GET['code'])) {
            if ($_SESSION['lang'] != "/en") {
                $formBuilder = new UpdatePasswordFormBuilder("Вы успешно восстановили пароль.", "", "", "Сохранить", false);

                $formBuilder->registerField(new \FormField("email", "hidden", true, "E-mail", "Не введен e-mail", "", false, "", $_GET['email']));
                $formBuilder->registerField(new \FormField("password", "password", true, "Пароль", "Не введен пароль"));
                $formBuilder->registerField(new \FormField("code", "hidden", true, "Пароль", "Не введен пароль", "", false, "", $_GET['code']));
                $posError = $formBuilder->processPostBuild();

            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            ?>
            <div class="container-fluid">
                <div class="row justify-content-between mb-3">
                    <div>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase"
                               href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=login"
                               role="button">На страницу авторизации</a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                    </div>
                </div>
            </div>
            <div class="mt-3"></div>

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
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build(array("error" => "Не найден запрос на восстановление пароля"));
        }
    }

}