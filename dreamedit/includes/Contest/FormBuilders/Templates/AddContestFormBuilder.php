<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

class AddContestFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $contest = Contest::getInstance();

                if(!empty($_GET['id'])) {
                    $query = $contest->getContestService()->updateContestWithId($this->sendFields, $_GET['id']);
                } else {
                    $query = $contest->getContestService()->addContest($this->sendFields);
                }

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