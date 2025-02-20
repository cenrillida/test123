<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\PageBuilders\PageBuilder;

class ProtocolWord implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * ProtocolWord constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->dissertationCouncils->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['vote_id']) && is_numeric($_GET['vote_id'])) {
            $vote = $this->dissertationCouncils->getVoteService()->getVoteById($_GET['vote_id']);
            if(!empty($vote)) {

                require_once __DIR__ . '/../../../PhpWord/Autoloader.php';
                require_once __DIR__ . '/../../../Common/Text.php';
                require_once __DIR__ . '/../../../dompdf/autoload.inc.php';
                require_once __DIR__ . '/../../../Common/XMLWriter.php';

                \PhpOffice\PhpWord\Autoloader::register();

                $phpWord = new \PhpOffice\PhpWord\PhpWord();

                $phpWord->setDefaultParagraphStyle(array('spacing' => 120, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));

                $section = $phpWord->addSection();
                $sectionStyle = $section->getStyle();
                $footer = $section->addFooter();
                $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_PORTRAIT);

                $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.25));
                $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.25));
                $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.5));
                $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1));



                $voteDate = $vote->getDate();
                $voteDateFormatted = "";
                if (!empty($voteDate) && $voteDate != "0000-00-00") {
                    try {
                        $dt = new \DateTime($voteDate);
                        $monthStr = \Dreamedit::rus_get_month_name($dt->format('m'),2);
                        $monthStr = mb_strtolower($monthStr, 'windows-1251');
                        $voteDateFormatted = "{$dt->format('d')} {$monthStr} {$dt->format('Y')}";
                    } catch (\Exception $e) {
                    }
                }
                $voteParticipantsCount = count($vote->getParticipants());
                $voteParticipatedCount = $this->dissertationCouncils->getVoteResultService()->getParticipatedCountByVoteId($vote->getId());
                $voteForCount = $this->dissertationCouncils->getVoteResultService()->getVoteForCountByVoteId($vote->getId());
                $voteAgainstCount = $this->dissertationCouncils->getVoteResultService()->getVoteAgainstCountByVoteId($vote->getId());
                $voteAbstainedCount = $this->dissertationCouncils->getVoteResultService()->getVoteAbstainedCountByVoteId($vote->getId());

                $voteNotParticipatedCount = $voteParticipantsCount-$voteParticipatedCount;
                if($voteNotParticipatedCount<0) $voteNotParticipatedCount = 0;
                $voteNotParticipatedCountText = \Dreamedit::RusEnding($voteNotParticipatedCount,"����","�����","������");

                $voteTechnicalProblemCount = $vote->getWithTechnicalProblem();
                if($voteTechnicalProblemCount<0) $voteTechnicalProblemCount = 0;
                if($voteTechnicalProblemCount>$voteNotParticipatedCount) $voteTechnicalProblemCount = $voteNotParticipatedCount;
                $voteEvadedCount = $voteNotParticipatedCount-$voteTechnicalProblemCount;
                if($voteEvadedCount<0) $voteEvadedCount = 0;
                $voteEvadedCountText = \Dreamedit::RusEnding($voteEvadedCount,"����","�����","������");

                $voteAttended = $vote->getAttended();
                if($voteAttended<0) $voteAttended = 0;
                $voteAttendedText = \Dreamedit::RusEnding($voteAttended,"����","�����","������");

                $title = mb_strtolower(mb_substr($vote->getTitle(),0,1,'windows-1251'),'windows-1251').mb_substr($vote->getTitle(),1);

//                $registerText = \Dreamedit::RusEnding($questionnaireRegistrationCount,"�����������������","������������������","������������������");
//                $registerMemberText = \Dreamedit::RusEnding($questionnaireRegistrationCount,"����","�����","������");
//                $participateText = \Dreamedit::RusEnding($questionnaireVoteCount,"������","�������","�������");
//                $participateMemberText = \Dreamedit::RusEnding($questionnaireVoteCount,"����","�����","������");
//
//                $membersMemberText = \Dreamedit::RusEnding($membersCount,"����","�����","������");

                $section->addText(
                    mb_convert_encoding("� � � � � � � �","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center')
                );
                $section->addText(
                    mb_convert_encoding('����������� ������������ ����������� ���������������� ������',"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center')
                );
                $section->addText(
                    mb_convert_encoding("{$vote->getDissertationCouncilName()} �� ���� ����� ���","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center')
                );

                $section->addText(
                    mb_convert_encoding("�� {$voteDateFormatted} �.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'right')
                );
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("������ ����������� ����������� ���������� �� ��������� ���������������� ������ � ��������� ������������� ������� �� ������� {$title}.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("������ ���������������� ������ ��������� � ���������� {$voteParticipantsCount} ������� �� ������ �������� ������������ �������������� ������� ����������.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                if($vote->getDissertationProfile()!="") {
                    $textRun = $section->addTextRun(array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700)));
                    $textRun->addText(
                        mb_convert_encoding("�������������� �� ��������� {$voteAttended} {$voteAttendedText} ������, � ��� ����� �������� ���� �� ������� ��������������� �����������: ", "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                    $textRun->addText(
                        mb_convert_encoding("{$vote->getDissertationProfile()} � {$vote->getDoctors()}", "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, 'bold' => true)
                    );
                    $textRun->addText(
                        mb_convert_encoding('.', "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                } else {
                    $textRun = $section->addTextRun(array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700)));
                    $textRun->addText(
                        mb_convert_encoding("�������������� �� ��������� {$voteAttended} {$voteAttendedText} ������.", "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                }
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("���������� ������������ �����������: �� ������� {$title}: ","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("�� {$voteForCount}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("������ {$voteAgainstCount}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("������������ {$voteAbstainedCount}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                if($voteNotParticipatedCount == 1) {
                    if($voteTechnicalProblemCount == 1) {
                        $section->addText(
                            mb_convert_encoding("� ������ ����������� ����������� �� ����������� �������� �� ������������ 1 ���� ������.","UTF-8","windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                        );
                    }
                    elseif($voteEvadedCount == 1) {
                        $section->addText(
                            mb_convert_encoding("� ������ ����������� ����������� ��������� �� ����������� ����������� ����������� 1 ���� ������.","UTF-8","windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                        );
                    } else {
                        $section->addText(
                            mb_convert_encoding("� ������ ����������� ����������� �� ������������ 1 ���� ������.","UTF-8","windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                        );
                    }
                } else {
                    $section->addText(
                        mb_convert_encoding("� ������ ����������� ����������� �� ������������� {$voteNotParticipatedCount} {$voteNotParticipatedCountText} ������, �� ��� �� ����������� �������� {$voteTechnicalProblemCount},","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                    );
                    $section->addText(
                        mb_convert_encoding("���������� �� ����������� ����������� ����������� {$voteEvadedCount}. ","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                    );
                }
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("������������ ���������������� ������","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );
                $section->addText(
                    mb_convert_encoding("{$vote->getDissertationCouncilName()}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );



                $tableStyle = array(
                    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                    'unit' => 'dxa'
                );
                $table = $section->addTable($tableStyle);
                //$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(17));
                $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0));
                $table->addRow();
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8.5),array(
                ));
                $cell->addText(
                    mb_convert_encoding($vote->getChairmanPosition(), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'left', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8.5));
                $cell->addText(
                    mb_convert_encoding($vote->getChairmanName(), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'right', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );

                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("������ ��������� ���������������� ������","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );
                $section->addText(
                    mb_convert_encoding("{$vote->getDissertationCouncilName()} �� ���� ����� ���","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );

                $table = $section->addTable($tableStyle);
                //$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(17));
                $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0));
                $table->addRow();
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8.5),array(
                ));
                $cell->addText(
                    mb_convert_encoding($vote->getSecretaryPosition(), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'left', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8.5));
                $cell->addText(
                    mb_convert_encoding($vote->getSecretaryName(), "UTF-8", "windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'right', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );


                $filename = \Dreamedit::encodeText("�������� ������������ ����������� - {$vote->getTitle()}.docx");

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
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                $this->dissertationCouncils->getPageBuilder()->build(array("error" => "�� ������� �����������"));
            }
        } else {
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }


    }

}