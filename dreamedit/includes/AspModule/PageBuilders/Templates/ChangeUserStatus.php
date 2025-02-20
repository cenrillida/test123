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
                echo "������. ������������ �� ����������.";
                exit;
            }
            $user = $this->aspModule->getUserService()->getUserById($_GET['id']);
            if(empty($user)) {
                echo "������. ������������ �� ����������.";
                exit;
            }
            $this->aspModule->getUserService()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $statusArr = array();

                foreach ($this->aspModule->getStatusService()->getAllStatuses() as $allStatus) {
                    $statusArr[] = new \OptionField($allStatus->getId(),$allStatus->getText());
                }

                $applicationsYearArr = array();

                $applicationsYearArr[] = new \OptionField(0,"�� ���������");
                foreach ($this->aspModule->getApplicationsYearService()->getApplicationsYearList() as $applicationsYear) {
                    $applicationsYearArr[] = new \OptionField($applicationsYear->getId(), $applicationsYear->getName());
                }

                $formBuilder = new ChangeUserStatusFormBuilder("�� ������� �������� ������ ��� ������������.","",__DIR__."/Documents/","���������", false);

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $fioR = $user->getFioR();
                if(empty($fioR)) {
                    $fioR = $user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName();
                }
                $formBuilder->registerField(new \FormField("", "header", false, "��������� ������� ��� ".$fioR));
                $formBuilder->registerField(new \FormField("application_year", "select", false, "�����", "","",false,"",$user->getApplicationsYear()->getId(),$applicationsYearArr));
                $formBuilder->registerField(new \FormField("status", "select", true, "������", "","",false,"",$user->getStatus(),$statusArr));
                $formBuilder->registerField(new \FormField("comment_from_admin", "textarea", false, "����������� ��� ������������", "","",false,"",$user->getCommentFromAdmin(),array(),array(),"",array(),10));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "������� ����������� ����������� ����"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "�������� ���� � �������� ����� ������"));

                $fieldValueArr = $this->aspModule->getFieldErrorService()->getCurrentUserFieldErrorList($user);

                $fieldsArr = array();
                foreach ($fieldValueArr as $k=>$value) {
                    $fieldsArr[] = new \OptionField($k,$value);
                }
                $workComplexFields = array();
                $workComplexFields[] = new \FormField("", "form-row", false, "");
                $workComplexFields[] = new \FormField("field_error_id", "select", false, "����","","", false,"","",$fieldsArr,array(),"col-lg-12");
                $workComplexFields[] = new \FormField("field_error_text", "text", false, "������","","", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new \FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new \FormField("fields_error", "complex-block", false, "�������� ������","","", false,"",$user->getFieldsError(),array(),array(),"", $workComplexFields));

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