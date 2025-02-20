<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\TryLoginException;
use DissertationCouncils\Exceptions\UserNotFoundException;
use DissertationCouncils\Models\User;

class AuthorizationService {

    /** @var DissertationCouncils */
    private $dissertationCouncils;

    /** @var bool */
    private $authorized = false;

    /** @var User */
    private $currentUser;

    /**
     * AuthorizationService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @return bool
     */
    private function tryAuthorizeCurrentUser() {
        if(!empty($this->currentUser)) {
            $this->authorized = true;
            $_SESSION['dissertation_councils_email'] = $this->currentUser->getEmail();
            $_SESSION['dissertation_councils_password'] = $this->currentUser->getPassword();
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
            $this->currentUser = $this->dissertationCouncils->getUserService()->getUserAdmin();
            return true;
        } else {
            $this->currentUser = $this->dissertationCouncils->getUserService()->getUserByEmailAndPassword(
                $_SESSION['dissertation_councils_email'],$_SESSION['dissertation_councils_password'],true
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
     * @throws TryLoginException
     * @throws UserNotFoundException
     */
    public function authorize($email, $password) {

       $this->dissertationCouncils->getAntiSpamService()->tryLoginRecord($email);

        $this->currentUser = $this->dissertationCouncils->getUserService()->getUserByEmailAndPassword(
            $email,
            $password,
            false
        );
        if(!$this->tryAuthorizeCurrentUser()) {
            throw new UserNotFoundException("ѕользователь с такими данными не найден.");
        }
    }

    /**
     * @throws UserNotFoundException
     */
    public function authorizeWithPhone($phone) {
        $this->currentUser = $this->dissertationCouncils->getUserService()->getUserByPhone(
            $phone
        );
        if(!$this->tryAuthorizeCurrentUser()) {
            throw new UserNotFoundException("ѕользователь с такими данными не найден.");
        }
    }

    public function logout() {
        $this->authorized = false;
        $_SESSION['dissertation_councils_email'] = "";
        $_SESSION['dissertation_councils_password'] = "";
    }

    /**
     * @param string $phone
     * @throws UserNotFoundException
     */
    public function checkPhone($phone) {
        if($this->dissertationCouncils->getUserService()->getUserByPhone($phone) == null) {
            throw new UserNotFoundException();
        }
    }

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

}