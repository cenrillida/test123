<?php

class AspAddDataPageBuilder implements AspPageBuilder {
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
        if($status->isAddDataAllow() || $status->isEditAddDataAllow() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {
                $genderArr = array(new OptionField("�������","�������"),new OptionField("�������","�������"));

                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AspAdminEditFormBuilder("������ ������� ��������.","",__DIR__ . "/Documents/","��������");
                } else {
                    $currentUser = $admin;
                    $formBuilder = new AspAddDataFormBuilder("�� ������� ��������� ������.", "", __DIR__ . "/Documents/", "���������");
                }

                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "� ����"));
                $genderArr = $formBuilder->setSelectedOptionArr($genderArr,$currentUser->getGender());
                $formBuilder->registerField(new FormField("gender", "select", true, "���", "�� ������ ���","",false,"","",$genderArr));
                $formBuilder->registerField(new FormField("fio_r", "text", true, "��� � ����������� ������", "�� ������� ���","������� ����� ���������",false,"",$currentUser->getFioR()));
                $formBuilder->registerField(new FormField("nationality", "text", true, "��������������", "�� ������� ��������������","�������",false,"",$currentUser->getNationality()));
                $formBuilder->registerField(new FormField("citizenship", "text", true, "�����������", "�� ������� �����������","���������� ���������",false,"",$currentUser->getCitizenship()));
                $formBuilder->registerField(new FormField("birthplace", "text", true, "����� ��������", "�� ������� ����� ��������","�. ������",false,"",$currentUser->getBirthplace()));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "���������� ������"));
                $formBuilder->registerField(new FormField("passport_series", "text", true, "����� ��������", "�� ������� ����� ��������","1234",false,"",$currentUser->getPassportSeries()));
                $formBuilder->registerField(new FormField("passport_number", "text", true, "����� ��������", "�� ������ ����� ��������","123456",false,"",$currentUser->getPassportNumber()));
                $formBuilder->registerField(new FormField("passport_place", "text", true, "�����", "�� ������� ����� ������ ��������","���������� ����...",false,"",$currentUser->getPassportPlace()));
                $formBuilder->registerField(new FormField("passport_date", "date", true, "���� ������ ��������", "�� ������� ���� ������ ��������","",false,"",$currentUser->getPassportDate()));
                $formBuilder->registerField(new FormField("passport_address", "text", true, "����� �����������", "�� ������ ����� �����������","���. ������, ��. �����������, ��� 23, �������� 2",false,"",$currentUser->getPassportAddress()));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "����������"));
                $formBuilder->registerField(new FormField("", "header-text", false, "������ ������ 3�4 ����������. ����������� ���������� 180x240 �������� ��� �����."));


                $imagePrefix = preg_replace("/[^a-z0-9]/i","",$currentUser->getEmail());
                $photo = $currentUser->getPhoto();
                if(!empty($photo)) {
                    $fileType = "image";
                } else {
                    $fileType = "";
                }
                $imageValue = "?mode=getUserPhoto";
                if($status->isAdminAllow()) {
                    $imageValue .= "&user_id=".$currentUser->getId();
                }
                $imageFile = new FileField($currentUser->getPhoto(),$this->aspModule->getAspDownloadService()->getPhotoUploadPath(),array(".jpg",".png",".jpeg",".gif"),10240 * 1024,$imagePrefix,$fileType);
                $formBuilder->registerField(new FormField("photo", "file", true, "���������� ���������� (�� ����� 10�����, ������: jpg,png,jpeg,gif)", "�� ��������� ����������","������� ����",false,"",$imageValue,array(),array(),"",array(),2,$imageFile));
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
                    <?php if(!empty($currentUser) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$currentUser->getId()?>"
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
        if(!$status->isAddDataAllow() && !$status->isEditAddDataAllow() && !$status->isAdminAllow()) {
            echo "�� ��� ��������� ������.";
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