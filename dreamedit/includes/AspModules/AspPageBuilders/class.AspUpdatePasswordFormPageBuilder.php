<?php

class AspUpdatePasswordFormPageBuilder implements AspPageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build()
    {
        global $DB,$_CONFIG,$site_templater;

        if($_SESSION[lang]!="/en") {
            $formBuilder = new AspUpdatePasswordFormBuilder("�� ������� ������������ ������.","","/files/File/graduate_school/","���������");

            $formBuilder->registerField(new FormField("email", "hidden", true, "E-mail", "�� ������ e-mail","",false,"",$_GET['email']));
            $formBuilder->registerField(new FormField("password", "password", true, "������", "�� ������ ������"));
            $formBuilder->registerField(new FormField("code", "hidden", true, "������", "�� ������ ������","",false,"",$_GET['code']));
            $posError = $formBuilder->processPostBuild();

        } else {
            $formBuilder = new AspUpdatePasswordFormBuilder("","","/files/File/graduate_school/","Save");
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