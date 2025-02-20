<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class LoginFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email']) && !empty($_POST['password'])) {
                $aspModule = AspModule::getInstance();
                if($aspModule->getAuthorizationService()->authorize($_POST['email'],$_POST['password'])) {
                    $this->result = true;
                    return "1";
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