<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AdminEditFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class EditReg implements PageBuilder {
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
            if(empty($_GET['user_id'])) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $user = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
            if(empty($user)) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $this->aspModule->getUserService()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $fieldOfStudies = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyList();
                $fieldOfStudySelectArr = array();
                foreach ($fieldOfStudies as $fieldOfStudy) {
                    $fieldOfStudySelectArr[] = new \OptionField($fieldOfStudy->getId(),$fieldOfStudy->getName());
                }

                $formBuilder = new AdminEditFormBuilder("Данные успешно изменены.","","/files/File/graduate_school/","Изменить", false);

                $formBuilder->registerField(new \FormField("lastname", "text", true, "Фамилия", "Не введена фамилия","Иванов",false,"",$user->getLastName()));
                $formBuilder->registerField(new \FormField("firstname", "text", true, "Имя", "Не введено имя","Иван",false,"",$user->getFirstName()));
                $formBuilder->registerField(new \FormField("thirdname", "text", false, "Отчество", "","Иванович",false,"",$user->getThirdName()));
                $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail","example@imemo.ru",true,"Неверный формат e-mail",$user->getEmail()));
                $formBuilder->registerField(new \FormField("phone", "text", true, "Номер телефона", "Не введен номер телефона","+7999",false,"",$user->getPhone()));
                $formBuilder->registerField(new \FormField("birthdate", "date", true, "Дата рождения", "Не введена дата рождения","",false,"",$user->getBirthDate()));
                $formBuilder->registerField(new \FormField("field_of_study", "select", true, "Группа научных специальностей", "Не выбрана группа научных специальностей","",false,"",$user->getFieldOfStudy(),$fieldOfStudySelectArr));

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
                <?php if(!empty($admin) && $status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$user->getId()?>"
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