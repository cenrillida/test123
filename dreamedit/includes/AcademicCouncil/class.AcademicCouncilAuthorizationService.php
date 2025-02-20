<?php

class AcademicCouncilAuthorizationService {

    /** @var AcademicCouncilModule */
    private $academicCouncilModule;

    /** @var bool */
    private $authorized = false;

    public function __construct($academicCouncilModule)
    {
        $this->academicCouncilModule = $academicCouncilModule;
    }

    /**
     * @return bool
     */
    public function checkLogin() {
        if($_SESSION['academic_council_login']=="admin" && $_SESSION['academic_council_password']=="Fnu91fB*H$(F!F") {
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
        if($login=="admin" && $password=="Fnu91fB*H$(F!F") {
            $this->authorized = true;
            $_SESSION['academic_council_login'] = "admin";
            $_SESSION['academic_council_password'] = "Fnu91fB*H$(F!F";
            return true;
        } else {
            $this->logout();
            return false;
        }
    }

    public function logout() {
        $this->authorized = false;
        $_SESSION['academic_council_login'] = "";
        $_SESSION['academic_council_password'] = "";
    }

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

}