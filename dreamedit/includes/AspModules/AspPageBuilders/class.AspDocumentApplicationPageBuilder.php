<?php

class AspDocumentApplicationPageBuilder implements AspPageBuilder {
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
        global $DB,$_CONFIG,$site_templater;

        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($admin->getStatus());
        if($status->isDocumentApplicationAllow() || $status->isEditDocumentApplicationAllow() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {

                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AspAdminEditFormBuilder("Данные успешно изменены.","",__DIR__ . "/Documents/","Изменить");
                } else {
                    $currentUser = $admin;
                    $formBuilder = new AspDocumentApplicationFormBuilder("Вы успешно заполнили данные.","","/files/File/graduate_school/","Отправить");
                }

                $fieldOfStudyProfiles = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyProfileListByFieldOfStudyId($currentUser->getFieldOfStudy());
                $fieldOfStudyProfileSelectArr = array();
                foreach ($fieldOfStudyProfiles as $fieldOfStudyProfile) {
                    $fieldOfStudyProfileSelectArr[] = new OptionField($fieldOfStudyProfile->getId(),$fieldOfStudyProfile->getName());
                }
                $yearSelectArr = array();
                $currentYear = date("Y");
                for ($i=$currentYear; $i>=1900; $i--) {
                    $yearSelectArr[] = new OptionField($i,$i);
                }
                $levelOutSelectArr = array();
                $levelOutSelectArr[] = new OptionField("","", true);
                for ($i=1; $i<=7; $i++) {
                    $levelOutSelectArr[] = new OptionField($i,$i);
                }

                $monthSelectArr = array();
                for ($i=1; $i<=12; $i++) {
                    $monthSelectArr[] = new OptionField($i,$i);
                }

//                $values = array();
//
//                $values['field_of_study_profile'] = $currentUser->getFieldOfStudyProfile();
//                $values['prioritet_1'] = $currentUser->getPrioritetFirst();
//                $values['prioritet_2'] = $currentUser->getPrioritetSecond();


                $willPayRadioArr = array();
                $willPayRadioArr[] = new RadioField(0,"За счет бюджетных ассигнований федерального бюджета","will_pay_0",!$currentUser->isWillPay());
                $willPayRadioArr[] = new RadioField(1,"По договору об оказании платных образовательных услуг","will_pay_1",$currentUser->isWillPay());
                $willPayPrioritet = array();
                $willPayPrioritet[] = new OptionField("","");
                $willPayPrioritet[] = new OptionField("За счет бюджетных ассигнований федерального бюджета","За счет бюджетных ассигнований федерального бюджета");
                $willPayPrioritet[] = new OptionField("По договору об оказании платных образовательных услуг","По договору об оказании платных образовательных услуг");
                $diplomSelectArr = array();
                $diplomSelectArr[] = new OptionField("","");
                $diplomSelectArr[] = new OptionField("магистра","Магистра");
                $diplomSelectArr[] = new OptionField("специалиста","Специалиста");
                $examSelectArr = array();
                $examSelectArr[] = new OptionField("английский","Английский язык");
                $examSelectArr[] = new OptionField("испанский","Испанский язык");
                $examSelectArr[] = new OptionField("немецкий","Немецкий язык");
                $examSelectArr[] = new OptionField("французский","Французский язык");
                $examSpecCondRadioArr = array();
                $examSpecCondRadioArr[] = new RadioField(0,"Не нуждаюсь","exam_spec_cond_0",!$currentUser->isExamSpecCond());
                $examSpecCondRadioArr[] = new RadioField(1,"Нуждаюсь","exam_spec_cond_1",$currentUser->isExamSpecCond());
                $examSpecCondDisciplineSelectArr = array();
                $examSpecCondDisciplineSelectArr[] = new OptionField("","");
                $examSpecCondDisciplineSelectArr[] = new OptionField("специальная дисциплина","Специальная дисциплина");
                $examSpecCondDisciplineSelectArr[] = new OptionField("экономика и политика зарубежных стран","Экономика и политика зарубежных стран");
                $examSpecCondDisciplineSelectArr[] = new OptionField("иностранный язык","Иностранный язык");
                $obshRadioArr = array();
                $obshRadioArr[] = new RadioField(0,"Не нуждаюсь","obsh_0",!$currentUser->isObsh());
                $obshRadioArr[] = new RadioField(1,"Нуждаюсь","obsh_1",$currentUser->isObsh());
                $academicDegreeSelectArr = array();
                $academicDegreeSelectArr[] = new OptionField("не имею","Не имею");
                $academicDegreeSelectArr[] = new OptionField("Кандидат наук","Кандидат наук");
                $academicDegreeSelectArr[] = new OptionField("Доктор наук","Доктор наук");
                $academicRankSelectArr = array();
                $academicRankSelectArr[] = new OptionField("не имею","Не имею");
                $academicRankSelectArr[] = new OptionField("Доцент","Доцент");
                $academicRankSelectArr[] = new OptionField("Профессор","Профессор");
                $academicRankSelectArr[] = new OptionField("Член-корреспондент (член-корр.) Академии наук","Член-корреспондент (член-корр.) Академии наук");
                $academicRankSelectArr[] = new OptionField("Действительный член (академик) Академии наук","Действительный член (академик) Академии наук");



                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $willPay = "0";
                $willBudget = "0";

                if($currentUser->isWillPay()) {
                    $willPay = "1";
                }
                if($currentUser->isWillBudget()) {
                    $willBudget = "1";
                }

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Заявление"));
                $fieldOfStudyProfileSelectArr = $formBuilder->setSelectedOptionArr($fieldOfStudyProfileSelectArr,$currentUser->getFieldOfStudyProfile());
                $formBuilder->registerField(new FormField("field_of_study_profile", "select", true, "Профиль(направленность)", "Не выбран профиль","",false,"","",$fieldOfStudyProfileSelectArr));
                $formBuilder->registerField(new FormField("", "header-text", false, "Условия поступления"));
                $formBuilder->registerField(new FormField("will_budget", "checkbox", false, "За счет бюджетных ассигнований федерального бюджета", "","",false,"",$willBudget,array(),array()));
                $formBuilder->registerField(new FormField("will_pay", "checkbox", false, "По договору об оказании платных образовательных услуг", "","",false,"",$willPay,array(),array()));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Приоритет по программам обучения"));
                $willPayPrioritetFirst = $formBuilder->setSelectedOptionArr($willPayPrioritet,$currentUser->getPrioritetFirst());
                $formBuilder->registerField(new FormField("prioritet_1", "select", false, "В случае поступления по различным условиям поступления прошу рассматривать программы обучения в следующей приоритетности зачисления:<br> 1", "","",false,"","",$willPayPrioritetFirst));
                $willPayPrioritetSecond = $formBuilder->setSelectedOptionArr($willPayPrioritet,$currentUser->getPrioritetSecond());
                $formBuilder->registerField(new FormField("prioritet_2", "select", false, "2", "","",false,"","",$willPayPrioritetSecond));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Образование"));
                $formBuilder->registerField(new FormField("education", "text", true, "Образование","Не указано образование","Высшее",false,"",$currentUser->getEducation()));
                $formBuilder->registerField(new FormField("university", "text", true, "Наименование высшего учебного заведения(в краткой форме)","Не указан ВУЗ","ИМЭМО РАН",false,"",$currentUser->getUniversity()));
                $universityEndYear = $formBuilder->setSelectedOptionArr($yearSelectArr,$currentUser->getUniversityYearEnd());
                $formBuilder->registerField(new FormField("university_year_end", "select", true, "Год окончания","Не указан год окончания","2000", false,"","",$universityEndYear));
                $diplom = $formBuilder->setSelectedOptionArr($diplomSelectArr,$currentUser->getDiplom());
                $formBuilder->registerField(new FormField("diplom", "select", false, "Диплом (Заполняется при наличии на момент подачи документов)", "Не выбран тип диплома","",false,"","",$diplom));
                $formBuilder->registerField(new FormField("", "form-row", false, ""));
                $formBuilder->registerField(new FormField("diplom_series", "text", false, "Серия диплома","Не указана серия диплома","123456", false,"",$currentUser->getDiplomSeries(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("diplom_number", "text", false, "Номер диплома","Не указан номер диплома","1234567", false,"",$currentUser->getDiplomNumber(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("diplom_date", "date", false, "Дата выдачи диплома","Не указана дата выдачи диплома","", false,"",$currentUser->getDiplomDate(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new FormField("", "form-row-end", false, ""));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Список всех учебных заведений (В том числе и заполненное сверху)"));

                $studyFormSelectArr = array();
                $studyFormSelectArr[] = new OptionField("очная","Очная");
                $studyFormSelectArr[] = new OptionField("очно-заочная","Очно-заочная");
                $studyFormSelectArr[] = new OptionField("заочная","Заочная");

                $universityComplexFields = array();
                $universityComplexFields[] = new FormField("", "form-row", false, "");
                $universityComplexFields[] = new FormField("university_name_place", "text", false, "Название учебного заведения и его местонахождения","","ИМЭМО РАН", false,"","",array(),array(),"col-lg-8");
                $universityComplexFields[] = new FormField("university_faculty", "text", false, "Факультет или отделение","","Экономика", false,"","",array(),array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_form", "select", false, "Форма обучения ","","", false,"","",$studyFormSelectArr,array(),"col-lg-12");
                $universityComplexFields[] = new FormField("university_year_in", "select", false, "Год поступления","","2000", false,"","",$yearSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_year_out", "select", false, "Год окончания или ухода","","2000", false,"","",$yearSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_level_out", "select", false, "Если не окончил, то с какого курса ушел","","", false,"","",$levelOutSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new FormField("university_special_number", "text", false, "Какую специальность получил в результате окончания учебного заведения, указать № диплома или удостоверения","","Экономист, 123456", false,"","",array(),array(),"col-lg-6");
                $universityComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("university_list", "complex-block", false, "Добавить учебное заведение","","", false,"",$currentUser->getUniversityList(),array(),array(),"", $universityComplexFields));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Навыки и достижения"));
                $formBuilder->registerField(new FormField("languages", "text", false, "Какими иностранными языками владеете","","Английский язык: владею свободно, Немецкий язык: читаю и перевожу со словарем",false,"",$currentUser->getLanguages()));
                $academicDegree = $formBuilder->setSelectedOptionArr($academicDegreeSelectArr,$currentUser->getAcademicDegree());
                $formBuilder->registerField(new FormField("academic_degree", "select", false, "Ученая степень","","Кандидат наук, Доцент", false,"","",$academicDegree));
                $academicRank = $formBuilder->setSelectedOptionArr($academicRankSelectArr,$currentUser->getAcademicRank());
                $formBuilder->registerField(new FormField("academic_rank", "select", false, "Ученое звание","","Кандидат наук, Доцент", false,"","",$academicRank));
                $formBuilder->registerField(new FormField("gov_awards", "textarea", false, "Какие имеете правительственные награды (Когда и чем награждены)","","", false,"",$currentUser->getGovAwards(),array(),array(),"", array(),10));
                $formBuilder->registerField(new FormField("science_work_and_invents", "textarea", false, "Какие имеете научные труды и изобретения (общее количество научных трудов с указанием их общего объема в а.л.)","","2 научные статьи общим объемом 1,8 а.л.", false,"",$currentUser->getScienceWorkAndInvents(),array(),array(),"", array(),5));
                $formBuilder->registerField(new FormField("attachment_count", "text", false, "Количество прилагаемых файлов со сведениями об индивидуальных достижениях","","4",false,"",$currentUser->getAttachmentCount()));
                $formBuilder->registerField(new FormField("attachment_pages", "text", false, "Сумма всех страниц в прилагаемых файлах со сведениями об индивидуальных достижениях","","25",false,"",$currentUser->getAttachmentPages()));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Выполняемая работа с начала трудовой деятельности (включая учебу в высших и средних специальных учебных заведениях, военную службу, участие в партизанских отрядах и работу по совместительству)"));
                $formBuilder->registerField(new FormField("", "header-text", false, "При заполнении данного пункта учреждения, организации и предприятия необходимо именовать так, как они назывались в свое время, военную службу записывать с указанием должности."));

                $workComplexFields = array();
                $workComplexFields[] = new FormField("", "form-row", false, "");
                $workComplexFields[] = new FormField("work_month_in", "select", false, "Месяц вступления","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_year_in", "select", false, "Год вступления","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_month_out", "select", false, "Месяц ухода","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_year_out", "select", false, "Год ухода","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new FormField("work_position", "text", false, "Должность с указанием учреждения, организации, предприятия, а также министерства (ведомства)","","Профессор", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new FormField("work_place", "text", false, "Местонахождение учреждения, организации, предприятия","","г. Москва", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("work_list", "complex-block", false, "Добавить работу","","", false,"",$currentUser->getWorkList(),array(),array(),"", $workComplexFields));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Пребывание за границей"));

                $abroadPurposeSelectArr = array();
                $abroadPurposeSelectArr[] = new OptionField("работа","Работа");
                $abroadPurposeSelectArr[] = new OptionField("служебная командировка","Служебная командировка");
                $abroadPurposeSelectArr[] = new OptionField("туризм","Туризм");

                $abroadComplexFields = array();
                $abroadComplexFields[] = new FormField("", "form-row", false, "");
                $abroadComplexFields[] = new FormField("abroad_month_in", "select", false, "Месяц начала поездки","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_year_in", "select", false, "Год начала поездки","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_month_out", "select", false, "Месяц конца поездки","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_year_out", "select", false, "Год конца поездки","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new FormField("abroad_country", "text", false, "В какой стране","","Германия", false,"","",array(),array(),"col-lg-12");
                $abroadComplexFields[] = new FormField("abroad_purpose", "select", false, "Цель пребывания за границей","","", false,"","",$abroadPurposeSelectArr,array(),"col-lg-12");
                $abroadComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("abroad_list", "complex-block", false, "Добавить поездку","","", false,"",$currentUser->getAbroadList(),array(),array(),"", $abroadComplexFields));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Воинская обязанность"));
                $formBuilder->registerField(new FormField("army_rank", "text", false, "Отношение к воинской обязанности и воинское звание","","",false,"",$currentUser->getArmyRank()));
                $formBuilder->registerField(new FormField("army_structure", "text", false, "Состав","","",false,"",$currentUser->getArmyStructure()));
                $formBuilder->registerField(new FormField("army_type", "text", false, "Род войск","","", false,"",$currentUser->getArmyType()));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Вступительное испытание"));
                $formBuilder->registerField(new FormField("exam", "select", true, "Выбор вступительного испытания", "Не выбрано вступительное испытание","",false,"","",$examSelectArr));
                $formBuilder->registerField(new FormField("exam_spec_cond", "radio", false, "В создании специальных условий при проведении вступительных испытаний в связи с ограниченными возможностями и инвалидностью","","",false,"","",array(),$examSpecCondRadioArr));
                $specCondDiscipline = $formBuilder->setSelectedOptionArr($examSpecCondDisciplineSelectArr,$currentUser->getExamSpecCondDiscipline());
                $formBuilder->registerField(new FormField("exam_spec_cond_discipline", "select", false, "Наименование дисциплины для специальных условий","", "","",false,"",$specCondDiscipline));
                $formBuilder->registerField(new FormField("exam_spec_cond_list", "text", false, "Перечень специальных условий","","",false,"",$currentUser->getExamSpecCondList()));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Общежитие"));
                $formBuilder->registerField(new FormField("obsh", "radio", false, "В общежитии на период обучения","","",false,"","",array(),$obshRadioArr));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Семейное положение и адрес"));
                $formBuilder->registerField(new FormField("relatives", "textarea", true, "Семейное положение в момент заполнения личного листка (перечислить членов семьи с указанием года рождения)","Не заполнено семейное положение","", false,"",$currentUser->getRelatives(),array(),array(),"", array(),5));
                $formBuilder->registerField(new FormField("home_address_phone", "text", true, "Домашний адрес и домашний телефон","Не заполнен домашний адрес","г. Москва, ул. Профсоюзная, дом 23, квартира 2, +74950000000", false,"",$currentUser->getHomeAddressPhone()));

                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        $exitPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_login");
        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-1">
                <div class="text-danger">Внимание! Документы считаются поданными только после нажатия на кнопку "Подать документы".</div>
            </div>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode'])):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                               role="button">Вернуться в личный кабинет</a>
                        </div>
                    <?php endif;?>
                    <?php if(!empty($currentUser) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$currentUser->getId()?>"
                               role="button">Вернуться к данным пользователя</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">Инструкция по работе с личным кабинетом</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                           role="button">Техническая поддержка</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">Выход</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!$status->isDocumentApplicationAllow() && !$status->isEditDocumentApplicationAllow() && !$status->isAdminAllow()) {
            echo "Ошибка доступа.";
        } else {
            if (!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $posError ?>
                </div>
                <?php
            }
            $formBuilder->build();
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}