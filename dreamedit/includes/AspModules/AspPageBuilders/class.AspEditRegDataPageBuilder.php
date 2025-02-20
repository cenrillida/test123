<?php

class AspEditRegDataPageBuilder implements AspPageBuilder {
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
        if($status->isAdminAllow()) {
            if(empty($_GET['user_id'])) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $user = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
            if(empty($user)) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $fieldOfStudies = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyList();
                $fieldOfStudySelectArr = array();
                foreach ($fieldOfStudies as $fieldOfStudy) {
                    $fieldOfStudySelectArr[] = new OptionField($fieldOfStudy->getId(),$fieldOfStudy->getName());
                }

                $formBuilder = new AspAdminEditFormBuilder("Данные успешно изменены.","","/files/File/graduate_school/","Изменить");

                $formBuilder->registerField(new FormField("lastname", "text", true, "Фамилия", "Не введена фамилия","Иванов",false,"",$user->getLastName()));
                $formBuilder->registerField(new FormField("firstname", "text", true, "Имя", "Не введено имя","Иван",false,"",$user->getFirstName()));
                $formBuilder->registerField(new FormField("thirdname", "text", false, "Отчество", "","Иванович",false,"",$user->getThirdName()));
                $formBuilder->registerField(new FormField("email", "email", true, "E-mail", "Не введен e-mail","example@imemo.ru",true,"Неверный формат e-mail",$user->getEmail()));
                $formBuilder->registerField(new FormField("phone", "text", true, "Номер телефона", "Не введен номер телефона","+7999",false,"",$user->getPhone()));
                $formBuilder->registerField(new FormField("birthdate", "date", true, "Дата рождения", "Не введена дата рождения","",false,"",$user->getBirthDate()));
                $formBuilder->registerField(new FormField("field_of_study", "select", true, "Направление подготовки", "Не выбрано направление","",false,"",$user->getFieldOfStudy(),$fieldOfStudySelectArr));

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
                    <?php if(!empty($user) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$user->getId()?>"
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