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
                $voteNotParticipatedCountText = \Dreamedit::RusEnding($voteNotParticipatedCount,"член","члена","членов");

                $voteTechnicalProblemCount = $vote->getWithTechnicalProblem();
                if($voteTechnicalProblemCount<0) $voteTechnicalProblemCount = 0;
                if($voteTechnicalProblemCount>$voteNotParticipatedCount) $voteTechnicalProblemCount = $voteNotParticipatedCount;
                $voteEvadedCount = $voteNotParticipatedCount-$voteTechnicalProblemCount;
                if($voteEvadedCount<0) $voteEvadedCount = 0;
                $voteEvadedCountText = \Dreamedit::RusEnding($voteEvadedCount,"член","члена","членов");

                $voteAttended = $vote->getAttended();
                if($voteAttended<0) $voteAttended = 0;
                $voteAttendedText = \Dreamedit::RusEnding($voteAttended,"член","члена","членов");

                $title = mb_strtolower(mb_substr($vote->getTitle(),0,1,'windows-1251'),'windows-1251').mb_substr($vote->getTitle(),1);

//                $registerText = \Dreamedit::RusEnding($questionnaireRegistrationCount,"Зарегистрировался","Зарегистрировались","Зарегистрировались");
//                $registerMemberText = \Dreamedit::RusEnding($questionnaireRegistrationCount,"член","члена","членов");
//                $participateText = \Dreamedit::RusEnding($questionnaireVoteCount,"Принял","Приняли","Приняли");
//                $participateMemberText = \Dreamedit::RusEnding($questionnaireVoteCount,"член","члена","членов");
//
//                $membersMemberText = \Dreamedit::RusEnding($membersCount,"член","члена","членов");

                $section->addText(
                    mb_convert_encoding("П Р О Т О К О Л","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center')
                );
                $section->addText(
                    mb_convert_encoding('результатов электронного голосования диссертационного совета',"UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center')
                );
                $section->addText(
                    mb_convert_encoding("{$vote->getDissertationCouncilName()} на базе ИМЭМО РАН","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'center')
                );

                $section->addText(
                    mb_convert_encoding("от {$voteDateFormatted} г.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'right')
                );
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("Тайное электронное голосование проводится на заседании диссертационного совета в удаленном интерактивном формате по вопросу {$title}.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("Состав диссертационного совета утвержден в количестве {$voteParticipantsCount} человек на период действия Номенклатуры специальностей научных работников.","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                if($vote->getDissertationProfile()!="") {
                    $textRun = $section->addTextRun(array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700)));
                    $textRun->addText(
                        mb_convert_encoding("Присутствовало на заседании {$voteAttended} {$voteAttendedText} совета, в том числе докторов наук по профилю рассматриваемой диссертации: ", "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                    $textRun->addText(
                        mb_convert_encoding("{$vote->getDissertationProfile()} – {$vote->getDoctors()}", "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12, 'bold' => true)
                    );
                    $textRun->addText(
                        mb_convert_encoding('.', "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                } else {
                    $textRun = $section->addTextRun(array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700)));
                    $textRun->addText(
                        mb_convert_encoding("Присутствовало на заседании {$voteAttended} {$voteAttendedText} совета.", "UTF-8", "windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12)
                    );
                }
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("Результаты электронного голосования: по вопросу {$title}: ","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("за {$voteForCount}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("против {$voteAgainstCount}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                $section->addText(
                    mb_convert_encoding("воздержались {$voteAbstainedCount}","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                );
                if($voteNotParticipatedCount == 1) {
                    if($voteTechnicalProblemCount == 1) {
                        $section->addText(
                            mb_convert_encoding("В тайном электронном голосовании по техническим причинам не проголосовал 1 член совета.","UTF-8","windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                        );
                    }
                    elseif($voteEvadedCount == 1) {
                        $section->addText(
                            mb_convert_encoding("В тайном электронном голосовании уклонился от обязанности осуществить голосование 1 член совета.","UTF-8","windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                        );
                    } else {
                        $section->addText(
                            mb_convert_encoding("В тайном электронном голосовании не проголосовал 1 член совета.","UTF-8","windows-1251"),
                            array('name' => 'Times New Roman', 'size' => 12),
                            array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                        );
                    }
                } else {
                    $section->addText(
                        mb_convert_encoding("В тайном электронном голосовании не проголосовало {$voteNotParticipatedCount} {$voteNotParticipatedCountText} совета, из них по техническим причинам {$voteTechnicalProblemCount},","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                    );
                    $section->addText(
                        mb_convert_encoding("уклонились от обязанности осуществить голосование {$voteEvadedCount}. ","UTF-8","windows-1251"),
                        array('name' => 'Times New Roman', 'size' => 12),
                        array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
                    );
                }
                $section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
                $section->addText(
                    mb_convert_encoding("Председатель диссертационного совета","UTF-8","windows-1251"),
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
                    mb_convert_encoding("Ученый секретарь диссертационного совета","UTF-8","windows-1251"),
                    array('name' => 'Times New Roman', 'size' => 12),
                    array('align' => 'justify')
                );
                $section->addText(
                    mb_convert_encoding("{$vote->getDissertationCouncilName()} на базе ИМЭМО РАН","UTF-8","windows-1251"),
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


                $filename = \Dreamedit::encodeText("Протокол электронного голосования - {$vote->getTitle()}.docx");

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
                $this->dissertationCouncils->getPageBuilder()->build(array("error" => "Не найдено голосование"));
            }
        } else {
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }


    }

}