<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

class AddUserFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload(false);
            if($result=="") {

                $contest = Contest::getInstance();

                if(!empty($_GET['id'])) {
                    $query = $contest->getUserService()->updateUserWithId($this->sendFields, $_GET['id']);
                } else {
                    $query = $contest->getUserService()->addUser($this->sendFields);
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