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
                echo "������. ������������ �� ����������.";
                exit;
            }
            $user = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
            if(empty($user)) {
                echo "������. ������������ �� ����������.";
                exit;
            }
            $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $fieldOfStudies = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyList();
                $fieldOfStudySelectArr = array();
                foreach ($fieldOfStudies as $fieldOfStudy) {
                    $fieldOfStudySelectArr[] = new OptionField($fieldOfStudy->getId(),$fieldOfStudy->getName());
                }

                $formBuilder = new AspAdminEditFormBuilder("������ ������� ��������.","","/files/File/graduate_school/","��������");

                $formBuilder->registerField(new FormField("lastname", "text", true, "�������", "�� ������� �������","������",false,"",$user->getLastName()));
                $formBuilder->registerField(new FormField("firstname", "text", true, "���", "�� ������� ���","����",false,"",$user->getFirstName()));
                $formBuilder->registerField(new FormField("thirdname", "text", false, "��������", "","��������",false,"",$user->getThirdName()));
                $formBuilder->registerField(new FormField("email", "email", true, "E-mail", "�� ������ e-mail","example@imemo.ru",true,"�������� ������ e-mail",$user->getEmail()));
                $formBuilder->registerField(new FormField("phone", "text", true, "����� ��������", "�� ������ ����� ��������","+7999",false,"",$user->getPhone()));
                $formBuilder->registerField(new FormField("birthdate", "date", true, "���� ��������", "�� ������� ���� ��������","",false,"",$user->getBirthDate()));
                $formBuilder->registerField(new FormField("field_of_study", "select", true, "����������� ����������", "�� ������� �����������","",false,"",$user->getFieldOfStudy(),$fieldOfStudySelectArr));

                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        $exitPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_login");
        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-1">
                <div class="text-danger">��������! ��������� ��������� ��������� ������ ����� ������� �� ������ "������ ���������".</div>
            </div>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode'])):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                           role="button">��������� � ������ �������</a>
                    </div>
                    <?php endif;?>
                    <?php if(!empty($user) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$user->getId()?>"
                               role="button">��������� � ������ ������������</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">���������� �� ������ � ������ ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                           role="button">����������� ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">�����</a>
                    </div>
                </div>
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