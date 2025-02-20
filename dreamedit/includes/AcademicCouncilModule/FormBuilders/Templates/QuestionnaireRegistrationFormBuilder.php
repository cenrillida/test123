<?php

namespace AcademicCouncilModule\FormBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;

class QuestionnaireRegistrationFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $academicCouncilModule = AcademicCouncilModule::getInstance();

                if ($academicCouncilModule->getQuestionnaireService()->sendRegistrationData($this->sendFields)) {
                    $this->result = true;
                    return "redirectToVote";
                } else {
                    return "������.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}