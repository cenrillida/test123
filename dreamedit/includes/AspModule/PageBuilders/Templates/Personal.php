<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class Personal implements PageBuilder {
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

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build();
            ?>
        <?php endif;?>


        <?php

        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus());
        $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyById($currentUser->getFieldOfStudy());
        echo "<h4>".$currentUser->getLastName()." ".$currentUser->getFirstName()." ".$currentUser->getThirdName()."</h4>";
        $photo = $currentUser->getPhoto();
        if(!empty($photo)) {
            echo "<div><img style=\"width: 180px !important; height: 240px !important;\" src=\"?mode=getUserPhoto\" alt=\"\"></div>";
            echo "<p><b>���� ���������� ��������, ������������� � � ���������� ����������. ��� ���������� ���������� ����� ��������� ���������� 3�4.</p>";
        }
        if(!empty($fieldOfStudy)) {
            $fieldOfStudyTitle = "������ ������� ��������������";
//            if($currentUser->isForDissertationAttachment()) {
//                $fieldOfStudyTitle = "�������������";
//            }
            echo "<p><b>{$fieldOfStudyTitle}:</b> " . $fieldOfStudy->getName() . "</p>";
        }
        echo "<p><b>������� ������:</b> ".$status->getText()."</p>";
        echo "<hr>";
        $nextStep = $status->getStepText();
        if(!empty($nextStep)) {
            echo "<h5 class='font-weight-bold'>".$nextStep."</h5>";
            if($currentUser->getCommentFromAdmin()!="") {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= \Dreamedit::LineBreakToBr($currentUser->getCommentFromAdmin()) ?>
                </div>
                <?php
            }
        }
        if($status->getId()==7 || $status->getId()==13) {
            $userFieldsError = $currentUser->getFieldsError();
            if(!empty($userFieldsError)) {
                $fieldErrorList = $this->aspModule->getFieldErrorService()->getCurrentUserFieldErrorList($currentUser);
                ?>
                <div>
                    ���� � ��������:
                    <ul style="list-style: square" class="text-danger">
                        <?php foreach ($userFieldsError as $fieldError):
                        if(!empty($fieldErrorList[$fieldError['field_error_id']])):
                        ?>
                        <li>
                            <?=$fieldErrorList[$fieldError['field_error_id']]?>: <?=$fieldError['field_error_text']?>
                        </li>
                        <?
                        endif;
                        endforeach;?>
                    </ul>
                </div>
                <?php
            }
        }
        if($status->isDocumentUploadAllow()):
            $applicationFile = "application";
            $applicationEmptyFile = "applicationEmpty";
            if($currentUser->isForDissertationAttachment()) {
                $applicationFile = "applicationDissertation";
                $applicationEmptyFile = "applicationDissertationEmpty";
            }
            ?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <div class="mr-3 mt-3">
                    <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=consentDataProcessing"
                                                                   role="button">������� �������� �� ��������� ������������ ������</a>
                </div>
                <div class="mr-3 mt-3">
                    <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=<?=$applicationFile?>"
                       role="button">������� ���������</a>
                </div>
                <div class="mr-3 mt-3">
                    <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=personalSheet"
                                                                   role="button">������� ������ ������ �� ����� ������</a>
                </div>
                <?php if($currentUser->isForDissertationAttachment()):?>
                <div class="mr-3 mt-3">
                    <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=scienceWork"
                                                                   role="button">������� ������ ������� ������</a>
                </div>
                <?php endif;?>
                <div class="mr-3 mt-3">
                    ��� �������������: <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=consentDataProcessingEmpty"
                                                                                      role="button">������� ������ �������� �� ��������� ������������ ������</a>
                </div>
                <div class="mr-3 mt-3">
                    ��� �������������: <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=<?=$applicationEmptyFile?>"
                                                                   role="button">������� ������ ���������</a>
                </div>
                <div class="mr-3 mt-3">
                    ��� �������������: <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createDocument&file=personalSheetEmpty"
                                                                                      role="button">������� ������ ������ ������ �� ����� ������</a>
                </div>
                <?php if($currentUser->isForDissertationAttachment()):?>
                <div class="mr-3 mt-3">
                    ��� �������������: <i class="fas fa-file-word text-primary"></i> <a target="_blank" href="/files/File/ru/graduate_school/science_work.docx"
                                                                                      role="button">������� ������ ������ ������� ������</a>
                </div>
                <?php endif;?>
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
            <?php if($status->isDocumentSendAllow()):?>
            <?php if($status->isDocumentUploadAllow()):?>
            <div class="row mb-3">
                <div class="col">
                    <hr>
                    <h5>���-���� ����� ������� ����������:</h5>
                    <div>
                        <ul>
                            <li class="checklist__<?php if($currentUser->getPdfConsentDataProcessing()=="") echo 'failed'; else echo 'success';?>">��������� �������� �� ��������� ������������ ������</li>
                            <li class="checklist__<?php if($currentUser->getPdfApplication()=="") echo 'failed'; else echo 'success';?>">��������� ���������</li>
                            <li class="checklist__<?php if($currentUser->getPdfPersonalSheet()=="") echo 'failed'; else echo 'success';?>">��������� ������ ������ �� ����� ������</li>
                            <li class="checklist__<?php if($currentUser->getPdfPersonalDocument()=="") echo 'failed'; else echo 'success';?>">��������� ��������, �������������� ��������</li>
                            <?php if(!$currentUser->isForDissertationAttachment() && $currentUser->getPensionCertificate()!=""):?>
                                <li class="checklist__<?php if($currentUser->getPdfPensionCertificate()=="") echo 'failed'; else echo 'success';?>">��������� �����</li>
                            <?php endif;?>
                            <?php if($currentUser->isForDissertationAttachment()):?>
                                <li class="checklist__<?php if($currentUser->getPdfScienceWorkList()=="") echo 'failed'; else echo 'success';?>">��������� ������ ������� ������</li>
                            <?php endif;?>
                            <li class="checklist__<?php if($currentUser->getPdfAutoBiography()=="") echo 'failed'; else echo 'success';?>">��������� �������������</li>
                            <?php if(!$currentUser->isForDissertationAttachment()):?>
                                <li class="checklist__<?php if($currentUser->getWordEssay()=="") echo 'failed'; else echo 'success';?>">��������� ���� �� ���� �����������</li>
                            <?php endif;?>
                            <li class="checklist__<?php if($currentUser->getPdfEducation()=="") echo 'notice'; else echo 'success';?>">��������� �������� �� ����������� � � ������������ (����� ��������� �������, ���� ��� � ������� �� ������ ������ ����������)</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <div class="row justify-content-start mb-3">
                <?php if($status->isDocumentSendAllow() && $status->isDocumentUploadAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase <?php if($currentUser->cantSendDocuments()) echo "disabled";?>" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=sendDocument"
                           role="button" <?php if($currentUser->cantSendDocuments()) echo "aria-disabled=\"true\"";?>>������ ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isDocumentSendAllow() && $status->isEducationCanUpload()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase <?php if($currentUser->getPdfEducation()=="") echo "disabled";?>" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=sendDocument"
                           role="button" <?php if($currentUser->getPdfEducation()=="") echo "aria-disabled=\"true\"";?>>������ ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isDocumentUploadAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=uploadDocument"
                           role="button">��������� ���������</a>
                    </div>
                <?php endif;?>
            </div>
            <?php endif;?>
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
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=documentApplicationControl"
                           role="button">��������� ������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createUser"
                           role="button">�������� ������������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=adminTable"
                           role="button">����� ������� ���������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applicationsYears"
                           role="button">����� �� �����</a>
                    </div>
                <?php endif;?>
                <?php if($status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=createXlsx"
                           role="button">�������� ���� � Excel</a>
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
                <?php if($status->isCanApplyForEntry() && !$currentUser->isForDissertationAttachment()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applyForEntry"
                           role="button">������� ������� �����������</a>
                    </div>
                <?php endif;?>
                <?php if($status->isCanEditApplyForEntry() && !$currentUser->isForDissertationAttachment()):?>
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