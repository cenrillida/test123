<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\FormBuilders\Templates\LoginFormBuilder;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class LoginForm implements PageBuilder {
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

        if($_GET['logout']==1) {
            $this->academicCouncilModule->getAuthorizationService()->logout();
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($this->academicCouncilModule->getAuthorizationService()->isAuthorized()) {
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($_SESSION[lang]!="/en") {
            $formBuilder = new LoginFormBuilder("Успешная авторизация.","","","Войти", false);

            $formBuilder->registerField(new \FormField("login", "text", true, "Логин", "Не введен логин"));
            $formBuilder->registerField(new \FormField("password", "password", true, "Пароль", "Не введен пароль"));
            $posError = $formBuilder->processPostBuild();

            if($posError=="1") {
                $personalPageId = $this->pages->getFirstPageIdByTemplate("ac_lk");
                if(!empty($personalPageId)) {
                    \Dreamedit::sendHeaderByCode(301);
                    \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$personalPageId);
                    return;
                }
            }

        } else {
            $formBuilder = new LoginFormBuilder("","","","Enter");
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


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