<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AdminEditFormBuilder;
use AspModule\FormBuilders\Templates\ApplyForEntryFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class ApplyForEntry implements PageBuilder {
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
        if($status->isCanApplyForEntry() || $status->isCanEditApplyForEntry() || $status->isAdminAllow()) {
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
                    $formBuilder = new AdminEditFormBuilder("Данные успешно изменены.","",__DIR__ . "/Documents/","Изменить", false);
                } else {
                    $currentUser = $admin;
                    $formBuilder = new ApplyForEntryFormBuilder("Вы успешно заполнили данные.","","/files/File/graduate_school/","Отправить", false);
                }

                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new \FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $willPayEntry = "0";
                $willBudgetEntry = "0";

                if($currentUser->isWillPayEntry()) {
                    $willPayEntry = "1";
                }
                if($currentUser->isWillBudgetEntry()) {
                    $willBudgetEntry = "1";
                }

                $formBuilder->registerField(new \FormField("", "header", false, "Условия поступления"));
                $formBuilder->registerField(new \FormField("will_budget_entry", "checkbox", false, "На основные места в рамках контрольных цифр приема", "","",false,"",$willBudgetEntry,array(),array()));
                $formBuilder->registerField(new \FormField("will_pay_entry", "checkbox", false, "На места по договору об оказании платных образовательных услуг", "","",false,"",$willPayEntry,array(),array()));

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
        if(!$status->isCanApplyForEntry() && !$status->isCanEditApplyForEntry() && !$status->isAdminAllow()) {
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