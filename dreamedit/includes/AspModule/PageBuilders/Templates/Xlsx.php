<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\FormBuilders\Templates\XlsxFormBuilder;
use AspModule\PageBuilders\PageBuilder;

class Xlsx implements PageBuilder {
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
        if($status->isAdminAllow()) {

            if($_SESSION[lang]!="/en") {
                $sortField = array();
                $sortField[] = new \OptionField("","");
                $sortField[] = new \OptionField("lastname","�������");
                $sortField[] = new \OptionField("firstname","���");
                $sortField[] = new \OptionField("field_of_study","������ ������� ��������������");
                $sortField[] = new \OptionField("field_of_study_profile","������� �������������");
                $sortField[] = new \OptionField("pdf_uploaded_date","���� ������ ����������");
                $sortField[] = new \OptionField("status","������");
                $sortField[] = new \OptionField("pension_certificate","�����");
                $sortField[] = new \OptionField("special_code","���");

                $sortType = array();
                $sortType[] = new \OptionField("","");
                $sortType[] = new \OptionField("ASC","� ������� �����������");
                $sortType[] = new \OptionField("DESC","� ������� ��������");

                $applicationsYearArr = array();
                $applicationsYearArr[] = new \OptionField(-1, "���");
                $applicationsYearArr[] = new \OptionField(0, "�� ���������");
                foreach ($this->aspModule->getApplicationsYearService()->getApplicationsYearList() as $applicationsYear) {
                    $applicationsYearArr[] = new \OptionField($applicationsYear->getId(), $applicationsYear->getName());
                }

                $formBuilder = new XlsxFormBuilder("xlsx ������� �����������.","","/files/File/graduate_school/","������������",false);

                $formBuilder->registerField(new \FormField("", "header", false, "�������� � ������ ��������� ������� ��"));
                $formBuilder->registerField(new \FormField("document_application_for_study", "checkbox", false, "��������"));
                $formBuilder->registerField(new \FormField("document_application_for_dissertation", "checkbox", false, "������������"));
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "����� ����� ��� ������������ ��������� Excel"));
                $formBuilder->registerField(new \FormField("lastname", "checkbox", false, "�������", "�� ������� �������","������"));
                $formBuilder->registerField(new \FormField("firstname", "checkbox", false, "���", "�� ������� ���","����"));
                $formBuilder->registerField(new \FormField("thirdname", "checkbox", false, "��������", "","��������"));
                $formBuilder->registerField(new \FormField("email", "checkbox", false, "E-mail", "�� ������ e-mail","example@imemo.ru",false,"�������� ������ e-mail"));
                $formBuilder->registerField(new \FormField("phone", "checkbox", false, "����� ��������", "�� ������ ����� ��������","+7999"));
                $formBuilder->registerField(new \FormField("birthdate", "checkbox", false, "���� ��������", "�� ������� ���� ��������"));
                $formBuilder->registerField(new \FormField("application_year", "checkbox", false, "�����"));
                $formBuilder->registerField(new \FormField("document_application_for", "checkbox", false, "��������� ������ ��"));
                $formBuilder->registerField(new \FormField("dissertation_theme", "checkbox", false, "�������������� ���� �����������"));
                $formBuilder->registerField(new \FormField("dissertation_supervisor", "checkbox", false, "������� ������������"));
                $formBuilder->registerField(new \FormField("dissertation_department", "checkbox", false, "������� �������������"));
                $formBuilder->registerField(new \FormField("field_of_study", "checkbox", false, "������ ������� ��������������", "�� ������� ������ ������� ��������������","",false,"",""));
                $formBuilder->registerField(new \FormField("field_of_study_profile", "checkbox", false, "������� �������������", "�� ������� ������� �������������","",false,"",""));
                $formBuilder->registerField(new \FormField("gender", "checkbox", false, "���", "�� ������ ���","",false,"",""));
                $formBuilder->registerField(new \FormField("fio_r", "checkbox", false, "��� � ����������� ������", "�� ������� ���","������� ����� ���������",false,""));
                $formBuilder->registerField(new \FormField("nationality", "checkbox", false, "��������������", "�� ������� ��������������","�������",false,""));
                $formBuilder->registerField(new \FormField("citizenship", "checkbox", false, "�����������", "�� ������� �����������","���������� ���������",false,""));
                $formBuilder->registerField(new \FormField("birthplace", "checkbox", false, "����� ��������", "�� ������� ����� ��������","�. ������",false,""));
                $formBuilder->registerField(new \FormField("passport_series", "checkbox", false, "����� ��������", "�� ������� ����� ��������","1234",false,""));
                $formBuilder->registerField(new \FormField("passport_number", "checkbox", false, "����� ��������", "�� ������ ����� ��������","123456",false,""));
                $formBuilder->registerField(new \FormField("passport_place", "checkbox", false, "�����", "�� ������� ����� ������ ��������","���������� ����...",false,""));
                $formBuilder->registerField(new \FormField("passport_date", "checkbox", false, "���� ������ ��������", "�� ������� ���� ������ ��������","",false,""));
                $formBuilder->registerField(new \FormField("passport_address", "checkbox", false, "����� �����������", "�� ������ ����� �����������","���. ������, ��. �����������, ��� 23, �������� 2",false,""));
                $formBuilder->registerField(new \FormField("pension_certificate", "checkbox", false, "�����", "�� ������ �����","",false,""));
                $formBuilder->registerField(new \FormField("special_code", "checkbox", false, "���", "�� ������ ���","",false,""));
                $formBuilder->registerField(new \FormField("pension_certificate_or_special_code", "checkbox", false, "��� ��� �����", "�� ������ ����� ��� ���","",false,""));
                $formBuilder->registerField(new \FormField("conditions", "checkbox", false, "������� �����������"));
                $formBuilder->registerField(new \FormField("conditions_entry", "checkbox", false, "������� ����������"));
                $formBuilder->registerField(new \FormField("prioritet_1", "checkbox", false, "��������� ����������� 1"));
                $formBuilder->registerField(new \FormField("prioritet_2", "checkbox", false, "��������� ����������� 2"));
                $formBuilder->registerField(new \FormField("education", "checkbox", false, "�����������"));
                $formBuilder->registerField(new \FormField("university", "checkbox", false, "������������ ������� �������� ���������"));
                $formBuilder->registerField(new \FormField("university_year_end", "checkbox", false, "��� ���������"));
                $formBuilder->registerField(new \FormField("diplom", "checkbox", false, "������"));
                $formBuilder->registerField(new \FormField("diplom_series", "checkbox", false, "����� �������"));
                $formBuilder->registerField(new \FormField("diplom_number", "checkbox", false, "����� �������"));
                $formBuilder->registerField(new \FormField("diplom_date", "checkbox", false, "���� ������ �������"));
                $formBuilder->registerField(new \FormField("languages", "checkbox", false, "������ ������������ ������� ��������","","���������� ����: ������ ��������, �������� ����: ����� � �������� �� ��������",false,""));
                $formBuilder->registerField(new \FormField("academic_degree", "checkbox", false, "������ �������","","�������� ����, ������", false,"",""));
                $formBuilder->registerField(new \FormField("academic_rank", "checkbox", false, "������ ������","","�������� ����, ������", false,"",""));
                $formBuilder->registerField(new \FormField("gov_awards", "checkbox", false, "����� ������ ����������������� ������� (����� � ��� ����������)","","", false,""));
                $formBuilder->registerField(new \FormField("science_work_and_invents", "checkbox", false, "����� ������ ������� ����� � �����������","","", false,""));
                $formBuilder->registerField(new \FormField("attachment_count", "checkbox", false, "���������� ����������� ������ �� ���������� �� �������������� �����������","","4",false,""));
                $formBuilder->registerField(new \FormField("attachment_pages", "checkbox", false, "����� ���� ������� � ����������� ������ �� ���������� �� �������������� �����������","","25",false,""));
                $formBuilder->registerField(new \FormField("army_rank", "checkbox", false, "��������� � �������� ����������� � �������� ������","","",false,""));
                $formBuilder->registerField(new \FormField("army_structure", "checkbox", false, "������","","",false,""));
                $formBuilder->registerField(new \FormField("army_type", "checkbox", false, "��� �����","","", false,""));
                $formBuilder->registerField(new \FormField("exam", "checkbox", false, "����� �������������� ���������", "�� ������� ������������� ���������","",false,"",""));
                $formBuilder->registerField(new \FormField("exam_spec_cond", "checkbox", false, "� �������� ����������� ������� ��� ���������� ������������� ��������� � ����� � ������������� ������������� � �������������","","",false,"","",array()));
                $formBuilder->registerField(new \FormField("exam_spec_cond_discipline", "checkbox", false, "������������ ���������� ��� ����������� �������","", "","",false,""));
                $formBuilder->registerField(new \FormField("exam_spec_cond_list", "checkbox", false, "�������� ����������� �������","","",false,""));
                $formBuilder->registerField(new \FormField("obsh", "checkbox", false, "� ��������� �� ������ ��������","","",false,"","",array()));
                $formBuilder->registerField(new \FormField("relatives", "checkbox", false, "�������� ��������� � ������ ���������� ������� ������ (����������� ������ ����� � ��������� ���� ��������)","�� ��������� �������� ���������","", false,""));
                $formBuilder->registerField(new \FormField("send_back_type", "checkbox", false, "������� ����������","","",false,"","",array()));
                $formBuilder->registerField(new \FormField("inform_type", "checkbox", false, "��������������","","",false,"","",array()));
                $formBuilder->registerField(new \FormField("home_address_phone", "checkbox", false, "�������� ����� � �������� �������","�� �������� �������� �����","�. ������, ��. �����������, ��� 23, �������� 2, +74950000000", false,""));
                $formBuilder->registerField(new \FormField("university_list", "checkbox", false, "������ �����"));
                $formBuilder->registerField(new \FormField("work_list", "checkbox", false, "������ �����"));
                $formBuilder->registerField(new \FormField("abroad_list", "checkbox", false, "������ ������� �� �������"));
                $formBuilder->registerField(new \FormField("science_work_list", "checkbox", false, "������ ������� ������"));
                $formBuilder->registerField(new \FormField("pdf_consent_data_processing", "checkbox", false, "������ �� �������� �� ��������� ������������ ������ (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_application", "checkbox", false, "������ �� ��������� (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_personal_document", "checkbox", false, "������ �� �������� �������������� �������� (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("word_essay", "checkbox", false, "������ �� ���� �� ���� ����������� (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_pension_certificate", "checkbox", false, "������ �� ����� (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_science_work_list", "checkbox", false, "������ �� ������ ������� ������ (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_education", "checkbox", false, "������ �� �������� �� ����������� (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_education_period_reference", "checkbox", false, "������ �� ������� �� ��������/������� ��������"));
                $formBuilder->registerField(new \FormField("pdf_autobiography", "checkbox", false, "������ �� �������� ������������� (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_personal_sheet", "checkbox", false, "������ �� ������ ������ �� ����� ������ (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_disabled_info", "checkbox", false, "������ �� ���������� �� ������������ (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("pdf_apply_for_entry", "checkbox", false, "������ �� ��������� � �������� �� ���������� (������ ��� ��������������)"));
                $formBuilder->registerField(new \FormField("status", "checkbox", false, "������"));
                $formBuilder->registerField(new \FormField("pdf_uploaded_date", "checkbox", false, "���� ������ ����������"));
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "����� ������� ��������"));
                foreach ($this->aspModule->getStatusService()->getAllStatuses() as $aspStatus) {
                    $formBuilder->registerField(new \FormField("status-".$aspStatus->getId(), "checkbox", false, $aspStatus->getText()));
                }
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "�����"));
                $formBuilder->registerField(new \FormField("applications_year_id", "select", false, "�����", "","",false,"",-1,$applicationsYearArr));
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "����������"));
                $formBuilder->registerField(new \FormField("sort_field_1", "select", false, "���� ���������� 1", "","",false,"","",$sortField));
                $formBuilder->registerField(new \FormField("sort_field_type_1", "select", false, "������� ���������� ���� 1", "","",false,"","",$sortType));
                $formBuilder->registerField(new \FormField("sort_field_2", "select", false, "���� ���������� 2", "","",false,"","",$sortField));
                $formBuilder->registerField(new \FormField("sort_field_type_2", "select", false, "������� ���������� ���� 2", "","",false,"","",$sortType));
                $formBuilder->registerField(new \FormField("sort_field_3", "select", false, "���� ���������� 3", "","",false,"","",$sortField));
                $formBuilder->registerField(new \FormField("sort_field_type_3", "select", false, "������� ���������� ���� 3", "","",false,"","",$sortType));
                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "���� �������� ����������"));
                $formBuilder->registerField(new \FormField("send_document_interval", "checkbox", false, "�������� ������� ����������"));
                $formBuilder->registerField(new \FormField("date_from", "date", false, "���� ������ ������� ������� ���������� (������������)", "","",false,"",""));
                $formBuilder->registerField(new \FormField("date_to", "date", false, "���� ����� ������� ������� ���������� (������������)", "","",false,"",""));

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
                           role="button">��������� � ������ ������������</a>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php
        if(!$status->isAdminAllow()) {
            echo "������ �������.";
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
                    <a class="btn btn-lg imemo-button text-uppercase" id="checkAll" href="#" role="button">�������� ��� ����</a>
                </div>
                <div class="ml-3 mt-3">
                    <a class="btn btn-lg imemo-button text-uppercase" id="uncheckAll" href="#" role="button">��������� ��� ����</a>
                </div>
            </div>
            <?php
            $formBuilder->build();
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }
}