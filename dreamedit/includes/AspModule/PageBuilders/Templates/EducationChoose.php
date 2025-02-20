<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\DocumentApplicationFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class EducationChoose implements PageBuilder {
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
        if(($status->isEducationCanUpload() && $currentUser->getPdfEducation()=="") || ($status->isEducationCanUpload() && $status->isDocumentSendAllow())) {
            if($_SESSION[lang]!="/en") {

                $formBuilder = new DocumentApplicationFormBuilder("�� ������� ��������� ������.","","/files/File/graduate_school/","���������",false);

                $diplomSelectArr = array();
                $diplomSelectArr[] = new \OptionField("","");
                $diplomSelectArr[] = new \OptionField("��������","��������");
                $diplomSelectArr[] = new \OptionField("�����������","�����������");

                $diplom = $formBuilder->setSelectedOptionArr($diplomSelectArr,$currentUser->getDiplom());
                $formBuilder->registerField(new \FormField("diplom", "select", false, "������", "�� ������ ��� �������","",false,"","",$diplom));
                $formBuilder->registerField(new \FormField("", "form-row", false, ""));
                $formBuilder->registerField(new \FormField("diplom_series", "text", false, "����� �������","�� ������� ����� �������","123456", false,"",$currentUser->getDiplomSeries(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new \FormField("diplom_number", "text", false, "����� �������","�� ������ ����� �������","1234567", false,"",$currentUser->getDiplomNumber(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new \FormField("diplom_date", "date", false, "���� ������ �������","�� ������� ���� ������ �������","", false,"",$currentUser->getDiplomDate(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new \FormField("", "form-row-end", false, ""));

                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <?php if(!empty($currentUser) && $status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$currentUser->getId()?>"
                           role="button">��������� � ������ ������������</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php
        if(($status->isEducationCanUpload() && $currentUser->getPdfEducation()=="") || ($status->isEducationCanUpload() && $status->isDocumentSendAllow())) {
            if (!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $posError ?>
                </div>
                <?php
            }
            $formBuilder->build();
        } else {
            echo "������ �������.";
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}