<?php

class AspChangeUserStatusPageBuilder implements AspPageBuilder {
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
        if($status->isAdminAllow()) {
            if(empty($_GET['id'])) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $user = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['id']);
            if(empty($user)) {
                echo "Ошибка. Пользователя не существует.";
                exit;
            }
            $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $statusArr = array();

                foreach ($this->aspModule->getAspStatusManager()->getAllStatuses() as $allStatus) {
                    $statusArr[] = new OptionField($allStatus->getId(),$allStatus->getText());
                }

                $formBuilder = new AspChangeUserStatusFormBuilder("Вы успешно изменили статус для пользователя.","",__DIR__."/Documents/","Отправить");

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $fioR = $user->getFioR();
                if(empty($fioR)) {
                    $fioR = $user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName();
                }
                $formBuilder->registerField(new FormField("", "header", false, "Изменения статуса для ".$fioR));
                $formBuilder->registerField(new FormField("status", "select", true, "Статус", "","",false,"",$user->getStatus(),$statusArr));
                $formBuilder->registerField(new FormField("comment_from_admin", "textarea", false, "Комментарий для пользователя", "","",false,"",$user->getCommentFromAdmin(),array(),array(),"",array(),10));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Указать неправильно заполненные поля"));
                $formBuilder->registerField(new FormField("", "header-text", false, "Выберите поле и напишите текст ошибки"));

                $fieldValueArr = array(
                    "empty_reset" => "",
                    "gender" => "Пол",
                    "fio_r" => "ФИО в родительном падеже",
                    "nationality" => "Национальность",
                    "citizenship" => "Гражданство",
                    "birthplace" => "Место рождения",
                    "passport_series" => "Серия паспорта",
                    "passport_number" => "Номер паспорта",
                    "passport_place" => "Выдан (паспорт)",
                    "passport_date" => "Дата выдачи паспорта",
                    "passport_address" => "Адрес регистрации",
                    "field_of_study_profile" => "Профиль(направленность)",
                    "will_pay_0" => "Оплата обучения бюджет",
                    "will_pay_1" => "Оплата обучения оплата",
                    "will_pay_entry" => "На основные места в рамках контрольных цифр приема",
                    "will_budget_entry" => "На места по договору об оказании платных образовательных услуг",
                    "prioritet_1" => "Оплата обучения Приоритет 1",
                    "prioritet_2" => "Оплата обучения Приоритет 2",
                    "photo" => "Фотография",
                    "education" => "Образование",
                    "university" => "Наименование высшего учебного заведения(в краткой форме)",
                    "university_year_end" => "Год окончания",
                    "diplom" => "Диплом",
                    "diplom_series" => "Серия диплома",
                    "diplom_number" => "Номер диплома",
                    "diplom_date" => "Дата выдачи диплома",
                    "languages" => "Какими иностранными языками владеете",
                    "academic_degree" => "Ученая степень",
                    "academic_rank" => "Ученое звание",
                    "gov_awards" => "Какие имеете правительственные награды (Когда и чем награждены)",
                    "science_work_and_invents" => "Какие имеете научные труды и изобретения",
                    "attachment_count" => "Количество прилагаемых файлов со сведениями об индивидуальных достижениях",
                    "attachment_pages" => "Сумма всех страниц в прилагаемых файлах со сведениями об индивидуальных достижениях",
                    "army_rank" => "Отношение к воинской обязанности и воинское звание",
                    "army_structure" => "Состав (воинская обязанность)",
                    "army_type" => "Род войск",
                    "exam" => "Выбор вступительного испытания",
                    "exam_spec_cond_0" => "В создании специальных условий при проведении вступительных испытаний в связи с ограниченными возможностями и инвалидностью не нуждаюсь",
                    "exam_spec_cond_1" => "В создании специальных условий при проведении вступительных испытаний в связи с ограниченными возможностями и инвалидностью нуждаюсь",
                    "exam_spec_cond_discipline" => "Наименование дисциплины для специальных условий",
                    "exam_spec_cond_list" => "Перечень специальных условий",
                    "obsh_0" => "Общежитие не нуждаюсь",
                    "obsh_1" => "Общежитие нуждаюсь",
                    "relatives" => "Семейное положение в момент заполнения личного листка",
                    "home_address_phone" => "Домашний адрес и домашний телефон",
                    "pdf_application" => "(PDF загрузка) Заявление",
                    "pdf_personal_document" => "(PDF загрузка) Документ, удостоверяющий личность",
                    "pdf_education" => "(PDF загрузка) Документ об образовании и о квалификации (с приложением)",
                    "pdf_autobiography" => "(PDF загрузка) Автобиография",
                    "pdf_personal_sheet" => "(PDF загрузка) Личный листок по учету кадров",
                    "pdf_disabled_info" => "(PDF загрузка) Документ, подтверждающий инвалидность",
                    "pdf_apply_for_entry" => "(PDF загрузка) Заявление о согласии на зачисление"
                );

                $counter=1;
                foreach ($user->getUniversityList() as $item) {
                    $fieldValueArr['university_name_place'.$counter] = "Учебное заведение №".$counter.": Название учебного заведения и его местонахождения ";
                    $fieldValueArr['university_faculty'.$counter] = "Учебное заведение №".$counter.": Факультет или отделение ";
                    $fieldValueArr['university_form'.$counter] = "Учебное заведение №".$counter.": Форма обучения ";
                    $fieldValueArr['university_year_in'.$counter] = "Учебное заведение №".$counter.": Год поступления ";
                    $fieldValueArr['university_year_out'.$counter] = "Учебное заведение №".$counter.": Год окончания или ухода ";
                    $fieldValueArr['university_level_out'.$counter] = "Учебное заведение №".$counter.": Если не окончил, то с какого курса ушел ";
                    $fieldValueArr['university_special_number'.$counter] = "Учебное заведение №".$counter.": Какую специальность получил в результате окончания учебного заведения, указать № диплома или удостоверения ";
                    $counter++;
                }

                $counter=1;

                foreach ($user->getWorkList() as $item) {
                    $fieldValueArr['work_month_in'.$counter] = "Работа №".$counter.": Месяц вступления";
                    $fieldValueArr['work_year_in'.$counter] = "Работа №".$counter.": Год вступления";
                    $fieldValueArr['work_month_out'.$counter] = "Работа №".$counter.": Месяц ухода";
                    $fieldValueArr['work_year_out'.$counter] = "Работа №".$counter.": Год ухода";
                    $fieldValueArr['work_position'.$counter] = "Работа №".$counter.": Должность с указанием учреждения, организации, предприятия, а также министерства (ведомства)";
                    $fieldValueArr['work_place'.$counter] = "Работа №".$counter.": Местонахождение учреждения, организации, предприятия";
                    $counter++;
                }

                $counter=1;

                foreach ($user->getAbroadList() as $item) {
                    $fieldValueArr['abroad_month_in'.$counter] = "Поездка №".$counter.": Месяц начала поездки";
                    $fieldValueArr['abroad_year_in'.$counter] = "Поездка №".$counter.": Год начала поездки";
                    $fieldValueArr['abroad_month_out'.$counter] = "Поездка №".$counter.": Месяц конца поездки";
                    $fieldValueArr['abroad_year_out'.$counter] = "Поездка №".$counter.": Год конца поездки";
                    $fieldValueArr['abroad_country'.$counter] = "Поездка №".$counter.": В какой стране";
                    $fieldValueArr['abroad_purpose'.$counter] = "Поездка №".$counter.": Цель пребывания за границей";
                    $counter++;
                }

                $counter=1;

                foreach ($user->getPdfIndividualAchievements() as $item) {
                    $fieldValueArr['pdf_individual_achievement'.$counter] = "(PDF загрузка) Индивидуальное достижение №".$counter;
                    $counter++;
                }

                asort($fieldValueArr);

                $fieldsArr = array();
                foreach ($fieldValueArr as $k=>$value) {
                    $fieldsArr[] = new OptionField($k,$value);
                }
                $workComplexFields = array();
                $workComplexFields[] = new FormField("", "form-row", false, "");
                $workComplexFields[] = new FormField("field_error_id", "select", false, "Поле","","", false,"","",$fieldsArr,array(),"col-lg-12");
                $workComplexFields[] = new FormField("field_error_text", "text", false, "Ошибка","","", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("fields_error", "complex-block", false, "Добавить ошибку","","", false,"",$user->getFieldsError(),array(),array(),"", $workComplexFields));

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
                    <?php if(!empty($user) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$user->getId()?>"
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
        if(!$status->isAdminAllow()) {
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