<?php

namespace Crossref\FormBuilders\Templates;

use Crossref\Crossref;

class NumberCheckFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            $result = $this->fillFieldsForUpload(false);
            if($result=="") {

                $crossref = Crossref::getInstance();

                if($_GET['ap']!=1) {
                    $module = "journal";
                } else {
                    $module = "afjournal";
                }

                if ($crossref->getNumberCheckService()->sendData($this->sendFields,$module)) {
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