<?php

class AspXlsxService {

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
    public function createXlsx($fields) {
        $currentUser = $this->aspModule->getCurrentUser();
        $status = $this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus());

        if($status->isAdminAllow()) {

            require_once dirname(__FILE__) . '/../../includes/PHPExcel/PHPExcel.php';

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

// Set document properties
            $objPHPExcel->getProperties()->setCreator(Dreamedit::encodeText("����� ���"))
                ->setLastModifiedBy(Dreamedit::encodeText("����� ���"))
                ->setTitle(Dreamedit::encodeText("������ ����������� ����� ���"))
                ->setSubject(Dreamedit::encodeText("������ ����������� ����� ���"))
                ->setDescription(Dreamedit::encodeText("������ ����������� ����� ���"))
                ->setKeywords(Dreamedit::encodeText("������ ����������� ����� ���"))
                ->setCategory(Dreamedit::encodeText("������ ����������� ����� ���"));

// Add some data
            $sheet = $objPHPExcel->setActiveSheetIndex(0);

            $columnPosition = 0; // ��������� ���������� x
            $startLine = 1; // ��������� ���������� y

            $columns = array(
            );
            if($fields['lastname']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�������'), 'width' => 30);
            }
            if($fields['firstname']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('���'), 'width' => 30);
            }
            if($fields['thirdname']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��������'), 'width' => 30);
            }
            if($fields['email']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('E-mail'), 'width' => 45);
            }
            if($fields['phone']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� ��������'), 'width' => 20);
            }
            if($fields['birthdate']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('���� ��������'), 'width' => 15);
            }
            if($fields['field_of_study']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����������� ����������'), 'width' => 50);
            }
            if($fields['field_of_study_profile']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�������'), 'width' => 80);
            }
            if($fields['gender']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('���'), 'width' => 30);
            }
            if($fields['fio_r']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��� � ����������� ������'), 'width' => 60);
            }
            if($fields['nationality']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��������������'), 'width' => 30);
            }
            if($fields['citizenship']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�����������'), 'width' => 30);
            }
            if($fields['birthplace']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� ��������'), 'width' => 30);
            }
            if($fields['passport_series']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� ��������'), 'width' => 30);
            }
            if($fields['passport_number']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� ��������'), 'width' => 30);
            }
            if($fields['passport_place']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�����'), 'width' => 60);
            }
            if($fields['passport_date']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('���� ������ ��������'), 'width' => 15);
            }
            if($fields['passport_address']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� �����������'), 'width' => 30);
            }
            if($fields['conditions']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������� �����������'), 'width' => 100);
            }
            if($fields['conditions_entry']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������� ����������'), 'width' => 100);
            }
            if($fields['prioritet_1']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��������� ����������� 1'), 'width' => 50);
            }
            if($fields['prioritet_2']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��������� ����������� 2'), 'width' => 50);
            }
            if($fields['education']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�����������'), 'width' => 15);
            }
            if($fields['university']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������������ ������� �������� ���������'), 'width' => 30);
            }
            if($fields['university_year_end']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��� ���������'), 'width' => 10);
            }
            if($fields['diplom']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������'), 'width' => 30);
            }
            if($fields['diplom_series']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� �������'), 'width' => 30);
            }
            if($fields['diplom_number']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� �������'), 'width' => 30);
            }
            if($fields['diplom_date']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('���� ������ �������'), 'width' => 15);
            }
            if($fields['languages']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ ������������ ������� ��������'), 'width' => 60);
            }
            if($fields['academic_degree']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �������'), 'width' => 30);
            }
            if($fields['academic_rank']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ ������'), 'width' => 30);
            }
            if($fields['gov_awards']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� ������ ����������������� �������'), 'width' => 30);
            }
            if($fields['science_work_and_invents']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� ������ ������� ����� � �����������'), 'width' => 30);
            }
            if($fields['attachment_count']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('���������� ����������� ������ �� ���������� �� �������������� �����������'), 'width' => 5);
            }
            if($fields['attachment_pages']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� ���� ������� � ����������� ������ �� ���������� �� �������������� �����������'), 'width' => 5);
            }
            if($fields['army_rank']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��������� � �������� ����������� � �������� ������'), 'width' => 30);
            }
            if($fields['army_structure']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������'), 'width' => 30);
            }
            if($fields['army_type']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('��� �����'), 'width' => 30);
            }
            if($fields['exam']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('����� �������������� ���������'), 'width' => 15);
            }
            if($fields['exam_spec_cond']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('� �������� ����������� ������� ��� ���������� ������������� ��������� � ����� � ������������� ������������� � �������������'), 'width' => 5);
            }
            if($fields['exam_spec_cond_discipline']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������������ ���������� ��� ����������� �������'), 'width' => 30);
            }
            if($fields['exam_spec_cond_list']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�������� ����������� �������'), 'width' => 30);
            }
            if($fields['obsh']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('� ��������� �� ������ ��������'), 'width' => 5);
            }
            if($fields['relatives']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�������� ��������� � ������ ���������� ������� ������'), 'width' => 70);
            }
            if($fields['home_address_phone']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('�������� ����� � �������� �������'), 'width' => 30);
            }
            if($fields['university_list']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �����'), 'width' => 100);
            }
            if($fields['work_list']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �����'), 'width' => 100);
            }
            if($fields['abroad_list']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ ������� �� �������'), 'width' => 100);
            }
            if($fields['pdf_application']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �� ��������� (������ ��� ��������������)'), 'width' => 30);
            }
            if($fields['pdf_personal_document']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �� �������� �������������� �������� (������ ��� ��������������)'), 'width' => 30);
            }
            if($fields['pdf_education']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �� �������� �� ����������� (������ ��� ��������������)'), 'width' => 30);
            }
            if($fields['pdf_autobiography']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �� �������� ������������� (������ ��� ��������������)'), 'width' => 30);
            }
            if($fields['pdf_personal_sheet']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �� ������ ������ �� ����� ������ (������ ��� ��������������)'), 'width' => 30);
            }
            if($fields['pdf_disabled_info']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �� ���������� �� ������������ (������ ��� ��������������)'), 'width' => 30);
            }
            if($fields['pdf_apply_for_entry']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������ �� ��������� � �������� �� ���������� (������ ��� ��������������)'), 'width' => 30);
            }
            if($fields['status']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('������'), 'width' => 30);
            }
            if($fields['pdf_uploaded_date']=="1") {
                $columns[] = array('title' => Dreamedit::encodeText('���� ������ ����������'), 'width' => 30);
            }

// ��������� �� ������ �������
            $currentColumn = $columnPosition;

// ��������� �����
            foreach ($columns as $column) {
                // ������ ������
                $sheet->getStyleByColumnAndRow($currentColumn, $startLine)
                    ->getFill()
                    ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('4dbf62');

                $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $column['title']);

                $sheet->getColumnDimensionByColumn($currentColumn)->setWidth($column['width']);

                // ��������� ������
                $currentColumn++;
            }

            $link_style_array = array(
                'font'  => array(
                    'color' => array('rgb' => '0000FF'),
                    'underline' => 'single'
                )
            );

            $statuses = array();
            if($fields['']) {
                $statuses[] = "";
            }
            foreach ($this->aspModule->getAspStatusManager()->getAllStatuses() as $aspStatus) {
                if($fields["status-".$aspStatus->getId()]) {
                    $statuses[] = $aspStatus->getId();
                }
            }
            $documentFrom = "";
            $documentTo = "";

            if($fields['send_document_interval']=="1") {
                if(!empty($fields['date_from']) && !empty($fields['date_to'])) {
                    $documentFrom = $fields['date_from'];
                    $documentTo = $fields['date_to'];
                }
            }

            $sortField1 = "lastname";
            $sortType1 = "ASC";
            $sortField2 = "lastname";
            $sortType2 = "ASC";
            $sortField3 = "lastname";
            $sortType3 = "ASC";

            if(!empty($fields['sort_field_1'])) {
                $sortField1 = $fields['sort_field_1'];
            }
            if(!empty($fields['sort_field_type_1'])) {
                $sortType1 = $fields['sort_field_type_1'];
            }
            if(!empty($fields['sort_field_2'])) {
                $sortField2 = $fields['sort_field_2'];
            }
            if(!empty($fields['sort_field_type_2'])) {
                $sortType2 = $fields['sort_field_type_2'];
            }
            if(!empty($fields['sort_field_3'])) {
                $sortField3 = $fields['sort_field_3'];
            }
            if(!empty($fields['sort_field_type_3'])) {
                $sortType3 = $fields['sort_field_type_3'];
            }

            if(!empty($statuses)) {
                foreach ($this->aspModule->getAspModuleUserManager()->getAllUsersWithStatus($statuses,$documentFrom,$documentTo,$sortField1,$sortType1,$sortField2,$sortType2,$sortField3,$sortType3) as $user) {
                    $startLine++;
                    $sheet->getRowDimension($startLine)->setRowHeight(15);
                    $columnId = 0;

                    if ($fields['lastname'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getLastName()));
                        $columnId++;
                    }
                    if ($fields['firstname'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getFirstName()));
                        $columnId++;
                    }
                    if ($fields['thirdname'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getThirdName()));
                        $columnId++;
                    }
                    if ($fields['email'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getEmail()));
                        $columnId++;
                    }
                    if ($fields['phone'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPhone()));
                        $columnId++;
                    }
                    if ($fields['birthdate'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getBirthDate()));
                        $columnId++;
                    }
                    if ($fields['field_of_study'] == "1") {
                        $fieldOfStudy = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyById($user->getFieldOfStudy());
                        if (!empty($fieldOfStudy)) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($fieldOfStudy->getName()));
                            $columnId++;
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText(""));
                            $columnId++;
                        }
                    }
                    if ($fields['field_of_study_profile'] == "1") {
                        $fieldOfStudy = $this->aspModule->getAspFieldOfStudyManager()->getFieldOfStudyProfileById($user->getFieldOfStudyProfile());
                        if (!empty($fieldOfStudy)) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($fieldOfStudy->getName()));
                            $columnId++;
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText(""));
                            $columnId++;
                        }
                    }
                    if ($fields['gender'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getGender()));
                        $columnId++;
                    }
                    if ($fields['fio_r'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getFioR()));
                        $columnId++;
                    }
                    if ($fields['nationality'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getNationality()));
                        $columnId++;
                    }
                    if ($fields['citizenship'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getCitizenship()));
                        $columnId++;
                    }
                    if ($fields['birthplace'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getBirthplace()));
                        $columnId++;
                    }
                    if ($fields['passport_series'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPassportSeries()));
                        $columnId++;
                    }
                    if ($fields['passport_number'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPassportNumber()));
                        $columnId++;
                    }
                    if ($fields['passport_place'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPassportPlace()));
                        $columnId++;
                    }
                    if ($fields['passport_date'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPassportDate()));
                        $columnId++;
                    }
                    if ($fields['passport_address'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPassportAddress()));
                        $columnId++;
                    }
                    if ($fields['conditions'] == "1") {
                        if ($user->isWillBudget() && !$user->isWillPay()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("�� ���� ��������� ������������ ������������ �������"));
                        }
                        if (!$user->isWillBudget() && $user->isWillPay()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("�� �������� �� �������� ������� ��������������� �����"));
                        }
                        if ($user->isWillBudget() && $user->isWillPay()) {
                            if ($user->getPrioritetFirst() != "" && $user->getPrioritetSecond() != "") {
                                $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPrioritetFirst() . ", " . $user->getPrioritetSecond()));
                            } else {
                                $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("�� ���� ��������� ������������ ������������ �������, �� �������� �� �������� ������� ��������������� �����"));
                            }
                        }
                        if (!$user->isWillBudget() && !$user->isWillPay()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("�� �������"));
                        }
                        $columnId++;
                    }
                    if ($fields['conditions_entry'] == "1") {
                        if ($user->isWillBudgetEntry() && !$user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("�� �������� ����� � ������ ����������� ���� ������"));
                        }
                        if (!$user->isWillBudgetEntry() && $user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("�� ����� �� �������� �� �������� ������� ��������������� �����"));
                        }
                        if ($user->isWillBudgetEntry() && $user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("������� ��� ��������"));
                        }
                        if (!$user->isWillBudgetEntry() && !$user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("�� �������"));
                        }
                        $columnId++;
                    }
                    if ($fields['prioritet_1'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPrioritetFirst()));
                        $columnId++;
                    }
                    if ($fields['prioritet_2'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPrioritetSecond()));
                        $columnId++;
                    }
                    if ($fields['education'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getEducation()));
                        $columnId++;
                    }
                    if ($fields['university'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getUniversity()));
                        $columnId++;
                    }
                    if ($fields['university_year_end'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getUniversityYearEnd()));
                        $columnId++;
                    }
                    if ($fields['diplom'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getDiplom()));
                        $columnId++;
                    }
                    if ($fields['diplom_series'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getDiplomSeries()));
                        $columnId++;
                    }
                    if ($fields['diplom_number'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getDiplomNumber()));
                        $columnId++;
                    }
                    if ($fields['diplom_date'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getDiplomDate()));
                        $columnId++;
                    }
                    if ($fields['languages'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getLanguages()));
                        $columnId++;
                    }
                    if ($fields['academic_degree'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getAcademicDegree()));
                        $columnId++;
                    }
                    if ($fields['academic_rank'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getAcademicRank()));
                        $columnId++;
                    }
                    if ($fields['gov_awards'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText(Dreamedit::LineBreakToComma($user->getGovAwards())));
                        $columnId++;
                    }
                    if ($fields['science_work_and_invents'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText(Dreamedit::LineBreakToComma($user->getScienceWorkAndInvents())));
                        $columnId++;
                    }
                    if ($fields['attachment_count'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getAttachmentCount()));
                        $columnId++;
                    }
                    if ($fields['attachment_pages'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getAttachmentPages()));
                        $columnId++;
                    }
                    if ($fields['army_rank'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getArmyRank()));
                        $columnId++;
                    }
                    if ($fields['army_structure'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getArmyStructure()));
                        $columnId++;
                    }
                    if ($fields['army_type'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getArmyType()));
                        $columnId++;
                    }
                    if ($fields['exam'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getExam()));
                        $columnId++;
                    }
                    if ($fields['exam_spec_cond'] == "1") {
                        if ($user->isExamSpecCond()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("��"));
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("���"));
                        }
                        $columnId++;
                    }
                    if ($fields['exam_spec_cond_discipline'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getExamSpecCondDiscipline()));
                        $columnId++;
                    }
                    if ($fields['exam_spec_cond_list'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getExamSpecCondList()));
                        $columnId++;
                    }
                    if ($fields['obsh'] == "1") {
                        if ($user->isObsh()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("��"));
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText("���"));
                        }
                        $columnId++;
                    }
                    if ($fields['relatives'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText(Dreamedit::LineBreakToComma($user->getRelatives())));
                        $columnId++;
                    }
                    if ($fields['home_address_phone'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getHomeAddressPhone()));
                        $columnId++;
                    }
                    if ($fields['university_list'] == "1") {
                        $counter = 1;
                        $str = "";
                        foreach ($user->getUniversityList() as $item) {
                            $str.=$counter.": ";
                            $str.="�������� �������� ��������� � ��� ���������������: ".$item['university_name_place'].", ";
                            $str.="��������� ��� ���������: ".$item['university_faculty'].", ";
                            $str.="����� ��������: ".$item['university_form'].", ";
                            $str.="��� �����������: ".$item['university_year_in'].", ";
                            $str.="��� ��������� ��� �����: ".$item['university_year_out'].", ";
                            $str.="���� �� �������, �� � ������ ����� ����: ".$item['university_level_out'].", ";
                            $str.="����� ������������� ������� � ���������� ��������� �������� ���������, ������� � ������� ��� �������������: ".$item['university_special_number'].". ";
                            $counter++;
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($str));
                        $columnId++;
                    }
                    if ($fields['work_list'] == "1") {
                        $counter = 1;
                        $str = "";
                        foreach ($user->getWorkList() as $item) {
                            $str.=$counter.": ";
                            $str.="����� ����������: ".$item['work_month_in'].", ";
                            $str.="��� ����������: ".$item['work_year_in'].", ";
                            $str.="����� �����: ".$item['work_month_out'].", ";
                            $str.="��� �����: ".$item['work_year_out'].", ";
                            $str.="��������� � ��������� ����������, �����������, �����������, � ����� ������������ (���������): ".$item['work_position'].", ";
                            $str.="��������������� ����������, �����������, �����������: ".$item['work_place'].". ";
                            $counter++;
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($str));
                        $columnId++;
                    }
                    if ($fields['abroad_list'] == "1") {
                        $counter = 1;
                        $str = "";
                        foreach ($user->getAbroadList() as $item) {
                            $str.=$counter.": ";
                            $str.="����� ������ �������: ".$item['abroad_month_in'].", ";
                            $str.="��� ������ �������: ".$item['abroad_year_in'].", ";
                            $str.="����� ����� �������: ".$item['abroad_month_out'].", ";
                            $str.="��� ����� �������: ".$item['abroad_year_out'].", ";
                            $str.="� ����� ������: ".$item['abroad_country'].", ";
                            $str.="���� ���������� �� ��������: ".$item['abroad_purpose'].". ";
                            $counter++;
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($str));
                        $columnId++;
                    }
                    if ($fields['pdf_application'] == "1") {
                        if ($user->getPdfApplication() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getApplication&user_id=" . $user->getId()) . '","' . Dreamedit::encodeText('�������') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_personal_document'] == "1") {
                        if ($user->getPdfPersonalDocument() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getPersonalDocument&user_id=" . $user->getId()) . '","' . Dreamedit::encodeText('�������') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_education'] == "1") {
                        if ($user->getPdfEducation() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getEducation&user_id=" . $user->getId()) . '","' . Dreamedit::encodeText('�������') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_autobiography'] == "1") {
                        if ($user->getPdfAutoBiography() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getAutobiography&user_id=" . $user->getId()) . '","' . Dreamedit::encodeText('�������') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_personal_sheet'] == "1") {
                        if ($user->getPdfPersonalSheet() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getPersonalSheet&user_id=" . $user->getId()) . '","' . Dreamedit::encodeText('�������') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_disabled_info'] == "1") {
                        if ($user->getPdfDisabledInfo() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getDisabledInfo&user_id=" . $user->getId()) . '","' . Dreamedit::encodeText('�������') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_apply_for_entry'] == "1") {
                        if ($user->getPdfApplyForEntry() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getApplyForEntry&user_id=" . $user->getId()) . '","' . Dreamedit::encodeText('�������') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['status'] == "1") {
                        $aspStatus = $this->aspModule->getAspStatusManager()->getStatusBy($user->getStatus());
                        if (!empty($aspStatus)) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($aspStatus->getText()));
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($aspStatus->getText()));
                        }

                        $columnId++;
                    }
                    if ($fields['pdf_uploaded_date'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, Dreamedit::encodeText($user->getPdfLastUploadDateTime()));
                        $columnId++;
                    }
                    for ($i = 0; $i <= $columnId; $i++) {
                        $sheet->getCellByColumnAndRow($i, $startLine)->getStyle()->getAlignment()->setWrapText(true);
                    }
                }
            }


// Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle(Dreamedit::encodeText("������ ����������� ����� ���"));

            $objPHPExcel->getActiveSheet()->freezePane('A2');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


            $this->aspModule->getAspDownloadService()->echoExcelHeader(Dreamedit::encodeText("������ ������������� ������� �������� �����������.xlsx"));

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            exit;
        }
        return false;
    }

}