<?php

namespace AspModule\Services;

use AspModule\AspModule;

class XlsxService {

    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
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
        $status = $this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus());

        if($status->isAdminAllow()) {

            require_once dirname(__FILE__) . '/../../../includes/PHPExcel/PHPExcel.php';

            // Create new PHPExcel object
            $objPHPExcel = new \PHPExcel();

// Set document properties
            $objPHPExcel->getProperties()->setCreator(\Dreamedit::encodeText("ИМЭМО РАН"))
                ->setLastModifiedBy(\Dreamedit::encodeText("ИМЭМО РАН"))
                ->setTitle(\Dreamedit::encodeText("Список аспирантуры ИМЭМО РАН"))
                ->setSubject(\Dreamedit::encodeText("Список аспирантуры ИМЭМО РАН"))
                ->setDescription(\Dreamedit::encodeText("Список аспирантуры ИМЭМО РАН"))
                ->setKeywords(\Dreamedit::encodeText("Список аспирантуры ИМЭМО РАН"))
                ->setCategory(\Dreamedit::encodeText("Список аспирантуры ИМЭМО РАН"));

// Add some data
            $sheet = $objPHPExcel->setActiveSheetIndex(0);

            $columnPosition = 0; // Начальная координата x
            $startLine = 1; // Начальная координата y

            $columns = array(
            );
            if($fields['lastname']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Фамилия'), 'width' => 30);
            }
            if($fields['firstname']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Имя'), 'width' => 30);
            }
            if($fields['thirdname']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Отчество'), 'width' => 30);
            }
            if($fields['email']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('E-mail'), 'width' => 45);
            }
            if($fields['phone']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Номер телефона'), 'width' => 20);
            }
            if($fields['birthdate']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Дата рождения'), 'width' => 15);
            }
            if($fields['application_year']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Прием'), 'width' => 30);
            }
            if($fields['document_application_for']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Документы поданы на'), 'width' => 30);
            }
            if($fields['dissertation_theme']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Предполагаемая тема диссертации'), 'width' => 50);
            }
            if($fields['dissertation_supervisor']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Научный руководитель'), 'width' => 30);
            }
            if($fields['dissertation_department']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Научное подразделение'), 'width' => 50);
            }
            if($fields['field_of_study']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Группа научных специальностей'), 'width' => 50);
            }
            if($fields['field_of_study_profile']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Научная специальность'), 'width' => 80);
            }
            if($fields['gender']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Пол'), 'width' => 30);
            }
            if($fields['fio_r']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('ФИО в родительном падеже'), 'width' => 60);
            }
            if($fields['nationality']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Национальность'), 'width' => 30);
            }
            if($fields['citizenship']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Гражданство'), 'width' => 30);
            }
            if($fields['birthplace']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Место рождения'), 'width' => 30);
            }
            if($fields['passport_series']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Серия паспорта'), 'width' => 30);
            }
            if($fields['passport_number']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Номер паспорта'), 'width' => 30);
            }
            if($fields['passport_place']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Выдан'), 'width' => 60);
            }
            if($fields['passport_date']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Дата выдачи паспорта'), 'width' => 15);
            }
            if($fields['passport_address']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Адрес регистрации'), 'width' => 30);
            }
            if($fields['pension_certificate']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('СНИЛС'), 'width' => 30);
            }
            if($fields['special_code']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Код'), 'width' => 30);
            }
            if($fields['pension_certificate_or_special_code']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Код или СНИЛС'), 'width' => 30);
            }
            if($fields['conditions']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Условия поступления'), 'width' => 100);
            }
            if($fields['conditions_entry']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Условия зачисления'), 'width' => 100);
            }
            if($fields['prioritet_1']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Приоритет поступления 1'), 'width' => 50);
            }
            if($fields['prioritet_2']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Приоритет поступления 2'), 'width' => 50);
            }
            if($fields['education']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Образование'), 'width' => 15);
            }
            if($fields['university']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Наименование высшего учебного заведения'), 'width' => 30);
            }
            if($fields['university_year_end']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Год окончания'), 'width' => 10);
            }
            if($fields['diplom']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Диплом'), 'width' => 30);
            }
            if($fields['diplom_series']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Серия диплома'), 'width' => 30);
            }
            if($fields['diplom_number']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Номер диплома'), 'width' => 30);
            }
            if($fields['diplom_date']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Дата выдачи диплома'), 'width' => 15);
            }
            if($fields['languages']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Какими иностранными языками владеете'), 'width' => 60);
            }
            if($fields['academic_degree']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ученая степень'), 'width' => 30);
            }
            if($fields['academic_rank']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ученое звание'), 'width' => 30);
            }
            if($fields['gov_awards']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Какие имеете правительственные награды'), 'width' => 30);
            }
            if($fields['science_work_and_invents']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Какие имеете научные труды и изобретения'), 'width' => 30);
            }
            if($fields['attachment_count']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Количество прилагаемых файлов со сведениями об индивидуальных достижениях'), 'width' => 5);
            }
            if($fields['attachment_pages']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Сумма всех страниц в прилагаемых файлах со сведениями об индивидуальных достижениях'), 'width' => 5);
            }
            if($fields['army_rank']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Отношение к воинской обязанности и воинское звание'), 'width' => 30);
            }
            if($fields['army_structure']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Состав'), 'width' => 30);
            }
            if($fields['army_type']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Род войск'), 'width' => 30);
            }
            if($fields['exam']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Выбор вступительного испытания'), 'width' => 15);
            }
            if($fields['exam_spec_cond']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('В создании специальных условий при проведении вступительных испытаний в связи с ограниченными возможностями и инвалидностью'), 'width' => 5);
            }
            if($fields['exam_spec_cond_discipline']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Наименование дисциплины для специальных условий'), 'width' => 30);
            }
            if($fields['exam_spec_cond_list']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Перечень специальных условий'), 'width' => 30);
            }
            if($fields['obsh']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('В общежитии на период обучения'), 'width' => 5);
            }
            if($fields['send_back_type']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Возврат документов'), 'width' => 60);
            }
            if($fields['inform_type']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Информирование'), 'width' => 60);
            }
            if($fields['relatives']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Семейное положение в момент заполнения личного листка'), 'width' => 70);
            }
            if($fields['home_address_phone']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Домашний адрес и домашний телефон'), 'width' => 30);
            }
            if($fields['university_list']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Список ВУЗов'), 'width' => 100);
            }
            if($fields['work_list']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Список работ'), 'width' => 100);
            }
            if($fields['abroad_list']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Список поездок за границу'), 'width' => 100);
            }
            if($fields['science_work_list']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Список научных трудов'), 'width' => 100);
            }
            if($fields['pdf_consent_data_processing']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на согласие на обработку персональных данных (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_application']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на заявление (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_personal_document']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на документ подтверждающий личность (только для администратора)'), 'width' => 30);
            }
            if($fields['word_essay']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на эссе по теме диссертации (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_pension_certificate']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на СНИЛС (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_science_work_list']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на список научных трудов (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_education']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на документ об образовании (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_education_period_reference']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на справку об обучении/периоде обучения)'), 'width' => 30);
            }
            if($fields['pdf_autobiography']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на документ автобиографии (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_personal_sheet']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на личный листок по учету кадров (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_disabled_info']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на информацию по инвалидности (только для администратора)'), 'width' => 30);
            }
            if($fields['pdf_apply_for_entry']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Ссылка на заявление о согласии на зачисление (только для администратора)'), 'width' => 30);
            }
            if($fields['status']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Статус'), 'width' => 30);
            }
            if($fields['pdf_uploaded_date']=="1") {
                $columns[] = array('title' => \Dreamedit::encodeText('Дата подачи документов'), 'width' => 30);
            }

// Указатель на первый столбец
            $currentColumn = $columnPosition;

// Формируем шапку
            foreach ($columns as $column) {
                // Красим ячейку
                $sheet->getStyleByColumnAndRow($currentColumn, $startLine)
                    ->getFill()
                    ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('4dbf62');

                $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $column['title']);

                $sheet->getColumnDimensionByColumn($currentColumn)->setWidth($column['width']);

                // Смещаемся вправо
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
            foreach ($this->aspModule->getStatusService()->getAllStatuses() as $aspStatus) {
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

            $applicationsYearId = -1;

            if(!empty($fields['applications_year_id']) || $fields['applications_year_id'] === '0') {
                $applicationsYearId = $fields['applications_year_id'];
            }

            if(!empty($statuses)) {
                foreach ($this->aspModule->getUserService()->getAllUsersWithStatus($statuses,$documentFrom,$documentTo,$sortField1,$sortType1,$sortField2,$sortType2,$sortField3,$sortType3,$applicationsYearId) as $user) {
                    if ($fields['document_application_for_study'] != "1") {
                        if(!$user->isForDissertationAttachment()) {
                            continue;
                        }
                    }
                    if ($fields['document_application_for_dissertation'] != "1") {
                        if($user->isForDissertationAttachment()) {
                            continue;
                        }
                    }
                    $startLine++;
                    $sheet->getRowDimension($startLine)->setRowHeight(15);
                    $columnId = 0;

                    if ($fields['lastname'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getLastName()));
                        $columnId++;
                    }
                    if ($fields['firstname'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getFirstName()));
                        $columnId++;
                    }
                    if ($fields['thirdname'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getThirdName()));
                        $columnId++;
                    }
                    if ($fields['email'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getEmail()));
                        $columnId++;
                    }
                    if ($fields['phone'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPhone()));
                        $columnId++;
                    }
                    if ($fields['birthdate'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getBirthDate()));
                        $columnId++;
                    }
                    if ($fields['application_year'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getApplicationsYear()->getName()));
                        $columnId++;
                    }
                    if ($fields['document_application_for'] == "1") {
                        if($user->isForDissertationAttachment()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Прикрепление"));
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Обучение"));
                        }

                        $columnId++;
                    }
                    if ($fields['dissertation_theme'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(\Dreamedit::LineBreakToSpace($user->getDissertationTheme())));
                        $columnId++;
                    }
                    if ($fields['dissertation_supervisor'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getDissertationSupervisor()));
                        $columnId++;
                    }
                    if ($fields['dissertation_department'] == "1") {
                        $department = "";
                        $currentDepartmentId = $user->getDissertationDepartment();
                        if(!empty($currentDepartmentId) && is_numeric($currentDepartmentId)) {
                            $departmentEl = $this->aspModule->getDepartmentService()->getFullPathDepartment($currentDepartmentId);
                            if(!empty($departmentEl)) {
                                $department = $departmentEl->getTitle();
                            }
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(\Dreamedit::LineBreakToSpace($department)));
                        $columnId++;
                    }
                    if ($fields['field_of_study'] == "1") {
                        $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyById($user->getFieldOfStudy());
                        if (!empty($fieldOfStudy)) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($fieldOfStudy->getName()));
                            $columnId++;
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(""));
                            $columnId++;
                        }
                    }
                    if ($fields['field_of_study_profile'] == "1") {
                        $fieldOfStudy = $this->aspModule->getFieldOfStudyService()->getFieldOfStudyProfileById($user->getFieldOfStudyProfile());
                        if (!empty($fieldOfStudy)) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($fieldOfStudy->getName()));
                            $columnId++;
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(""));
                            $columnId++;
                        }
                    }
                    if ($fields['gender'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getGender()));
                        $columnId++;
                    }
                    if ($fields['fio_r'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getFioR()));
                        $columnId++;
                    }
                    if ($fields['nationality'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getNationality()));
                        $columnId++;
                    }
                    if ($fields['citizenship'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getCitizenship()));
                        $columnId++;
                    }
                    if ($fields['birthplace'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getBirthplace()));
                        $columnId++;
                    }
                    if ($fields['passport_series'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPassportSeries()));
                        $columnId++;
                    }
                    if ($fields['passport_number'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPassportNumber()));
                        $columnId++;
                    }
                    if ($fields['passport_place'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPassportPlace()));
                        $columnId++;
                    }
                    if ($fields['passport_date'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPassportDate()));
                        $columnId++;
                    }
                    if ($fields['passport_address'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPassportAddress()));
                        $columnId++;
                    }
                    if ($fields['pension_certificate'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPensionCertificate()));
                        $columnId++;
                    }
                    if ($fields['special_code'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getSpecialCode()));
                        $columnId++;
                    }
                    if ($fields['pension_certificate_or_special_code'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPensionCertificateOrCode()));
                        $columnId++;
                    }
                    if ($fields['conditions'] == "1") {
                        if ($user->isWillBudget() && !$user->isWillPay()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("За счет бюджетных ассигнований федерального бюджета"));
                        }
                        if (!$user->isWillBudget() && $user->isWillPay()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("По договору об оказании платных образовательных услуг"));
                        }
                        if ($user->isWillBudget() && $user->isWillPay()) {
                            if ($user->getPrioritetFirst() != "" && $user->getPrioritetSecond() != "") {
                                $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPrioritetFirst() . ", " . $user->getPrioritetSecond()));
                            } else {
                                $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("За счет бюджетных ассигнований федерального бюджета, По договору об оказании платных образовательных услуг"));
                            }
                        }
                        if (!$user->isWillBudget() && !$user->isWillPay()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Не выбрано"));
                        }
                        $columnId++;
                    }
                    if ($fields['conditions_entry'] == "1") {
                        if ($user->isWillBudgetEntry() && !$user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("На основные места в рамках контрольных цифр приема"));
                        }
                        if (!$user->isWillBudgetEntry() && $user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("На места по договору об оказании платных образовательных услуг"));
                        }
                        if ($user->isWillBudgetEntry() && $user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Выбраны оба варианта"));
                        }
                        if (!$user->isWillBudgetEntry() && !$user->isWillPayEntry()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Не выбрано"));
                        }
                        $columnId++;
                    }
                    if ($fields['prioritet_1'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPrioritetFirst()));
                        $columnId++;
                    }
                    if ($fields['prioritet_2'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPrioritetSecond()));
                        $columnId++;
                    }
                    if ($fields['education'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getEducation()));
                        $columnId++;
                    }
                    if ($fields['university'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getUniversity()));
                        $columnId++;
                    }
                    if ($fields['university_year_end'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getUniversityYearEnd()));
                        $columnId++;
                    }
                    if ($fields['diplom'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getDiplom()));
                        $columnId++;
                    }
                    if ($fields['diplom_series'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getDiplomSeries()));
                        $columnId++;
                    }
                    if ($fields['diplom_number'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getDiplomNumber()));
                        $columnId++;
                    }
                    if ($fields['diplom_date'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getDiplomDate()));
                        $columnId++;
                    }
                    if ($fields['languages'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getLanguages()));
                        $columnId++;
                    }
                    if ($fields['academic_degree'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getAcademicDegree()));
                        $columnId++;
                    }
                    if ($fields['academic_rank'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getAcademicRank()));
                        $columnId++;
                    }
                    if ($fields['gov_awards'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(\Dreamedit::LineBreakToComma($user->getGovAwards())));
                        $columnId++;
                    }
                    if ($fields['science_work_and_invents'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(\Dreamedit::LineBreakToComma($user->getScienceWorkAndInvents())));
                        $columnId++;
                    }
                    if ($fields['attachment_count'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getAttachmentCount()));
                        $columnId++;
                    }
                    if ($fields['attachment_pages'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getAttachmentPages()));
                        $columnId++;
                    }
                    if ($fields['army_rank'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getArmyRank()));
                        $columnId++;
                    }
                    if ($fields['army_structure'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getArmyStructure()));
                        $columnId++;
                    }
                    if ($fields['army_type'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getArmyType()));
                        $columnId++;
                    }
                    if ($fields['exam'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getExam()));
                        $columnId++;
                    }
                    if ($fields['exam_spec_cond'] == "1") {
                        if ($user->isExamSpecCond()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Да"));
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Нет"));
                        }
                        $columnId++;
                    }
                    if ($fields['exam_spec_cond_discipline'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getExamSpecCondDiscipline()));
                        $columnId++;
                    }
                    if ($fields['exam_spec_cond_list'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getExamSpecCondList()));
                        $columnId++;
                    }
                    if ($fields['obsh'] == "1") {
                        if ($user->isObsh()) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Да"));
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText("Нет"));
                        }
                        $columnId++;
                    }
                    if ($fields['send_back_type'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($this->aspModule->getUserService()->getSendBackTypeText($user->getSendBackType())));
                        $columnId++;
                    }
                    if ($fields['inform_type'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($this->aspModule->getUserService()->getInformTypeText($user->getInformType())));
                        $columnId++;
                    }
                    if ($fields['relatives'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(\Dreamedit::LineBreakToComma($user->getRelatives())));
                        $columnId++;
                    }
                    if ($fields['home_address_phone'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getHomeAddressPhone()));
                        $columnId++;
                    }
                    if ($fields['university_list'] == "1") {
                        $counter = 1;
                        $str = "";
                        foreach ($user->getUniversityList() as $item) {
                            $str.=$counter.": ";
                            $str.="Название учебного заведения и его местонахождения: ".$item['university_name_place'].", ";
                            $str.="Факультет или отделение: ".$item['university_faculty'].", ";
                            $str.="Форма обучения: ".$item['university_form'].", ";
                            $str.="Год поступления: ".$item['university_year_in'].", ";
                            $str.="Год окончания или ухода: ".$item['university_year_out'].", ";
                            $str.="Если не окончил, то с какого курса ушел: ".$item['university_level_out'].", ";
                            $str.="Какую специальность получил в результате окончания учебного заведения, указать № диплома или удостоверения: ".$item['university_special_number'].". ";
                            $counter++;
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($str));
                        $columnId++;
                    }
                    if ($fields['work_list'] == "1") {
                        $counter = 1;
                        $str = "";
                        foreach ($user->getWorkList() as $item) {
                            $str.=$counter.": ";
                            $str.="Месяц вступления: ".$item['work_month_in'].", ";
                            $str.="Год вступления: ".$item['work_year_in'].", ";
                            if($item['work_out']) {
                                $str.="Год, Месяц ухода: По настоящее время, ";
                            } else {
                                $str.="Месяц ухода: ".$item['work_month_out'].", ";
                                $str.="Год ухода: ".$item['work_year_out'].", ";
                            }
                            $str.="Должность с указанием учреждения, организации, предприятия, а также министерства (ведомства): ".$item['work_position'].", ";
                            $str.="Местонахождение учреждения, организации, предприятия: ".$item['work_place'].". ";
                            $counter++;
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($str));
                        $columnId++;
                    }
                    if ($fields['abroad_list'] == "1") {
                        $counter = 1;
                        $str = "";
                        foreach ($user->getAbroadList() as $item) {
                            $str.=$counter.": ";
                            $str.="Месяц начала поездки: ".$item['abroad_month_in'].", ";
                            $str.="Год начала поездки: ".$item['abroad_year_in'].", ";
                            $str.="Месяц конца поездки: ".$item['abroad_month_out'].", ";
                            $str.="Год конца поездки: ".$item['abroad_year_out'].", ";
                            $str.="В какой стране: ".$item['abroad_country'].", ";
                            $str.="Цель пребывания за границей: ".$item['abroad_purpose'].". ";
                            $counter++;
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($str));
                        $columnId++;
                    }
                    if ($fields['science_work_list'] == "1") {
                        $counter = 1;
                        $str = "";
                        foreach ($user->getScienceWorkList() as $item) {
                            $str.=$counter.": ";
                            $str.="Тип научного труда: " . $this->aspModule->getScienceWorkService()->getScienceWorkByTypeId($item['science_work_type']) . ", ";
                            $str.="Наименование научного труда: ".$item['science_work_name'].", ";
                            $str.="Название издательства, журнала: ".$item['science_work_journal_name'].", ";
                            $str.="Индексируется в РИНЦ: ".((int)$item['science_work_journal_rinc']==1 ? "Да" : "Нет").", ";
                            $str.="Индексируется в WoS (СС, ESCI): ".((int)$item['science_work_journal_wos']==1 ? "Да" : "Нет").", ";
                            $str.="Индексируется в Scopus: ".((int)$item['science_work_journal_scopus']==1 ? "Да" : "Нет").", ";
                            $str.="Ссылка на статью на сайте журнала: ".$item['science_work_site_link'].", ";
                            $str.="Год издания: ".$item['science_work_year'].", ";
                            $str.="Номер журнала: ".$item['science_work_number'].", ";
                            $str.="Количество авторских/печатных листов (для книг), страницы в журнале (для статей): ".$item['science_work_pages'].", ";
                            $str.="Примечание (соавторы): ".$item['science_work_other_authors'].", ";
                            $str.="E-mail издания для проверки: ".$item['science_work_email'].". ";
                            $counter++;
                        }
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($str));
                        $columnId++;
                    }
                    if ($fields['pdf_consent_data_processing'] == "1") {
                        if ($user->getPdfConsentDataProcessing() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getConsentDataProcessing&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_application'] == "1") {
                        if ($user->getPdfApplication() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getApplication&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_personal_document'] == "1") {
                        if ($user->getPdfPersonalDocument() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getPersonalDocument&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['word_essay'] == "1") {
                        if ($user->getWordEssay() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getEssay&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_pension_certificate'] == "1") {
                        if ($user->getPdfPensionCertificate() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getPensionCertificate&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_science_work_list'] == "1") {
                        if ($user->getPdfScienceWorkList() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getScienceWorkList&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_education'] == "1") {
                        if ($user->getPdfEducation() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getEducation&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_education_period_reference'] == "1") {
                        if ($user->getPdfEducationPeriodReference() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getEducationPeriodReference&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_autobiography'] == "1") {
                        if ($user->getPdfAutoBiography() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getAutobiography&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_personal_sheet'] == "1") {
                        if ($user->getPdfPersonalSheet() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getPersonalSheet&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_disabled_info'] == "1") {
                        if ($user->getPdfDisabledInfo() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getDisabledInfo&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['pdf_apply_for_entry'] == "1") {
                        if ($user->getPdfApplyForEntry() != "") {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '=Hyperlink("' . \Dreamedit::encodeText("https://www.imemo.ru/postgraduate-studies/account?mode=getPdfFile&file=getApplyForEntry&user_id=" . $user->getId()) . '","' . \Dreamedit::encodeText('Скачать') . '")');
                            $sheet->getCellByColumnAndRow($columnId, $startLine)->getStyle()->applyFromArray($link_style_array);
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, '');
                        }
                        $columnId++;
                    }
                    if ($fields['status'] == "1") {
                        $aspStatus = $this->aspModule->getStatusService()->getStatusBy($user->getStatus());
                        if (!empty($aspStatus)) {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($aspStatus->getText()));
                        } else {
                            $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($aspStatus->getText()));
                        }

                        $columnId++;
                    }
                    if ($fields['pdf_uploaded_date'] == "1") {
                        $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($user->getPdfLastUploadDateTime()));
                        $columnId++;
                    }
                    for ($i = 0; $i <= $columnId; $i++) {
                        $sheet->getCellByColumnAndRow($i, $startLine)->getStyle()->getAlignment()->setWrapText(true);
                    }
                }
            }


// Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle(\Dreamedit::encodeText("Список аспирантуры ИМЭМО РАН"));

            $objPHPExcel->getActiveSheet()->freezePane('A2');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . \Dreamedit::encodeText("Список пользователей личного кабинета аспирантуры.xlsx") . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            //$this->aspModule->getDownloadService()->echoExcelHeader(\Dreamedit::encodeText("Список пользователей личного кабинета аспирантуры.xlsx"));

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            exit;
        }
        return false;
    }

}