<?php

namespace AcademicCouncilModule\FormBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;

class QuestionnaireMailerFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $academicCouncilModule = AcademicCouncilModule::getInstance();

                if ($academicCouncilModule->getQuestionnaireService()->sendMails($this->sendFields)) {
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