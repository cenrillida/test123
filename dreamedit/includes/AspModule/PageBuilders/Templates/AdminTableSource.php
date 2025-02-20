<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class AdminTableSource implements PageBuilder {
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
        $currentUser = $this->aspModule->getCurrentUser();

        if($this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus())->isAdminAllow()) {
            header("Content-type: application/json");

            $rows = array();

            if(!empty($_GET['applications_year_id']) || $_GET['applications_year_id']==='0') {
                $users = $this->aspModule->getUserService()->getAllUsersByApplicationsYearId($_GET['applications_year_id'],"pdf_last_upload_date","DESC");
            } else {
                $users = $this->aspModule->getUserService()->getAllUsers("pdf_last_upload_date","DESC");
            }

            $counter = 0;
            foreach ($users as $user) {
                $rows[$counter] = array();
                if($user->getId() != 1) {
                    $rows[$counter]['del'] = "<div class=\"del-button\"><a href=\"#\" onclick=\"deleteLoginGet({$user->getId()})\"><i class=\"dxi dxi-close\"></i></a></div>";
                }
                $rows[$counter]['fio'] = \Dreamedit::normJsonStr($user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName());
                $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyById($user->getFieldOfStudy());
                if(!empty($fieldOfStudy)) {
                    $fieldOfStudy = $fieldOfStudy->getName();
                } else {
                    $fieldOfStudy = "";
                }
                $rows[$counter]['field_of_study'] = \Dreamedit::normJsonStr($fieldOfStudy);
                $fieldOfStudyProfile = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyProfileById($user->getFieldOfStudyProfile());
                if(!empty($fieldOfStudyProfile)) {
                    $fieldOfStudyProfile = $fieldOfStudyProfile->getName();
                } else {
                    $fieldOfStudyProfile = "";
                }
                if($user->isForDissertationAttachment()) {
                    $documentApplicationFor = "Прикрепление";
                } else {
                    $documentApplicationFor = "Обучение";
                }
                $rows[$counter]['pension_certificate_or_special_code'] = \Dreamedit::normJsonStr($user->getPensionCertificateOrCode());
                $rows[$counter]['document_application_for'] = \Dreamedit::normJsonStr($documentApplicationFor);
                $rows[$counter]['field_of_study_profile'] = \Dreamedit::normJsonStr($fieldOfStudyProfile);
                $rows[$counter]['status'] = \Dreamedit::normJsonStr($this->aspModule->getStatusService()->getStatusBy($user->getStatus())->getText());
                $rows[$counter]['email'] = \Dreamedit::normJsonStr($user->getEmail());
                $rows[$counter]['phone'] = \Dreamedit::normJsonStr($user->getPhone());
                $rows[$counter]['application_year'] = \Dreamedit::normJsonStr($user->getApplicationsYear()->getName());
                $rows[$counter]['user_data_page'] = "<div class=\"cell-button\"><a target='_blank' href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=getUserData&id=".$user->getId()."\"><i class=\"dxi dxi-eye\"></i></a></div>";
                $rows[$counter]['change_status'] = "<div class=\"cell-button\"><a target='_blank' href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=changeUserStatus&id=".$user->getId()."\"><i class=\"dxi dxi-pencil\"></i></a></div>";
                $rows[$counter]['pdf_last_upload_date'] = \Dreamedit::normJsonStr($user->getPdfLastUploadDateTime());
                $counter++;
            }

            echo json_encode($rows);
        } else {
            echo "Ошибка доступа.";
        }
    }
}