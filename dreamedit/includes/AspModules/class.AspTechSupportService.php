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
        $data = "<b>Запрос технической поддержки</b>:" . $nn.$nn;

        $data .="ID пользователя: ".$id.$nn;
        $data .="ФИО пользователя: ".$currentUser->getLastName()." ".$currentUser->getFirstName()." ".$currentUser->getThirdName().$nn;
        $data .="email пользователя: ".$email.$nn;
        $data .="Статус пользователя: ".$status->getText().$nn;

        $data .="Текст обращения:".$nn.$nn;

        $data .= Dreamedit::LineBreakToBr($fields['problem']);

        $data .=$nn.$nn;
        $data .= "С уважением," . $nn;
        $data .= "ИМЭМО РАН." . $nn;

        MailSend::send_mime_mail("Аспирантура ИМЭМО РАН", "asp_tech_support@imemo.ru", "", "alexqw1@yandex.ru,asp_tech_support@imemo.ru", "cp1251", "utf-8", "Запрос технической поддержки", $data);


        return true;
    }

}