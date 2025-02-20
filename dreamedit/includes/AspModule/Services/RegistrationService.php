<?php

namespace AspModule\Services;

use AspModule\AspModule;

class RegistrationService {

    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
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
        $resetCode = $this->aspModule->getUserService()->getResetCode($email);
        if(!empty($resetCode)) {
            $nn = "<br>";
            $data = "<b>�������������� ������ �� ����� ����������� ����� ���</b>:" . $nn;

            $data .= $nn."<a href=\"https://imemo.ru/index.php?page_id=".$_REQUEST['page_id']."&mode=passwordUpdate&code=".$resetCode."&email=".$email."\">�������� ������</a>" . $nn.$nn;

            $data .= "� ���������," . $nn;
            $data .= "����� ���" . $nn;

            \MailSend::send_mime_mail("����������� ����� ���", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "�������������� ������", $data);

            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function updatePassword($email,$code,$password) {
        return $this->aspModule->getUserService()->updatePassword($email,$code,$password);
    }

    /**
     * @return bool
     */
    public function checkResetCode($email,$code) {
        return $this->aspModule->getUserService()->checkResetCode($email,$code);
    }

    /**
     * @return bool
     */
    public function register($email,$password,$firstname,$lastname,$thirdname,$phone,$birthdate,$fieldOfStudy,$forDissertationAttachment) {
        $code = $this->aspModule->getUserService()->registerRequest($email,$password,$firstname,$lastname,$thirdname,$phone,$birthdate,$fieldOfStudy,$forDissertationAttachment);

        if(!empty($code)) {
            $nn = "<br>";

            $data = $nn . "<a href=\"https://imemo.ru/index.php?page_id=" . $_REQUEST['page_id'] . "&mode=registerConfirm&code=" . $code . "\">����������� �����������</a>" . $nn . $nn;

            $data .= "� ���������," . $nn;
            $data .= "����� ���" . $nn;

            \MailSend::send_mime_mail("����������� ����� ���", "noreply@imemo.ru", "", $email, "cp1251", "utf-8", "�����������", $data);
            return true;
        }
        return false;
    }

    public function confirmRegister($code) {
        $result = $this->aspModule->getUserService()->createUserFromRequest($code);
        echo $result;
    }

    /**
     * @return bool
     */
    public function checkExistUser($email) {
        $user = $this->aspModule->getUserService()->getUserByEmail($email);
        if(empty($user)) {
            return false;
        }
        return true;
    }

}