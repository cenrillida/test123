<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AddApplicationsYearFormBuilder;
use AspModule\FormBuilders\Templates\CreateUserFormBuilder;
use AspModule\FormBuilders\Templates\DocumentApplicationControlFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class DocumentApplicationControl implements PageBuilder {
    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($admin->getStatus());
        if($status->isAdminAllow()) {
            $sendText = "Настройки успешно сохранены.";
            $buttonText = "Сохранить";

            $forDissertationAttachmentSelectArr = array();
            $forDissertationAttachmentSelectArr[] = new \OptionField("0","Обучение в аспирантуре");
            $forDissertationAttachmentSelectArr[] = new \OptionField("1","Прикрепление для написания диссертации");

            $isOpenedStudy = "0";
            $isOpenedDissertation = "0";

            if($this->aspModule->getDocumentApplicationStatusService()->isOpenedStudy()) {
                $isOpenedStudy = "1";
            }
            if($this->aspModule->getDocumentApplicationStatusService()->isOpenedDissertation()) {
                $isOpenedDissertation = "1";
            }

            $formBuilder = new DocumentApplicationControlFormBuilder($sendText,"","",$buttonText,false);

            $formBuilder->registerField(new \FormField("application_opened", "checkbox", false, "Подача документов открыта (обучение)", "", "", false, "", $isOpenedStudy, array(), array()));
            $formBuilder->registerField(new \FormField("application_closed_text", "textarea", false, "Текст, если подача документов закрыта (обучение)","","", false,"",$this->aspModule->getDocumentApplicationStatusService()->getClosedTextStudy(),array(),array(),"", array(),10));
            $formBuilder->registerField(new \FormField("application_dissertation_opened", "checkbox", false, "Подача документов открыта (прикрепление)", "", "", false, "", $isOpenedDissertation, array(), array()));
            $formBuilder->registerField(new \FormField("application_dissertation_closed_text", "textarea", false, "Текст, если подача документов закрыта (прикрепление)","","", false,"",$this->aspModule->getDocumentApplicationStatusService()->getClosedTextDissertation(),array(),array(),"", array(),10));

            $posError = $formBuilder->processPostBuild();
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <?php
        if(!$status->isAdminAllow()) {
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