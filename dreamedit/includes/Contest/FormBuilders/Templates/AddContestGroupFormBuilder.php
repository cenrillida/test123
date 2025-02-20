<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

class AddContestGroupFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $contest = Contest::getInstance();

                if(!empty($_GET['id'])) {
                    $query = $contest->getContestGroupService()->updateContestGroupWithId($this->sendFields, $_GET['id']);
                } else {
                    $query = $contest->getContestGroupService()->addContestGroup($this->sendFields);
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