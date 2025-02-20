<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class UpdatePasswordFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email']) && !empty($_POST['code']) && !empty($_POST['password'])) {
                $aspModule = AspModule::getInstance();
                $result = $aspModule->getRegistrationService()->updatePassword($_POST['email'],$_POST['code'],$_POST['password']);
                if($result == "1") {
                    $this->result = true;
                    return "";
                } else {
                    return $result;
                }
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}