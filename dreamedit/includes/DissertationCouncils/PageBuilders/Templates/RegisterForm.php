<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\LoginFormBuilder;
use DissertationCouncils\FormBuilders\Templates\RegisterFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class RegisterForm implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * RegisterForm constructor.
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

        if($_SESSION['lang']!="/en") {
            $formBuilder = new RegisterFormBuilder("�� ��� e-mail ��������� ������ ��� ������������� �����������.","","","������������������", false);

            $formBuilder->registerField(new \FormField("lastname", "text", true, "�������", "�� ������� �������","������"));
            $formBuilder->registerField(new \FormField("firstname", "text", true, "���", "�� ������� ���","����"));
            $formBuilder->registerField(new \FormField("thirdname", "text", false, "��������", "","��������"));
            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "�� ������ e-mail","example@imemo.ru",true,"�������� ������ e-mail"));
            $formBuilder->registerField(new \FormField("password", "password", true, "������", "�� ������ ������"));
            $posError = $formBuilder->processPostBuild();

        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-3">
                <div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=login"
                           role="button">�� �������� �����������</a>
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