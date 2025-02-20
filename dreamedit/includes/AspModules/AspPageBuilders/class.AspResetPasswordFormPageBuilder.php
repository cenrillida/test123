<?php

class AspResetPasswordFormPageBuilder implements AspPageBuilder {
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
            $formBuilder = new AspPasswordResetFormBuilder("��� ���������� ������ �� ������� ��� ������ ������.","","/files/File/graduate_school/","������������");

            $formBuilder->registerField(new FormField("email", "email", true, "E-mail", "�� ������ e-mail"));
            $posError = $formBuilder->processPostBuild();

        } else {
            $formBuilder = new AspPasswordResetFormBuilder("","","/files/File/graduate_school/","Reset");
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