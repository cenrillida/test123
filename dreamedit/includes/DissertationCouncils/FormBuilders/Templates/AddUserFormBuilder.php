<?php

namespace DissertationCouncils\FormBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;

class AddUserFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload(false);
            if($result=="") {

                $dissertationCouncils = DissertationCouncils::getInstance();

                try {
                    if(!empty($_GET['id'])) {
                        $query = $dissertationCouncils->getUserService()->updateUserWithId($this->sendFields, $_GET['id']);
                    } else {
                        $query = $dissertationCouncils->getUserService()->addUser($this->sendFields);
                    }
                } catch (Exception $exception) {
                    return $exception->getMessage();
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