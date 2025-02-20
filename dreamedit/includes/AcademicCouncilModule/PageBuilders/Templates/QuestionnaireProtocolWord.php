<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class QuestionnaireProtocolWord implements PageBuilder {

    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    /**
     * QuestionnaireProtocolWord constructor.
     * @param AcademicCouncilModule $academicCouncilModule
     * @param \Pages $pages
     */
    public function __construct(AcademicCouncilModule $academicCouncilModule, $pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        if($this->academicCouncilModule->getAuthorizationService()->isAuthorized()) {
            $questionnaire = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireById($_GET['id']);
            if(!empty($questionnaire)) {

                require_once __DIR__ . '/../../../PhpWord/Autoloader.php';
                require_once __DIR__ . '/../../../Common/Text.php';
                require_once __DIR__ . '/../../../dompdf/autoload.inc.php';
                require_once __DIR__ . '/../../../Common/XMLWriter.php';

                \PhpOffice\PhpWord\Autoloader::register();

                $phpWord = new \PhpOffice\PhpWord\PhpWord();

                $phpWord->setDefaultParagraphStyle(array('spacing' => 0, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));

                $section = $phpWord->addSection();
                $sectionStyle = $section->getStyle();
                $footer = $section->addFooter();
                $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_PORTRAIT);

                $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
                $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1));

                $questionnaireDate = $questionnaire->getQuestionnaireDate();
                $questionnaireDateFormatted = "";
                if (!empty($questionnaireDate) && $questionnaireDate != "0000-00-00") {
                    try {
                        $dt = new \DateTime($questionnaireDate);
                        $questionnaireDateFormatted = $dt->format('d.m.Y');
                    } catch (\Exception $e) {
                    }
                }
                $questionnaireRegistrationCount = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireRegistrationCountById($questionnaire->getId());
                //$questionnaireParticipateCount = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireParticipateCountById($questionnaire->getId());
                $questionnaireVoteCount = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireSecretAllCountById($questionnaire->getId());

                if($questionnaire->getQuestionnaireMembersCount()!="") {
                    $membersCount = $questionnaire->getQuestionnaireMembersCount();
                } else {
                    $membersCount = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireMembersCountById($questionnaire->getId());
                }

//                $arriveText = \Dreamedit::RusEnding($questionnaireParticipateCount,"�������������","��������������","��������������");
//                $participateText = \Dreamedit::RusEnding($questionnaireVoteCount,"������","�������","�������");
//                $memberText = \Dreamedit::RusEnding($questionnaireParticipateCount,"����","�����","������");
//                $participateMemberText = \Dreamedit::RusEnding($questionnaireVoteCount,"����","�����","������");

                $registerText = \Dreamedit::RusEnding($questionnaireRegistrationCount,"�����������������","������������������","������������������");
                $registerMemberText = \Dreamedit::RusEnding($questionnaireRegistrationCount,"����","�����","������");
                $participateText = \Dreamedit::RusEnding($questionnaireVoteCount,"������","�������","�������");
                $participateMemberText = \Dreamedit::RusEnding($questionnaireVoteCount,"����","�����","������");

                $membersMemberText = \Dreamedit::RusEnding($membersCount,"����","�����","������");

                $section->addText(
                    mb_convert_encoding("�������� � {$questionnaire->getProtocolNumber()}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                    array('align' => 'center')
                );
                $section->addText(
                    mb_convert_encoding('�������� ������� ������ ������� ������ �� ����������� ���������������� ������� ����������� �� �������',"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                    array('align' => 'center')
                );
                $section->addText(
                    mb_convert_encoding("�{$questionnaire->getQuestionnaireQuestion()}�","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
                    array('align' => 'center')
                );

                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding($questionnaireDateFormatted,"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'right')
                );
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding('������ ����������� ��������� � �������������� ������ ������� �� ����������� ����� ����� ��� �� ��������� ������� ����� ��� �� 09.11.2020 � 33�/�.',"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("������ ������� ������ ����� ��� ������ ������������ ������� ���������� ����� ��� 16 ������ 2018 ���� � ���������� 60 �������. � ��������� ����� � ������ ������� ������ ������ {$membersCount} {$membersMemberText}.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("{$registerText} ��� ������� � ����������� {$questionnaireRegistrationCount} {$registerMemberText} ������� ������.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );
                $section->addText(
                    mb_convert_encoding("{$participateText} ������� � ����������� ����������� {$questionnaireVoteCount} {$participateMemberText} ������� ������.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );
                $section->addText(
                    mb_convert_encoding("���������� �����������:","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));


                $tableStyle = array(
                    'borderColor' => '000000',
                    'borderSize' => 1,
                    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                    'unit' => 'dxa'
                );
                $table = $section->addTable($tableStyle);
                $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(17));
                $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0));
                $table->addRow();
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.5),array(
                    'borderSize' => 1,
                ));
                $cell->addText(
                    mb_convert_encoding('�.�.�.', "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.5));
                $cell->addText(
                    mb_convert_encoding('����������� � �������� � ������ ������� ������', "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1));
                $cell->addText(
                    mb_convert_encoding('��', "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                $cell->addText(
                    mb_convert_encoding('������', "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
                $cell->addText(
                    mb_convert_encoding('�����������', "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $table->addRow();
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.5),array(
                    'borderSize' => 1,
                    'valign' => 'center'
                ));
                $cell->addText(
                    mb_convert_encoding($questionnaire->getQuestionnaireFio(), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.5),array(
                    'borderSize' => 1,
                    'valign' => 'center'
                ));
                $cell->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $cell->addText(
                    mb_convert_encoding($questionnaire->getQuestionnairePosition(), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1),array(
                    'borderSize' => 1,
                    'valign' => 'center'
                ));
                $cell->addText(
                    mb_convert_encoding($this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireSecretForCountById($questionnaire->getId()), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),array(
                    'borderSize' => 1,
                    'valign' => 'center'
                ));
                $cell->addText(
                    mb_convert_encoding($this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireSecretAgainstCountById($questionnaire->getId()), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3),array(
                    'borderSize' => 1,
                    'valign' => 'center'
                ));
                $cell->addText(
                    mb_convert_encoding($this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireSecretAbstainedCountById($questionnaire->getId()), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );

                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));


                $tableStyle = array(
                    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                    'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
                    'unit' => 'dxa'
                );
                $table = $section->addTable($tableStyle);
                $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(17));
                $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0));
                $table->addRow();
                $cell = $table->addCell(
                    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
                    array(
                        'valign' => 'bottom'
                    )
                );
                $cell->addText(
                    mb_convert_encoding('������ ��������� ����� ���',"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'left')
                );
                $cell = $table->addCell(
                    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(6),
                    array(
                        'borderBottomColor' => '000000',
                        'borderBottomSize'  => 1,
                        'valign' => 'bottom'
                    )
                );
                $cell = $table->addCell(
                    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(4),
                    array(
                        'valign' => 'bottom'
                    )
                );
                $cell->addText(
                    mb_convert_encoding('(�.�. �������)',"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'left')
                );

                $filename = \Dreamedit::encodeText("�������� � {$questionnaire->getProtocolNumber()}.docx");

                header("Content-Description: File Transfer");
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                header('Content-Transfer-Encoding: binary');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Expires: 0');

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save("php://output");

                exit();

            } else {
                $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("error");
                $this->academicCouncilModule->getPageBuilder()->build(array("error" => "�� ������ �����"));
            }
        } else {
            $this->academicCouncilModule->getPageBuilderManager()->setPageBuilder("error");
            $this->academicCouncilModule->getPageBuilder()->build();
        }


    }

}