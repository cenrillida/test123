<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class AddApplicationsYearFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();

                if(!empty($_GET['id'])) {
                    $query = $aspModule->getApplicationsYearService()->updateApplicationsYearWithId(
                        $this->sendFields,
                        $_GET['id']
                    );
                } else {
                    $query = $aspModule->getApplicationsYearService()->addApplicationsYear($this->sendFields);
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