<?php

namespace AcademicCouncilModule\PageBuilders\Templates;

use AcademicCouncilModule\AcademicCouncilModule;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireCreateFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireEditFormBuilder;
use AcademicCouncilModule\FormBuilders\Templates\QuestionnaireMailerFormBuilder;
use AcademicCouncilModule\PageBuilders\PageBuilder;

class QuestionnaireParticipateList implements PageBuilder {
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var \Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

//                error_reporting(E_ALL);
//        ini_set('display_errors', 1);

        if($this->academicCouncilModule->getAuthorizationService()->isAuthorized()) {

            $members = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireMembersListById($_GET['id']);

            if(!empty($members)) {

                require_once __DIR__ . '/../../../PhpWord/Autoloader.php';
                require_once __DIR__ . '/../../../Common/Text.php';
                require_once __DIR__ . '/../../../dompdf/autoload.inc.php';
                require_once __DIR__ . '/../../../Common/XMLWriter.php';

                \PhpOffice\PhpWord\Autoloader::register();

                $phpWord = new \PhpOffice\PhpWord\PhpWord();

                $phpWord->setDefaultParagraphStyle(array('spacing' => 0, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));

                $section = $phpWord->addSection();

                $sectionStyle = $section->getStyle();
                $sectionStyle->setPageNumberingStart(1);
                $headerFirstPage = $section->addHeader();
                $headerFirstPage->firstPage();
                $footerFirstPage = $section->addFooter();
                $footerFirstPage->firstPage();
                $footer = $section->addFooter();
                $footer->addPreserveText('{PAGE}', null, array('align' => 'right'));

                $sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_LANDSCAPE);

                $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.65));
                $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
                $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
                $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));

                $questionnaireId = $this->academicCouncilModule->getQuestionnaireService()->getQuestionnaireById($_GET['id']);

                $orderDate = $questionnaireId->getOrderDate();
                if(!empty($orderDate) && $orderDate!="0000-00-00") {
                    $dt = new \DateTime($orderDate);
                    $orderYear = $dt->format('Y');
                    $orderDay = $dt->format('d');
                    $orderMonth = mb_strtolower(\Dreamedit::rus_get_month_name($dt->format('m'),2));
                } else {
                    $orderDay = "___";
                    $orderMonth = "_______";
                    $orderYear = date('Y');
                }
                $orderNumber = "___";
                if($questionnaireId->getOrderNumber()!="") {
                    $orderNumber = $questionnaireId->getOrderNumber();
                }
                $questionnaireDate = $questionnaireId->getQuestionnaireDate();
                if(!empty($questionnaireDate) && $questionnaireDate!="0000-00-00") {
                    $dt = new \DateTime($questionnaireDate);
                    $questionnaireYear = $dt->format('Y');
                    $questionnaireDay = $dt->format('d');
                    $questionnaireMonth = mb_strtolower(\Dreamedit::rus_get_month_name($dt->format('m'),2));
                } else {
                    $questionnaireDay = "____";
                    $questionnaireMonth = "_______";
                    $questionnaireYear = date('Y');
                }
                $questionnaireQuestion = "____________";
                if($questionnaireId->getQuestionnaireQuestion()!="") {
                    $questionnaireQuestion = $questionnaireId->getQuestionnaireQuestion();
                }

                $section->addText(
                    mb_convert_encoding('Приложение к приказу от «'.$orderDay.'» '.$orderMonth.' '.$orderYear.' г. № '.$orderNumber, "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 12, "bold" => true),
                    array('align' => 'right', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $section->addTextBreak(1, array('name' => 'Arial', 'size' => 12),array('spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single')));
                $section->addText(
                    mb_convert_encoding('Регистрация участников предварительного голосования', "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 12, "bold" => true),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $section->addText(
                    mb_convert_encoding('по вопросу «'.$questionnaireQuestion.'»,', "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 12, "bold" => true),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $section->addText(
                    mb_convert_encoding('заседание Ученого совета ИМЭМО РАН от «'.$questionnaireDay.'» '.$questionnaireMonth.' '.$questionnaireYear.' года ', "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 12, "bold" => true),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );

                $tableStyle = array(
                    'borderColor' => '000000',
                    'borderSize' => 1,
                    'cellMarginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
                    'cellMarginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19)
                );
                $section->addTextBreak(2, array('name' => 'Arial', 'size' => 12),array('spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single')));
                $table = $section->addTable($tableStyle);
                $table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(27.25));
                $table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
                $table->addRow();
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21.5));

                $cell->addText(
                    mb_convert_encoding('Фамилия И.О., ', "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell->addText(
                    mb_convert_encoding('члена Ученого совета', "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );

                $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.25));
                $cell->addText(
                    mb_convert_encoding('Зарегистрировался для участия в голосовании', "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 12),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );
                $cell->addText(
                    mb_convert_encoding('(внести в ячейку «зарегистрировался»)', "UTF-8", "windows-1251"),
                    array('name' => 'Arial', 'size' => 10),
                    array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                );

                $phpWord->addNumberingStyle(
                    'multilevel',
                    array(
                        'type' => 'multilevel',
                        'levels' => array(
                            array('alignment' => "right", 'left' => 360, 'format' => 'decimal', 'text' => '%1.', 'start' => 1, 'font' => 'Arial', 'fontSize' => 24),
                        )
                    )
                );

                $counter=1;

                foreach ($members as $member) {
                    $table->addRow();
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5), array("margin" => 0));
                    $cell->addListItem('', 0, array('name' => 'Arial', 'size' => 12), 'multilevel');
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(21.5));
                    $thirdName = "";
                    if($member->getThirdName()!="") {
                        $thirdName = substr($member->getThirdName(),0,1).". ";
                    }
                    $addFioText = "";
                    if($counter==1) {
                        $addFioText = ", председатель Ученого совета";
                    }
                    if($counter==2) {
                        $addFioText = ", секретарь Ученого совета";
                    }

                    $meetingParticipation = "";
                    if($member->isRegistrationCompleted()) {
                        $meetingParticipation = "зарегистрировался";
                    }

                    $cell->addText(
                        mb_convert_encoding($member->getLastName()." ".substr($member->getFirstName(),0,1).". ".$thirdName.$addFioText, "UTF-8", "windows-1251"),
                        array('name' => 'Arial', 'size' => 12),
                        array('align' => 'left', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                    );
                    $cell->addTextBreak(1, array('name' => 'Arial', 'size' => 12),array('spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single')));
                    $cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.25));
                    $cell->addText(
                        mb_convert_encoding($meetingParticipation, "UTF-8", "windows-1251"),
                        array('name' => 'Arial', 'size' => 12),
                        array('align' => 'center', 'spaceAfter' => 0,'spacingLineRule' => 'single','space' => array('line' => 240,'type' => 'single'))
                    );
                    $counter++;
                }


                $filename = \Dreamedit::encodeText("Регистрация.docx");

                $this->academicCouncilModule->getDownloadService()->echoWordHeader($filename);

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save("php://output");


                exit();

            }


        } else {
            echo "Ошибка доступа";
        }
    }

}