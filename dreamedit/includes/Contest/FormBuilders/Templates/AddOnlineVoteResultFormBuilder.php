<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

class AddOnlineVoteResultFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $contest = Contest::getInstance();

                $query = $contest->getContestService()->addContestAdditional($this->sendFields);

                if ($query) {
                    $this->result = true;
                    return "";
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