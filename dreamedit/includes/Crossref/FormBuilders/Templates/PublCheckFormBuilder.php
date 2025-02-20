<?php

namespace Crossref\FormBuilders\Templates;

use Crossref\Crossref;

class PublCheckFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload(false);
            if($result=="") {

                $crossref = Crossref::getInstance();
                if ($crossref->getNumberCheckService()->sendData($this->sendFields,'publ')) {
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