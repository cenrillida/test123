<?php

namespace DissertationCouncils\FormBuilders\Templates;

use DissertationCouncils\DissertationCouncils;

class UpdatePasswordFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(
                filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
                !empty($_POST['email']) &&
                !empty($_POST['code']) &&
                !empty($_POST['password'])
            ) {
                $dissertationCouncils = DissertationCouncils::getInstance();

                $result = $dissertationCouncils->getRegistrationService()->updatePassword(
                    $_POST['email'],
                    $_POST['code'],
                    $_POST['password']
                );
                if($result == "1") {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}