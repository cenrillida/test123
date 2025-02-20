<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class CreateUserFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {


            $result = $this->fillFieldsForUpload();

            if($result=="") {

                $aspModule = AspModule::getInstance();

                if ($aspModule->getUserService()->createUser($this->sendFields)) {
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