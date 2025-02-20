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
            $data = "<b>�������������� ������ � ������� ����������� ���������� ������� ����� ���</b>:" . $nn;

            $data .= $nn."<a href=\"https://imemo.ru/index.php?page_id=".$_REQUEST['page_id']."&mode=updatePassword&code=".$resetCode."&email=".$email."\">�������� ������</a>" . $nn.$nn;

            $data .= "� ���������," . $nn;
            $data .= "����� ���" . $nn;

            \MailSend::send_mime_mail("���������� �������� ����� ���", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "�������������� ������", $data);

            return;
        }
        throw new UserNotFoundException("������������ � ������ ������� �� ������.");
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

            $data = "<b>����������� � ������� ����������� ���������� ������� ����� ���</b>:" . $nn;

            $data .= $nn . "<a href=\"https://imemo.ru/index.php?page_id=" . $_REQUEST['page_id'] . "&mode=registerConfirm&code=" . $code . "\">����������� �����������</a>" . $nn . $nn;

            $data .= "� ���������," . $nn;
            $data .= "����� ���" . $nn;

            \MailSend::send_mime_mail("���������� �������� ����� ���", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "�����������", $data);

            return;
        }

        throw new Exception("����������� ������");
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
            throw new UserAlreadyExistException("������������ � ����� e-mail ��� ���������������");
        }
    }

}