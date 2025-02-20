<?php

namespace AspModule\Services;

use AspModule\AspModule;
use AspModule\Models\User;

class AuthorizationService {

    /** @var User */
    private $currentUser;
    /** @var bool */
    private $authorized = false;
    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @return bool
     */
    private function tryAuthorizeCurrentUser() {
        if(!empty($this->currentUser)) {
            $this->authorized = true;
            $_SESSION['asp_login'] = $this->currentUser->getId();
            $_SESSION['asp_email'] = $this->currentUser->getEmail();
            $_SESSION['asp_password'] = $this->currentUser->getPassword();
            return true;
        } else {
            $this->logout();
            return false;
        }
    }

    /**
     * @return bool
     */
    public function checkLogin() {
        $this->currentUser = $this->aspModule->getUserService()->getUserByIdEmailPassword($_SESSION['asp_login'],$_SESSION['asp_email'],$_SESSION['asp_password']);
        return $this->tryAuthorizeCurrentUser();
    }

    /**
     * @return bool
     */
    public function authorize($email, $password) {
        $this->currentUser = $this->aspModule->getUserService()->getUserByEmailAndPassword($email,$password);
        if(empty($this->currentUser)) {
            return false;
        }
        return true;
    }

    public function logout() {
        $this->authorized = false;
        $_SESSION['asp_login'] = "";
        $_SESSION['asp_email'] = "";
        $_SESSION['asp_password'] = "";
        $this->currentUser = null;
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

}