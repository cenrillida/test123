<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\AddUserFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class AddUser implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * AddUser constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->dissertationCouncils->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin()) {
            $sendText = "Пользователь успешно добавлен.";
            $buttonText = "Добавить";
            $lastName = "";
            $firstName = "";
            $thirdName = "";
            $email = "";
            $isAdminRights = "0";
            $phone = "";

            if(!empty($_GET['id'])) {
                $user = $this->dissertationCouncils->getUserService()->getUserById($_GET['id']);
                if(!empty($user) && (!$user->getStatus()->isAdmin() || $user->getStatus()->isCanVote())) {
                    $lastName = $user->getLastName();
                    $firstName = $user->getFirstName();
                    $thirdName = $user->getThirdName();
                    $sendText = "Данные обновлены.";
                    $buttonText = "Изменить";
                    $email = $user->getEmail();
                    $isAdminRights = $user->getStatus()->isAdmin();
                    $phone = $user->getPhone();
                } else {
                    $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                    $this->dissertationCouncils->getPageBuilder()->build(array('error' => 'Пользователь не найден'));
                    exit;
                }
            }


            $formBuilder = new AddUserFormBuilder($sendText, "", "", $buttonText, false);

            $formBuilder->registerField(new \FormField("lastname", "hidden", false, "Фамилия", "Не введена фамилия","",false,"",$lastName));
            $formBuilder->registerField(new \FormField("firstname", "hidden", false, "Имя", "Не введено имя","",false,"",$firstName));
            $formBuilder->registerField(new \FormField("thirdname", "hidden", false, "Отчество", "Не введено отчество","",false,"",$thirdName));
            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "Не введен e-mail","example@imemo.ru",true,"Неверный формат e-mail",$email));
            $formBuilder->registerField(new \FormField("phone", "text", false, "Телефон", "","+79031234567",false,"",$phone));

//            if(empty($_GET['id'])) {
//                $formBuilder->registerField(new \FormField("password", "password", true, "Пароль", "Не введен пароль"));
//            }
            $posError = $formBuilder->processPostBuild();

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("top");
            $this->dissertationCouncils->getPageBuilder()->build(array("main_back" => true));

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
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }


    }

}