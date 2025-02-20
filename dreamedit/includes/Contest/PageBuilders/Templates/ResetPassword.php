<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\LoginFormBuilder;
use Contest\FormBuilders\Templates\RegisterFormBuilder;
use Contest\FormBuilders\Templates\ResetPasswordFormBuilder;
use Contest\PageBuilders\PageBuilder;

class ResetPassword implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ResetPassword constructor.
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

        if($_SESSION[lang]!="/en") {
            $formBuilder = new ResetPasswordFormBuilder("На Ваш e-mail отправлено письмо со ссылкой для сброса пароля.","","","Восстановить", false);

            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail","example@imemo.ru",true,"Неверный формат e-mail"));

            $posError = $formBuilder->processPostBuild();

        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-3">
                <div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=login"
                           role="button">На страницу авторизации</a>
                    </div>
                </div>
                <div class="row justify-content-end">
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