<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\ChangeUserStatusFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class ChangeUserStatus implements PageBuilder {
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
            if(empty($_GET['id'])) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $user = $this->aspModule->getUserService()->getUserById($_GET['id']);
            if(empty($user)) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $this->aspModule->getUserService()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $statusArr = array();

                foreach ($this->aspModule->getStatusService()->getAllStatuses() as $allStatus) {
                    $statusArr[] = new \OptionField($allStatus->getId(),$allStatus->getText());
                }

                $applicationsYearArr = array();

                $applicationsYearArr[] = new \OptionField(0,"Не определен");
                foreach ($this->aspModule->getApplicationsYearService()->getApplicationsYearList() as $applicationsYear) {
                    $applicationsYearArr[] = new \OptionField($applicationsYear->getId(), $applicationsYear->getName());
                }

                $formBuilder = new ChangeUserStatusFormBuilder("Вы успешно изменили статус для пользователя.","",__DIR__."/Documents/","Отправить", false);

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $fioR = $user->getFioR();
                if(empty($fioR)) {
                    $fioR = $user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName();
                }
                $formBuilder->registerField(new \FormField("", "header", false, "Изменения статуса для ".$fioR));
                $formBuilder->registerField(new \FormField("application_year", "select", false, "Прием", "","",false,"",$user->getApplicationsYear()->getId(),$applicationsYearArr));
                $formBuilder->registerField(new \FormField("status", "select", true, "Статус", "","",false,"",$user->getStatus(),$statusArr));
                $formBuilder->registerField(new \FormField("comment_from_admin", "textarea", false, "Комментарий для пользователя", "","",false,"",$user->getCommentFromAdmin(),array(),array(),"",array(),10));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Указать неправильно заполненные поля"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "Выберите поле и напишите текст ошибки"));

                $fieldValueArr = $this->aspModule->getFieldErrorService()->getCurrentUserFieldErrorList($user);

                $fieldsArr = array();
                foreach ($fieldValueArr as $k=>$value) {
                    $fieldsArr[] = new \OptionField($k,$value);
                }
                $workComplexFields = array();
                $workComplexFields[] = new \FormField("", "form-row", false, "");
                $workComplexFields[] = new \FormField("field_error_id", "select", false, "Поле","","", false,"","",$fieldsArr,array(),"col-lg-12");
                $workComplexFields[] = new \FormField("field_error_text", "text", false, "Ошибка","","", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new \FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new \FormField("fields_error", "complex-block", false, "Добавить ошибку","","", false,"",$user->getFieldsError(),array(),array(),"", $workComplexFields));

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