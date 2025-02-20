<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\LoginFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class LoginForm implements PageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        if($_GET['logout']==1) {
            $this->aspModule->getAuthorizationService()->logout();
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($this->aspModule->getAuthorizationService()->isAuthorized()) {
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($_SESSION['lang']!="/en") {
            $formBuilder = new LoginFormBuilder("Успешная авторизация.","","/files/File/graduate_school/","Войти", false);

            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail"));
            $formBuilder->registerField(new \FormField("password", "password", true, "Пароль", "Не введен пароль"));
            $posError = $formBuilder->processPostBuild();

            $currentUser = $this->aspModule->getCurrentUser();
            if($posError=="1" && !empty($currentUser)) {
                $_SESSION['asp_login'] = $currentUser->getId();
                $_SESSION['asp_email'] = $currentUser->getEmail();
                $_SESSION['asp_password'] = $currentUser->getPassword();


                $personalPageId = $this->pages->getFirstPageIdByTemplate("asp_lk");
                if(!empty($personalPageId)) {
                    \Dreamedit::sendHeaderByCode(301);
                    \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$personalPageId);
                    return;
                }
            }

        } else {
            $formBuilder = new LoginFormBuilder("","","/files/File/graduate_school/","Enter");
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>
        <div class="container-fluid">
            <div class="row justify-content-end mb-3">
                <div class="ml-3 mt-3">
                    <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=passwordReset" role="button">Восстановить пароль</a>
                </div>
                <div class="ml-3 mt-3">
                    <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=register" role="button">Регистрация</a>
                </div>
            </div>
        </div>


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