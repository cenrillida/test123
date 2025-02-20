<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//
//require_once __DIR__.'/includes/PhpWord/Autoloader.php';
//require_once 'includes/Common/Text.php';
//require_once 'includes/dompdf/autoload.inc.php';
//require_once 'includes/Common/XMLWriter.php';
//
//\PhpOffice\PhpWord\Autoloader::register();
//
//$phpWord = new \PhpOffice\PhpWord\PhpWord();
//
//$phpWord->setDefaultParagraphStyle(array('spacing' => 0, 'spacingLineRule' => 'auto', 'spaceAfter' => 0));
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
//$footer = $section->addFooter();
////$footer->addPreserveText('{PAGE}',null, array('align' => 'right'));
////$paper = new \PhpOffice\PhpWord\Style\Paper();
////$paper->setSize('Letter');  // or 'Legal', 'A4' ...
////
////$sectionStyle->setPageSizeH($paper->getHeight());
////$sectionStyle->setPageSizeW($paper->getWidth());
//$sectionStyle->setOrientation(\PhpOffice\PhpWord\Style\Section::ORIENTATION_PORTRAIT);
//
//$sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5));
//$sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
//$sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
//$sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1));
//
//$section->addText(
//    mb_convert_encoding('Федеральное государственное бюджетное научное учреждение',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$section->addText(
//    mb_convert_encoding('«Национальный исследовательский институт мировой экономики и международных отношений имени Е.М. Примакова Российской академии наук»',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$section->addText(
//    mb_convert_encoding('(ИМЭМО им. Е.М. Примакова РАН)',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('ПРОТОКОЛ № 1',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$section->addText(
//    mb_convert_encoding('заседания Конкурсной комиссии',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$section->addText(
//    mb_convert_encoding('для проведения Конкурса на замещение должностей научных работников',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$section->addText(
//    mb_convert_encoding('ИМЭМО им. Е.М. Примакова РАН',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true),
//    array('align' => 'center')
//);
//$textRun = $section->addTextRun(array('align' => 'center'));
//$textRun->addText(
//    mb_convert_encoding('от «',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$textRun->addText(
//    mb_convert_encoding('30',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
//);
//$textRun->addText(
//    mb_convert_encoding('»  ',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$textRun->addText(
//    mb_convert_encoding('сентября',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
//);
//$textRun->addText(
//    mb_convert_encoding('  20',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$textRun->addText(
//    mb_convert_encoding('20',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
//);
//$textRun->addText(
//    mb_convert_encoding('г.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('Списочный состав Конкурсной комиссии утверждён Приказом директора ИМЭМО им. Е.М. Примакова РАН от 22.12.2017 г.№ 30 о/д» (с изменениями, утвержденными Приказом по Институту от 31.01.2020 г. № 9 о/д) в составе 18 человек, в том числе одного секретаря без права голоса.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('Во исполнение приказа Директора ИМЭМО РАН №662к от 25.09.2020 заседание Конкурсной комиссии от 29.04. 2020 г. проведено в дистанционном on-line режиме с использованием средств видеоконференцсвязи.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$textRun = $section->addTextRun(array('align' => 'justify'));
//$textRun->addText(
//    mb_convert_encoding('В голосовании приняли участие ',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$textRun->addText(
//    mb_convert_encoding('12',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "underline" => "single")
//);
//$textRun->addText(
//    mb_convert_encoding(' членов Конкурсной комиссии согласно рейтинговым листам (см. прил.) Кворум имеется.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$section->addText(
//    mb_convert_encoding('Председательствует на заседании: директор ИМЭМО РАН, чл.-корр. РАН Войтоловский Ф.Г.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addText(
//    mb_convert_encoding('Секретарь Конкурсной комиссии: Макарова А.А.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('Повестка дня:',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'center')
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('О замещении должности научного сотрудника Группы изучения общих проблем региона Лаборатории «Центр ближневосточных исследований» Федерального государственного бюджетного научного учреждения «Национальный исследовательский институт мировой экономики и международных отношений имени Е.М. Примакова Российской академии наук» (ИМЭМО им. Е.М. Примакова РАН).',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addTextBreak(2,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('По результатам проведения конкурса на замещение должности научного сотрудника Группы изучения общих проблем региона Лаборатории «Центр ближневосточных исследований» получены следующие результаты:',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$textRun = $section->addTextRun(array('align' => 'justify'));
//$textRun->addText(
//    mb_convert_encoding('Кандидат № 1:  ',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
//);
//$textRun->addText(
//    mb_convert_encoding('Тюкаева Т.И.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true, "underline" => "single")
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('СУММА БАЛЛЬНОЙ ОЦЕНКИ членов Конкурсной комиссии, принявших участие в заседании, согласно рейтинговым листам : 189',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addTextBreak(2,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('РЕШЕНИЕ Конкурсной комиссии :',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify')
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$textRun = $section->addTextRun(array('align' => 'justify'));
//$textRun->addText(
//    mb_convert_encoding('По результатам конкурса на замещение должности научного сотрудника Группы изучения общих проблем региона Лаборатории «Центр ближневосточных исследований» победителем является ',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$textRun->addText(
//    mb_convert_encoding('Тюкаева Т.И.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
//);
//$textRun->addText(
//    mb_convert_encoding(' Второе место - ',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12)
//);
//$textRun->addText(
//    mb_convert_encoding('отсутствует.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, "bold" => true)
//);
//
//$section->addPageBreak();
//
//$section->addText(
//    mb_convert_encoding('Признать конкурс на замещение вышеуказанной должности научного работника ИМЭМО им. Е.М. Примакова РАН состоявшимся.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
//);
//$section->addTextBreak(1,array('name' => 'Times New Roman', 'size' => 12));
//$section->addText(
//    mb_convert_encoding('Результаты конкурса считать основанием для заключения трудового договора с победителем на срок до трех лет.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'justify', 'keepNext' => true, 'indentation' => array('firstLine' => 700))
//);
//
//$section->addTextBreak(2,array('name' => 'Times New Roman', 'size' => 12));
//
//$tableStyle = array(
//    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
//    'unit' => 'dxa'
//);
//$table = $section->addTable($tableStyle);
//$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(17));
//$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(0));
//$table->addRow();
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(8),
//    array(
//        'valign' => 'bottom'
//    )
//);
//$cell->addText(
//    mb_convert_encoding('Председатель Конкурсной комиссии',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'left')
//);
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
//    array(
//        'borderBottomColor' => '000000',
//        'borderBottomSize'  => 1,
//        'valign' => 'bottom'
//    )
//);
//$cell->addImage(
//    __DIR__."/testp.png",
//    array('align' => 'center', 'width' => '150')
//);
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
//    array(
//        'valign' => 'bottom'
//    )
//);
//
//$cell->addText(
//    mb_convert_encoding('Загашвили В.С.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'center')
//);
//$tableStyle = array(
//    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'unit' => 'dxa'
//);
//
//
//$table = $section->addTable($tableStyle);
//$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
//$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
//$table->addRow();
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8));
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
//);
//$cell->addText(
//    mb_convert_encoding('подпись',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'center')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
//
//$tableStyle = array(
//    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'cellMarginBottom'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.35),
//    'unit' => 'dxa'
//);
//
//$table = $section->addTable($tableStyle);
//$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
//$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
//$table->addRow();
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(8),
//    array(
//        'valign' => 'bottom'
//    )
//);
//$cell->addText(
//    mb_convert_encoding('Секретарь Конкурсной комиссии',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'left')
//);
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
//    array(
//        'borderBottomColor' => '000000',
//        'borderBottomSize'  => 1,
//        'valign' => 'bottom'
//    )
//);
//$cell->addImage(
//    __DIR__."/testp.png",
//    array('align' => 'center', 'width' => '150')
//);
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7),
//    array(
//        'valign' => 'bottom'
//    )
//);
//
//$cell->addText(
//    mb_convert_encoding('Загашвили В.С.',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'center')
//);
//$tableStyle = array(
//    'cellMarginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'cellMarginRight'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.19),
//    'unit' => 'dxa'
//);
//$table = $section->addTable($tableStyle);
//$table->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(28));
//$table->getStyle()->setIndent(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(-1.06));
//$table->addRow();
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(8));
//$cell = $table->addCell(
//    \PhpOffice\PhpWord\Shared\Converter::cmToTwip(7)
//);
//$tableInside = $cell->addTable($tableStyle);
//$tableInside->getStyle()->setWidth(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
//$tableInside->addRow();
//$cellInside = $tableInside->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));
//$cellInside->addText(
//    mb_convert_encoding('Подпись верна',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12, 'color' => '00b04f', 'bold' => true),
//    array('align' => 'left')
//);
//$cellInside = $tableInside->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));
//$cellInside->addText(
//    mb_convert_encoding('30.09.2020',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'right')
//);
//$cellInside->addText(
//    mb_convert_encoding('18:25:19',"UTF-8","windows-1251"),
//    array('name' => 'Times New Roman', 'size' => 12),
//    array('align' => 'right')
//);
//$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7));
//
//
//
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
//
//
//$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//$objWriter->save(__DIR__.'/includes/AcademicCouncil/Documents/testdoc.docx');

//phpinfo();