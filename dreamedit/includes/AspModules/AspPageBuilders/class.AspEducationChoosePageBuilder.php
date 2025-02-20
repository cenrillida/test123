<?php

class AspEducationChoosePageBuilder implements AspPageBuilder {
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

                $formBuilder = new AspDocumentApplicationFormBuilder("Вы успешно заполнили данные.","","/files/File/graduate_school/","Отправить");

                $diplomSelectArr = array();
                $diplomSelectArr[] = new OptionField("","");
                $diplomSelectArr[] = new OptionField("магистра","Магистра");
                $diplomSelectArr[] = new OptionField("специалиста","Специалиста");

                $diplom = $formBuilder->setSelectedOptionArr($diplomSelectArr,$currentUser->getDiplom());
                $formBuilder->registerField(new FormField("diplom", "select", false, "Диплом", "Не выбран тип диплома","",false,"","",$diplom));
                $formBuilder->registerField(new FormField("", "form-row", false, ""));
                $formBuilder->registerField(new FormField("diplom_series", "text", false, "Серия диплома","Не указана серия диплома","123456", false,"",$currentUser->getDiplomSeries(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("diplom_number", "text", false, "Номер диплома","Не указан номер диплома","1234567", false,"",$currentUser->getDiplomNumber(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("diplom_date", "date", false, "Дата выдачи диплома","Не указана дата выдачи диплома","", false,"",$currentUser->getDiplomDate(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("", "form-row-end", false, ""));

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