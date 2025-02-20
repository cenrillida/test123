<?php
//require_once 'includes/dompdf/autoload.inc.php';
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
//    <div style=\"position: absolute;font-size: 13px;top: 149px;left: 299px;\">
//        <p>".$hello."</p>
//    </div>
//</div>
//</body>
//</html>";
//$dompdf->loadHtml($html);
//$dompdf->render();
//file_put_contents(__DIR__."/includes/AspModules/Documents/doc1.pdf", $dompdf->output());