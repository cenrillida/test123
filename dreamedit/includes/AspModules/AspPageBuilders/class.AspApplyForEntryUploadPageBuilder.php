<?php

class AspApplyForEntryUploadPageBuilder implements AspPageBuilder {
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

        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($admin->getStatus());
        if($status->isCanApplyForEntrySend() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {


                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AspAdminEditFormBuilder("������ ������� ��������.","",__DIR__ . "/Documents/","��������");
                } else {
                    $currentUser = $admin;
                    $formBuilder = new AspApplyForEntryUploadFormBuilder("�� ������� ��������� ���������.","",__DIR__."/Documents/","���������");
                }

                $postFix = "";
                if($status->isAdminAllow()) {
                    $postFix = "&user_id=".$currentUser->getId();
                }

                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "��������� � �������� �� ����������"));
                $formBuilder->registerField(new FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=applyForEntry\" role=\"button\">������� ��������� � �������� �� ����������</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "��� �������������: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=applyForEntryEmpty\" role=\"button\">������� ������ ��������� � �������� �� ����������</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "�����������, ��������� ���������� ����, ���������, ������������� � PDF � ����������."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfApplyForEntry()!="") {
                    $pdfApplyForEntry = "getApplyForEntry".$postFix;
                } else {
                    $pdfApplyForEntry = "";
                }

                $applyForEntryFile = new FileField($pdfApplyForEntry,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_apply_for_entry", "file", false, "���������� ��������� � �������� �� ���������� (�� ����� 10�����, ������: pdf)", "�� ��������� ��������� � �������� �� ����������","������� ����",false,"","?mode=getUserPhoto".$postFix,array(),array(),"",array(),2,$applyForEntryFile));


                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        $exitPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_login");
        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-1">
                <div class="text-danger">��������! ��������� ��������� ��������� ������ ����� ������� �� ������ "������ ���������".</div>
            </div>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode'])):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                           role="button">��������� � ������ �������</a>
                    </div>
                    <?php endif;?>
                    <?php if(!empty($currentUser) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$currentUser->getId()?>"
                               role="button">��������� � ������ ������������</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">���������� �� ������ � ������ ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                           role="button">����������� ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">�����</a>
                    </div>
                </div>
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