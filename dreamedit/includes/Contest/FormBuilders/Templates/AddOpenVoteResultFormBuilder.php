<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

class AddOpenVoteResultFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $contest = Contest::getInstance();

                $query = $contest->getOpenVoteService()->addOpenVoteResults($this->sendFields);

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