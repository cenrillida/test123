<?php

namespace DissertationCouncils\FormBuilders\Templates;

use DissertationCouncils\DissertationCouncils;

class VoteFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload(false);
            if($result=="") {

                $dissertationCouncils = DissertationCouncils::getInstance();

                $query = $dissertationCouncils->getVoteResultService()->addVoteResult(
                    $this->sendFields
                );

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