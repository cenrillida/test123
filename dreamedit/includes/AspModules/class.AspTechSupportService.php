<?php

class AspTechSupportService {

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
    public function sendData($fields) {
        $currentUser = $this->aspModule->getCurrentUser();
        $id = $currentUser->getId();
        $email = $currentUser->getEmail();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus());

        $nn = "<br>";
        $data = "<b>������ ����������� ���������</b>:" . $nn.$nn;

        $data .="ID ������������: ".$id.$nn;
        $data .="��� ������������: ".$currentUser->getLastName()." ".$currentUser->getFirstName()." ".$currentUser->getThirdName().$nn;
        $data .="email ������������: ".$email.$nn;
        $data .="������ ������������: ".$status->getText().$nn;

        $data .="����� ���������:".$nn.$nn;

        $data .= Dreamedit::LineBreakToBr($fields['problem']);

        $data .=$nn.$nn;
        $data .= "� ���������," . $nn;
        $data .= "����� ���." . $nn;

        MailSend::send_mime_mail("����������� ����� ���", "asp_tech_support@imemo.ru", "", "alexqw1@yandex.ru,asp_tech_support@imemo.ru", "cp1251", "utf-8", "������ ����������� ���������", $data);


        return true;
    }

}