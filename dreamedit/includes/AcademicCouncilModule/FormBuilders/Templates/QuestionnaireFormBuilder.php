<?php

namespace AcademicCouncilModule\FormBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;

class QuestionnaireFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $academicCouncilModule = AcademicCouncilModule::getInstance();

                if ($academicCouncilModule->getQuestionnaireService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Îøèáêà.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}