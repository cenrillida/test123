<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AdminEditFormBuilder;
use AspModule\FormBuilders\Templates\ApplyForEntryUploadFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class ApplyForEntryUpload implements PageBuilder {
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
        if($status->isCanApplyForEntrySend() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {


                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $this->aspModule->getUserService()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AdminEditFormBuilder("������ ������� ��������.","",__DIR__ . "/Documents/","��������", false);
                } else {
                    $currentUser = $admin;
                    $formBuilder = new ApplyForEntryUploadFormBuilder("�� ������� ��������� ���������.","",__DIR__."/Documents/","���������",false);
                }

                $postFix = "";
                if($status->isAdminAllow()) {
                    $postFix = "&user_id=".$currentUser->getId();
                }

                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new \FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "��������� � �������� �� ����������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=applyForEntry\" role=\"button\">������� ��������� � �������� �� ����������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "��� �������������: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=applyForEntryEmpty\" role=\"button\">������� ������ ��������� � �������� �� ����������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "�����������, ��������� ���������� ����, ���������, ������������� � PDF � ����������."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfApplyForEntry()!="") {
                    $pdfApplyForEntry = "getApplyForEntry".$postFix;
                } else {
                    $pdfApplyForEntry = "";
                }

                $applyForEntryFile = new \FileField($pdfApplyForEntry,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_apply_for_entry", "file", false, "���������� ��������� � �������� �� ���������� (�� ����� 10�����, ������: pdf)", "�� ��������� ��������� � �������� �� ����������","������� ����",false,"","?mode=getUserPhoto".$postFix,array(),array(),"",array(),2,$applyForEntryFile));


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
        if(!$status->isCanApplyForEntrySend() && !$status->isAdminAllow()) {
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