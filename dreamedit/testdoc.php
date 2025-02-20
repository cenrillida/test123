<?php

//var_dump($_SERVER['HTTP_USER_AGENT']);
//
//require_once 'includes/dompdf/autoload.inc.php';
//require_once 'includes/tfpdf/tfpdf.php';
//require_once 'includes/FPDF/fpdf.php';
//require_once 'includes/FPDI/fpdi.php';
//$hello = mb_convert_encoding("Привет","UTF-8","windows-1251");
//
//$pdf = new tFPDF();
//$pdf->AddPage();
//
//// Add a Unicode font (uses UTF-8)
//$pdf->AddFont('DejaVu','','TimesNewRoman.ttf',true);
//$pdf->SetFont('DejaVu','',13);
//
//// Load a UTF-8 string from a file and print it
//$txt = mb_convert_encoding("Привет f13 f13 f1 f13 f13 f1 f13 f13 f13f 13f 13 f31 f13 ","UTF-8","windows-1251");
//$pdf->Write(5,$txt);
//
//$pdf->Output("F",__DIR__."/includes/AspModules/Documents/doc3.pdf");
//
//// initiate FPDI
//$pdf = new FPDI('P');
//// add a page
//$pdf->AddPage();
//// set the source file to doc1.pdf and import a page
//$pdf->setSourceFile(__DIR__."/includes/AspModules/Documents/zayavlenie_template.pdf");
//$tplIdx = $pdf->importPage(1);
//// use the imported page and place it at point 10,10 with a width of 210 mm
//$pdf->useTemplate($tplIdx, 0, 0, 210,297);
//// set the source file to doc2.pdf and import a page
//$pdf->setSourceFile(__DIR__."/includes/AspModules/Documents/doc3.pdf");
//$tplIdx = $pdf->importPage(1);
//// use the imported page and place it at point 100,10 with a width of 210 mm
//$pdf->useTemplate($tplIdx, 95, 48, 210);
//
//$pdf->Output();
//
//
//exit;
//
//$dompdf = new \Dompdf\Dompdf();
//$hello = mb_convert_encoding("Привет","UTF-8","windows-1251");
//$html = "<html>
//<head>
//<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
//<style>
//  body { font-family: DejaVu Sans, sans-serif; }
//</style>
//<title></title>
//</head>
//<body>
//  <p>".$hello."</p>
//</body>
//</html>";
//$dompdf->loadHtml($html);
//$dompdf->render();
//file_put_contents(__DIR__."/includes/AspModules/Documents/doc1.pdf", $dompdf->output());
//
////unset($dompdf);
////
////$dompdf = new \Dompdf\Dompdf();
////$dompdf->loadHtml('<p>&nbsp;</p><p>Hello</p>');
////$dompdf->render();
////file_put_contents(__DIR__."/includes/AspModules/Documents/doc2.pdf", $dompdf->output());
//
//
//
//
//exit;
//
//require_once 'includes/PhpWord/Autoloader.php';
//require_once 'includes/Common/Text.php';
//require_once 'includes/dompdf/autoload.inc.php';
//
//
////require_once 'includes/Common/XMLWriter.php';
//\PhpOffice\PhpWord\Autoloader::register();
//
////$phpWord = \PhpOffice\PhpWord\IOFactory::load(__DIR__."/includes/AspModules/Documents/zayavlenie.docx");
//
//try {
//    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(__DIR__."/includes/AspModules/Documents/zayavlenie2.docx");
//
//    $path = __DIR__."/includes/dompdf";
//
//    \PhpOffice\PhpWord\Settings::setPdfRendererPath($path);
//    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
//
//    $inline = new \PhpOffice\PhpWord\Element\TextRun();
//    $myFontStyle = array('size' => 13, 'color' => "black");
//    //$myParagraphStyle = array('align'=>'center');
//
//    $inline->addText('by a red italic text', $myFontStyle);
//    $templateProcessor->setComplexValue('fio_r', $inline);
//    //$templateProccesor->setValue('fio_r', 'myvar');
//    //$templateProcessor->saveAs(__DIR__."/includes/AspModules/Documents/zayavlenie_test.docx");
//
//
//    $docx = $templateProcessor->save();
//    $phpWord = \PhpOffice\PhpWord\IOFactory::load($docx);
//    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord,'PDF');
//
//
//
//    $xmlWriter->save(__DIR__."/includes/AspModules/Documents/zayavlenie_test.pdf");  // Save to PDF
//
//} catch (Exception $exc) {
//    var_dump($exc);
//}
