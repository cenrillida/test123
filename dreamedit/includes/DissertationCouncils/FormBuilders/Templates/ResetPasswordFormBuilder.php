<?php

namespace DissertationCouncils\FormBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;
use DissertationCouncils\Exceptions\TryLoginException;
use DissertationCouncils\Exceptions\UserNotFoundException;

class ResetPasswordFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email'])) {
                $dissertationCouncils = DissertationCouncils::getInstance();
                try {
                    $dissertationCouncils->getRegistrationService()->resetPasswordRequest($_POST['email']);
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