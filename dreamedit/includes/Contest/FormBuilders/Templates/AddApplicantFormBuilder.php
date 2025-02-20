<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

class AddApplicantFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $contest = Contest::getInstance();

                if(!empty($_GET['id'])) {
                    $query = $contest->getApplicantService()->updateApplicantWithId($this->sendFields, $_GET['id']);
                } else {
                    $query = $contest->getApplicantService()->addApplicant($this->sendFields);
                }

                if ($query) {
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