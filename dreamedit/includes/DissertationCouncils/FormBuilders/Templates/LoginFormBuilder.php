<?php

namespace DissertationCouncils\FormBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;

class LoginFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['email']) && !empty($_POST['password'])) {
                $dissertationCouncils = DissertationCouncils::getInstance();

                try {
                    $dissertationCouncils->getAuthorizationService()->authorize($_POST['email'],$_POST['password']);
                    $this->result = true;
                    return "1";
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