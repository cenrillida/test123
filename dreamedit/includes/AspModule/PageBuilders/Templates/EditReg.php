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
                echo "������. ������������ �� ����������.";
                exit;
            }
            $user = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
            if(empty($user)) {
                echo "������. ������������ �� ����������.";
                exit;
            }
            $this->aspModule->getUserService()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $fieldOfStudies = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyList();
                $fieldOfStudySelectArr = array();
                foreach ($fieldOfStudies as $fieldOfStudy) {
                    $fieldOfStudySelectArr[] = new \OptionField($fieldOfStudy->getId(),$fieldOfStudy->getName());
                }

                $formBuilder = new AdminEditFormBuilder("������ ������� ��������.","","/files/File/graduate_school/","��������", false);

                $formBuilder->registerField(new \FormField("lastname", "text", true, "�������", "�� ������� �������","������",false,"",$user->getLastName()));
                $formBuilder->registerField(new \FormField("firstname", "text", true, "���", "�� ������� ���","����",false,"",$user->getFirstName()));
                $formBuilder->registerField(new \FormField("thirdname", "text", false, "��������", "","��������",false,"",$user->getThirdName()));
                $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "�� ������ e-mail","example@imemo.ru",true,"�������� ������ e-mail",$user->getEmail()));
                $formBuilder->registerField(new \FormField("phone", "text", true, "����� ��������", "�� ������ ����� ��������","+7999",false,"",$user->getPhone()));
                $formBuilder->registerField(new \FormField("birthdate", "date", true, "���� ��������", "�� ������� ���� ��������","",false,"",$user->getBirthDate()));
                $formBuilder->registerField(new \FormField("field_of_study", "select", true, "������ ������� ��������������", "�� ������� ������ ������� ��������������","",false,"",$user->getFieldOfStudy(),$fieldOfStudySelectArr));

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
                           role="button">��������� � ������ ������������</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php
        if(!$status->isAdminAllow()) {
            echo "������ �������.";
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