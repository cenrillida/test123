<?php

class AspRegistrationService {

    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    /**
     * @return bool
     */
    public function resetPasswordRequest($email) {
        $resetCode = $this->aspModule->getAspModuleUserManager()->getResetCode($email);
        if(!empty($resetCode)) {
            $nn = "<br>";
            $data = "<b>Восстановление пароля на сайте аспирантуры ИМЭМО РАН</b>:" . $nn;

            $confirmPages = $this->pages->getPages(1,null,null,"asp_lk_password_reset");
            if(!empty($confirmPages)) {
                $confirmPage = array_shift($confirmPages);
                $data .= $nn."<a href=\"https://imemo.ru/index.php?page_id=".$confirmPage['page_id']."&code=".$resetCode."&email=".$email."\">Сбросить пароль</a>" . $nn.$nn;
            }

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН." . $nn;

            MailSend::send_mime_mail("Аспирантура ИМЭМО РАН", "register@imemo.ru", "", $email, "cp1251", "utf-8", "Восстановление пароля", $data);

            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function updatePassword($email,$code,$password) {
        return $this->aspModule->getAspModuleUserManager()->updatePassword($email,$code,$password);
    }

    /**
     * @return bool
     */
    public function checkResetCode($email,$code) {
        return $this->aspModule->getAspModuleUserManager()->checkResetCode($email,$code);
    }

    /**
     * @return bool
     */
    public function register($email,$password,$firstname,$lastname,$thirdname,$phone,$birthdate,$fieldOfStudy) {
        $code = $this->aspModule->getAspModuleUserManager()->registerRequest($email,$password,$firstname,$lastname,$thirdname,$phone,$birthdate,$fieldOfStudy);

        if(!empty($code)) {
            $nn = "<br>";

            $confirmPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_register_confirm");

            $data = "<b>Регистрация на сайте аспирантуры ИМЭМО РАН</b>:" . $nn;

            if (!empty($confirmPageId)) {
                $data .= $nn . "<a href=\"https://imemo.ru/index.php?page_id=" . $confirmPageId . "&code=" . $code . "\">Подтвердить регистрацию</a>" . $nn . $nn;
            }

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН." . $nn;

            MailSend::send_mime_mail("Аспирантура ИМЭМО РАН", "register@imemo.ru", "", $email, "cp1251", "utf-8", "Регистрация", $data);
            return true;
        }
        return false;
    }

    public function confirmRegister($code) {
        $result = $this->aspModule->getAspModuleUserManager()->createUserFromRequest($code);
        echo $result;
    }

    /**
     * @return bool
     */
    public function checkExistUser($email) {
        $user = $this->aspModule->getAspModuleUserManager()->getUserByEmail($email);
        if(empty($user)) {
            return false;
        }
        return true;
    }

}