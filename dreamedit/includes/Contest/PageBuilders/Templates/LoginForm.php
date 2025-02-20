<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\LoginFormBuilder;
use Contest\PageBuilders\PageBuilder;

class LoginForm implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * LoginForm constructor.
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

        if($_GET['logout']==1) {
            $this->contest->getAuthorizationService()->logout();
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($this->contest->getAuthorizationService()->isAuthorized()) {
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($_SESSION[lang]!="/en") {
            $formBuilder = new LoginFormBuilder("Успешная авторизация.","","","Войти", false);

            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail"));
            $formBuilder->registerField(new \FormField("password", "password", true, "Пароль", "Не введен пароль"));
            $posError = $formBuilder->processPostBuild();

            if($posError=="1" && $this->contest->getAuthorizationService()->isAuthorized()) {
                $personalPageId = $this->pages->getFirstPageIdByTemplate("contest_lk");
                if(!empty($personalPageId)) {
                    \Dreamedit::sendHeaderByCode(301);
                    \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$personalPageId);
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
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=resetPassword"
                           role="button">Восстановить пароль</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=register"
                           role="button">Регистрация</a>
                    </div>
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