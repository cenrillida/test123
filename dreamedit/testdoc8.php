<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//require_once __DIR__.'/includes/PhpWord/Autoloader.php';
//require_once 'includes/Common/Text.php';
//require_once 'includes/dompdf/autoload.inc.php';
//require_once 'includes/Common/XMLWriter.php';
//
//\PhpOffice\PhpWord\Autoloader::register();
//
//$phpWord = new \PhpOffice\PhpWord\PhpWord();
//
//$section = $phpWord->addSection();
//
////$section->addText(htmlspecialchars('Page field:'));
////$section->addField('PAGE', array('format' => 'ArabicDash'));
////
////$section->addText('Lead text.');
////$footnote = $section->addFootnote();
////$footnote->addField('PAGE', array('format' => 'ArabicDash'));
//
//$sectionStyle = $section->getStyle();
//$sectionStyle->setPageNumberingStart(1);
//$headerFirstPage = $section->addHeader();
//$headerFirstPage->firstPage();
//$footerFirstPage = $section->addFooter();
//$footerFirstPage->firstPage();
//$footer = $section->addFooter();
//$footer->addPreserveText('{PAGE}',null, array('align' => 'right'));
////$paper = new \PhpOffice\PhpWord\Style\Paper();
////$paper->setSize('Letter');  // or 'Legal', 'A4' ...
////
////$sectionStyle->setPageSizeH($paper->getHeight());
////$sectionStyle->setPageSizeW($paper->getWidth());
//$sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_LANDSCAPE);
//
//$sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.65));
//$sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
//$sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
//$sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
//
//$section->addText(
//    mb_convert_encoding('Приложение к приказу от «___» _______ 2020 г. № ___',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12, "bold" => true),
//    array('align' => 'right')
//);
//$section->addTextBreak(1,array('name' => 'Arial', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('Опросный лист заседания Ученого совета ИМЭМО РАН от «____» _______2020 года ',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$section->addText(
//    mb_convert_encoding('по вопросу «____________»',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//
//$tableStyle = array(
//    'borderColor' => '000000',
//    'borderSize'  => 1,
//    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19)
//);
//$section->addTextBreak(2,array('name' => 'Arial', 'size' => 12));
//$table = $section->addTable($tableStyle);
//$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(27.25));
//$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
//$table->addRow();
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.5));
//$cell->addText(
//    mb_convert_encoding('Фамилия И.О., ',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('члена Ученого совета',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.25));
//$cell->addText(
//    mb_convert_encoding('Отметка об участии в заседании Ученого совета',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('(внести в ячейку «принял участие»)',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
//$cell->addText(
//    mb_convert_encoding('Результаты голосования',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('(внести в ячейку «да» или «нет»)',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
//$cell->addText(
//    mb_convert_encoding('Примечания',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('(замечания, возражения,',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('особое мнение)',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//
//$table->addRow();
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5), array("margin" => 0));
//$phpWord->addNumberingStyle(
//    'multilevel',
//    array(
//        'type' => 'multilevel',
//        'levels' => array(
//            array('alignment' => "right",'left'=> 360, 'format' => 'decimal', 'text' => '%1.', 'start' => 1, 'font' => 'Arial', 'fontSize' => 24),
//        )
//    )
//);
//$cell->addListItem('', 0, array('name' => 'Arial', 'size' => 12), 'multilevel');
//$cell->addListItem('', 0, array('name' => 'Arial', 'size' => 12), 'multilevel');
////$cell->addText(
////    mb_convert_encoding('1.    ',"UTF-8","windows-1251"),
////    array('name' => 'Arial', 'size' => 12),
////    array('align' => 'right')
////);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.5));
//
//$cell->addText(
//    mb_convert_encoding('Фамилия И.О., ',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('члена Ученого совета',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.25));
//$cell->addText(
//    mb_convert_encoding('Отметка об участии в заседании Ученого совета',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('(внести в ячейку «принял участие»)',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
//$cell->addText(
//    mb_convert_encoding('Результаты голосования',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('(внести в ячейку «да» или «нет»)',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
//$cell->addText(
//    mb_convert_encoding('Примечания',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 12),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('(замечания, возражения,',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//$cell->addText(
//    mb_convert_encoding('особое мнение)',"UTF-8","windows-1251"),
//    array('name' => 'Arial', 'size' => 10),
//    array('align' => 'center')
//);
//
//
//$filename = 'date1.docx';
//
//header("Content-Description: File Transfer");
//header('Content-Disposition: attachment; filename="' . $filename . '"');
//header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//header('Content-Transfer-Encoding: binary');
//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//header('Expires: 0');
//
//$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//$objWriter->save("php://output");
//
//exit();


//$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//$objWriter->save(__DIR__.'/includes/AcademicCouncil/Documents/testdoc.docx');