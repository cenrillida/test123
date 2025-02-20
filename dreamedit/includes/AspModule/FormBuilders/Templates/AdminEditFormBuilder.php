<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class AdminEditFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();

                $user = $aspModule->getUserService()->getCurrentEditableUser();

                if(!empty($user)) {
                    if ($aspModule->getAdminEditService()->sendData($this->sendFields,$user)) {
                        $this->result = true;
                        return "";
                    } else {
                        return "Îøèáêà.";
                    }
                }
                else {
                    return "Îøèáêà.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}