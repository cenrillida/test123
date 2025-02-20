<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Exceptions\UserNotFoundException;
use Contest\Models\User;

class AuthorizationService {

    /** @var Contest */
    private $contest;

    /** @var bool */
    private $authorized = false;

    /** @var User */
    private $currentUser;

    /**
     * AuthorizationService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @return bool
     */
    private function tryAuthorizeCurrentUser() {
        if(!empty($this->currentUser)) {
            $this->authorized = true;
            $_SESSION['contest_email'] = $this->currentUser->getEmail();
            $_SESSION['contest_password'] = $this->currentUser->getPassword();
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
        global $_CONFIG;

        if(isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]))
            \Dreamedit::updateSession($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_id"]);

        if(isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]])) {
            $this->authorized = true;
            $this->currentUser = $this->contest->getUserService()->getUserAdmin();
            return true;
        } else {
            $this->currentUser = $this->contest->getUserService()->getUserByEmailAndPassword(
                $_SESSION['contest_email'],$_SESSION['contest_password'],true
            );
            return $this->tryAuthorizeCurrentUser();
        }
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @throws \Contest\Exceptions\TryLoginException
     * @throws UserNotFoundException
     */
    public function authorize($email, $password) {

       $this->contest->getAntiSpamService()->tryLoginRecord($email);

        $this->currentUser = $this->contest->getUserService()->getUserByEmailAndPassword(
            $email,
            $password,
            false
        );
        if(!$this->tryAuthorizeCurrentUser()) {
            throw new UserNotFoundException("ѕользователь с такими данными не найден.");
        }
    }

    public function logout() {
        $this->authorized = false;
        $_SESSION['contest_email'] = "";
        $_SESSION['contest_password'] = "";
    }

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

}