<?php
//require_once 'includes/dompdf/autoload.inc.php';
//require_once 'includes/tfpdf/tfpdf.php';
//require_once 'includes/FPDF/fpdf.php';
//require_once 'includes/FPDI/fpdi.php';
//$dompdf = new \Dompdf\Dompdf();
//$hello = mb_convert_encoding("Привет","UTF-8","windows-1251");
//$html = "<html>
//<head>
//    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
//    <style>
//            @font-face {
//          font-family: 'Times New Roman';
//          font-style: normal;
//          font-weight: normal;
//          src: url(https://www.imemo.ru/dreamedit/includes/tfpdf/font/unifont/TimesNewRoman.ttf) format('truetype');
//        }
//        body { font-family: 'Times New Roman', sans-serif; }
//    </style>
//    <title></title>
//</head>
//<body>
//<div style=\"position: relative\">
//    <div style=\"width: 595px; height: 841px\"></div>
//    <div style=\"position: absolute;font-size: 15px;top: 141px;left: 380px;\">
//        <p>".$hello."</p>
//    </div>
//</div>
//</body>
//</html>";
//$dompdf->loadHtml($html);
//$dompdf->render();
//file_put_contents(__DIR__."/includes/AspModules/Documents/doc1.pdf", $dompdf->output());
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
//$pdf->setSourceFile(__DIR__."/includes/AspModules/Documents/doc1.pdf");
//$tplIdx = $pdf->importPage(1);
//// use the imported page and place it at point 100,10 with a width of 210 mm
//$pdf->useTemplate($tplIdx, 0, 0, 210, 297);
//
//$pdf->Output();
