<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Exceptions\Exception;
use Contest\Exceptions\TryLoginException;
use Contest\Exceptions\UserAlreadyExistException;
use Contest\Exceptions\UserNotFoundException;
use Contest\Models\User;

class RegistrationService {

    /** @var Contest */
    private $contest;

    /**
     * RegistrationService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @throws \Contest\Exceptions\TryLoginException|UserNotFoundException
     */
    public function resetPasswordRequest($email) {

        $this->contest->getAntiSpamService()->tryLoginRecord($email);

        $resetCode = $this->contest->getUserService()->getResetCode($email);
        if(!empty($resetCode)) {
            $nn = "<br>";
            $data = "<b>Восстановление пароля в системе голосования конкурсной комисии ИМЭМО РАН</b>:" . $nn;

            $data .= $nn."<a href=\"https://imemo.ru/index.php?page_id=".$_REQUEST['page_id']."&mode=updatePassword&code=".$resetCode."&email=".$email."\">Сбросить пароль</a>" . $nn.$nn;

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН" . $nn;

            \MailSend::send_mime_mail("Конкурсная комиссия ИМЭМО РАН", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "Восстановление пароля", $data);

            return;
        }
        throw new UserNotFoundException("Пользователь с такими данными не найден.");
    }

    /**
     * @return string
     */
    public function updatePassword($email,$code,$password) {
        return $this->contest->getUserService()->updatePassword($email,$code,$password);
    }

    /**
     * @return bool
     */
    public function checkResetCode($email,$code) {
        return $this->contest->getUserService()->checkResetCode($email,$code);
    }

    /**
     * @throws UserAlreadyExistException|TryLoginException|Exception
     */
    public function register($email,$password,$firstname,$lastname,$thirdname) {

        $this->contest->getAntiSpamService()->tryLoginRecord($email);

        $this->checkExistUser($email);

        $code = $this->contest->getUserService()->registerRequest($email,$password,$firstname,$lastname,$thirdname);

        if(!empty($code)) {
            $nn = "<br>";

            $data = "<b>Регистрация в системе голосования конкурсной комисии ИМЭМО РАН</b>:" . $nn;

            $data .= $nn . "<a href=\"https://imemo.ru/index.php?page_id=" . $_REQUEST['page_id'] . "&mode=registerConfirm&code=" . $code . "\">Подтвердить регистрацию</a>" . $nn . $nn;

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН" . $nn;

            \MailSend::send_mime_mail("Конкурсная комиссия ИМЭМО РАН", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "Регистрация", $data);

            return;
        }

        throw new Exception("Неизвестная ошибка");
    }

    public function confirmRegister($code) {
        $result = $this->contest->getUserService()->createUserFromRequest($code);
        echo $result;
    }


    /**
     * @param string $email
     * @throws UserAlreadyExistException
     */
    public function checkExistUser($email) {
        $user = $this->contest->getUserService()->getUserByEmail($email);
        if(!empty($user)) {
            throw new UserAlreadyExistException("Пользователь с таким e-mail уже зарегистрирован");
        }
    }

}