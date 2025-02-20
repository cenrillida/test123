<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AddApplicationsYearFormBuilder;
use AspModule\FormBuilders\Templates\CreateUserFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class CreateUser implements PageBuilder {
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

        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($admin->getStatus());
        if($status->isAdminAllow()) {
            $sendText = "������������ ������� ��������.";
            $buttonText = "��������";

            $forDissertationAttachmentSelectArr = array();
            $forDissertationAttachmentSelectArr[] = new \OptionField("0","�������� � �����������");
            $forDissertationAttachmentSelectArr[] = new \OptionField("1","������������ ��� ��������� �����������");

            $formBuilder = new CreateUserFormBuilder($sendText,"","",$buttonText,false);

            $formBuilder->registerField(new \FormField("lastname", "text", true, "�������", "�� ������� �������","������"));
            $formBuilder->registerField(new \FormField("firstname", "text", true, "���", "�� ������� ���","����"));
            $formBuilder->registerField(new \FormField("thirdname", "text", false, "��������", "","��������"));
            $formBuilder->registerField(new \FormField("email", "text", false, "E-mail", "�� ������ e-mail","example@imemo.ru",false,"�������� ������ e-mail"));
            $formBuilder->registerField(new \FormField("for_dissertation_attachment", "select", false, "��������� ������ ��", "�� ������� ��� ������ ����������","",false,"","",$forDissertationAttachmentSelectArr));


            $posError = $formBuilder->processPostBuild();
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <?php
        if(!$status->isAdminAllow()) {
            echo "������ �������.";
        } else {
            if (!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $posError ?>
                </div>
                <?php
            }
            $formBuilder->build();
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}