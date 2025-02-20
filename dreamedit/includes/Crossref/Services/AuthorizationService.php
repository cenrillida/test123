<?php

namespace Crossref\Services;

use Crossref\Crossref;

class AuthorizationService {

    /** @var Crossref */
    private $crossref;

    /** @var bool */
    private $authorized = false;

    /**
     * AuthorizationService constructor.
     * @param Crossref $crossref
     */
    public function __construct(Crossref $crossref)
    {
        $this->crossref = $crossref;
    }

    /**
     * @return bool
     */
    public function checkLogin() {
        global $_CONFIG;

        if(isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]))
            \Dreamedit::updateSession($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_id"]);

        if(($_SESSION['crossref_login']=="admin" && $_SESSION['crossref_password']=="X$&FHA*fh!hf") || isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]])) {
            $this->authorized = true;
            return true;
        } else {
            $this->logout();
            return false;
        }
    }

    /**
     * @return bool
     */
    public function authorize($login, $password) {
        if($login=="admin" && $password=="X$&FHA*fh!hf") {
            $this->authorized = true;
            $_SESSION['crossref_login'] = "admin";
            $_SESSION['crossref_password'] = "X$&FHA*fh!hf";
            return true;
        } else {
            $this->logout();
            return false;
        }
    }

    public function logout() {
        $this->authorized = false;
        $_SESSION['crossref_login'] = "";
        $_SESSION['crossref_password'] = "";
    }

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

}