<?php
////Персоналии и почты(у кого есть) в excel
//
//function explodeEmailTo ($mail, &$emails) {
//    foreach (explode(",",$mail) as $email) {
//        $email = str_replace(" ","",$email);
//        if(!empty($email) && !in_array($email,$emails)) {
//            $emails[] = $email;
//        }
//    }
//}
//
//include_once dirname(__FILE__)."/_include.php";
//
//$persons = $DB->select("
//SELECT *
//FROM persons
//WHERE mail1<>'' OR mail2<>'' OR emails_for_ac_mailing<>'' OR emails_for_mailing<>''
//ORDER BY surname
//");
//
//$personsResult = array();
//
//foreach ($persons as $person) {
//    $currentPerson = array();
//    $currentPerson['surname'] = $person['surname'];
//    $currentPerson['name'] = $person['name'];
//    $currentPerson['fname'] = $person['fname'];
//
//    $emails = array();
//
//    explodeEmailTo($person['mail1'],$emails);
//    explodeEmailTo($person['mail2'],$emails);
//    explodeEmailTo($person['emails_for_ac_mailing'],$emails);
//    explodeEmailTo($person['emails_for_mailing'],$emails);
//
//    $currentPerson['mails'] = $emails;
//
//    $personsResult[] = $currentPerson;
//}
//
////echo "<pre>";
////var_dump($personsResult);
////echo "</pre>";
//
//require_once dirname(__FILE__) . '/includes/PHPExcel/PHPExcel.php';
//
//$objPHPExcel = new \PHPExcel();
//
//// Set document properties
//$objPHPExcel->getProperties()->setCreator(\Dreamedit::encodeText("ИМЭМО РАН"))
//    ->setLastModifiedBy(\Dreamedit::encodeText("ИМЭМО РАН"))
//    ->setTitle(\Dreamedit::encodeText("Список персоналий ИМЭМО РАН"))
//    ->setSubject(\Dreamedit::encodeText("Список персоналий ИМЭМО РАН"))
//    ->setDescription(\Dreamedit::encodeText("Список персоналий ИМЭМО РАН"))
//    ->setKeywords(\Dreamedit::encodeText("Список персоналий ИМЭМО РАН"))
//    ->setCategory(\Dreamedit::encodeText("Список персоналий ИМЭМО РАН"));
//
//// Add some data
//$sheet = $objPHPExcel->setActiveSheetIndex(0);
//
//$columnPosition = 0; // Начальная координата x
//$startLine = 1; // Начальная координата y
//
//$columns = array(
//    array('title' => \Dreamedit::encodeText('Фамилия'), 'width' => 30),
//    array('title' => \Dreamedit::encodeText('Имя'), 'width' => 30),
//    array('title' => \Dreamedit::encodeText('Отчество'), 'width' => 30),
//    array('title' => \Dreamedit::encodeText('E-mails'), 'width' => 150),
//);
//
//// Указатель на первый столбец
//$currentColumn = $columnPosition;
//
//// Формируем шапку
//foreach ($columns as $column) {
//    // Красим ячейку
//    $sheet->getStyleByColumnAndRow($currentColumn, $startLine)
//        ->getFill()
//        ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
//        ->getStartColor()
//        ->setRGB('4dbf62');
//
//    $sheet->setCellValueByColumnAndRow($currentColumn, $startLine, $column['title']);
//
//    $sheet->getColumnDimensionByColumn($currentColumn)->setWidth($column['width']);
//
//    // Смещаемся вправо
//    $currentColumn++;
//}
//
//$link_style_array = array(
//    'font'  => array(
//        'color' => array('rgb' => '0000FF'),
//        'underline' => 'single'
//    )
//);
//
//foreach ($personsResult as $person) {
//    $startLine++;
//    $sheet->getRowDimension($startLine)->setRowHeight(15);
//    $columnId = 0;
//
//    $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($person['surname']));
//    $columnId++;
//    $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($person['name']));
//    $columnId++;
//    $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText($person['fname']));
//    $columnId++;
//    $sheet->setCellValueByColumnAndRow($columnId, $startLine, \Dreamedit::encodeText(implode(",",$person['mails'])));
//    $columnId++;
//
//}
//
//
//$objPHPExcel->getActiveSheet()->setTitle(\Dreamedit::encodeText("Список персоналий ИМЭМО РАН"));
//
//$objPHPExcel->getActiveSheet()->freezePane('A2');
//
//
//// Set active sheet index to the first sheet, so Excel opens this as the first sheet
//$objPHPExcel->setActiveSheetIndex(0);
//
//
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment; filename="' . \Dreamedit::encodeText("Список персоналий ИМЭМО РАН.xlsx") . '"');
//header('Cache-Control: max-age=0');
//header('Cache-Control: max-age=1');
//header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//header ('Pragma: public'); // HTTP/1.0
//
////$this->aspModule->getDownloadService()->echoExcelHeader(\Dreamedit::encodeText("Список пользователей личного кабинета аспирантуры.xlsx"));
//
//$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save('php://output');
//
//exit;