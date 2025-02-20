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
            "gender" => "���",
            "fio_r" => "��� � ����������� ������",
            "nationality" => "��������������",
            "citizenship" => "�����������",
            "birthplace" => "����� ��������",
            "passport_series" => "����� ��������",
            "passport_number" => "����� ��������",
            "passport_place" => "����� (�������)",
            "passport_date" => "���� ������ ��������",
            "passport_address" => "����� �����������",
            "field_of_study_profile" => "������� �������������",
            "will_pay_0" => "������ �������� ������",
            "will_pay_1" => "������ �������� ������",
            "will_pay_entry" => "�� �������� ����� � ������ ����������� ���� ������",
            "will_budget_entry" => "�� ����� �� �������� �� �������� ������� ��������������� �����",
            "prioritet_1" => "������ �������� ��������� 1",
            "prioritet_2" => "������ �������� ��������� 2",
            "photo" => "����������",
            "education" => "�����������",
            "university" => "������������ ������� �������� ���������(� ������� �����)",
            "university_year_end" => "��� ���������",
            "diplom" => "������",
            "diplom_series" => "����� �������",
            "diplom_number" => "����� �������",
            "diplom_date" => "���� ������ �������",
            "languages" => "������ ������������ ������� ��������",
            "academic_degree" => "������ �������",
            "academic_rank" => "������ ������",
            "gov_awards" => "����� ������ ����������������� ������� (����� � ��� ����������)",
            "science_work_and_invents" => "����� ������ ������� ����� � �����������",
            "attachment_count" => "���������� ����������� ������ �� ���������� �� �������������� �����������",
            "attachment_pages" => "����� ���� ������� � ����������� ������ �� ���������� �� �������������� �����������",
            "army_rank" => "��������� � �������� ����������� � �������� ������",
            "army_structure" => "������ (�������� �����������)",
            "army_type" => "��� �����",
            "exam" => "����� �������������� ���������",
            "exam_spec_cond_0" => "� �������� ����������� ������� ��� ���������� ������������� ��������� � ����� � ������������� ������������� � ������������� �� ��������",
            "exam_spec_cond_1" => "� �������� ����������� ������� ��� ���������� ������������� ��������� � ����� � ������������� ������������� � ������������� ��������",
            "exam_spec_cond_discipline" => "������������ ���������� ��� ����������� �������",
            "exam_spec_cond_list" => "�������� ����������� �������",
            "obsh_0" => "��������� �� ��������",
            "obsh_1" => "��������� ��������",
            "relatives" => "�������� ��������� � ������ ���������� ������� ������",
            "home_address_phone" => "�������� ����� � �������� �������",
            "pdf_application" => "(PDF ��������) ���������",
            "pdf_personal_document" => "(PDF ��������) ��������, �������������� ��������",
            "word_essay" => "(Word ��������) ���� �� ���� �����������",
            "pdf_pension_certificate" => "(PDF ��������) �����",
            "pdf_science_work_list" => "(PDF ��������) ������ ������� ������",
            "pdf_education" => "(PDF ��������) �������� �� ����������� � � ������������ (� �����������)",
            "pdf_autobiography" => "(PDF ��������) �������������",
            "pdf_personal_sheet" => "(PDF ��������) ������ ������ �� ����� ������",
            "pdf_disabled_info" => "(PDF ��������) ��������, �������������� ������������",
            "pdf_apply_for_entry" => "(PDF ��������) ��������� � �������� �� ����������",
            "dissertation_theme" => "�������������� ���� �����������",
            "dissertation_supervisor" => "������� ������������",
            "dissertation_department" => "������� �������������",
            "pension_certificate" => "�����",
            "send_back_type" => "����� ������� �������� ����������",
            "inform_type" => "��������������",
        );

        $counter=1;
        foreach ($user->getUniversityList() as $item) {
            $fieldValueArr['university_name_place'.$counter] = "������� ��������� �".$counter.": �������� �������� ��������� � ��� ��������������� ";
            $fieldValueArr['university_faculty'.$counter] = "������� ��������� �".$counter.": ��������� ��� ��������� ";
            $fieldValueArr['university_form'.$counter] = "������� ��������� �".$counter.": ����� �������� ";
            $fieldValueArr['university_year_in'.$counter] = "������� ��������� �".$counter.": ��� ����������� ";
            $fieldValueArr['university_year_out'.$counter] = "������� ��������� �".$counter.": ��� ��������� ��� ����� ";
            $fieldValueArr['university_level_out'.$counter] = "������� ��������� �".$counter.": ���� �� �������, �� � ������ ����� ���� ";
            $fieldValueArr['university_special_number'.$counter] = "������� ��������� �".$counter.": ����� ������������� ������� � ���������� ��������� �������� ���������, ������� � ������� ��� ������������� ";
            $counter++;
        }

        $counter=1;

        foreach ($user->getWorkList() as $item) {
            $fieldValueArr['work_month_in'.$counter] = "������ �".$counter.": ����� ����������";
            $fieldValueArr['work_year_in'.$counter] = "������ �".$counter.": ��� ����������";
            $fieldValueArr['work_out'.$counter] = "������ �".$counter.": �� ��������� �����";
            $fieldValueArr['work_month_out'.$counter] = "������ �".$counter.": ����� �����";
            $fieldValueArr['work_year_out'.$counter] = "������ �".$counter.": ��� �����";
            $fieldValueArr['work_position'.$counter] = "������ �".$counter.": ��������� � ��������� ����������, �����������, �����������, � ����� ������������ (���������)";
            $fieldValueArr['work_place'.$counter] = "������ �".$counter.": ��������������� ����������, �����������, �����������";
            $counter++;
        }

        $counter=1;

        foreach ($user->getAbroadList() as $item) {
            $fieldValueArr['abroad_month_in'.$counter] = "������� �".$counter.": ����� ������ �������";
            $fieldValueArr['abroad_year_in'.$counter] = "������� �".$counter.": ��� ������ �������";
            $fieldValueArr['abroad_month_out'.$counter] = "������� �".$counter.": ����� ����� �������";
            $fieldValueArr['abroad_year_out'.$counter] = "������� �".$counter.": ��� ����� �������";
            $fieldValueArr['abroad_country'.$counter] = "������� �".$counter.": � ����� ������";
            $fieldValueArr['abroad_purpose'.$counter] = "������� �".$counter.": ���� ���������� �� ��������";
            $counter++;
        }

        $counter=1;

        foreach ($user->getPdfIndividualAchievements() as $item) {
            $fieldValueArr['pdf_individual_achievement'.$counter] = "(PDF ��������) �������������� ���������� �".$counter;
            $counter++;
        }

        $counter=1;

        foreach ($user->getScienceWorkList() as $item) {
            $fieldValueArr['science_work_type'.$counter] = "������� ���� �".$counter.": ��� �������� �����";
            $fieldValueArr['science_work_name'.$counter] = "������� ���� �".$counter.": ������������ �������� �����";
            $fieldValueArr['science_work_journal_name'.$counter] = "������� ���� �".$counter.": �������� ������������, �������";
            $fieldValueArr['science_work_journal_rinc'.$counter] = "������� ���� �".$counter.": ������������� � ���� ";
            $fieldValueArr['science_work_journal_wos'.$counter] = "������� ���� �".$counter.": ������������� � WoS (��, ESCI) ";
            $fieldValueArr['science_work_journal_scopus'.$counter] = "������� ���� �".$counter.": ������������� � Scopus ";
            $fieldValueArr['science_work_site_link'.$counter] = "������� ���� �".$counter.": ������ �� ������ �� ����� �������";
            $fieldValueArr['science_work_year'.$counter] = "������� ���� �".$counter.": ��� �������";
            $fieldValueArr['science_work_number'.$counter] = "������� ���� �".$counter.": ����� �������";
            $fieldValueArr['science_work_pages'.$counter] = "������� ���� �".$counter.": ���������� ���������/�������� ������ (��� ����), �������� � ������� (��� ������)";
            $fieldValueArr['science_work_other_authors'.$counter] = "������� ���� �".$counter.": ���������� (������� ���������)";
            $fieldValueArr['science_work_email'.$counter] = "������� ���� �".$counter.": E-mail ������� ��� ��������";
            $counter++;
        }

        asort($fieldValueArr);

        return $fieldValueArr;
    }

}