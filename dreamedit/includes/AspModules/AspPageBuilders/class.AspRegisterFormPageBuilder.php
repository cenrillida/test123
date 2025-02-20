<?php

class AspRegisterFormPageBuilder implements AspPageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build()
    {
        global $DB,$_CONFIG, $site_templater;

        if($_SESSION[lang]!="/en") {
            $fieldOfStudies = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyList();
            $fieldOfStudySelectArr = array();
            foreach ($fieldOfStudies as $fieldOfStudy) {
                $fieldOfStudySelectArr[] = new OptionField($fieldOfStudy->getId(),$fieldOfStudy->getName());
            }

            $formBuilder = new AspRegisterFormBuilder("На Ваш e-mail отправлен запрос для подтверждения регистрации.","С требованиями согласен/согласна","/files/File/graduate_school/","Зарегистрироваться");

            $formBuilder->registerField(new FormField("lastname", "text", true, "Фамилия", "Не введена фамилия","Иванов"));
            $formBuilder->registerField(new FormField("firstname", "text", true, "Имя", "Не введено имя","Иван"));
            $formBuilder->registerField(new FormField("thirdname", "text", false, "Отчество", "","Иванович"));
            $formBuilder->registerField(new FormField("email", "email", true, "E-mail", "Не введен e-mail","example@imemo.ru",true,"Неверный формат e-mail"));
            $formBuilder->registerField(new FormField("password", "password", true, "Пароль", "Не введен пароль"));
            $formBuilder->registerField(new FormField("phone", "text", true, "Номер телефона", "Не введен номер телефона","+7999"));
            $formBuilder->registerField(new FormField("birthdate", "date", true, "Дата рождения", "Не введена дата рождения"));
            $formBuilder->registerField(new FormField("field_of_study", "select", true, "Направление подготовки", "Не выбрано направление","",false,"","",$fieldOfStudySelectArr));
            $posError = $formBuilder->processPostBuild();

        } else {
            $formBuilder = new AspRegisterFormBuilder("The registration approval message have been send to your e-mail.","Agree with rules","/files/File/graduate_school/","Register");
        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if(!empty($posError)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?=$posError?>
            </div>
            <?php
        }

        $formBuilder->build();

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}