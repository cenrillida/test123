<?
global $_CONFIG, $site_templater, $DB;

?>
<style>
div#stats {
	text-align: center;
	padding: 100px;
	background-color: CCCCCC;
	margin: 0 300;
	/* vertical-align: middle; */
	display: block;
	border: 4px solid black;
	border-radius: 20px;
}
body {
	padding-top: 100px;
}
.rubrics_stats {
    text-align: center;
    padding: 20px 50px;
    background-color: CCCCCC;
    margin: 10px 15px;
    border: 4px solid black;
    border-radius: 20px;
}
</style>
<?php
$date = date("Y-m-d");
$specrubrics = $DB->select("SELECT l.el_id AS ARRAY_KEY, l.el_id AS id,l.icont_text AS rubric
                FROM adm_ilines_type AS c
               INNER JOIN adm_ilines_element AS e ON e.itype_id=c.itype_id AND e.itype_id=13 
               INNER JOIN adm_ilines_content AS l ON l.el_id=e.el_id AND l.icont_var= 'title'
               INNER JOIN adm_ilines_content AS s ON s.el_id=e.el_id AND s.icont_var= 'sort'
                 ORDER BY s.icont_text");

if(empty($_GET[specrub])) {
	$stats_today = $DB->select("SELECT SUM(views) AS 'views', SUM(hosts) AS 'hosts' FROM magazine_visits WHERE magazine LIKE 'specrub-%' AND date='".$date."'");
	$stats_all = $DB->select("SELECT SUM(views) AS 'views' FROM magazine_visits WHERE magazine LIKE 'specrub-%'");
}
else
{
	$stats_today = $DB->select("SELECT views, hosts FROM magazine_visits WHERE magazine='specrub-".(int)$_GET[specrub]."' AND date='".$date."'");
	$stats_all = $DB->select("SELECT SUM(views) AS 'views' FROM magazine_visits WHERE magazine='specrub-".(int)$_GET[specrub]."'");
}

echo '<div class="rubrics_stats">';
if(empty($_GET[specrub]))
	echo "<b>Все</b>";
else
	echo "<a href=\"/index.php?page_id=".(int)$_GET[page_id]."\">Все</a>";
foreach ($specrubrics as $key => $value) {
	if((int)$_GET[specrub]==$value[id])
		echo " | <b>".$value[rubric]."</b>";
	else
		echo " | <a href=\"/index.php?page_id=".(int)$_GET[page_id]."&specrub=".$value[id]."\">".$value[rubric]."</a>";
}
echo '</div>';
echo "<div id=stats>";
echo "<h1>Статистика:</h1><br>";
echo "<h2>Просмотров сегодня: ".$stats_today[0]['views']."</h2>";
echo "<h2>Уникальных посетителей сегодня: ".$stats_today[0]['hosts']."</h2>";
echo "<h2>Просмотров всего: ".$stats_all[0]['views']."</h2><img style='width: 50%;' src=/images/logo.png></div>";

?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <div id="chart_div"></div>

  <script type="text/javascript">
	google.charts.load('current', {packages: ['corechart'], 'language': 'ru'});
	google.charts.setOnLoadCallback(drawBasic);
	function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Просмотров');
      data.addColumn('number', 'Уникальных посетителей');

      data.addRows([
      	<?php 
      	if(empty($_GET[specrub])) {
      		$stats_chart = $DB->select("SELECT MONTH(date)-1 AS month, YEAR(date) AS year, DAY(date) AS day, SUM(hosts) AS hosts, SUM(views) AS views FROM magazine_visits WHERE magazine LIKE 'specrub-%' GROUP BY date ORDER BY date");
      	}
      	else
      	{
      		$stats_chart = $DB->select("SELECT MONTH(date)-1 AS month, YEAR(date) AS year, DAY(date) AS day, hosts, views FROM magazine_visits WHERE magazine='specrub-".(int)$_GET[specrub]."' ORDER BY date");
      	}
      	$first = true;
      	foreach ($stats_chart as $key => $value) {
      		if($first)
      			$first=false;
      		else
      			echo ',';
      		echo '[new Date(\''.$value['year'].'\',\''.$value['month'].'\',\''.$value['day'].'\'), '.$value['views'].', '.$value['hosts'].']';
      	}
      	?>
      ]);

      var options = {
      	height: 500,
        hAxis: {
          title: 'Дата'
        },
        vAxis: {
          title: 'Статистика',
          gridlines: {
	          count: 10,
	        }
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);

    }
  </script>