<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\AdminEditFormBuilder;
use AspModule\FormBuilders\Templates\DocumentApplicationFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class DocumentApplication implements PageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $admin = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getStatusService()->getStatusBy($admin->getStatus());
        if($status->isDocumentApplicationAllow() || $status->isEditDocumentApplicationAllow() || $status->isAdminAllow()) {
            if($_SESSION[lang]!="/en") {

                if($status->isAdminAllow()) {
                    if (empty($_GET['user_id'])) {
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $currentUser = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
                    if (empty($currentUser)) {
                        echo "Ошибка. Пользователя не существует.";
                        exit;
                    }
                    $this->aspModule->getUserService()->setCurrentEditableUser($currentUser);
                    $formBuilder = new AdminEditFormBuilder("Данные успешно изменены.","",__DIR__ . "/Documents/","Изменить",false);
                } else {
                    $currentUser = $admin;
                    $formBuilder = new DocumentApplicationFormBuilder("Вы успешно заполнили данные.","","/files/File/graduate_school/","Отправить", false);
                }

                $fieldOfStudyProfiles = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyProfileListByFieldOfStudyId($currentUser->getFieldOfStudy());
                $fieldOfStudyProfileSelectArr = array();
                foreach ($fieldOfStudyProfiles as $fieldOfStudyProfile) {
                    $fieldOfStudyProfileSelectArr[] = new \OptionField($fieldOfStudyProfile->getId(),$fieldOfStudyProfile->getName());
                }
                $yearSelectArr = array();
                $currentYear = date("Y");
                for ($i=$currentYear; $i>=1900; $i--) {
                    $yearSelectArr[] = new \OptionField($i,$i);
                }
                $levelOutSelectArr = array();
                $levelOutSelectArr[] = new \OptionField("","", true);
                for ($i=1; $i<=7; $i++) {
                    $levelOutSelectArr[] = new \OptionField($i,$i);
                }

                $monthSelectArr = array();
                for ($i=1; $i<=12; $i++) {
                    $monthSelectArr[] = new \OptionField($i,$i);
                }

//                $values = array();
//
//                $values['field_of_study_profile'] = $currentUser->getFieldOfStudyProfile();
//                $values['prioritet_1'] = $currentUser->getPrioritetFirst();
//                $values['prioritet_2'] = $currentUser->getPrioritetSecond();


                $willPayRadioArr = array();
                $willPayRadioArr[] = new \RadioField(0,"За счет бюджетных ассигнований федерального бюджета","will_pay_0",!$currentUser->isWillPay());
                $willPayRadioArr[] = new \RadioField(1,"По договору об оказании платных образовательных услуг","will_pay_1",$currentUser->isWillPay());
                $willPayPrioritet = array();
                $willPayPrioritet[] = new \OptionField("","");
                $willPayPrioritet[] = new \OptionField("За счет бюджетных ассигнований федерального бюджета","За счет бюджетных ассигнований федерального бюджета");
                $willPayPrioritet[] = new \OptionField("По договору об оказании платных образовательных услуг","По договору об оказании платных образовательных услуг");
                $diplomSelectArr = array();
                $diplomSelectArr[] = new \OptionField("","");
                $diplomSelectArr[] = new \OptionField("магистра","Магистра");
                $diplomSelectArr[] = new \OptionField("специалиста","Специалиста");
                $examSelectArr = array();
                $examSelectArr[] = new \OptionField("английский","Английский язык");
                $examSelectArr[] = new \OptionField("испанский","Испанский язык");
                $examSelectArr[] = new \OptionField("немецкий","Немецкий язык");
                $examSelectArr[] = new \OptionField("французский","Французский язык");
                $examSpecCondRadioArr = array();
                $examSpecCondRadioArr[] = new \RadioField(0,"Не нуждаюсь","exam_spec_cond_0",!$currentUser->isExamSpecCond());
                $examSpecCondRadioArr[] = new \RadioField(1,"Нуждаюсь","exam_spec_cond_1",$currentUser->isExamSpecCond());
                $examSpecCondDisciplineSelectArr = array();
                $examSpecCondDisciplineSelectArr[] = new \OptionField("","");
                $examSpecCondDisciplineSelectArr[] = new \OptionField("специальная дисциплина","Специальная дисциплина");
                $examSpecCondDisciplineSelectArr[] = new \OptionField("экономика и политика зарубежных стран","Экономика и политика зарубежных стран");
                $examSpecCondDisciplineSelectArr[] = new \OptionField("иностранный язык","Иностранный язык");
                $obshRadioArr = array();
                $obshRadioArr[] = new \RadioField(0,"Не нуждаюсь","obsh_0",!$currentUser->isObsh());
                $obshRadioArr[] = new \RadioField(1,"Нуждаюсь","obsh_1",$currentUser->isObsh());
                $academicDegreeSelectArr = array();
                $academicDegreeSelectArr[] = new \OptionField("не имею","Не имею");
                $academicDegreeSelectArr[] = new \OptionField("Кандидат наук","Кандидат наук");
                $academicDegreeSelectArr[] = new \OptionField("Доктор наук","Доктор наук");
                $academicRankSelectArr = array();
                $academicRankSelectArr[] = new \OptionField("не имею","Не имею");
                $academicRankSelectArr[] = new \OptionField("Доцент","Доцент");
                $academicRankSelectArr[] = new \OptionField("Профессор","Профессор");
                $academicRankSelectArr[] = new \OptionField("Член-корреспондент (член-корр.) Академии наук","Член-корреспондент (член-корр.) Академии наук");
                $academicRankSelectArr[] = new \OptionField("Действительный член (академик) Академии наук","Действительный член (академик) Академии наук");
                $scienceWorkTypeSelectArr = array();
                foreach ($this->aspModule->getScienceWorkService()->getScienceWorkTypes() as $key => $scienceWorkType) {
                    $scienceWorkTypeSelectArr[] = new \OptionField($key, $scienceWorkType);
                }

                $sendBackTypeSelectArr = array();
                $sendBackTypeSelectArr[] = new \OptionField("1",$this->aspModule->getUserService()->getSendBackTypeText(1));
                $sendBackTypeSelectArr[] = new \OptionField("2",$this->aspModule->getUserService()->getSendBackTypeText(2));

                $informTypeSelectArr = array();
                $informTypeSelectArr[] = new \OptionField("1",$this->aspModule->getUserService()->getInformTypeText(1));
                $informTypeSelectArr[] = new \OptionField("2",$this->aspModule->getUserService()->getInformTypeText(2));


                $fieldsError = $currentUser->getFieldsError();

                foreach ($fieldsError as $item) {
                    $formBuilder->registerErrorField(new \FormFieldError($item['field_error_id'],$item['field_error_text']));
                }

                $willPay = "0";
                $willBudget = "0";

                if($currentUser->isWillPay()) {
                    $willPay = "1";
                }
                if($currentUser->isWillBudget()) {
                    $willBudget = "1";
                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Заявление"));
                $fieldOfStudyProfileSelectArr = $formBuilder->setSelectedOptionArr($fieldOfStudyProfileSelectArr,$currentUser->getFieldOfStudyProfile());
                $fieldOfStudyProfileTitle = "Научная специальность";
                $fieldOfStudyProfileTitleCheck = "Не выбрана научная специальность";

                $formBuilder->registerField(new \FormField("field_of_study_profile", "select", true, $fieldOfStudyProfileTitle, $fieldOfStudyProfileTitleCheck,"",false,"","",$fieldOfStudyProfileSelectArr));

                if(!$currentUser->isForDissertationAttachment()) {
                    $formBuilder->registerField(new \FormField("", "header-text", false, "Условия поступления"));
                    $formBuilder->registerField(new \FormField("will_budget", "checkbox", false, "За счет бюджетных ассигнований федерального бюджета", "", "", false, "", $willBudget, array(), array()));
                    $formBuilder->registerField(new \FormField("will_pay", "checkbox", false, "По договору об оказании платных образовательных услуг", "", "", false, "", $willPay, array(), array()));
                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Приоритет по программам обучения"));
                    $willPayPrioritetFirst = $formBuilder->setSelectedOptionArr($willPayPrioritet, $currentUser->getPrioritetFirst());
                    $formBuilder->registerField(new \FormField("prioritet_1", "select", false, "В случае поступления по различным условиям поступления прошу рассматривать программы обучения в следующей приоритетности зачисления:<br> 1", "", "", false, "", "", $willPayPrioritetFirst));
                    $willPayPrioritetSecond = $formBuilder->setSelectedOptionArr($willPayPrioritet, $currentUser->getPrioritetSecond());
                    $formBuilder->registerField(new \FormField("prioritet_2", "select", false, "2", "", "", false, "", "", $willPayPrioritetSecond));
                } else {

                    $departmentSelectArr = array();
                    $departmentSelectArr[] = new \OptionField("", "");
                    foreach ($this->aspModule->getDepartmentService()->getAllDepartments() as $departmentEl) {
                        $departmentSelectArr[] = new \OptionField($departmentEl->getId(), $departmentEl->getTitle());
                    }

                    $formBuilder->registerField(new \FormField("dissertation_theme", "textarea", false, "Предполагаемая тема диссертации","","", false,"",$currentUser->getDissertationTheme(),array(),array(),"", array(),4));
                    $formBuilder->registerField(new \FormField("dissertation_supervisor", "text", false, "Научный руководитель","","", false,"",$currentUser->getDissertationSupervisor(),array(),array(),""));
                    $formBuilder->registerField(new \FormField("dissertation_department", "select", false, "Научное подразделение","","", false,"",$currentUser->getDissertationDepartment(),$departmentSelectArr));
                }


                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Образование"));
                $formBuilder->registerField(new \FormField("education", "text", true, "Образование","Не указано образование","Высшее",false,"",$currentUser->getEducation()));
                $formBuilder->registerField(new \FormField("university", "text", true, "Наименование высшего учебного заведения(в краткой форме)","Не указан ВУЗ","ИМЭМО РАН",false,"",$currentUser->getUniversity()));
                $universityEndYear = $formBuilder->setSelectedOptionArr($yearSelectArr,$currentUser->getUniversityYearEnd());
                $formBuilder->registerField(new \FormField("university_year_end", "select", true, "Год окончания","Не указан год окончания","2000", false,"","",$universityEndYear));
                $diplom = $formBuilder->setSelectedOptionArr($diplomSelectArr,$currentUser->getDiplom());
                $formBuilder->registerField(new \FormField("diplom", "select", false, "Диплом (Заполняется при наличии на момент подачи документов)", "Не выбран тип диплома","",false,"","",$diplom));
                $formBuilder->registerField(new \FormField("", "form-row", false, ""));
                $formBuilder->registerField(new \FormField("diplom_series", "text", false, "Серия диплома","Не указана серия диплома","123456", false,"",$currentUser->getDiplomSeries(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new \FormField("diplom_number", "text", false, "Номер диплома","Не указан номер диплома","1234567", false,"",$currentUser->getDiplomNumber(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new \FormField("diplom_date", "date", false, "Дата выдачи диплома","Не указана дата выдачи диплома","", false,"",$currentUser->getDiplomDate(),array(),array(),"col-sm-4"));
                $formBuilder->registerField(new \FormField("", "form-row-end", false, ""));
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Список всех учебных заведений (В том числе и заполненное сверху)"));

                $studyFormSelectArr = array();
                $studyFormSelectArr[] = new \OptionField("очная","Очная");
                $studyFormSelectArr[] = new \OptionField("очно-заочная","Очно-заочная");
                $studyFormSelectArr[] = new \OptionField("заочная","Заочная");

                $universityComplexFields = array();
                $universityComplexFields[] = new \FormField("", "form-row", false, "");
                $universityComplexFields[] = new \FormField("university_name_place", "text", false, "Название учебного заведения и его местонахождения","","ИМЭМО РАН (сокращенно)", false,"","",array(),array(),"col-lg-8");
                $universityComplexFields[] = new \FormField("university_faculty", "text", false, "Факультет или отделение","","Экономика (сокращенно)", false,"","",array(),array(),"col-lg-4");
                $universityComplexFields[] = new \FormField("university_form", "select", false, "Форма обучения ","","", false,"","",$studyFormSelectArr,array(),"col-lg-12");
                $universityComplexFields[] = new \FormField("university_year_in", "select", false, "Год поступления","","2000", false,"","",$yearSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new \FormField("university_year_out", "select", false, "Год окончания или ухода","","2000", false,"","",$yearSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new \FormField("university_level_out", "select", false, "Если не окончил, то с какого курса ушел","","", false,"","",$levelOutSelectArr,array(),"col-lg-4");
                $universityComplexFields[] = new \FormField("university_special_number", "text", false, "Какую специальность получил в результате окончания учебного заведения, указать № диплома или удостоверения","","Экономист, 123456", false,"","",array(),array(),"col-lg-6");
                $universityComplexFields[] = new \FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new \FormField("university_list", "complex-block", false, "Добавить учебное заведение","","", false,"",$currentUser->getUniversityList(),array(),array(),"", $universityComplexFields));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Навыки и достижения"));
                $formBuilder->registerField(new \FormField("languages", "text", false, "Какими иностранными языками владеете","","Английский язык: владею свободно, Немецкий язык: читаю и перевожу со словарем",false,"",$currentUser->getLanguages()));
                $academicDegree = $formBuilder->setSelectedOptionArr($academicDegreeSelectArr,$currentUser->getAcademicDegree());
                $formBuilder->registerField(new \FormField("academic_degree", "select", false, "Ученая степень","","Кандидат наук, Доцент", false,"","",$academicDegree));
                $academicRank = $formBuilder->setSelectedOptionArr($academicRankSelectArr,$currentUser->getAcademicRank());
                $formBuilder->registerField(new \FormField("academic_rank", "select", false, "Ученое звание","","Кандидат наук, Доцент", false,"","",$academicRank));
                $formBuilder->registerField(new \FormField("gov_awards", "textarea", false, "Какие имеете правительственные награды (Когда и чем награждены)","","", false,"",$currentUser->getGovAwards(),array(),array(),"", array(),10));
                $formBuilder->registerField(new \FormField("science_work_and_invents", "textarea", false, "Какие имеете научные труды и изобретения (общее количество научных трудов с указанием их общего объема в а.л.)","","2 научные статьи общим объемом 1,8 а.л.", false,"",$currentUser->getScienceWorkAndInvents(),array(),array(),"", array(),5));
                $formBuilder->registerField(new \FormField("attachment_count", "text", false, "Количество прилагаемых файлов со сведениями об индивидуальных достижениях","","4",false,"",$currentUser->getAttachmentCount()));
                $formBuilder->registerField(new \FormField("attachment_pages", "text", false, "Сумма всех страниц в прилагаемых файлах со сведениями об индивидуальных достижениях","","25",false,"",$currentUser->getAttachmentPages()));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Выполняемая работа с начала трудовой деятельности (включая учебу в высших и средних специальных учебных заведениях, военную службу, участие в партизанских отрядах и работу по совместительству)"));
                $formBuilder->registerField(new \FormField("", "header-text", false, "При заполнении данного пункта учреждения, организации и предприятия необходимо именовать так, как они назывались в свое время, военную службу записывать с указанием должности."));

                $workComplexFields = array();
                $workComplexFields[] = new \FormField("", "form-row", false, "");
                $workComplexFields[] = new \FormField("work_month_in", "select", false, "Месяц вступления","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new \FormField("work_year_in", "select", false, "Год вступления","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new \FormField("work_out", "checkbox", false, "По настоящее время","","", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new \FormField("work_month_out", "select", false, "Месяц ухода","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new \FormField("work_year_out", "select", false, "Год ухода","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $workComplexFields[] = new \FormField("work_position", "text", false, "Должность с указанием учреждения, организации, предприятия, а также министерства (ведомства)","","Сокращенно", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new \FormField("work_place", "text", false, "Местонахождение учреждения, организации, предприятия","","Сокращенно", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new \FormField("", "form-row-end", false, "");

                $workList = $currentUser->getWorkList();
                foreach ($workList as $key=>$value) {
                    if($value['work_out']) {
                        $workList[$key]['work_out'] = "1";
                    } else {
                        $workList[$key]['work_out'] = "0";
                    }
                }

                $formBuilder->registerField(new \FormField("work_list", "complex-block", false, "Добавить работу","","", false,"",$workList,array(),array(),"", $workComplexFields));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Пребывание за границей"));

                $abroadPurposeSelectArr = array();
                $abroadPurposeSelectArr[] = new \OptionField("работа","Работа");
                $abroadPurposeSelectArr[] = new \OptionField("служебная командировка","Служебная командировка");
                $abroadPurposeSelectArr[] = new \OptionField("туризм","Туризм");
                $abroadPurposeSelectArr[] = new \OptionField("обучение","Обучение");

                $abroadComplexFields = array();
                $abroadComplexFields[] = new \FormField("", "form-row", false, "");
                $abroadComplexFields[] = new \FormField("abroad_month_in", "select", false, "Месяц начала поездки","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new \FormField("abroad_year_in", "select", false, "Год начала поездки","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new \FormField("abroad_month_out", "select", false, "Месяц конца поездки","","2000", false,"","",$monthSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new \FormField("abroad_year_out", "select", false, "Год конца поездки","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                $abroadComplexFields[] = new \FormField("abroad_country", "text", false, "В какой стране","","Германия", false,"","",array(),array(),"col-lg-12");
                $abroadComplexFields[] = new \FormField("abroad_purpose", "select", false, "Цель пребывания за границей","","", false,"","",$abroadPurposeSelectArr,array(),"col-lg-12");
                $abroadComplexFields[] = new \FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new \FormField("abroad_list", "complex-block", false, "Добавить поездку","","", false,"",$currentUser->getAbroadList(),array(),array(),"", $abroadComplexFields));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Воинская обязанность"));
                $formBuilder->registerField(new \FormField("army_rank", "text", false, "Отношение к воинской обязанности и воинское звание","","",false,"",$currentUser->getArmyRank()));
                $formBuilder->registerField(new \FormField("army_structure", "text", false, "Состав","","",false,"",$currentUser->getArmyStructure()));
                $formBuilder->registerField(new \FormField("army_type", "text", false, "Род войск","","", false,"",$currentUser->getArmyType()));

                if(!$currentUser->isForDissertationAttachment()) {
                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Вступительное испытание"));
                    $formBuilder->registerField(new \FormField("exam", "select", true, "Выбор вступительного испытания", "Не выбрано вступительное испытание", "", false, "", "", $examSelectArr));
                    $formBuilder->registerField(new \FormField("exam_spec_cond", "radio", false, "В создании специальных условий при проведении вступительных испытаний в связи с ограниченными возможностями и инвалидностью", "", "", false, "", "", array(), $examSpecCondRadioArr));
                    $specCondDiscipline = $formBuilder->setSelectedOptionArr($examSpecCondDisciplineSelectArr, $currentUser->getExamSpecCondDiscipline());
                    $formBuilder->registerField(new \FormField("exam_spec_cond_discipline", "select", false, "Наименование дисциплины для специальных условий", "", "", "", false, "", $specCondDiscipline));
                    $formBuilder->registerField(new \FormField("exam_spec_cond_list", "text", false, "Перечень специальных условий", "", "", false, "", $currentUser->getExamSpecCondList()));
                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Общежитие"));
                    $formBuilder->registerField(new \FormField("obsh", "radio", false, "В общежитии на период обучения", "", "", false, "", "", array(), $obshRadioArr));
                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Возврат документов"));
                    $formBuilder->registerField(new \FormField("send_back_type", "select", true, "В случае непоступления прошу осуществить возврат оригиналов документов следующим способом", "Не выбрано метод возврата документов", "", false, "", "", $sendBackTypeSelectArr));
                }

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Семейное положение и адрес"));
                $formBuilder->registerField(new \FormField("relatives", "textarea", true, "Семейное положение в момент заполнения личного листка (перечислить членов семьи с указанием года рождения)","Не заполнено семейное положение","", false,"",$currentUser->getRelatives(),array(),array(),"", array(),5));
                $formBuilder->registerField(new \FormField("home_address_phone", "text", true, "Домашний адрес и домашний телефон","Не заполнен домашний адрес","г. Москва, ул. Профсоюзная, дом 23, квартира 2, +74950000000", false,"",$currentUser->getHomeAddressPhone()));

                if($currentUser->isForDissertationAttachment()) {
                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Информирование"));
                    $formBuilder->registerField(new \FormField("inform_type", "select", true, "Прошу информировать меня о ходе рассмотрения вопроса о прикреплении", "Не выбрано метод информирования", "", false, "", "", $informTypeSelectArr));

                    $formBuilder->registerField(new \FormField("", "hr", false, ""));
                    $formBuilder->registerField(new \FormField("", "header", false, "Список трудов"));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "Список трудов включает только опубликованные работы за весь период научной деятельности либо за последние пять лет."));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "Заполнять в хронологическом порядке."));
                    $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/files/File/ru/graduate_school/instruction_science_work.pdf\" role=\"button\">Скачать инструкцию по заполнению научных трудов</a>"));

                    $scienceWorkComplexFields = array();
                    $scienceWorkComplexFields[] = new \FormField("", "form-row", false, "");
                    $scienceWorkComplexFields[] = new \FormField("science_work_type", "select", false, "Тип научного труда","","", false,"","",$scienceWorkTypeSelectArr,array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_name", "text", false, "Наименование научного труда","","", false,"","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_journal_name", "text", false, "Название издательства, журнала","","", false,"","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_journal_rinc", "checkbox", false, "Индексируется в РИНЦ","","", false,"","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_journal_wos", "checkbox", false, "Индексируется в WoS (СС, ESCI)","","", false,"","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_journal_scopus", "checkbox", false, "Индексируется в Scopus","","", false,"","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_site_link", "text", false, "Ссылка на статью на сайте журнала","","https://", false,"","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_year", "select", false, "Год издания","","2000", false,"","",$yearSelectArr,array(),"col-lg-6");
                    $scienceWorkComplexFields[] = new \FormField("science_work_number", "text", false, "Номер журнала","","№2", false,"","",array(),array(),"col-lg-6");
                    $scienceWorkComplexFields[] = new \FormField("science_work_pages", "text", false, "Количество авторских/печатных листов (для книг), страницы в журнале (для статей) вводить в числовом формате без пробелов; десятые при наличии отделяются запятой (пример: 5,6)","","", false,"","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("science_work_other_authors", "text", false, "Примечание (указать соавторов)","","", false,"","",array(),array(),"col-lg-12");
                    //$scienceWorkComplexFields[] = new \FormField("science_work_email", "email", false, "E-mail издания для проверки", "Не введен e-mail","example@imemo.ru",false,"Неверный формат e-mail","",array(),array(),"col-lg-12");
                    $scienceWorkComplexFields[] = new \FormField("", "form-row-end", false, "");

                    $formBuilder->registerField(new \FormField("science_work_list", "complex-block", false, "Добавить научный труд","","", false,"",$currentUser->getScienceWorkList(),array(),array(),"", $scienceWorkComplexFields));
                }

                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->aspModule->getAuthorizationService()->isAuthorized()):
            $this->aspModule->getPageBuilderManager()->setPageBuilder("top");
            $this->aspModule->getPageBuilder()->build(array("main_back" => true));
            ?>
        <?php endif;?>
        <div class="container-fluid">
            <div class="row justify-content-start mb-3">
                <?php if(!empty($currentUser) && $status->isAdminAllow()):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$currentUser->getId()?>"
                           role="button">Вернуться к данным пользователя</a>
                    </div>
                <?php endif;?>
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

            $workCount = 1;
            foreach ($workList as $key=>$value) {
                if($value['work_out']) {
                    ?>
                    <script>
                        $( document ).ready(function() {
                            $('#work_month_out<?=$workCount?>').attr( "disabled", true );
                            $('#work_year_out<?=$workCount?>').attr( "disabled", true );
                        });
                    </script>
                    <?php
                }
                ?>
                <script>
                    $("#work_out<?=$workCount?>").change(function() {
                        if(this.checked) {
                            $('#work_month_out<?=$workCount?>').attr('disabled', true);
                            $('#work_year_out<?=$workCount?>').attr('disabled', true);
                        } else {
                            $('#work_month_out<?=$workCount?>').attr('disabled', false);
                            $('#work_year_out<?=$workCount?>').attr('disabled', false);
                        }
                    });
                </script>
                <?php
                $workCount++;
            }
            $scienceWorkCount = 1;
            foreach ($currentUser->getScienceWorkList() as $key=>$value) {
                ?>
                <script>
                    //$("#science_work_number<?//=$scienceWorkCount?>//").on("input",function(el) {
                    //    if(el.currentTarget.value[0] !== '№') {
                    //        el.currentTarget.value = el.currentTarget.value.replace("№", '');
                    //        el.currentTarget.value = '№' + el.currentTarget.value;
                    //    }
                    //});
                </script>
                <?php
                $scienceWorkCount++;
            }
            ?>
            <script>
                $('#addListwork_list').on( "click", function() {
                    var currentElement = $('#count-work_list').val();
                    $("#work_out"+currentElement).change(function() {
                        if(this.checked) {
                            $('#work_month_out'+currentElement).attr('disabled', true);
                            $('#work_year_out'+currentElement).attr('disabled', true);
                        } else {
                            $('#work_month_out'+currentElement).attr('disabled', false);
                            $('#work_year_out'+currentElement).attr('disabled', false);
                        }
                    });
                });
                $('#addListscience_work_list').on( "click", function() {
                    var currentElement = $('#count-science_work_list').val();
                    $("#science_work_number"+currentElement).val('№');
                    // $("#science_work_number"+currentElement).on("input",function(el) {
                    //     if(el.currentTarget.value[0] !== '№') {
                    //         el.currentTarget.value = el.currentTarget.value.replace("№", '');
                    //         el.currentTarget.value = '№' + el.currentTarget.value;
                    //     }
                    // });
                });

                function priorityChange () {
                    if($('#will_pay')[0].checked && $('#will_budget')[0].checked) {
                        $('#prioritet_1').attr('disabled', false);
                        $('#prioritet_2').attr('disabled', false);
                    } else {
                        $('#prioritet_1').attr('disabled', true);
                        $('#prioritet_1').val('');
                        $('#prioritet_2').attr('disabled', true);
                        $('#prioritet_2').val('');
                    }
                }

                $("#will_pay").change(function() {
                    priorityChange();
                });

                $("#will_budget").change(function() {
                    priorityChange();
                });

                $(document).ready(function () {
                    priorityChange();
                });
            </script>
            <?php
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}