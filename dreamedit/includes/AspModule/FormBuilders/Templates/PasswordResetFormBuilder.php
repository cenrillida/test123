<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class PasswordResetFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email'])) {
                $aspModule = AspModule::getInstance();
                if($aspModule->getRegistrationService()->resetPasswordRequest($_POST['email'])) {
                    $this->result = true;
                    return "";
                } else {
                    return "Пользователь с такими данными не найден.";
                }
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}