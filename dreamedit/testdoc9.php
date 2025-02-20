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
$sectionStyle->setPageNumberingStart(1);
$headerFirstPage = $section->addHeader();
$headerFirstPage->firstPage();
$footerFirstPage = $section->addFooter();
$footerFirstPage->firstPage();
$footer = $section->addFooter();
//$footer->addPreserveText('{PAGE}',null, array('align' => 'right'));
//$paper = new \PhpOffice\PhpWord\Style\Paper();
//$paper->setSize('Letter');  // or 'Legal', 'A4' ...
//
//$sectionStyle->setPageSizeH($paper->getHeight());
//$sectionStyle->setPageSizeW($paper->getWidth());
$sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_LANDSCAPE);

$sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.65));
$sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
$sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
$sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));

$section->addText(
    mb_convert_encoding('����������� ��������������� ��������� ������� ���������� ������������� ����������������� �������� ������� ��������� �',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
    array('align' => 'center')
);
$section->addText(
    mb_convert_encoding('������������� ��������� ����� �.�. ��������� ���������� �������� ���� (����� ��. �.�. ��������� ���)',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
    array('align' => 'center')
);
$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
$section->addText(
    mb_convert_encoding('����������� ���� � 1',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
    array('align' => 'center')
);
$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));

$tableStyle = array(
    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.25)
);
$table = $section->addTable($tableStyle);
$table->addRow();
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
$cell->addText(
    mb_convert_encoding('����� ���������� ��������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15),
    array(
        'borderBottomColor' => '000000',
        'borderBottomSize'  => 1
    )
);
$cell->addText(
    mb_convert_encoding('��������� �.�.',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
    array('align' => 'left')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5));
$cell->addText(
    mb_convert_encoding('�� �30� �������� 2020 �.',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$tableStyle = array(
    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19)
);
$table = $section->addTable($tableStyle);
$table->addRow();
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15)
);
$cell->addText(
    mb_convert_encoding('(�.�.�.)',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 9),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5));

$section->addText(
    mb_convert_encoding('��� ���������� ������ �������� �� ��������� ��������� ��������� �������� ���������� ������ �������� ����� ������� ������� ����������� ������ ��������������� ������������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'left')
);

$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));

$section->addText(
    mb_convert_encoding('�������� ��������� ����������:',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
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
$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
$table->addRow();
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.75));
$cell->addText(
    mb_convert_encoding('�',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(4.2));
$cell->addText(
    mb_convert_encoding('�.�.�',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('�����������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(13));
$cell->addText(
    mb_convert_encoding('�������� ����������, ����� ���������� ',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������������ �� ���������� �����������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������� ����������: ����������, ������, � �.�. �',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������������� ��������; ������� � ������� ��',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������� � ���������, ���������-�������������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('���������, ������� � ���������� ������������,',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������� � ������� ������������, ������������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('���������� �������� ����������� �����������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������������, ������� � ��������������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������������ �� ����������� �����������, ������� �',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������-��������������� ������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('(0-10 ������)',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(9));
$cell->addText(
    mb_convert_encoding('���� � ������������ �����������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3)
);
$cell->addText(
    mb_convert_encoding('�������������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 10.5, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('(0-5 ������)',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 10.5),
    array('align' => 'center')
);
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3)
);
$cell->addText(
    mb_convert_encoding('��������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('��������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('�����',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);
$cell->addText(
    mb_convert_encoding('��������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12, 'bold' => true),
    array('align' => 'center')
);


$section->addTextBreak(2,array('name' => 'Times New Roman', 'size' => 12));

$tableStyle = array(
    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
    'unit' => 'dxa'
);
$table = $section->addTable($tableStyle);
$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
$table->addRow();
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(6),
    array(
        'valign' => 'bottom'
    )
);
$cell->addText(
    mb_convert_encoding('���� ���������� ��������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
    array(
        'borderBottomColor' => '000000',
        'borderBottomSize'  => 1,
        'valign' => 'bottom'
    )
);
$cell->addImage(
    __DIR__."/testp.png",
    array('align' => 'center', 'width' => '150')
);
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(15),
    array(
        'borderBottomColor' => '000000',
        'borderBottomSize'  => 1,
        'valign' => 'bottom'
    )
);

$cell->addText(
    mb_convert_encoding('��������� �.�.',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$tableStyle = array(
    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
    'unit' => 'dxa'
);
$table = $section->addTable($tableStyle);
$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
$table->addRow();
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(6));
$cell = $table->addCell(
    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
);
$cell->addText(
    mb_convert_encoding('�������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
);
$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(15));
$cell->addText(
    mb_convert_encoding('����������� �������',"UTF-8","windows-1251"),
    array('name' => 'Times New Roman', 'size' => 12),
    array('align' => 'center')
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