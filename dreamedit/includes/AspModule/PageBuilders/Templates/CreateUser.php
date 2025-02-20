<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AddApplicationsYearFormBuilder;
use AspModule\FormBuilders\Templates\CreateUserFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class CreateUser implements PageBuilder {
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
        if($status->isAdminAllow()) {
            $sendText = "Пользователь успешно добавлен.";
            $buttonText = "Добавить";

            $forDissertationAttachmentSelectArr = array();
            $forDissertationAttachmentSelectArr[] = new \OptionField("0","Обучение в аспирантуре");
            $forDissertationAttachmentSelectArr[] = new \OptionField("1","Прикрепление для написания диссертации");

            $formBuilder = new CreateUserFormBuilder($sendText,"","",$buttonText,false);

            $formBuilder->registerField(new \FormField("lastname", "text", true, "Фамилия", "Не введена фамилия","Иванов"));
            $formBuilder->registerField(new \FormField("firstname", "text", true, "Имя", "Не введено имя","Иван"));
            $formBuilder->registerField(new \FormField("thirdname", "text", false, "Отчество", "","Иванович"));
            $formBuilder->registerField(new \FormField("email", "text", false, "E-mail", "Не введен e-mail","example@imemo.ru",false,"Неверный формат e-mail"));
            $formBuilder->registerField(new \FormField("for_dissertation_attachment", "select", false, "Документы поданы на", "Не выбрано тип подачи документов","",false,"","",$forDissertationAttachmentSelectArr));


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