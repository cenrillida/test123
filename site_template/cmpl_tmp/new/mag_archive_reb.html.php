<?
//
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

global $DB,$_CONFIG, $site_templater;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

	$contentDir = '/home/imemon/html/files/File/magazines/REB_month/content';
	$statisticsDir = '/home/imemon/html/files/File/magazines/REB_month/statistics';
	$contentYearsScanned = scandir($contentDir);
	$contentYears = array();

	foreach ($contentYearsScanned as $year) {
		if($year!="." && $year!="..") {
			$contentPdfScanned = scandir($contentDir."/".$year);
			$contentYears[$year] = array();
			foreach ($contentPdfScanned as $pdf) {
				if($pdf!="." && $pdf!="..") {
					$month = substr($pdf,5,2);
					$contentYears[$year][$month]['pdf'] = $pdf;
				}
			}
		}
	}

	$statisticYearsScanned = scandir($statisticsDir);

	foreach ($statisticYearsScanned as $year) {
		if($year!="." && $year!="..") {
			$contentPdfScanned = scandir($statisticsDir."/".$year);
			foreach ($contentPdfScanned as $pdf) {
				if($pdf!="." && $pdf!="..") {
					$month = substr($pdf,5,2);
					if(!empty($contentYears[$year][$month])) {
						$contentYears[$year][$month]['statistics'] = $pdf;
					}
				}
			}
		}
	}

	krsort($contentYears);

	?>
<table class="table table-striped">
	<?php foreach ($contentYears as $year=>$monthArr): ksort($monthArr);?>
		<thead class="thead-light">
		<tr>
			<th scope="col"><?=$year?></th>
			<th scope="col"><?php if($_SESSION[lang]!="/en") echo "ÍÎÌÅÐ"; else echo "NUMBER";?></th>
			<th scope="col"><?php if($_SESSION[lang]!="/en") echo "ÑÒÀÒÈÑÒÈÊÀ"; else echo "STATISTIC";?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($monthArr as $month=>$pdfs):?>
		<tr>
			<th scope="row">&nbsp;</th>
			<td><a href="/files/File/magazines/REB_month/content/<?=$year?>/<?=$pdfs['pdf']?>" target="_blank"># <?=(int)$month?>/<?=$year?></a></td>
			<td><a href="/files/File/magazines/REB_month/statistics/<?=$year?>/<?=$pdfs['statistics']?>" target="_blank"><?php if($_SESSION[lang]!="/en") echo "Ñòàòèñòèêà"; else echo "Statistic";?> <?=(int)$month?>/<?=$year?></a></td>
		</tr>
		<?php endforeach;?>
		</tbody>
	<?php endforeach;?>
</table>
<?php

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");


?>
