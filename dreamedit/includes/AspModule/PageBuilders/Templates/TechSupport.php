<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\TechSupportFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class TechSupport implements PageBuilder {
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

        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus());
        if($_SESSION[lang]!="/en") {

            $formBuilder = new TechSupportFormBuilder("�������� ���������� ������ ����������� ���������.","",__DIR__."/Documents/","���������", false);

            $formBuilder->registerField(new \FormField("", "hr", false, ""));
            $formBuilder->registerField(new \FormField("", "header", false, "����������� ���������"));
            $formBuilder->registerField(new \FormField("problem", "textarea", true, "������� ��������", "�� ��������� ��������","",false,"","",array(),array(),"",array(),10));
            $posError = $formBuilder->processPostBuild();

        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <?php
        if (!empty($posError)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?= $posError ?>
            </div>
            <?php
        }
        $formBuilder->build();
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}