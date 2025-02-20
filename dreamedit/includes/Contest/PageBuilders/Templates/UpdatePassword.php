<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\LoginFormBuilder;
use Contest\FormBuilders\Templates\RegisterFormBuilder;
use Contest\FormBuilders\Templates\UpdatePasswordFormBuilder;
use Contest\PageBuilders\PageBuilder;

class UpdatePassword implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * UpdatePassword constructor.
     * @param Contest $contest
     * @param \Pages $pages
     */
    public function __construct(Contest $contest, $pages)
    {
        $this->contest = $contest;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        if($this->contest->getRegistrationService()->checkResetCode($_GET['email'],$_GET['code'])) {
            if ($_SESSION[lang] != "/en") {
                $formBuilder = new UpdatePasswordFormBuilder("Вы успешно восстановили пароль.", "", "", "Сохранить");

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
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build(array("error" => "Не найден запрос на восстановление пароля"));
        }
    }

}