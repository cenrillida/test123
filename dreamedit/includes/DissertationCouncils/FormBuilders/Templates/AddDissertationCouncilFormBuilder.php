<?php

namespace DissertationCouncils\FormBuilders\Templates;

use DissertationCouncils\DissertationCouncils;

class AddDissertationCouncilFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $dissertationCouncils = DissertationCouncils::getInstance();

                if(!empty($_GET['id'])) {
                    $query = $dissertationCouncils->getDissertationCouncilService()->updateDissertationCouncilWithId($this->sendFields, $_GET['id']);
                } else {
                    $query = $dissertationCouncils->getDissertationCouncilService()->addDissertationCouncil($this->sendFields);
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