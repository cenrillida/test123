<?php


class AspUpdatePasswordFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email']) && !empty($_POST['code']) && !empty($_POST['password'])) {
                $aspModule = AspModule::getInstance();
                $result = $aspModule->getAspRegistrationService()->updatePassword($_POST['email'],$_POST['code'],$_POST['password']);
                if($result == "1") {
                    $this->result = true;
                    return "";
                } else {
                    return $result;
                }
            } else {
                return "Ошибка ввода.";
            }
        }
        return "";
    }
}

class AspPasswordResetFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email'])) {
                $aspModule = AspModule::getInstance();
                if($aspModule->getAspRegistrationService()->resetPasswordRequest($_POST['email'])) {
                    $this->result = true;
                    return "";
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

class AspLoginFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email']) && !empty($_POST['password'])) {
                $aspModule = AspModule::getInstance();
                if($aspModule->getAspAuthorizationService()->authorize($_POST['email'],$_POST['password'])) {
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

class AspRegisterFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['email']) && !empty($_POST['lastname']) && !empty($_POST['password'])) {

                $aspModule = AspModule::getInstance();

                if($aspModule->getAspRegistrationService()->checkExistUser($_POST['email'])) {
                    return "Пользователь с таким e-mail уже зарегистрирован";
                }

                if($aspModule->getAspRegistrationService()->register($_POST['email'],$_POST['password'],$_POST['firstname'],$_POST['lastname'],$_POST['thirdname'],$_POST['phone'],$_POST['birthdate'],$_POST['field_of_study'])) {
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

class AspAddDataFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();

                if ($aspModule->getAspAddDataService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspDocumentApplicationFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {


            $result = $this->fillFieldsForUpload();

            if($result=="") {

                $aspModule = AspModule::getInstance();

                if ($aspModule->getAspDocumentApplicationService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspApplyForEntryFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {


            $result = $this->fillFieldsForUpload();

            if($result=="") {

                $aspModule = AspModule::getInstance();

                if ($aspModule->getAspApplyForEntryService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspChangeUserStatusFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();

                $user = $aspModule->getAspModuleUserManager()->getCurrentEditableUser();

                if(!empty($user)) {
                    if ($aspModule->getAspChangeUserStatusService()->sendData($this->sendFields,$user)) {
                        $this->result = true;
                        return "";
                    } else {
                        return "Ошибка.";
                    }
                }
                else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspAdminEditFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();

                $user = $aspModule->getAspModuleUserManager()->getCurrentEditableUser();

                if(!empty($user)) {
                    if ($aspModule->getAspAdminEditService()->sendData($this->sendFields,$user)) {
                        $this->result = true;
                        return "";
                    } else {
                        return "Ошибка.";
                    }
                }
                else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspDocumentUploadFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();
                if ($aspModule->getAspDocumentUploadService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspApplyForEntryUploadFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();
                if ($aspModule->getAspApplyForEntryUploadService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspTechSupportFormBuilder extends FormBuilder {
    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();
                if ($aspModule->getAspTechSupportService()->sendData($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}

class AspXlsxFormBuilder extends FormBuilder {

    public function processPostBuild()
    {
        global $DB;
        if(parent::processPostBuild()) {

            $result = $this->fillFieldsForUpload();
            if($result=="") {

                $aspModule = AspModule::getInstance();
                if ($aspModule->getAspXlsxService()->createXlsx($this->sendFields)) {
                    $this->result = true;
                    return "";
                } else {
                    return "Ошибка.";
                }
            } else {
                return $result;
            }

        }
        return "";
    }
}