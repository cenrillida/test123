<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

function encodeText($text) {
    return iconv("windows-1251","utf-8", $text);
}

ini_set('memory_limit', '256M');
include_once dirname(__FILE__) . "/../../../_include.php";

/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Moscow');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../../../includes/PHPExcel/PHPExcel.php';

//$validLocale = PHPExcel_Settings::setLocale('ru');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("IMEMO")
    ->setLastModifiedBy("IMEMO")
    ->setTitle("Persons IMEMO")
    ->setSubject("Persons IMEMO")
    ->setDescription("Persons IMEMO")
    ->setKeywords("Persons IMEMO")
    ->setCategory("Persons IMEMO");

// Add some data
$sheet = $objPHPExcel->setActiveSheetIndex(0);

$columnPosition = 0; // Начальная координата x
$startLine = 1; // Начальная координата y

$columns = array(
    array('title' => encodeText('ID'), 'width' => 10),
    array('title' => encodeText('Фамилия'), 'width' => 20),
    array('title' => encodeText('Имя'), 'width' => 15),
    array('title' => encodeText('Отчество'), 'width' => 15),
    array('title' => encodeText('ФИО (EN)'), 'width' => 40),
    array('title' => encodeText('ID дубля'), 'width' => 10),
    array('title' => encodeText('Ученая степень'), 'width' => 15),
    array('title' => encodeText('Ученое звание'), 'width' => 15),
    array('title' => encodeText('Членство в РАН'), 'width' => 30),
    array('title' => encodeText('Д 002.003.01'), 'width' => 200),
    array('title' => encodeText('Д 002.003.02'), 'width' => 200),
    array('title' => encodeText('Д 002.003.03'), 'width' => 200),
    array('title' => encodeText('Д 4'), 'width' => 200),
    array('title' => encodeText('Годы жизни'), 'width' => 15),
    array('title' => encodeText('Должность 1'), 'width' => 70),
    array('title' => encodeText('Подразделение 1'), 'width' => 70),
    array('title' => encodeText('Должность 2'), 'width' => 70),
    array('title' => encodeText('Подразделение 2'), 'width' => 70),
    array('title' => encodeText('Должность 3'), 'width' => 70),
    array('title' => encodeText('Подразделение 3'), 'width' => 70),
    array('title' => encodeText('Телефон публичный'), 'width' => 30),
    array('title' => encodeText('e-mail публичный'), 'width' => 30),
    array('title' => encodeText('Телефон для администрации'), 'width' => 30),
    array('title' => encodeText('e-mail для администрации'), 'width' => 30),
    array('title' => encodeText('Science Index'), 'width' => 15),
    array('title' => encodeText('Scopus'), 'width' => 15),
    array('title' => encodeText('ORCID'), 'width' => 15),
    array('title' => encodeText('ResearcherID'), 'width' => 15),
    array('title' => encodeText('О себе'), 'width' => 100),
    array('title' => encodeText('О себе (EN)'), 'width' => 100)
);

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


$persons =  $DB->select('SELECT * FROM persons ORDER BY id');
$science_grades = $DB->select("SELECT c.el_id AS ARRAY_KEY,c.icont_text AS full
						FROM adm_directories_content AS c
                        INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=7
						WHERE icont_var='text'
							ORDER BY c.icont_text");
$science_names =$DB->select("SELECT c.el_id AS ARRAY_KEY,c.icont_text AS full
						FROM adm_directories_content AS c
                        INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=8
						WHERE icont_var='text'
							ORDER BY c.icont_text");
$rans=$DB->select("SELECT c.el_id AS ARRAY_KEY,c.icont_text AS full FROM adm_directories_content AS c
                  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=10
						WHERE icont_var='value'
						ORDER BY c.icont_text");
$specdss=$DB->select("SELECT c.el_id AS ARRAY_KEY,c.icont_text AS full FROM adm_directories_content AS c
                  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=17
						WHERE icont_var='text'
						ORDER BY c.icont_text");
$doljn=$DB->select("SELECT c.el_id AS ARRAY_KEY,c.icont_text AS full
                      FROM adm_directories_content AS c
                      INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=9
						WHERE icont_var='text'
							ORDER BY c.icont_text");

$otdels = array();

$pg = new Pages();
$pp0=$pg->getChilds(417);

foreach($pp0 as $pp)
{
    $otdels[$pp['page_id']] = $pp['page_name'];
    $pp20=$pg->getChilds($pp['page_id']);
    foreach ($pp20 as $pp2)
    {
        $otdels[$pp2['page_id']] = $pp2['page_name'];
        $pp30=$pg->getChilds($pp2['page_id']);
        foreach ($pp30 as $pp3)
        {
            $otdels[$pp3['page_id']] = $pp3['page_name'];
        }
    }
}

$link_style_array = array(
    'font'  => array(
        'color' => array('rgb' => '0000FF'),
        'underline' => 'single'
    )
);


//echo "<pre>";
//var_dump($science_grades);
//echo "</pre>";

foreach ($persons as $key=>$person) {
    // Перекидываем указатель на следующую строку
    $startLine++;
    $sheet->getRowDimension($startLine)->setRowHeight(15);
    // Указатель на первый столбец
    $sheet->setCellValueByColumnAndRow(0, $startLine, encodeText($person['id']));
    $sheet->setCellValueByColumnAndRow(1, $startLine, encodeText($person['surname']));
    $sheet->setCellValueByColumnAndRow(2, $startLine, encodeText($person['name']));
    $sheet->setCellValueByColumnAndRow(3, $startLine, encodeText($person['fname']));
    $sheet->setCellValueByColumnAndRow(4, $startLine, encodeText($person['Autor_en']));
    if($person['second_profile']!=-1) {
        $sheet->setCellValueByColumnAndRow(5, $startLine, encodeText($person['second_profile']));
    } else {
        $sheet->setCellValueByColumnAndRow(5, $startLine, '');
    }
    if(!empty($science_grades[$person['us']]['full'])) {
        $sheet->setCellValueByColumnAndRow(6, $startLine, encodeText($science_grades[$person['us']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(6, $startLine, '');
    }
    if(!empty($science_names[$person['uz']]['full'])) {
        $sheet->setCellValueByColumnAndRow(7, $startLine, encodeText($science_names[$person['uz']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(7, $startLine, '');
    }
    if(!empty($rans[$person['ran']]['full'])) {
        $sheet->setCellValueByColumnAndRow(8, $startLine, encodeText($rans[$person['ran']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(8, $startLine, '');
    }
    if(!empty($specdss[$person['spec_ds']]['full'])) {
        $sheet->setCellValueByColumnAndRow(9, $startLine, encodeText($specdss[$person['spec_ds']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(9, $startLine, '');
    }
    if(!empty($specdss[$person['spec_ds2']]['full'])) {
        $sheet->setCellValueByColumnAndRow(10, $startLine, encodeText($specdss[$person['spec_ds2']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(10, $startLine, '');
    }
    if(!empty($specdss[$person['spec_ds3']]['full'])) {
        $sheet->setCellValueByColumnAndRow(11, $startLine, encodeText($specdss[$person['spec_ds3']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(11, $startLine, '');
    }
    if(!empty($specdss[$person['spec_ds4']]['full'])) {
        $sheet->setCellValueByColumnAndRow(12, $startLine, encodeText($specdss[$person['spec_ds4']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(12, $startLine, '');
    }
    if(!empty($specdss[$person['spec_ds4']]['full'])) {
        $sheet->setCellValueByColumnAndRow(12, $startLine, encodeText($specdss[$person['spec_ds4']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(12, $startLine, '');
    }
    $sheet->setCellValueByColumnAndRow(13, $startLine, encodeText($person['rewards']));
    if(!empty($doljn[$person['dolj']]['full'])) {
        $sheet->setCellValueByColumnAndRow(14, $startLine, encodeText($doljn[$person['dolj']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(14, $startLine, '');
    }
    if(!empty($otdels[$person['otdel']])) {
        $sheet->setCellValueByColumnAndRow(15, $startLine, encodeText($otdels[$person['otdel']]));
    } else {
        $sheet->setCellValueByColumnAndRow(15, $startLine, '');
    }
    if(!empty($doljn[$person['dolj2']]['full'])) {
        $sheet->setCellValueByColumnAndRow(16, $startLine, encodeText($doljn[$person['dolj2']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(16, $startLine, '');
    }
    if(!empty($otdels[$person['otdel2']])) {
        $sheet->setCellValueByColumnAndRow(17, $startLine, encodeText($otdels[$person['otdel2']]));
    } else {
        $sheet->setCellValueByColumnAndRow(17, $startLine, '');
    }
    if(!empty($doljn[$person['dolj3']]['full'])) {
        $sheet->setCellValueByColumnAndRow(18, $startLine, encodeText($doljn[$person['dolj3']]['full']));
    } else {
        $sheet->setCellValueByColumnAndRow(18, $startLine, '');
    }
    if(!empty($otdels[$person['otdel3']])) {
        $sheet->setCellValueByColumnAndRow(19, $startLine, encodeText($otdels[$person['otdel3']]));
    } else {
        $sheet->setCellValueByColumnAndRow(19, $startLine, '');
    }
    $sheet->setCellValueByColumnAndRow(20, $startLine, encodeText($person['tel1']));
    $sheet->setCellValueByColumnAndRow(21, $startLine, encodeText($person['mail1']));
    $sheet->setCellValueByColumnAndRow(22, $startLine, encodeText($person['tel2']));
    $sheet->setCellValueByColumnAndRow(23, $startLine, encodeText($person['mail2']));

    preg_match_all('@href="([^"]+elibrary.ru[^"]+)"@', $person['about'], $elibrary_link);
    $elibrary_link = array_pop($elibrary_link);

    if(!empty($elibrary_link[0])) {
        $elibrary_link = $elibrary_link[0];
        $sheet->setCellValueByColumnAndRow(24, $startLine, '=Hyperlink("'.encodeText($elibrary_link).'","'.encodeText('Открыть').'")');
        $sheet->getCellByColumnAndRow(24,$startLine)->getStyle()->applyFromArray($link_style_array);
    } else {
        $sheet->setCellValueByColumnAndRow(24, $startLine, '');
    }

    preg_match_all('@href="([^"]+scopus.com[^"]+)"@', $person['about'], $scopus_link);
    $scopus_link = array_pop($scopus_link);

    if(!empty($scopus_link[0])) {
        $scopus_link = $scopus_link[0];
        $sheet->setCellValueByColumnAndRow(25, $startLine, '=Hyperlink("'.encodeText($scopus_link).'","'.encodeText('Открыть').'")');
        $sheet->getCellByColumnAndRow(25,$startLine)->getStyle()->applyFromArray($link_style_array);
    } else {
        $sheet->setCellValueByColumnAndRow(25, $startLine, '');
    }

//    preg_match_all('@href="([^"]+orcid.org[^"]+)"@', $person['about'], $orcid_link);
//    $orcid_link = array_pop($orcid_link);

    if(!empty($person['orcid'])) {
        $orcidLink = "https://orcid.org/".$person['orcid'];
        $sheet->setCellValueByColumnAndRow(26, $startLine, '=Hyperlink("'.encodeText($orcidLink).'","'.encodeText('Открыть').'")');
        $sheet->getCellByColumnAndRow(26,$startLine)->getStyle()->applyFromArray($link_style_array);
    } else {
        $sheet->setCellValueByColumnAndRow(26, $startLine, '');
    }

    preg_match_all('@href="([^"]+researcherid.com[^"]+)"@', $person['about'], $researcherID);
    $researcherID = array_pop($researcherID);

    if(!empty($researcherID[0])) {
        $researcherID = $researcherID[0];
        $sheet->setCellValueByColumnAndRow(27, $startLine, '=Hyperlink("'.encodeText($researcherID).'","'.encodeText('Открыть').'")');
        $sheet->getCellByColumnAndRow(27,$startLine)->getStyle()->applyFromArray($link_style_array);
    } else {
        $sheet->setCellValueByColumnAndRow(27, $startLine, '');
    }


    $about = preg_replace('/<!--.*-->/iUs', "", $person['about']);
    $about = preg_replace('/<.*>/iUs', "", $about);
    $aboutEn = preg_replace('/<!--.*-->/iUs', "", $person['about_en']);
    $aboutEn = preg_replace('/<.*>/iUs', "", $aboutEn);
    $sheet->setCellValueByColumnAndRow(28, $startLine, htmlspecialchars(encodeText(ltrim($about))));
    $sheet->getCellByColumnAndRow(28,$startLine)->getStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $sheet->getCellByColumnAndRow(28,$startLine)->getStyle()->getAlignment()->setWrapText(true);
    $sheet->setCellValueByColumnAndRow(29, $startLine, htmlspecialchars(encodeText(ltrim($aboutEn))));
    $sheet->getCellByColumnAndRow(29,$startLine)->getStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $sheet->getCellByColumnAndRow(29,$startLine)->getStyle()->getAlignment()->setWrapText(true);
//    for ($i=0;$i<=29;$i++) {
//        $sheet->getCellByColumnAndRow($i,$startLine)->getStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_FILL);
//    }

}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Persons');

$objPHPExcel->getActiveSheet()->freezePane('A2');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="persons.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;