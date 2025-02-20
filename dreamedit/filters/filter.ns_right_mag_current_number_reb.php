<?
global $_CONFIG, $page_content;

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



?>
<table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th scope="col"><?php if($_SESSION[lang]!="/en") echo "ÍÎÌÅÐ"; else echo "NUMBER";?></th>
            <th scope="col"><?php if($_SESSION[lang]!="/en") echo "ÑÒÀÒÈÑÒÈÊÀ"; else echo "STATISTIC";?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><a href="/files/File/magazines/REB_month/content/<?=$lastYear?>/<?=$lastNumber['pdf']?>" target="_blank"># <?=(int)$lastNumber['month']?>/<?=$lastYear?></a></td>
            <td><a href="/files/File/magazines/REB_month/statistics/<?=$lastYear?>/<?=$lastNumber['statistics']?>" target="_blank"><?php if($_SESSION[lang]!="/en") echo "Ñòàòèñòèêà"; else echo "Statistic";?> <?=(int)$lastNumber['month']?>/<?=$lastYear?></a></td>
        </tr>
        </tbody>
</table>