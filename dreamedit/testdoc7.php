<?php
//
//include_once "includes/class.DocumentTemplater.php";
//
////error_reporting(E_ALL);
////ini_set('display_errors', 1);
//
//$templater = new DocumentTemplater();
//$documentTextFieldsFirstPage = array();
//$documentTextFieldsFirstPage[] = new DocumentTextField("ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff",50,163,7.3,35,207.7,"alexq_fior", "L");
////$documentTextFieldsFirstPage[] = new DocumentTextField("ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff",50,45,7.5,145.8,114,"alexq_fior", "L",7);
//
////for ($i=1; $i<=1200; $i++) {
////    //coordinate = 114 + (($i-1)*7.5);
////    $documentTextFieldsFirstPage[] = new DocumentTextField("f",50,45,7.5,155.8,124,"alexq_fior", "L",7);
////}
//
////$documentTextFieldsFirstPage[] = new DocumentTextField("ИМЭМО РАН г. Москва",50,43,7.5,9,124,"alexq_fior", "C",7);
//
////$documentTextFieldsFirstPage[] = new DocumentTextField("x",12,3,5,14.3,188.7,"alexq_fior", "L");
//
//$documentTextFieldsSecondPage = array();
////$documentTextFieldsSecondPage[] = new DocumentTextField("ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff",50,170,5.8,14,120,"alexq_fior");
//$documentTextFieldsSecondPage[] = new DocumentTextField("ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff",250,72,6.53,130.5,176.5,"alexq_fior", "L",7);
//
//
//$documentPages = array();
//
//$photos = array();
//$photos[] = new DocumentPhotoField(__DIR__."/includes/AspModules/Documents/Photo/alexqw1yaruphoto474FBC84-8657-473F-8FB0-6FF316E068C917278055718.jpg","30","40","170","35");
//
//$documentPages[] = new DocumentPage($documentTextFieldsFirstPage,$photos);
//$documentPages[] = new DocumentPage($documentTextFieldsSecondPage);
//$documentPages[] = new DocumentPage($documentTextFieldsSecondPage);
//$documentPages[] = new DocumentPage($documentTextFieldsFirstPage);
//
//$templater->fillFileWithTemplate(__DIR__."/includes/AspModules/Documents/Templates/personal_data_sheet_on_personnel_tracking.pdf",$documentPages);
//
////$templater->fillFileWithTemplate(__DIR__."/includes/AspModules/Documents/Templates/zayavlenie_template_4.pdf",$documentPages,"Заявление Сформированное.pdf");