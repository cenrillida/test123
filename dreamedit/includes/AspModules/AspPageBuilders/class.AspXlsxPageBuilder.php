<?php

class AspXlsxPageBuilder implements AspPageBuilder {
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

            if($_SESSION[lang]!="/en") {
                $sortField = array();
                $sortField[] = new OptionField("","");
                $sortField[] = new OptionField("lastname","Фамилия");
                $sortField[] = new OptionField("firstname","Имя");
                $sortField[] = new OptionField("field_of_study","Направление");
                $sortField[] = new OptionField("field_of_study_profile","Профиль");
                $sortField[] = new OptionField("pdf_uploaded_date","Дата подачи документов");
                $sortField[] = new OptionField("status","Статус");

                $sortType = array();
                $sortType[] = new OptionField("","");
                $sortType[] = new OptionField("ASC","В порядке возрастания");
                $sortType[] = new OptionField("DESC","В порядке убывания");

                $formBuilder = new AspXlsxFormBuilder("xlsx успешно сформирован.","","/files/File/graduate_school/","Сформировать");

                $formBuilder->registerField(new FormField("", "header", false, "Выбор полей для формирования документа Excel"));
                $formBuilder->registerField(new FormField("lastname", "checkbox", false, "Фамилия", "Не введена фамилия","Иванов"));
                $formBuilder->registerField(new FormField("firstname", "checkbox", false, "Имя", "Не введено имя","Иван"));
                $formBuilder->registerField(new FormField("thirdname", "checkbox", false, "Отчество", "","Иванович"));
                $formBuilder->registerField(new FormField("email", "checkbox", false, "E-mail", "Не введен e-mail","example@imemo.ru",false,"Неверный формат e-mail"));
                $formBuilder->registerField(new FormField("phone", "checkbox", false, "Номер телефона", "Не введен номер телефона","+7999"));
                $formBuilder->registerField(new FormField("birthdate", "checkbox", false, "Дата рождения", "Не введена дата рождения"));
                $formBuilder->registerField(new FormField("field_of_study", "checkbox", false, "Направление подготовки", "Не выбрано направление","",false,"",""));
                $formBuilder->registerField(new FormField("field_of_study_profile", "checkbox", false, "Профиль", "Не выбрано направление","",false,"",""));
                $formBuilder->registerField(new FormField("gender", "checkbox", false, "Пол", "Не выбран пол","",false,"",""));
                $formBuilder->registerField(new FormField("fio_r", "checkbox", false, "ФИО в родительном падеже", "Не введено ФИО","Иванова Ивана Ивановича",false,""));
                $formBuilder->registerField(new FormField("nationality", "checkbox", false, "Национальность", "Не введена национальность","Русский",false,""));
                $formBuilder->registerField(new FormField("citizenship", "checkbox", false, "Гражданство", "Не введено гражданство","Российская Федерация",false,""));
                $formBuilder->registerField(new FormField("birthplace", "checkbox", false, "Место рождения", "Не введено место рождения","г. Москва",false,""));
                $formBuilder->registerField(new FormField("passport_series", "checkbox", false, "Серия паспорта", "Не введена серия паспорта","1234",false,""));
                $formBuilder->registerField(new FormField("passport_number", "checkbox", false, "Номер паспорта", "Не введен номер паспорта","123456",false,""));
                $formBuilder->registerField(new FormField("passport_place", "checkbox", false, "Выдан", "Не введено место выдачи паспорта","Отделением УФМС...",false,""));
                $formBuilder->registerField(new FormField("passport_date", "checkbox", false, "Дата выдачи паспорта", "Не введена дата выдачи паспорта","",false,""));
                $formBuilder->registerField(new FormField("passport_address", "checkbox", false, "Адрес регистрации", "Не введен адрес регистрации","гор. Москва, ул. Профсоюзная, дом 23, квартира 2",false,""));
                $formBuilder->registerField(new FormField("conditions", "checkbox", false, "Условия поступления"));
                $formBuilder->registerField(new FormField("conditions_entry", "checkbox", false, "Условия зачисления"));
                $formBuilder->registerField(new FormField("prioritet_1", "checkbox", false, "Приоритет поступления 1"));
                $formBuilder->registerField(new FormField("prioritet_2", "checkbox", false, "Приоритет поступления 2"));
                $formBuilder->registerField(new FormField("education", "checkbox", false, "Образование"));
                $formBuilder->registerField(new FormField("university", "checkbox", false, "Наименование высшего учебного заведения"));
                $formBuilder->registerField(new FormField("university_year_end", "checkbox", false, "Год окончания"));
                $formBuilder->registerField(new FormField("diplom", "checkbox", false, "Диплом"));
                $formBuilder->registerField(new FormField("diplom_series", "checkbox", false, "Серия диплома"));
                $formBuilder->registerField(new FormField("diplom_number", "checkbox", false, "Номер диплома"));
                $formBuilder->registerField(new FormField("diplom_date", "checkbox", false, "Дата выдачи диплома"));
                $formBuilder->registerField(new FormField("languages", "checkbox", false, "Какими иностранными языками владеете","","Английский язык: владею свободно, Немецкий язык: читаю и перевожу со словарем",false,""));
                $formBuilder->registerField(new FormField("academic_degree", "checkbox", false, "Ученая степень","","Кандидат наук, Доцент", false,"",""));
                $formBuilder->registerField(new FormField("academic_rank", "checkbox", false, "Ученое звание","","Кандидат наук, Доцент", false,"",""));
                $formBuilder->registerField(new FormField("gov_awards", "checkbox", false, "Какие имеете правительственные награды (Когда и чем награждены)","","", false,""));
                $formBuilder->registerField(new FormField("science_work_and_invents", "checkbox", false, "Какие имеете научные труды и изобретения","","", false,""));
                $formBuilder->registerField(new FormField("attachment_count", "checkbox", false, "Количество прилагаемых файлов со сведениями об индивидуальных достижениях","","4",false,""));
                $formBuilder->registerField(new FormField("attachment_pages", "checkbox", false, "Сумма всех страниц в прилагаемых файлах со сведениями об индивидуальных достижениях","","25",false,""));
                $formBuilder->registerField(new FormField("army_rank", "checkbox", false, "Отношение к воинской обязанности и воинское звание","","",false,""));
                $formBuilder->registerField(new FormField("army_structure", "checkbox", false, "Состав","","",false,""));
                $formBuilder->registerField(new FormField("army_type", "checkbox", false, "Род войск","","", false,""));
                $formBuilder->registerField(new FormField("exam", "checkbox", false, "Выбор вступительного испытания", "Не выбрано вступительное испытание","",false,"",""));
                $formBuilder->registerField(new FormField("exam_spec_cond", "checkbox", false, "В создании специальных условий при проведении вступительных испытаний в связи с ограниченными возможностями и инвалидностью","","",false,"","",array()));
                $formBuilder->registerField(new FormField("exam_spec_cond_discipline", "checkbox", false, "Наименование дисциплины для специальных условий","", "","",false,""));
                $formBuilder->registerField(new FormField("exam_spec_cond_list", "checkbox", false, "Перечень специальных условий","","",false,""));
                $formBuilder->registerField(new FormField("obsh", "checkbox", false, "В общежитии на период обучения","","",false,"","",array()));
                $formBuilder->registerField(new FormField("relatives", "checkbox", false, "Семейное положение в момент заполнения личного листка (перечислить членов семьи с указанием года рождения)","Не заполнено семейное положение","", false,""));
                $formBuilder->registerField(new FormField("home_address_phone", "checkbox", false, "Домашний адрес и домашний телефон","Не заполнен домашний адрес","г. Москва, ул. Профсоюзная, дом 23, квартира 2, +74950000000", false,""));
                $formBuilder->registerField(new FormField("university_list", "checkbox", false, "Список ВУЗов"));
                $formBuilder->registerField(new FormField("work_list", "checkbox", false, "Список работ"));
                $formBuilder->registerField(new FormField("abroad_list", "checkbox", false, "Список поездок за границу"));
                $formBuilder->registerField(new FormField("pdf_application", "checkbox", false, "Ссылка на заявление (только для администратора)"));
                $formBuilder->registerField(new FormField("pdf_personal_document", "checkbox", false, "Ссылка на документ подтверждающий личность (только для администратора)"));
                $formBuilder->registerField(new FormField("pdf_education", "checkbox", false, "Ссылка на документ об образовании (только для администратора)"));
                $formBuilder->registerField(new FormField("pdf_autobiography", "checkbox", false, "Ссылка на документ автобиографии (только для администратора)"));
                $formBuilder->registerField(new FormField("pdf_personal_sheet", "checkbox", false, "Ссылка на личный листок по учету кадров (только для администратора)"));
                $formBuilder->registerField(new FormField("pdf_disabled_info", "checkbox", false, "Ссылка на информацию по инвалидности (только для администратора)"));
                $formBuilder->registerField(new FormField("pdf_apply_for_entry", "checkbox", false, "Ссылка на заявление о согласии на зачисление (только для администратора)"));
                $formBuilder->registerField(new FormField("status", "checkbox", false, "Статус"));
                $formBuilder->registerField(new FormField("pdf_uploaded_date", "checkbox", false, "Дата подачи документов"));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Какие статусы выводить"));
                foreach ($this->aspModule->getAspStatusManager()->getAllStatuses() as $aspStatus) {
                    $formBuilder->registerField(new FormField("status-".$aspStatus->getId(), "checkbox", false, $aspStatus->getText()));
                }
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Сортировка"));
                $formBuilder->registerField(new FormField("sort_field_1", "select", false, "Поле сортировки 1", "","",false,"","",$sortField));
                $formBuilder->registerField(new FormField("sort_field_type_1", "select", false, "Порядок сортировки поля 1", "","",false,"","",$sortType));
                $formBuilder->registerField(new FormField("sort_field_2", "select", false, "Поле сортировки 2", "","",false,"","",$sortField));
                $formBuilder->registerField(new FormField("sort_field_type_2", "select", false, "Порядок сортировки поля 2", "","",false,"","",$sortType));
                $formBuilder->registerField(new FormField("sort_field_3", "select", false, "Поле сортировки 3", "","",false,"","",$sortField));
                $formBuilder->registerField(new FormField("sort_field_type_3", "select", false, "Порядок сортировки поля 3", "","",false,"","",$sortType));
                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "Дата отправки документов"));
                $formBuilder->registerField(new FormField("send_document_interval", "checkbox", false, "Интервал поданых документов"));
                $formBuilder->registerField(new FormField("date_from", "date", false, "Дата начала выборки поданых документов (включительно)", "","",false,"",""));
                $formBuilder->registerField(new FormField("date_to", "date", false, "Дата конца выборки поданых документов (включительно)", "","",false,"",""));

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
            ?>
            <div class="row justify-content-start mb-3">
                <div class="ml-3 mt-3">
                    <a class="btn btn-lg imemo-button text-uppercase" id="checkAll" href="#" role="button">Отметить все поля</a>
                </div>
                <div class="ml-3 mt-3">
                    <a class="btn btn-lg imemo-button text-uppercase" id="uncheckAll" href="#" role="button">Отключить все поля</a>
                </div>
            </div>
            <?php
            $formBuilder->build();
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }
}