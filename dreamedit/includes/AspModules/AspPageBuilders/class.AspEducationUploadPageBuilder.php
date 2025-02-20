<?php

class AspEducationUploadPageBuilder implements AspPageBuilder {
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

        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus());
        if(($status->isEducationCanUpload() && $currentUser->getPdfEducation()=="") || ($status->isEducationCanUpload() && $status->isDocumentSendAllow())) {
            if($_SESSION[lang]!="/en") {

                $formBuilder = new AspDocumentUploadFormBuilder("Вы успешно загрузили документы.","",__DIR__."/Documents/","Отправить");


                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Необходимо дозаполнить заявление и заново прикрепить. Дата заполняется такая же, как в ранее поданом заявлении."));
                $formBuilder->registerField(new FormField("", "header", false, "Заявление"));
                $formBuilder->registerField(new FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=application\" role=\"button\">Скачать заявление</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "При необходимости: <i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=createDocument&file=applicationEmpty\" role=\"button\">Скачать пустое заявление</a>"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Распечатать, заполнить оставшиеся поля, подписать, отсканировать в PDF и прикрепить."));

                $filePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());

                if($currentUser->getPdfApplication()!="") {
                    $pdfApplication = "getApplication";
                } else {
                    $pdfApplication = "";
                }

                $applicationFile = new FileField($pdfApplication,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_application", "file", false, "Прикрепить заявление (не более 10МБайт, формат: pdf)", "Не загружено заявление","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$applicationFile));


                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Документ об образовании и о квалификации (с приложением)"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Отсканировать в PDF и прикрепить."));

                if($currentUser->getPdfEducation()!="") {
                    $education = "getEducation";
                } else {
                    $education = "";
                }

                $educationFile = new FileField($education,$this->aspModule->getAspDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf");
                $formBuilder->registerField(new FormField("pdf_education", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)", "","Выбрать файл",false,"","?mode=getUserPhoto",array(),array(),"",array(),2,$educationFile));

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