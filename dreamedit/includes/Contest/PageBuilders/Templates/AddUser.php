<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\PageBuilders\PageBuilder;

class AddUser implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * AddUser constructor.
     * @param Contest $contest
     * @param \Pages $pages
     */
    public function __construct(Contest $contest, $pages)
    {
        $this->contest = $contest;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin()) {
            $sendText = "Пользователь успешно добавлен.";
            $buttonText = "Добавить";
            $lastName = "";
            $firstName = "";
            $thirdName = "";
            $email = "";
            $isAdminRights = "0";
            $position = "";
            $imagePrefix = \UUID::v4();
            $imageValue = "?mode=getSign";
            $fileType = "";
            $sign = "";
            if(!empty($_GET['id'])) {
                $user = $this->contest->getUserService()->getUserById($_GET['id']);
                if(!empty($user) && (!$user->getStatus()->isAdmin() || $user->getStatus()->isCanVote())) {
                    $lastName = $user->getLastName();
                    $firstName = $user->getFirstName();
                    $thirdName = $user->getThirdName();
                    $sendText = "Данные обновлены.";
                    $buttonText = "Изменить";
                    $email = $user->getEmail();
                    $isAdminRights = $user->getStatus()->isAdmin();
                    $position = $user->getPosition();
                    $imagePrefix = preg_replace("/[^a-z0-9]/i","",$user->getEmail());
                    $imageValue .= "&user_id=".$user->getId();
                    $sign = $user->getSign();
                    if(!empty($sign)) {
                        $fileType = "image";
                    }
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array('error' => 'Пользователь не найден'));
                    exit;
                }
            }


            $formBuilder = new AddUserFormBuilder($sendText, "", "", $buttonText, false);

            $formBuilder->registerField(new \FormField("lastname", "text", true, "Фамилия", "Не введена фамилия","",false,"",$lastName));
            $formBuilder->registerField(new \FormField("firstname", "text", false, "Имя", "Не введено имя","",false,"",$firstName));
            $formBuilder->registerField(new \FormField("thirdname", "text", false, "Отчество", "Не введено отчество","",false,"",$thirdName));
            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail","example@imemo.ru",true,"Неверный формат e-mail",$email));
            $formBuilder->registerField(new \FormField("position", "text", false, "Должность", "","",false,"",$position));
            $formBuilder->registerField(new \FormField("admin", "checkbox", false, "С правами администратора", "","",false,"",$isAdminRights,array(),array()));
//            $formBuilder->registerField(new \FormField("", "hr", false, ""));
//            $formBuilder->registerField(new \FormField("", "header", false, "Подпись"));
//            $imageFile = new \FileField($sign,$this->contest->getDownloadService()->getSignsUploadPath(),array(".jpg",".png",".jpeg",".gif"),10240 * 1024,$imagePrefix,$fileType);
//            $formBuilder->registerField(new \FormField("sign", "file", false, "Прикрепить подпись (размер 240х70, не более 10МБайт, формат: jpg,png,jpeg,gif)", "","Выбрать файл",false,"",$imageValue,array(),array(),"",array(),2,$imageFile));

            if(empty($_GET['id'])) {
                $formBuilder->registerField(new \FormField("password", "password", true, "Пароль", "Не введен пароль"));
            }
            $posError = $formBuilder->processPostBuild();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
            $this->contest->getPageBuilderManager()->setPageBuilder("top");
            $this->contest->getPageBuilder()->build(array("main_back" => true));

            ?>
            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=usersList"
                           role="button">Вернуться к списку</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </div>

            <?php

            if(!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?=$posError?>
                </div>
                <?php
            }

            $formBuilder->build();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }


    }

}