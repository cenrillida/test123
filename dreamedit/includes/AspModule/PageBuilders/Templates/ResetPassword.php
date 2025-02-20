<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;
use AspModule\FormBuilders\Templates\PasswordResetFormBuilder;

class ResetPassword implements PageBuilder {
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

        if($_SESSION[lang]!="/en") {
            $formBuilder = new PasswordResetFormBuilder("Вам отправлено письмо со ссылкой для сброса пароля.","","/files/File/graduate_school/","Восстановить");

            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail"));
            $posError = $formBuilder->processPostBuild();

        } else {
            $formBuilder = new PasswordResetFormBuilder("","","/files/File/graduate_school/","Reset");
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