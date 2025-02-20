<?php

class AcademicCouncilLoginFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['login']) && !empty($_POST['password'])) {
                $academicCouncilModule = AcademicCouncilModule::getInstance();
                if($academicCouncilModule->getAcademicCouncilAuthorizationService()->authorize($_POST['login'],$_POST['password'])) {
                    $this->result = true;
                    return "1";
                } else {
                    return "Пользователь с такими данными не найден.";
                }
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}

class AcademicCouncilQuestionnaireFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $academicCouncilModule = AcademicCouncilModule::getInstance();

                if ($academicCouncilModule->getAcademicCouncilQuestionnaireService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AcademicCouncilQuestionnaireMailerFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $academicCouncilModule = AcademicCouncilModule::getInstance();

                if ($academicCouncilModule->getAcademicCouncilQuestionnaireService()->sendMails($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AcademicCouncilQuestionnaireCreateFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['name'])) {
                $academicCouncilModule = AcademicCouncilModule::getInstance();
                $academicCouncilModule->getAcademicCouncilQuestionnaireService()->createQuestionnaire($_POST['name'],$_POST['d_start'],$_POST['t_start'],$_POST['d_end'],$_POST['t_end'],$_POST['order_date'],$_POST['order_number'],$_POST['questionnaire_date'],$_POST['questionnaire_question']);
                $this->result = true;
                return "";
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}

class AcademicCouncilQuestionnaireEditFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['name']) && !empty($_GET['id'])) {
                $academicCouncilModule = AcademicCouncilModule::getInstance();
                $academicCouncilModule->getAcademicCouncilQuestionnaireService()->updateQuestionnaire($_GET['id'],$_POST['name'],$_POST['d_start'],$_POST['t_start'],$_POST['d_end'],$_POST['t_end'],$_POST['order_date'],$_POST['order_number'],$_POST['questionnaire_date'],$_POST['questionnaire_question']);
                $this->result = true;
                return "";
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}