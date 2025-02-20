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
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $this->aspModule->getUserService()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AdminEditFormBuilder("Данные успешно изменены.","",__DIR__ . "/Documents/","Изменить",false);
                } else {
                    $currentUser = $admin;
                    $formBuilder = new DocumentUploadFormBuilder("Вы успешно загрузили документы.","",__DIR__."/Documents/","Отправить",false);
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
                $formBuilder->registerField(new \FormField("", "header", false, "Если у Вас много документов и не получается загрузить все сразу, попробуйте загружать по одному"));
                $formBuilder->registerField(new \FormField("", "header", false, "Согласие на обработку персональных данных"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=consentDataProcessing\" role=\"button\">Скачать согласие на обработку персональных данных</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=consentDataProcessingEmpty\" role=\"button\">Скачать пустое согласие на обработку персональных данных</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Распечатать, заполнить оставшиеся поля, подписать, отсканировать в PDF и прикрепить."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfConsentDataProcessing()!="") {
                    $pdfConsentDataProcessing = "getConsentDataProcessing".$postFix;
                } else {
                    $pdfConsentDataProcessing = "";
                }

                $consentDataProcessingFile = new \FileField($pdfConsentDataProcessing,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_consent_data_processing", "file", false, "Прикрепить заявление (не более 10МБайт, формат: pdf)", "Не загружено заявление","Выбрать файл",false,"","?mode=getUserPhoto".$postFix,array(),array(),"",array(),2,$consentDataProcessingFile));


                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Заявление"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationFile}\" role=\"button\">Скачать заявление</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationEmptyFile}\" role=\"button\">Скачать пустое заявление</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Распечатать, заполнить оставшиеся поля, подписать, отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfApplication()!="") {
                    $pdfApplication = "getApplication".$postFix;
                } else {
                    $pdfApplication = "";
                }

                $applicationFile = new \FileField($pdfApplication,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_application", "file", false, "Прикрепить заявление (не более 10МБайт, формат: pdf)", "Не загружено заявление","Выбрать файл",false,"","?mode=getUserPhoto".$postFix,array(),array(),"",array(),2,$applicationFile));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Документ, удостоверяющий личность"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfPersonalDocument()!="") {
                    $personalDocument = "getPersonalDocument".$postFix;
                } else {
                    $personalDocument = "";
                }

                $personalDocumentFile = new \FileField($personalDocument,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_personal_document", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "Не загружен документ, удостоверяющий личность","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$personalDocumentFile));

                if(!$currentUser->isForDissertationAttachment()) {

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "СНИЛС"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "Отсканировать в PDF и прикрепить."));

                    if ($currentUser->getPdfPensionCertificate() != "") {
                        $pensionCertificate = "getPensionCertificate" . $postFix;
                    } else {
                        $pensionCertificate = "";
                    }

                    $pensionCertificateFile = new \FileField($pensionCertificate, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".pdf"), 10240 * 1024, $filePrefix, "pdf");
                    $formBuilder->registerField(new \FormField("pdf_pension_certificate", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "Не загружен СНИЛС", "Выбрать файл", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $pensionCertificateFile));

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Эссе по теме диссертации"));

                    if ($currentUser->getWordEssay() != "") {
                        $essay = "getEssay" . $postFix;
                    } else {
                        $essay = "";
                    }

                    $essayFile = new \FileField($essay, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".docx"), 10240 * 1024, $filePrefix, "docx");
                    $formBuilder->registerField(new \FormField("word_essay", "file", false, "Прикрепить документ (не более 10МБайт, формат: docx)", "Не загружено эссе", "Выбрать файл", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $essayFile));

                }

                if($currentUser->isForDissertationAttachment()) {

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Список научных трудов"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-word text-primary\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=scienceWork\" role=\"button\">Скачать список научных трудов</a>"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-word text-primary\"></i> <a target=\"_blank\" href=\"/files/File/ru/graduate_school/science_work.docx\" role=\"button\">Скачать пустой список научных трудов</a>"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/files/File/ru/graduate_school/instruction_science_work.pdf\" role=\"button\">Инструкция по заполнению списка научных трудов</a>"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "Распечатать, заполнить, подписать, отсканировать в PDF и прикрепить."));

                    if ($currentUser->getPdfScienceWorkList() != "") {
                        $scienceWorkList = "getScienceWorkList" . $postFix;
                    } else {
                        $scienceWorkList = "";
                    }

                    $scienceWorkListFile = new \FileField($scienceWorkList, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".pdf"), 10240 * 1024, $filePrefix, "pdf");
                    $formBuilder->registerField(new \FormField("pdf_science_work_list", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "Не загружен СНИЛС", "Выбрать файл", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $scienceWorkListFile));

                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Документ об образовании и о квалификации (с приложением)"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfEducation()!="") {
                    $education = "getEducation".$postFix;
                } else {
                    $education = "";
                }

                $educationFile = new \FileField($education,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_education", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$educationFile));

                if($currentUser->isForDissertationAttachment()) {

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Справка об обучении/периоде обучения"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "Прикрепить в PDF."));

                    if ($currentUser->getPdfEducationPeriodReference() != "") {
                        $educationPeriodReference = "getEducationPeriodReference" . $postFix;
                    } else {
                        $educationPeriodReference = "";
                    }

                    $educationPeriodReferenceFile = new \FileField($educationPeriodReference, $this->aspModule->getDownloadService()->getDocumentsUploadPath(), array(".pdf"), 10240 * 1024, $filePrefix, "pdf");
                    $formBuilder->registerField(new \FormField("pdf_education_period_reference", "file", false, "Прикрепить справку (не более 10МБайт, формат: pdf)", "", "Выбрать файл", false, "", "?mode=getUserPhoto", array(), array(), "", array(), 2, $educationPeriodReferenceFile));

                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Автобиография"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Прикрепить в PDF."));

                if($currentUser->getPdfAutoBiography()!="") {
                    $autobiography = "getAutobiography".$postFix;
                } else {
                    $autobiography = "";
                }

                $autobiographyFile = new \FileField($autobiography,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_autobiography", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$autobiographyFile));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Личный листок по учету кадров"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=personalSheet\" role=\"button\">Скачать личный листок по учету кадров</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=personalSheetEmpty\" role=\"button\">Скачать пустой личный листок по учету кадров</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Распечатать, заполнить оставшиеся поля, подписать, отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfPersonalSheet()!="") {
                    $personalSheet = "getPersonalSheet".$postFix;
                } else {
                    $personalSheet = "";
                }

                $personalSheetFile = new \FileField($personalSheet,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_personal_sheet", "file", false, "Прикрепить личный листок по учету кадров (не более 10МБайт, формат: pdf)", "Не загружен личный листок по учету кадров","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$personalSheetFile));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Документы, подтверждающие индивидуальные достижения"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Прикрепить в PDF."));

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
                $individualAchievementsComplexFields[] = new \FormField("pdf_individual_achievement", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)","","Выбрать файл", false,"","",array(),array(),"",array(),2,$individualAchievementFile);

                $formBuilder->registerField(new \FormField("pdf_individual_achievements", "complex-block", false, "Добавить индивидуальное достижение","","", false,"",$currentUser->getPdfIndividualAchievements(),array(),array(),"", $individualAchievementsComplexFields));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Документ, подтверждающий инвалидность (при необходимости создания специальных условий при проведении вступительных испытаний)"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Прикрепить в PDF."));

                if($currentUser->getPdfDisabledInfo()!="") {
                    $disabledInfo = "getDisabledInfo".$postFix;
                } else {
                    $disabledInfo = "";
                }

                $disabledInfoFile = new \FileField($disabledInfo,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_disabled_info", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$disabledInfoFile));



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
                           role="button">Вернуться к данным пользователя</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php
        if(!$status->isDocumentUploadAllow() && !$status->isAdminAllow()) {
            echo "Ошибка доступа.";
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