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

                $formBuilder = new DocumentUploadFormBuilder("Вы успешно загрузили документы.","",__DIR__."/Documents/","Отправить", false);


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
                $formBuilder->registerField(new \FormField("", "header", false, "Необходимо дозаполнить заявление и заново прикрепить. Дата заполняется такая же, как в ранее поданом заявлении."));
                $formBuilder->registerField(new \FormField("", "header", false, "Заявление"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationFile}\" role=\"button\">Скачать заявление</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file={$applicationEmptyFile}\" role=\"button\">Скачать пустое заявление</a>"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Распечатать, заполнить оставшиеся поля, подписать, отсканировать в PDF и прикрепить."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfApplication()!="") {
                    $pdfApplication = "getApplication";
                } else {
                    $pdfApplication = "";
                }

                $applicationFile = new \FileField($pdfApplication,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_application", "file", false, "Прикрепить заявление (не более 10МБайт, формат: pdf)", "Не загружено заявление","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$applicationFile));


                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Документ об образовании и о квалификации (с приложением)"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfEducation()!="") {
                    $education = "getEducation";
                } else {
                    $education = "";
                }

                $educationFile = new \FileField($education,$this->aspModule->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new \FormField("pdf_education", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$educationFile));

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
            echo "Ошибка доступа.";
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}