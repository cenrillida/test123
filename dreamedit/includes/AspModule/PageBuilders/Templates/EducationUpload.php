<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\DocumentUploadFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class EducationUpload implements PageBuilder {
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

                $formBuilder = new DocumentUploadFormBuilder("�� ������� ��������� ���������.","",__DIR__."/Documents/","���������", false);


                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new \FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $applicationFile = "application";
                $applicationEmptyFile = "applicationEmpty";
                if($currentUser->isForDissertationAttachment()) {
                    $applicationFile = "applicationDissertation";
                    $applicationEmptyFile = "applicationDissertationEmpty";
                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "���������� ����������� ��������� � ������ ����������. ���� ����������� ����� ��, ��� � ����� ������� ���������."));
                $formBuilder->registerField(new \FormField("", "header", false, "���������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationFile}\" role=\"button\">������� ���������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "��� �������������: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationEmptyFile}\" role=\"button\">������� ������ ���������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "�����������, ��������� ���������� ����, ���������, ������������� � PDF � ����������."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfApplication()!="") {
                    $pdfApplication = "getApplication";
                } else {
                    $pdfApplication = "";
                }

                $applicationFile = new \FileField($pdfApplication,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_application", "file", false, "���������� ��������� (�� ����� 10�����, ������: pdf)", "�� ��������� ���������","������� ����",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$applicationFile));


                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "�������� �� ����������� � � ������������ (� �����������)"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "������������� � PDF � ����������."));

                if($currentUser->getPdfEducation()!="") {
                    $education = "getEducation";
                } else {
                    $education = "";
                }

                $educationFile = new \FileField($education,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_education", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)", "","������� ����",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$educationFile));

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