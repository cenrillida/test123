<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AdminEditFormBuilder;
use AspModule\FormBuilders\Templates\DocumentUploadFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class DocumentUpload implements PageBuilder {
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
        if($status->isDocumentUploadAllow() || $status->isAdminAllow()) {
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
                    $formBuilder = new AdminEditFormBuilder("������ ������� ��������.","",__DIR__ . "/Documents/","��������",false);
                } else {
                    $currentUser = $admin;
                    $formBuilder = new DocumentUploadFormBuilder("�� ������� ��������� ���������.","",__DIR__."/Documents/","���������",false);
                }

                $postFix = "";
                if($status->isAdminAllow()) {
                    $postFix = "&user_id=".$currentUser->getId();
                }

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
                $formBuilder->registerField(new \FormField("", "header", false, "���� � ��� ����� ���������� � �� ���������� ��������� ��� �����, ���������� ��������� �� ������"));
                $formBuilder->registerField(new \FormField("", "header", false, "�������� �� ��������� ������������ ������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=consentDataProcessing\" role=\"button\">������� �������� �� ��������� ������������ ������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "��� �������������: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=consentDataProcessingEmpty\" role=\"button\">������� ������ �������� �� ��������� ������������ ������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "�����������, ��������� ���������� ����, ���������, ������������� � PDF � ����������."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfConsentDataProcessing()!="") {
                    $pdfConsentDataProcessing = "getConsentDataProcessing".$postFix;
                } else {
                    $pdfConsentDataProcessing = "";
                }

                $consentDataProcessingFile = new \FileField($pdfConsentDataProcessing,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_consent_data_processing", "file", false, "���������� ��������� (�� ����� 10�����, ������: pdf)", "�� ��������� ���������","������� ����",false,"","?mode=getUserPhoto".$postFix,array(),array(),"",array(),2,$consentDataProcessingFile));


                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "���������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationFile}\" role=\"button\">������� ���������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "��� �������������: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationEmptyFile}\" role=\"button\">������� ������ ���������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "�����������, ��������� ���������� ����, ���������, ������������� � PDF � ����������."));

                if($currentUser->getPdfApplication()!="") {
                    $pdfApplication = "getApplication".$postFix;
                } else {
                    $pdfApplication = "";
                }

                $applicationFile = new \FileField($pdfApplication,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_application", "file", false, "���������� ��������� (�� ����� 10�����, ������: pdf)", "�� ��������� ���������","������� ����",false,"","?mode=getUserPhoto".$postFix,array(),array(),"",array(),2,$applicationFile));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "��������, �������������� ��������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "������������� � PDF � ����������."));

                if($currentUser->getPdfPersonalDocument()!="") {
                    $personalDocument = "getPersonalDocument".$postFix;
                } else {
                    $personalDocument = "";
                }

                $personalDocumentFile = new \FileField($personalDocument,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_personal_document", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)", "�� �������� ��������, �������������� ��������","������� ����",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$personalDocumentFile));

                if(!$currentUser->isForDissertationAttachment()) {

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "�����"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "������������� � PDF � ����������."));

                    if ($currentUser->getPdfPensionCertificate() != "") {
                        $pensionCertificate = "getPensionCertificate" . $postFix;
                    } else {
                        $pensionCertificate = "";
                    }

                    $pensionCertificateFile = new \FileField($pensionCertificate, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".pdf"), 10240 * 1024, $filePrefix, "pdf");
                    $formBuilder->registerField(new \FormField("pdf_pension_certificate", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)", "�� �������� �����", "������� ����", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $pensionCertificateFile));

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "���� �� ���� �����������"));

                    if ($currentUser->getWordEssay() != "") {
                        $essay = "getEssay" . $postFix;
                    } else {
                        $essay = "";
                    }

                    $essayFile = new \FileField($essay, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".docx"), 10240 * 1024, $filePrefix, "docx");
                    $formBuilder->registerField(new \FormField("word_essay", "file", false, "���������� �������� (�� ����� 10�����, ������: docx)", "�� ��������� ����", "������� ����", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $essayFile));

                }

                if($currentUser->isForDissertationAttachment()) {

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "������ ������� ������"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-word text-primary\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=scienceWork\" role=\"button\">������� ������ ������� ������</a>"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "��� �������������: <i class=\"fas fa-file-word text-primary\"></i> <a target=\"_blank\" href=\"/files/File/ru/graduate_school/science_work.docx\" role=\"button\">������� ������ ������ ������� ������</a>"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/files/File/ru/graduate_school/instruction_science_work.pdf\" role=\"button\">���������� �� ���������� ������ ������� ������</a>"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "�����������, ���������, ���������, ������������� � PDF � ����������."));

                    if ($currentUser->getPdfScienceWorkList() != "") {
                        $scienceWorkList = "getScienceWorkList" . $postFix;
                    } else {
                        $scienceWorkList = "";
                    }

                    $scienceWorkListFile = new \FileField($scienceWorkList, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".pdf"), 10240 * 1024, $filePrefix, "pdf");
                    $formBuilder->registerField(new \FormField("pdf_science_work_list", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)", "�� �������� �����", "������� ����", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $scienceWorkListFile));

                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "�������� �� ����������� � � ������������ (� �����������)"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "������������� � PDF � ����������."));

                if($currentUser->getPdfEducation()!="") {
                    $education = "getEducation".$postFix;
                } else {
                    $education = "";
                }

                $educationFile = new \FileField($education,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_education", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)", "","������� ����",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$educationFile));

                if($currentUser->isForDissertationAttachment()) {

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "������� �� ��������/������� ��������"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "���������� � PDF."));

                    if ($currentUser->getPdfEducationPeriodReference() != "") {
                        $educationPeriodReference = "getEducationPeriodReference" . $postFix;
                    } else {
                        $educationPeriodReference = "";
                    }

                    $educationPeriodReferenceFile = new \FileField($educationPeriodReference, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".pdf"), 10240 * 1024, $filePrefix, "pdf");
                    $formBuilder->registerField(new \FormField("pdf_education_period_reference", "file", false, "���������� ������� (�� ����� 10�����, ������: pdf)", "", "������� ����", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $educationPeriodReferenceFile));

                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "�������������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "���������� � PDF."));

                if($currentUser->getPdfAutoBiography()!="") {
                    $autobiography = "getAutobiography".$postFix;
                } else {
                    $autobiography = "";
                }

                $autobiographyFile = new \FileField($autobiography,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_autobiography", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)", "","������� ����",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$autobiographyFile));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "������ ������ �� ����� ������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=personalSheet\" role=\"button\">������� ������ ������ �� ����� ������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "��� �������������: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=personalSheetEmpty\" role=\"button\">������� ������ ������ ������ �� ����� ������</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "�����������, ��������� ���������� ����, ���������, ������������� � PDF � ����������."));

                if($currentUser->getPdfPersonalSheet()!="") {
                    $personalSheet = "getPersonalSheet".$postFix;
                } else {
                    $personalSheet = "";
                }

                $personalSheetFile = new \FileField($personalSheet,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_personal_sheet", "file", false, "���������� ������ ������ �� ����� ������ (�� ����� 10�����, ������: pdf)", "�� �������� ������ ������ �� ����� ������","������� ����",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$personalSheetFile));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "���������, �������������� �������������� ����������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "���������� � PDF."));

//                var_dump($currentUser->getPdfIndividualAchievements());
//                exit;

                $changableIndividualAchievements = array();
                $counter = 1;
                foreach ($currentUser->getPdfIndividualAchievements() as $k=>$value) {
                    $changableIndividualAchievements[$k] = array();
                    if(!empty($value['pdf_individual_achievement'])) {
                        $changableIndividualAchievements[$k]['pdf_individual_achievement'] = "getIndividualAchievements&id=".$counter.$postFix;
                    } else {
                        $changableIndividualAchievements[$k]['pdf_individual_achievement'] = "";
                    }
                    $counter++;
                }

                $individualAchievementsComplexFields = array();
                $individualAchievementFile = new \FileField($currentUser->getPdfIndividualAchievements(),$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf",$changableIndividualAchievements);
                $individualAchievementsComplexFields[] = new \FormField("pdf_individual_achievement", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)","","������� ����", false,"","",array(),array(),"",array(),2,$individualAchievementFile);

                $formBuilder->registerField(new \FormField("pdf_individual_achievements", "complex-block", false, "�������� �������������� ����������","","", false,"",$currentUser->getPdfIndividualAchievements(),array(),array(),"", $individualAchievementsComplexFields));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "��������, �������������� ������������ (��� ������������� �������� ����������� ������� ��� ���������� ������������� ���������)"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "���������� � PDF."));

                if($currentUser->getPdfDisabledInfo()!="") {
                    $disabledInfo = "getDisabledInfo".$postFix;
                } else {
                    $disabledInfo = "";
                }

                $disabledInfoFile = new \FileField($disabledInfo,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_disabled_info", "file", false, "���������� �������� (�� ����� 10�����, ������: pdf)", "","������� ����",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$disabledInfoFile));



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
        if(!$status->isDocumentUploadAllow() && !$status->isAdminAllow()) {
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