<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//require_once 'includes/tfpdf/tfpdf.php';
//require_once 'includes/FPDI/fpdi.php';
//
//// initiate PDF
//$pdf = new FPDI();
//
//// Add some Unicode font (uses UTF-8)
//$pdf->AddFont('DejaVu','','TimesNewRoman.ttf',true);
//$pdf->SetFont('DejaVu','',13);
//
//// add a page
//$pdf->AddPage();
//
//$pdf->SetFont('DejaVu', '', 14);
//
//// Load a UTF-8 string from a file and print it
//$txt = mb_convert_encoding("    Привет f44f u2f4uh2 4uf hu24fh2h4ufh2 u4hfhu24fhu 24huf ","UTF-8","windows-1251");
//$pdf->Write(8, $txt);
//
//// Select a standard font (uses windows-1252)
//$pdf->SetFont('Arial', '', 14);
//$pdf->Ln(10);
//$pdf->Write(5, 'The file uses font subsetting.');
//
//$pdf->Output();
//
//exit;
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
//$txt = mb_convert_encoding("    Привет f44f u2f4uh2 4uf hu24fh2h4ufh2 u4hfhu24fhu 24huf ","UTF-8","windows-1251");
//
//$total_string_width = $pdf->GetStringWidth($txt);
//$number_of_lines = $total_string_width / (95 - 1);
//
//$number_of_lines = ceil( $number_of_lines );  // Round it up.
//
//if($number_of_lines>2) {
//
//} else {
//    $pdf->MultiCell( 95, 8.8, $txt, 0,"L");
//}
//
////$pdf->Write(4,$txt);
//
//
//
//
//$pdf->Output("F",__DIR__."/includes/AspModules/Documents/doc3.pdf");
//
//// initiate FPDI
//$pdf = new FPDI('P');
//// add a page
//$pdf->AddPage();
//// set the source file to doc1.pdf and import a page
//$pdf->setSourceFile(__DIR__."/includes/AspModules/Documents/Templates/zayavlenie_template_4.pdf");
//$tplIdx = $pdf->importPage(1);
//$size = $pdf->getTemplateSize($tplIdx);
//
//// use the imported page and place it at point 10,10 with a width of 210 mm
//$pdf->useTemplate($tplIdx, 0, 0, $size['w'],$size['h']);
//// set the source file to doc2.pdf and import a page
//$pdf->setSourceFile(__DIR__."/includes/AspModules/Documents/doc3.pdf");
//$tplIdx = $pdf->importPage(1);
//// use the imported page and place it at point 100,10 with a width of 210 mm
//$pdf->useTemplate($tplIdx, 90, 45.8);
//
////$pdf->Image(__DIR__."/../newsite/img/logo_jour.png",0,0,314);
//
//$pdf->Output();
