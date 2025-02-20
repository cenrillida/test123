<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\LoginFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class LoginForm implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * LoginForm constructor.
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

        if($_GET['logout']==1) {
            $this->dissertationCouncils->getAuthorizationService()->logout();
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($this->dissertationCouncils->getAuthorizationService()->isAuthorized()) {
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($_SESSION['lang']!="/en") {
            $formBuilder = new LoginFormBuilder("Успешная авторизация.","","","Войти", false);

            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail"));
            $formBuilder->registerField(new \FormField("password", "password", true, "Пароль", "Не введен пароль"));
            $posError = $formBuilder->processPostBuild();

            if($posError=="1" && $this->dissertationCouncils->getAuthorizationService()->isAuthorized()) {
                $personalPageId = $this->pages->getFirstPageIdByTemplate("dissertation_councils_lk");
                if(!empty($personalPageId)) {
                    \Dreamedit::sendHeaderByCode(301);
                    \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$personalPageId);
                    return;
                }
            }

        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>

        <div class="container-fluid">
            <div class="row justify-content-between mb-3">
                <div>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=smsAuth"
                           role="button">Авторизация по СМС</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=resetPassword"
                           role="button">Восстановить пароль</a>
                    </div>
<!--                    <div class="mt-3 pl-2 pr-2">-->
<!--                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=--><?//=$_REQUEST['page_id']?><!--&mode=register"-->
<!--                           role="button">Регистрация</a>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
        <div class="mt-3"></div>
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