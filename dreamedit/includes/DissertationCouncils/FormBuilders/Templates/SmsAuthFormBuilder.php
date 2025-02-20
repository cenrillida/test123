<?php

namespace DissertationCouncils\FormBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;

class SmsAuthFormBuilder extends \FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(!empty($_POST['token'])) {
                $dissertationCouncils = DissertationCouncils::getInstance();

                try {
                    $phone = $dissertationCouncils->getTokenService()->getPhoneWithCheck($_POST['token']);
                    $dissertationCouncils->getAuthorizationService()->authorizeWithPhone($phone);
                    $this->result = true;
                    return "1";
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return "Îøèáêà.";
            }
        }
        return "";
    }
}