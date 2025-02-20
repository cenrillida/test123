<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;
use Contest\Exceptions\Exception;
use Contest\Exceptions\UserAlreadyExistException;

class RegisterFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(
                filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
                !empty($_POST['email']) &&
                !empty($_POST['lastname']) &&
                !empty($_POST['password'])
            ) {
                $contest = Contest::getInstance();
                try {
                    $contest->getRegistrationService()->register(
                        $_POST['email'],
                        $_POST['password'],
                        $_POST['firstname'],
                        $_POST['lastname'],
                        $_POST['thirdname']
                    );
                    $this->result = true;
                    return "";
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}