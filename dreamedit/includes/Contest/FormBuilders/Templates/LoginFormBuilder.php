<?php

namespace Contest\FormBuilders\Templates;

use Contest\Contest;
use Contest\Exceptions\Exception;

class LoginFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['email']) && !empty($_POST['password'])) {
                $contest = Contest::getInstance();

                try {
                    $contest->getAuthorizationService()->authorize($_POST['email'],$_POST['password']);
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