<?php

namespace AspModule\Services;

use AspModule\AspModule;
use AspModule\Models\User;

class FieldErrorService {

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @param User $user
     * @return string[]
     */
    function getCurrentUserFieldErrorList($user) {
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
            "field_of_study_profile" => "Научная специальность",
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
            "word_essay" => "(Word загрузка) Эссе по теме диссертации",
            "pdf_pension_certificate" => "(PDF загрузка) СНИЛС",
            "pdf_science_work_list" => "(PDF загрузка) Список научных трудов",
            "pdf_education" => "(PDF загрузка) Документ об образовании и о квалификации (с приложением)",
            "pdf_autobiography" => "(PDF загрузка) Автобиография",
            "pdf_personal_sheet" => "(PDF загрузка) Личный листок по учету кадров",
            "pdf_disabled_info" => "(PDF загрузка) Документ, подтверждающий инвалидность",
            "pdf_apply_for_entry" => "(PDF загрузка) Заявление о согласии на зачисление",
            "dissertation_theme" => "Предполагаемая тема диссертации",
            "dissertation_supervisor" => "Научный руководитель",
            "dissertation_department" => "Научное подразделение",
            "pension_certificate" => "СНИЛС",
            "send_back_type" => "Выбор способа возврата документов",
            "inform_type" => "Информирование",
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
            $fieldValueArr['work_out'.$counter] = "Работа №".$counter.": По настоящее время";
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

        $counter=1;

        foreach ($user->getScienceWorkList() as $item) {
            $fieldValueArr['science_work_type'.$counter] = "Научный труд №".$counter.": Тип научного труда";
            $fieldValueArr['science_work_name'.$counter] = "Научный труд №".$counter.": Наименование научного труда";
            $fieldValueArr['science_work_journal_name'.$counter] = "Научный труд №".$counter.": Название издательства, журнала";
            $fieldValueArr['science_work_journal_rinc'.$counter] = "Научный труд №".$counter.": Индексируется в РИНЦ ";
            $fieldValueArr['science_work_journal_wos'.$counter] = "Научный труд №".$counter.": Индексируется в WoS (СС, ESCI) ";
            $fieldValueArr['science_work_journal_scopus'.$counter] = "Научный труд №".$counter.": Индексируется в Scopus ";
            $fieldValueArr['science_work_site_link'.$counter] = "Научный труд №".$counter.": Ссылка на статью на сайте журнала";
            $fieldValueArr['science_work_year'.$counter] = "Научный труд №".$counter.": Год издания";
            $fieldValueArr['science_work_number'.$counter] = "Научный труд №".$counter.": Номер журнала";
            $fieldValueArr['science_work_pages'.$counter] = "Научный труд №".$counter.": Количество авторских/печатных листов (для книг), страницы в журнале (для статей)";
            $fieldValueArr['science_work_other_authors'.$counter] = "Научный труд №".$counter.": Примечание (указать соавторов)";
            $fieldValueArr['science_work_email'.$counter] = "Научный труд №".$counter.": E-mail издания для проверки";
            $counter++;
        }

        asort($fieldValueArr);

        return $fieldValueArr;
    }

}