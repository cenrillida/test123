<?php

class AspDocumentUploadPageBuilder implements AspPageBuilder {
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
        if($status->isDocumentUploadAllow() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {


                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AspAdminEditFormBuilder("Данные успешно изменены.","",__DIR__ . "/Documents/","Изменить");
                } else {
                    $currentUser = $admin;
                    $formBuilder = new AspDocumentUploadFormBuilder("Вы успешно загрузили документы.","",__DIR__."/Documents/","Отправить");
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
                $formBuilder->registerField(new FormField("", "header", false, "Если у Вас много документов и не получается загрузить все сразу, попробуйте загружать по одному"));
                $formBuilder->registerField(new FormField("", "header", false, "Заявление"));
                $formBuilder->registerField(new FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=application\" role=\"button\">Скачать заявление</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=applicationEmpty\" role=\"button\">Скачать пустое заявление</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Распечатать, заполнить оставшиеся поля, подписать, отсканировать в PDF и прикрепить."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfApplication()!="") {
                    $pdfApplication = "getApplication".$postFix;
                } else {
                    $pdfApplication = "";
                }

                $applicationFile = new FileField($pdfApplication,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_application", "file", false, "Прикрепить заявление (не более 10МБайт, формат: pdf)", "Не загружено заявление","Выбрать файл",false,"","?mode=getUserPhoto".$postFix,array(),array(),"",array(),2,$applicationFile));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Документ, удостоверяющий личность"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfPersonalDocument()!="") {
                    $personalDocument = "getPersonalDocument".$postFix;
                } else {
                    $personalDocument = "";
                }

                $personalDocumentFile = new FileField($personalDocument,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_personal_document", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "Не загружен документ, удостоверяющий личность","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$personalDocumentFile));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Документ об образовании и о квалификации (с приложением)"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfEducation()!="") {
                    $education = "getEducation".$postFix;
                } else {
                    $education = "";
                }

                $educationFile = new FileField($education,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_education", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$educationFile));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Автобиография"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Прикрепить в PDF."));

                if($currentUser->getPdfAutoBiography()!="") {
                    $autobiography = "getAutobiography".$postFix;
                } else {
                    $autobiography = "";
                }

                $autobiographyFile = new FileField($autobiography,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_autobiography", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$autobiographyFile));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Личный листок по учету кадров"));
                $formBuilder->registerField(new FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=personalSheet\" role=\"button\">Скачать личный листок по учету кадров</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=personalSheetEmpty\" role=\"button\">Скачать пустой личный листок по учету кадров</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Распечатать, заполнить оставшиеся поля, подписать, отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfPersonalSheet()!="") {
                    $personalSheet = "getPersonalSheet".$postFix;
                } else {
                    $personalSheet = "";
                }

                $personalSheetFile = new FileField($personalSheet,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_personal_sheet", "file", false, "Прикрепить личный листок по учету кадров (не более 10МБайт, формат: pdf)", "Не загружен личный листок по учету кадров","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$personalSheetFile));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Документы, подтверждающие индивидуальные достижения"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Прикрепить в PDF."));

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
                $individualAchievementFile = new FileField($currentUser->getPdfIndividualAchievements(),$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf",$changableIndividualAchievements);
                $individualAchievementsComplexFields[] = new FormField("pdf_individual_achievement", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)","","Выбрать файл", false,"","",array(),array(),"",array(),2,$individualAchievementFile);

                $formBuilder->registerField(new FormField("pdf_individual_achievements", "complex-block", false, "Добавить индивидуальное достижение","","", false,"",$currentUser->getPdfIndividualAchievements(),array(),array(),"", $individualAchievementsComplexFields));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Документ, подтверждающий инвалидность (при необходимости создания специальных условий при проведении вступительных испытаний)"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Прикрепить в PDF."));

                if($currentUser->getPdfDisabledInfo()!="") {
                    $disabledInfo = "getDisabledInfo".$postFix;
                } else {
                    $disabledInfo = "";
                }

                $disabledInfoFile = new FileField($disabledInfo,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_disabled_info", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$disabledInfoFile));



                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        $exitPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_login");
        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-1">
                <div class="text-danger">Внимание! Документы считаются поданными только после нажатия на кнопку "Подать документы".</div>
            </div>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode'])):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                           role="button">Вернуться в личный кабинет</a>
                    </div>
                    <?php endif;?>
                    <?php if(!empty($currentUser) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$currentUser->getId()?>"
                               role="button">Вернуться к данным пользователя</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">Инструкция по работе с личным кабинетом</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                           role="button">Техническая поддержка</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">Выход</a>
                    </div>
                </div>
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