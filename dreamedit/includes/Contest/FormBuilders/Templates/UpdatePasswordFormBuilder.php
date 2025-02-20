<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;

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
                $contest = Contest::getInstance();

                $result = $contest->getRegistrationService()->updatePassword(
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