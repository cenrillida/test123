<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

class AddOnlineVoteFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload(false);
            if($result=="") {

                $contest = Contest::getInstance();

                $query = $contest->getOnlineVoteService()->addOnlineVoteResults(
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