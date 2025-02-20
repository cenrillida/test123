<?php

class AspAdminTablePageSourceBuilder implements AspPageBuilder {
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
        $currentUser = $this->aspModule->getCurrentUser();

        if($this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus())->isAdminAllow()) {
            header("Content-type: application/json");

            $rows = array();

            $counter = 0;
            foreach ($this->aspModule->getAspModuleUserManager()->getAllUsers("pdf_last_upload_date","DESC") as $user) {
                $rows[$counter] = array();
                $rows[$counter]['fio'] = Dreamedit::normJsonStr($user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName());
                $fieldOfStudy = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyById($user->getFieldOfStudy());
                if(!empty($fieldOfStudy)) {
                    $fieldOfStudy = $fieldOfStudy->getName();
                } else {
                    $fieldOfStudy = "";
                }
                $rows[$counter]['field_of_study'] = Dreamedit::normJsonStr($fieldOfStudy);
                $fieldOfStudyProfile = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyProfileById($user->getFieldOfStudyProfile());
                if(!empty($fieldOfStudyProfile)) {
                    $fieldOfStudyProfile = $fieldOfStudyProfile->getName();
                } else {
                    $fieldOfStudyProfile = "";
                }
                $rows[$counter]['field_of_study_profile'] = Dreamedit::normJsonStr($fieldOfStudyProfile);
                $rows[$counter]['status'] = Dreamedit::normJsonStr($this->aspModule->getAspStatusManager()->getStatusBy($user->getStatus())->getText());
                $rows[$counter]['email'] = Dreamedit::normJsonStr($user->getEmail());
                $rows[$counter]['phone'] = Dreamedit::normJsonStr($user->getPhone());
                $rows[$counter]['user_data_page'] = "<div class=\"cell-button\"><a target='_blank' href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=getUserData&id=".$user->getId()."\"><i class=\"dxi dxi-eye\"></i></a></div>";
                $rows[$counter]['change_status'] = "<div class=\"cell-button\"><a target='_blank' href=\"/index.php?page_id=".$_REQUEST['page_id']."&mode=changeUserStatus&id=".$user->getId()."\"><i class=\"dxi dxi-pencil\"></i></a></div>";
                $rows[$counter]['pdf_last_upload_date'] = Dreamedit::normJsonStr($user->getPdfLastUploadDateTime());
                $counter++;
            }

            echo json_encode($rows);
        } else {
            echo "Ошибка доступа.";
        }
    }
}