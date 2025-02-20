<?php

namespace AcademicCouncilModule\FormBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;

class LoginFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['login']) && !empty($_POST['password'])) {
                $academicCouncilModule = AcademicCouncilModule::getInstance();
                if($academicCouncilModule->getAuthorizationService()->authorize($_POST['login'],$_POST['password'])) {
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