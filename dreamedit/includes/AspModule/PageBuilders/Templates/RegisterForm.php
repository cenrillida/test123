<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\RegisterFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class RegisterForm implements PageBuilder {
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
        global $DB,$_CONFIG, $site_templater;

        if($_SESSION[lang]!="/en") {
            $fieldOfStudies = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyList();
            $fieldOfStudySelectArr = array();
            foreach ($fieldOfStudies as $fieldOfStudy) {
                $fieldOfStudySelectArr[] = new \OptionField($fieldOfStudy->getId(),$fieldOfStudy->getName());
            }
            $forDissertationAttachmentSelectArr = array();
            $forDissertationAttachmentSelectArr[] = new \OptionField("0","�������� � �����������");
            $forDissertationAttachmentSelectArr[] = new \OptionField("1","������������ ��� ��������� �����������");

            $formBuilder = new RegisterFormBuilder("�� ��� e-mail ��������� ������ ��� ������������� �����������.","� ������������ ��������/��������","/files/File/graduate_school/","������������������");

            $formBuilder->registerField(new \FormField("lastname", "text", true, "�������", "�� ������� �������","������"));
            $formBuilder->registerField(new \FormField("firstname", "text", true, "���", "�� ������� ���","����"));
            $formBuilder->registerField(new \FormField("thirdname", "text", false, "��������", "","��������"));
            $formBuilder->registerField(new \FormField("email", "email", true, "E-mail", "�� ������ e-mail","example@imemo.ru",true,"�������� ������ e-mail"));
            $formBuilder->registerField(new \FormField("password", "password", true, "������", "�� ������ ������"));
            $formBuilder->registerField(new \FormField("phone", "text", true, "����� ��������", "�� ������ ����� ��������","+7999"));
            $formBuilder->registerField(new \FormField("birthdate", "date", true, "���� ��������", "�� ������� ���� ��������"));
            $formBuilder->registerField(new \FormField("field_of_study", "select", true, "������ ������� ��������������", "�� ������� ������ ������� ��������������","",false,"","",$fieldOfStudySelectArr));
            $formBuilder->registerField(new \FormField("for_dissertation_attachment", "select", true, "������ ��������� ��", "�� ������� ��� ������ ����������","",false,"","",$forDissertationAttachmentSelectArr));
            $posError = $formBuilder->processPostBuild();

        } else {
            $formBuilder = new RegisterFormBuilder("The registration approval message have been send to your e-mail.","Agree with rules","/files/File/graduate_school/","Register");
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
        ?>

        <div class="container-fluid">
            <div class="row justify-content-between mb-3">
                <div>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=login"
                           role="button">�� �������� �����������</a>
                    </div>
                </div>
                <div class="row justify-content-end">
                </div>
            </div>
        </div>
        <div class="mt-3"></div>

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
    }

}