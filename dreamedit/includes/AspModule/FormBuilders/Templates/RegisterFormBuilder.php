<?php

namespace AspModule\FormBuilders\Templates;

use AspModule\AspModule;

class RegisterFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email']) && !empty($_POST['lastname']) && !empty($_POST['password'])) {

                $aspModule = AspModule::getInstance();

                if($aspModule->getRegistrationService()->checkExistUser($_POST['email'])) {
                    return "Пользователь с таким e-mail уже зарегистрирован";
                }

                if($aspModule->getRegistrationService()->register($_POST['email'],$_POST['password'],$_POST['firstname'],$_POST['lastname'],$_POST['thirdname'],$_POST['phone'],$_POST['birthdate'],$_POST['field_of_study'],$_POST['for_dissertation_attachment'])) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return "Ошибка.";
            }

        }
        return "";
    }
}