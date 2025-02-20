<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;
use Contest\Exceptions\Exception;
use Contest\Exceptions\TryLoginException;
use Contest\Exceptions\UserNotFoundException;

class ResetPasswordFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email'])) {
                $contest = Contest::getInstance();
                try {
                    $contest->getRegistrationService()->resetPasswordRequest($_POST['email']);
                    $this->result = true;
                    return "";
                } catch (Exception $exception) {
                    return $exception->getMessage();
                }
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}