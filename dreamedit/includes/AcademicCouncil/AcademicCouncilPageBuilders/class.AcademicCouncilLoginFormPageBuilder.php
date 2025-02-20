<?php

class AcademicCouncilLoginFormPageBuilder implements AcademicCouncilPageBuilder {
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

        if($_SESSION[lang]!="/en") {
            $formBuilder = new AcademicCouncilLoginFormBuilder("Успешная авторизация.","","","Войти");

            $formBuilder->registerField(new FormField("login", "text", true, "Логин", "Не введен логин"));
            $formBuilder->registerField(new FormField("password", "password", true, "Пароль", "Не введен пароль"));
            $posError = $formBuilder->processPostBuild();

            if($posError=="1" && $this->academicCouncilModule->getAcademicCouncilAuthorizationService()->isAuthorized()) {
                $personalPageId = $this->pages->getFirstPageIdByTemplate("ac_lk");
                if(!empty($personalPageId)) {
                    Dreamedit::sendHeaderByCode(301);
                    Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$personalPageId);
                    return;
                }
            }

        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>

        <?php

        if(!empty($posError)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?=$posError?>
            </div>
            <?php
        }

        $formBuilder->build();

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}