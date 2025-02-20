<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class DocumentUploadFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();
                if ($aspModule->getDocumentUploadService()->sendData($this->sendFields)) {
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