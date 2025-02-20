<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AddDataFormBuilder;
use AspModule\FormBuilders\Templates\AdminEditFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class AddData implements PageBuilder {
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
        if($status->isAddDataAllow() || $status->isEditAddDataAllow() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {
                $genderArr = array(new \OptionField("�������","�������"),new \OptionField("�������","�������"));

                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "������. ������������ �� ����������.";
                        exit;
                    }
                    $this->aspModule->getUserService()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AdminEditFormBuilder("������ ������� ��������.","",__DIR__ . "/Documents/","��������",false);
                } else {
                    $currentUser = $admin;
                    $formBuilder = new AddDataFormBuilder("�� ������� ��������� ������.", "", __DIR__ . "/Documents/", "���������",false);
                }

                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new \FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $isPensionDocumentDontHave = "0";

                if($currentUser->isPensionCertificateDontHave()) {
                    $isPensionDocumentDontHave = "1";
                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "� ����"));
                $genderArr = $formBuilder->setSelectedOptionArr($genderArr,$currentUser->getGender());
                $formBuilder->registerField(new \FormField("gender", "select", true, "���", "�� ������ ���","",false,"","",$genderArr));
                $formBuilder->registerField(new \FormField("fio_r", "text", true, "��� � ����������� ������", "�� ������� ���","������� ����� ���������",false,"",$currentUser->getFioR()));
                $formBuilder->registerField(new \FormField("nationality", "text", true, "��������������", "�� ������� ��������������","�������",false,"",$currentUser->getNationality()));
                $formBuilder->registerField(new \FormField("citizenship", "text", true, "�����������", "�� ������� �����������","���������� ���������",false,"",$currentUser->getCitizenship()));
                $formBuilder->registerField(new \FormField("birthplace", "text", true, "����� ��������", "�� ������� ����� ��������","�. ������",false,"",$currentUser->getBirthplace()));
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "���������� ������"));
                $formBuilder->registerField(new \FormField("passport_series", "text", true, "����� ��������", "�� ������� ����� ��������","1234",false,"",$currentUser->getPassportSeries()));
                $formBuilder->registerField(new \FormField("passport_number", "text", true, "����� ��������", "�� ������ ����� ��������","123456",false,"",$currentUser->getPassportNumber()));
                $formBuilder->registerField(new \FormField("passport_place", "text", true, "�����", "�� ������� ����� ������ ��������","���������� ����...",false,"",$currentUser->getPassportPlace()));
                $formBuilder->registerField(new \FormField("passport_date", "date", true, "���� ������ ��������", "�� ������� ���� ������ ��������","",false,"",$currentUser->getPassportDate()));
                $formBuilder->registerField(new \FormField("passport_address", "text", true, "����� �����������", "�� ������ ����� �����������","���. ������, ��. �����������, ��� 23, �������� 2",false,"",$currentUser->getPassportAddress()));
                if(!$currentUser->isForDissertationAttachment()) {
                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "�����"));
                    $formBuilder->registerField(new \FormField("pension_certificate_dont_have", "checkbox", false, "� ���� ��� �����", "", "", false, "", $isPensionDocumentDontHave, array(), array()));
                    $pensionCertificateField = new \FormField("pension_certificate", "text", true, "����� �����", "�� ������ ����� �����","123-456-789 00",false,"",$currentUser->getPensionCertificate());
                    $pensionCertificateField->setSwitchableRequiredField("pension_certificate_dont_have");
                    $formBuilder->registerField($pensionCertificateField);
                }
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "����������"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "������ ������ 3�4 ����������. ����������� ���������� 180x240 �������� ��� �����."));


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
                $imageFile = new \FileField($currentUser->getPhoto(),$this->aspModule->getDownloadService()->getPhotoUploadPath(),array(".jpg",".png",".jpeg",".gif"),10240 * 1024,$imagePrefix,$fileType);
                $formBuilder->registerField(new \FormField("photo", "file", true, "���������� ���������� (�� ����� 10�����, ������: jpg,png,jpeg,gif)", "�� ��������� ����������","������� ����",false,"",$imageValue,array(),array(),"",array(),2,$imageFile));
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
                           role="button">��������� � ������ ������������</a>
                    </div>
                <?php endif;?>
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
        if($currentUser->isPensionCertificateDontHave()) {
            ?>
            <script>
                $( document ).ready(function() {
                    $('#pension_certificate').attr( "disabled", true );
                    $('#pension_certificate').attr( "disabled", true );
                });
            </script>
            <?php
        }
        ?>
        <script>
            $("#pension_certificate_dont_have").change(function() {
                if(this.checked) {
                    $('#pension_certificate').attr('disabled', true);
                    $('#pension_certificate').val('');
                } else {
                    $('#pension_certificate').attr('disabled', false);
                }
            });
        </script>
        <?php
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}