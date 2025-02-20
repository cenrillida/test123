<?php

class AspAuthorizationService {

    /** @var AspModuleUser */
    private $currentUser;
    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @return bool
     */
    public function checkLogin() {

        $this->currentUser = $this->aspModule->getAspModuleUserManager()->getUserByIdEmailPassword($_SESSION['asp_login'],$_SESSION['asp_email'],$_SESSION['asp_password']);
        if(empty($this->currentUser)) {
            $_SESSION['asp_login'] = "";
            $_SESSION['asp_email'] = "";
            $_SESSION['asp_password'] = "";
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function authorize($email, $password) {
        $this->currentUser = $this->aspModule->getAspModuleUserManager()->getUserByEmailAndPassword($email,$password);
        if(empty($this->currentUser)) {
            return false;
        }
        return true;
    }

    public function logout() {
        $_SESSION['asp_login'] = "";
        $_SESSION['asp_email'] = "";
        $_SESSION['asp_password'] = "";
        $this->currentUser = null;
    }

    /**
     * @return AspModuleUser
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

}