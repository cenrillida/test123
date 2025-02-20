<?php


$contentDir = '/home/imemon/html/files/File/magazines/REB_month/content';
$statisticsDir = '/home/imemon/html/files/File/magazines/REB_month/statistics';
$contentYearsScanned = scandir($contentDir);
$contentYears = array();

foreach ($contentYearsScanned as $year) {
    if ($year != "." && $year != "..") {
        $contentYears[$year] = $year;
    }
}

krsort($contentYears);

$lastYear = array_shift($contentYears);
$contentPdfScanned = scandir($contentDir."/".$lastYear);
$numbers = array();

foreach ($contentPdfScanned as $pdf) {
    if($pdf!="." && $pdf!="..") {
        $month = substr($pdf,5,2);
        $numbers[$month] = array("month"=>$month,'pdf'=>$pdf);
    }
}

$statisticYearsScanned = scandir($statisticsDir);

$statisticYears = array();

foreach ($contentYearsScanned as $year) {
    if ($year != "." && $year != "..") {
        $statisticYears[$year] = $year;
    }
}

krsort($statisticYears);

$lastYear = array_shift($statisticYears);
$contentPdfScanned = scandir($statisticsDir."/".$lastYear);

foreach ($contentPdfScanned as $pdf) {
    if($pdf!="." && $pdf!="..") {
        $month = substr($pdf,5,2);
        if(!empty($numbers[$month])) {
            $numbers[$month]['statistics'] = $pdf;
        }
    }
}

krsort($numbers);

$lastNumber = array_shift($numbers);



Dreamedit::sendHeaderByCode(301);

Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."//files/File/magazines/REB_month/content/".$lastYear."/".$lastNumber['pdf']);