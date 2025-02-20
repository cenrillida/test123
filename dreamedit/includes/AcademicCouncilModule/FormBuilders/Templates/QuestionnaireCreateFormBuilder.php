<?php

namespace AcademicCouncilModule\FormBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;

class QuestionnaireCreateFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['name'])) {
                $academicCouncilModule = AcademicCouncilModule::getInstance();

                $academicCouncilModule->getQuestionnaireService()->createQuestionnaire($_POST['name'],$_POST['d_start'],$_POST['t_start'],$_POST['d_end'],$_POST['t_end'],$_POST['order_date'],$_POST['order_number'],$_POST['questionnaire_date'],$_POST['questionnaire_question'], $_POST['secret'], $_POST['protocol_number'], $_POST['questionnaire_fio'], $_POST['questionnaire_position']);
                $this->result = true;
                return "";
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}