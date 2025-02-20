<?php

class AspPersonalPageBuilder implements AspPageBuilder {
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

        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus());
        $fieldOfStudy = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyById($currentUser->getFieldOfStudy());
        echo "<h4>".$currentUser->getLastName()." ".$currentUser->getFirstName()." ".$currentUser->getThirdName()."</h4>";
        $photo = $currentUser->getPhoto();
        if(!empty($photo)) {
            echo "<div><img style=\"width: 180px !important; height: 240px !important;\" src=\"?mode=getUserPhoto\" alt=\"\"></div>";
            echo "<p><b>���� ���������� ��������, ������������� � � ���������� ����������. ��� ���������� ���������� ����� ��������� ���������� 3�4.</p>";
        }
        if(!empty($fieldOfStudy)) {
            echo "<p><b>����������� ����������:</b> " . $fieldOfStudy->getName() . "</p>";
        }
        echo "<p><b>������� ������:</b> ".$status->getText()."</p>";
        echo "<hr>";
        $nextStep = $status->getStepText();
        if(!empty($nextStep)) {
            echo "<h5 class='font-weight-bold'>".$nextStep."</h5>";
            if($currentUser->getCommentFromAdmin()!="") {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= Dreamedit::LineBreakToBr($currentUser->getCommentFromAdmin()) ?>
                </div>
                <?php
            }
        }
        if($status->isDocumentUploadAllow()):?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <div class="mr-3 mt-3">
                    <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=application"
                       role="button">������� ���������</a>
                </div>
                <div class="mr-3 mt-3">
                    <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=personalSheet"
                                                                   role="button">������� ������ ������ �� ����� ������</a>
                </div>
                <div class="mr-3 mt-3">
                    ��� �������������: <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=applicationEmpty"
                                                                   role="button">������� ������ ���������</a>
                </div>
                <div class="mr-3 mt-3">
                    ��� �������������: <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=personalSheetEmpty"
                                                                                      role="button">������� ������ ������ ������ �� ����� ������</a>
                </div>
            </div>
        </div>
        <?php endif;?>
        <?php if($status->isCanApplyForEntrySend()):?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <div class="mr-3 mt-3">
                    <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=applyForEntry"
                                                                   role="button">������� ��������� � �������� �� ����������</a>
                </div>
                <div class="mr-3 mt-3">
                    ��� �������������: <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=applyForEntryEmpty"
                                                                                      role="button">������� ������ ��������� � �������� �� ����������</a>
                </div>
            </div>
        </div>
        <?php endif;?>
        <?php if($status->isEducationCanUpload() && $currentUser->getPdfEducation()==""):?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <div>
                    <h5>� ��� �� �������� ������. ����������� ��������� � ��������� ����� ������ ���������. ����� ��������� ������.</h5>
                </div>
            </div>
        </div>
    <?php endif;?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <?php if(($status->isEducationCanUpload() && $currentUser->getPdfEducation()=="") || ($status->isEducationCanUpload() && $status->isDocumentSendAllow()) ):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=addEducation"
                           role="button">����������� ���������</a>
                    </div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=educationUpload"
                           role="button">��������� ��������� � ������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=adminTable"
                           role="button">������� ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createXlsx"
                           role="button">�������� ���� � Excel</a>
                    </div>
                <?php endif;?>
                <?php if($status->isDocumentSendAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=sendDocument"
                           role="button">������ ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isDocumentUploadAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=uploadDocument"
                           role="button">��������� ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isCanApplyForEntrySend()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntryUpload"
                           role="button">��������� ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isAddDataAllow()):?>
                <div class="mr-3 mt-3">
                    <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=addData"
                       role="button">��������� �������������� ������</a>
                </div>
                <?php endif;?>
                <?php if($status->isDocumentApplicationAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=documentApplication"
                           role="button">��������� ������ ��� ������ ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isEditAddDataAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=addData"
                           role="button">�������� �������������� ������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isEditDocumentApplicationAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=documentApplication"
                           role="button">�������� ������ ��� ������ ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isCanApplyForEntry()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntry"
                           role="button">������� ������� �����������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isCanEditApplyForEntry()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntry"
                           role="button">�������� ������� �����������</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}