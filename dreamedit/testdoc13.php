<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/includes/PhpWord/Autoloader.php';
require_once 'includes/Common/Text.php';
require_once 'includes/dompdf/autoload.inc.php';
require_once 'includes/Common/XMLWriter.php';

\PhpOffice\PhpWord\Autoloader::register();

$phpWord = new \PhpOffice\PhpWord\PhpWord();

$phpWord->setDefaultParagraphStyle(array('spacing' => 0, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));

$section = $phpWord->addSection();

//$section->addText(htmlspecialchars('Page field:'));
//$section->addField('PAGE', array('format' => 'ArabicDash'));
//
//$section->addText('Lead text.');
//$footnote = $section->addFootnote();
//$footnote->addField('PAGE', array('format' => 'ArabicDash'));

$sectionStyle = $section->getStyle();
$footer = $section->addFooter();
//$footer->addPreserveText('{PAGE}',null, array('align' => 'right'));
//$paper = new \PhpOffice\PhpWord\Style\Paper();
//$paper->setSize('Letter');  // or 'Legal', 'A4' ...
//
//$sectionStyle->setPageSizeH($paper->getHeight());
//$sectionStyle->setPageSizeW($paper->getWidth());
$sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_PORTRAIT);

$sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.5));
$sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
$sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
$sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));

$section->addText(
    mb_convert_encoding('СПИСОК НАУЧНЫХ ТРУДОВ',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 12, "bold" => true),
    array('align' => 'center')
);
$section->addTextBreak(1,array('name' => 'Arial', 'size' => 12));
$section->addText(
    mb_convert_encoding('Фамилия, Имя, Отчество',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 12, "bold" => true),
    array('align' => 'left')
);

$tableStyle = array(
    'borderColor' => '000000',
    'borderSize'  => 1,
    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.05),
    'unit' => 'dxa'
);

$table = $section->addTable($tableStyle);
$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(19));
//$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
$table->addRow();
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('№№ п/п',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.26),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('Наименование научного труда',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4),array("vMerge" => "restart"));
//$textRun = $cell->addTextRun(
//    array('align' => 'center')
//);
$cell->addText(
    mb_convert_encoding('Название издательства, журнала',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('Отметить журналы, индексируемые в РИНЦ, WoS (СС, ESCI), Scopus;',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('Привести ссылку на статью на сайте журнала',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('Год издания, № журнала',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);

$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('Кол-во страниц и объем в авт / печ. листах (для книг); страницы (для статей).',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('При наличии соавторов указать авторский вклад',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);

$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('Примечание (указать соавторов)',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);

//////

$table->addRow();

$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('1',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.26),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('2',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4),array("vMerge" => "restart"));
//$textRun = $cell->addTextRun(
//    array('align' => 'center')
//);
$cell->addText(
    mb_convert_encoding('3',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.25),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('4',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);

$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('5',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);

$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3.5),array("vMerge" => "restart"));
$cell->addText(
    mb_convert_encoding('6',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'spacing' => -12),
    array('align' => 'center')
);

$table->addRow();

/////

$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(19),array("gridspan" => "6"));
$cell->addText(
    mb_convert_encoding('Монографии (в т.ч. ответственное редактирование монографий), главы в монографиях, брошюры',"UTF-8","windows-1251"),
    array('name' => 'Arial', 'size' => 10, 'bold' => true, 'spacing' => -12),
    array('align' => 'center')
);

//$section->addTextBreak(2,array('name' => 'Arial', 'size' => 12));
//
$footer->addText(
    mb_convert_encoding('"___"____________________20     г.	                               Автор ____________/_________________',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12)
);

$filename = 'date1.docx';

header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save("php://output");

exit();


$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save(__DIR__.'/includes/AcademicCouncil/Documents/testdoc.docx');