<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;
use DissertationCouncils\Exceptions\TryLoginException;
use DissertationCouncils\Exceptions\UserAlreadyExistException;
use DissertationCouncils\Exceptions\UserNotFoundException;
use DissertationCouncils\Models\User;

class RegistrationService {

    /** @var DissertationCouncils */
    private $dissertationCouncils;

    /**
     * RegistrationService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @throws TryLoginException|UserNotFoundException
     */
    public function resetPasswordRequest($email) {

        $this->dissertationCouncils->getAntiSpamService()->tryLoginRecord($email);

        $resetCode = $this->dissertationCouncils->getUserService()->getResetCode($email);
        if(!empty($resetCode)) {
            $nn = "<br>";
            $data = "<b>Восстановление пароля в системе голосования диссертационных советов ИМЭМО РАН</b>:" . $nn;

            $data .= $nn."<a href=\"https://imemo.ru/index.php?page_id=".$_REQUEST['page_id']."&mode=updatePassword&code=".$resetCode."&email=".$email."\">Сбросить пароль</a>" . $nn.$nn;

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН" . $nn;

            \MailSend::send_mime_mail("Диссертационные советы ИМЭМО РАН", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "Восстановление пароля", $data);

            return;
        }
        throw new UserNotFoundException("Пользователь с такими данными не найден.");
    }

    /**
     * @return string
     */
    public function updatePassword($email,$code,$password) {
        return $this->dissertationCouncils->getUserService()->updatePassword($email,$code,$password);
    }

    /**
     * @return bool
     */
    public function checkResetCode($email,$code) {
        return $this->dissertationCouncils->getUserService()->checkResetCode($email,$code);
    }

    /**
     * @throws UserAlreadyExistException|TryLoginException|Exception
     */
    public function register($email,$password,$firstname,$lastname,$thirdname) {

        $this->dissertationCouncils->getAntiSpamService()->tryLoginRecord($email);

        $this->checkExistUser($email);

        $code = $this->dissertationCouncils->getUserService()->registerRequest($email,$password,$firstname,$lastname,$thirdname);

        if(!empty($code)) {
            $nn = "<br>";

            $data = "<b>Регистрация в системе голосования диссертационных советов ИМЭМО РАН</b>:" . $nn;

            $data .= $nn . "<a href=\"https://imemo.ru/index.php?page_id=" . $_REQUEST['page_id'] . "&mode=registerConfirm&code=" . $code . "\">Подтвердить регистрацию</a>" . $nn . $nn;

            $data .= "С уважением," . $nn;
            $data .= "ИМЭМО РАН" . $nn;

            \MailSend::send_mime_mail("Диссертационные советы ИМЭМО РАН", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "Регистрация", $data);

            return;
        }

        throw new Exception("Неизвестная ошибка");
    }

    public function confirmRegister($code) {
        $result = $this->dissertationCouncils->getUserService()->createUserFromRequest($code);
        echo $result;
    }


    /**
     * @param string $email
     * @throws UserAlreadyExistException
     */
    public function checkExistUser($email) {
        $user = $this->dissertationCouncils->getUserService()->getUserByEmail($email);
        if(!empty($user)) {
            throw new UserAlreadyExistException("Пользователь с таким e-mail уже зарегистрирован");
        }
    }

}