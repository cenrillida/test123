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
                echo "������. ������������ �� ����������.";
                exit;
            }
            $user = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['id']);
            if(empty($user)) {
                echo "������. ������������ �� ����������.";
                exit;
            }
            $this->aspModule->getAspModuleUserManager()->setCurrentEditableUser($user);
            if($_SESSION[lang]!="/en") {

                $statusArr = array();

                foreach ($this->aspModule->getAspStatusManager()->getAllStatuses() as $allStatus) {
                    $statusArr[] = new OptionField($allStatus->getId(),$allStatus->getText());
                }

                $formBuilder = new AspChangeUserStatusFormBuilder("�� ������� �������� ������ ��� ������������.","",__DIR__."/Documents/","���������");

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $fioR = $user->getFioR();
                if(empty($fioR)) {
                    $fioR = $user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName();
                }
                $formBuilder->registerField(new FormField("", "header", false, "��������� ������� ��� ".$fioR));
                $formBuilder->registerField(new FormField("status", "select", true, "������", "","",false,"",$user->getStatus(),$statusArr));
                $formBuilder->registerField(new FormField("comment_from_admin", "textarea", false, "����������� ��� ������������", "","",false,"",$user->getCommentFromAdmin(),array(),array(),"",array(),10));

                $formBuilder->registerField(new FormField("", "hr", false, ""));
                $formBuilder->registerField(new FormField("", "header", false, "������� ����������� ����������� ����"));
                $formBuilder->registerField(new FormField("", "header-text", false, "�������� ���� � �������� ����� ������"));

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
                    "field_of_study_profile" => "�������(��������������)",
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
                    "pdf_education" => "(PDF ��������) �������� �� ����������� � � ������������ (� �����������)",
                    "pdf_autobiography" => "(PDF ��������) �������������",
                    "pdf_personal_sheet" => "(PDF ��������) ������ ������ �� ����� ������",
                    "pdf_disabled_info" => "(PDF ��������) ��������, �������������� ������������",
                    "pdf_apply_for_entry" => "(PDF ��������) ��������� � �������� �� ����������"
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

                asort($fieldValueArr);

                $fieldsArr = array();
                foreach ($fieldValueArr as $k=>$value) {
                    $fieldsArr[] = new OptionField($k,$value);
                }
                $workComplexFields = array();
                $workComplexFields[] = new FormField("", "form-row", false, "");
                $workComplexFields[] = new FormField("field_error_id", "select", false, "����","","", false,"","",$fieldsArr,array(),"col-lg-12");
                $workComplexFields[] = new FormField("field_error_text", "text", false, "������","","", false,"","",array(),array(),"col-lg-12");
                $workComplexFields[] = new FormField("", "form-row-end", false, "");

                $formBuilder->registerField(new FormField("fields_error", "complex-block", false, "�������� ������","","", false,"",$user->getFieldsError(),array(),array(),"", $workComplexFields));

                $posError = $formBuilder->processPostBuild();

            }
        }


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        $exitPageId = $this->pages->getFirstPageIdByTemplate("asp_lk_login");
        ?>
        <div class="container-fluid">
            <div class="row justify-content-between mb-1">
                <div class="text-danger">��������! ��������� ��������� ��������� ������ ����� ������� �� ������ "������ ���������".</div>
            </div>
            <div class="row justify-content-between mb-3">
                <div>
                    <?php if(!empty($_GET['mode'])):?>
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                           role="button">��������� � ������ �������</a>
                    </div>
                    <?php endif;?>
                    <?php if(!empty($user) && $status->isAdminAllow()):?>
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=getUserData&id=<?=$user->getId()?>"
                               role="button">��������� � ������ ������������</a>
                        </div>
                    <?php endif;?>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" target="_blank" href="/files/File/ru/graduate_school/instruction.pdf"
                           role="button">���������� �� ������ � ������ ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=techSupportContact"
                           role="button">����������� ���������</a>
                    </div>
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                           role="button">�����</a>
                    </div>
                </div>
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
            $formBuilder->build();
        }
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}