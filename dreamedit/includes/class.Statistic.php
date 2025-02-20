<?php

class Statistic 
{
	//Учет статистики по уникальному наименованию некоторого объекта, за которым ведется наблюдение
	public static function theCounter($counterName) {
		global $DB;
        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $ipVisitsTimeCollection = $visitsDb->ip_visits_time;
        $ipVisitsCollection = $visitsDb->ip_visits;
        $visitsDailyCollection = $visitsDb->visits_daily;
        $visitsMonthCollection = $visitsDb->visits;

		$visitor_ip = $_SERVER['REMOTE_ADDR'];
		$date = date("Y-m-d");
		$datet = date("Y-m-d H:i:s");
        // Create a PHP DateTime object for the current time
        $currentTime = new DateTime();
        // Convert the PHP DateTime object to BSON UTCDateTime
        $utcDateTime = new MongoDate($currentTime->getTimestamp());

        $ipVisitsTimeCollection->insert(array("address" => $visitor_ip, "magazine" => $counterName, "datet" => $datet, "datetime" => $utcDateTime));

        $res = $visitsDailyCollection->count(array('date' => $date, 'magazine' => $counterName));
		$deleted = false;
		$inserted = false;
		if ($res == 0)
		{
            $ipVisitsCollection->remove(array('magazine' => $counterName));
            $ipVisitsCollection->insert(array('address' => $visitor_ip, 'magazine' => $counterName));
            $deleted = true;
            $visitsDailyCollection->insert(array('date' => $date, 'hosts' => 1, 'views' => 1, 'magazine' => $counterName));
        }
		else
		{
            $current = $ipVisitsCollection->count(array('address' => $visitor_ip, 'magazine' => $counterName));
            if($current >= 1) {
                $visitsDailyCollection->update(array('date' => $date, 'magazine' => $counterName), array('$inc' => array('views' => 1)));
            } else {
                $ipVisitsCollection->insert(array('address' => $visitor_ip, 'magazine' => $counterName));
                $inserted = true;
                $visitsDailyCollection->update(array('date' => $date, 'magazine' => $counterName), array('$inc' => array('views' => 1, 'hosts' => 1)));
            }
		}

		$year = date("Y");
		$month = date("m");

        $res = $visitsMonthCollection->count(array("year" => $year, "month" => $month, "magazine" => $counterName));

        if($res == 0) {
            if(!$deleted) {
                $ipVisitsCollection->remove(array('magazine' => $counterName));
                $ipVisitsCollection->insert(array('address' => $visitor_ip, 'magazine' => $counterName));
                $deleted = true;
            }

            $visitsMonthCollection->insert(array("year" => $year, "month" => $month, "magazine" => $counterName, "hosts" => 1, "views" => 1));
        } else {
            $current = $ipVisitsCollection->count(array('address' => $visitor_ip, 'magazine' => $counterName));
            $resArr = $visitsMonthCollection->findOne(array("year" => $year, "month" => $month, "magazine" => $counterName));

            if(!empty($resArr)) {
                if ($current >= 1) {
                    if ($inserted) {
                        $visitsMonthCollection->update(array("_id" => $resArr['_id']),array("year" => $year, "month" => $month, "magazine" => $counterName, "hosts" => (int)$resArr['hosts']+1, "views" => (int)$resArr['views']+1));
                    } else {
                        $visitsMonthCollection->update(array("_id" => $resArr['_id']),array("year" => $year, "month" => $month, "magazine" => $counterName, "hosts" => (int)$resArr['hosts'], "views" => (int)$resArr['views']+1));
                    }
                } else {
                    $ipVisitsCollection->insert(array('address' => $visitor_ip, 'magazine' => $counterName));
                    $visitsMonthCollection->update(array("_id" => $resArr['_id']),array("year" => $year, "month" => $month, "magazine" => $counterName, "hosts" => (int)$resArr['hosts']+1, "views" => (int)$resArr['views']+1));
                }
            }
        }
	}

    public static function getPagesList() {
        global $DB;
        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $visitsDailyCollection = $visitsDb->visits_daily;

        $regex = '/^pageid-(\d+).*$/';
        $match = array();
        $match['magazine'] = new MongoRegex($regex);

        $pagesStat = $visitsDailyCollection->aggregate(array(
            array(
                '$match' => $match,
            ),
            array(
                '$group' => array(
                    '_id' => '$magazine',
                    'sumviews' => array('$sum' => '$views'),
                ),
            ),
            array(
                '$project' => array(
                    '_id' => 0,
                    'magazine' => '$_id',
                    'sumviews' => 1,
                ),
            ),
        ));

        foreach ($pagesStat['result'] as $key=>$value) {
            preg_match($regex, $value['magazine'], $matches);
            $pagesStat['result'][$key]['page_id'] = intval($matches[1]);
        }

        $ids = array_map(function ($el) { return (int)$el['page_id'];}, $pagesStat['result']);
        $idsImploded = implode(',', $ids);
        if(empty($idsImploded)) $idsImploded = '-1';

        $pages = $DB->select("SELECT ap.page_id AS page_id, ap.page_name AS page_name FROM adm_pages AS ap
							WHERE ap.page_id IN ({$idsImploded})
							GROUP BY ap.page_id 
							ORDER BY ap.page_name,ap.page_id"
        );

        return $pages;
    }

	public static function getStatMain() {
	    global $DB;
        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $ipVisitsTimeCollection = $visitsDb->ip_visits_time;
        $ipVisitsCollection = $visitsDb->ip_visits;

        $currentTime = new MongoDate(strtotime('-5 minutes'));

        $visitorsLive = $ipVisitsTimeCollection->aggregate(array(
            array('$match' => array(
                'datetime' => array('$gt' => $currentTime),
                '$or' => array(
                    array('magazine' => 'all-web-site'),
                    array('magazine' => 'all-web-site-en')
                )
            )),
            array(
                '$group' => array(
                    '_id' => '$address',
                    'visitors' => array('$first' => '$address')
                )
            ),
            array('$sort' => array('datet' => -1))
        ));

        $visitsAllGroup = $ipVisitsCollection->distinct('address', array(
            '$or' => array(
                array('magazine' => 'all-web-site'),
                array('magazine' => 'all-web-site-en')
            )
        ));

        return array("visitors_live" => count($visitorsLive['result']),"visitors_count" => count($visitsAllGroup));
    }

	public static function theStatMain($newsite = false) {
	    global $DB;
	    $visitors = self::getStatMain();
        $text_today = 'Посетителей сегодня';
        $text_live = 'На сайте';
        if($_SESSION[lang]=="/en") {
            $text_today = 'Visitors today';
            $text_live = 'Now';
        }
        echo "<h3>".$text_today."</h3><h2 class=\"text-danger font-weight-bold\" id=\"main-visitors-all\">".$visitors['visitors_count']."</h2><p>".$text_live.": <span id=\"main-visitors-live\">".$visitors['visitors_live']."</span></p>";
        ?>
        <script>
            jQuery( document ).ready(function() {
                jQuery.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/index.php?page_id=1555&ajax_get_views_mode=all<?php if ($_SESSION["lang"] == "/en") echo "&ajax_stat_lang=en";?>',
                    success: function (data) {
                        setCounter(data.visitors_live,'main-visitors-live');
                        setCounter(data.visitors_count,'main-visitors-all');
                    }
                })
            });
        </script>
        <?php
	}

	public static function getStatJour($url = "") {
	    if($url == "") {
	        if(!empty($_SESSION["jour_url"])) {
                $url = $_SESSION["jour_url"];
            }
            if(!empty($_TPL_REPLACMENT["JOUR_COUNTER"])) {
                $url = $_TPL_REPLACMENT["JOUR_COUNTER"];
            }
        }
        global $DB;
        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $visitsDailyCollection = $visitsDb->visits_daily;

        $date = date("Y-m-d");
        $statsToday = $visitsDailyCollection->findOne(array(
            "magazine" => $url,
            "date" => $date
        ));
        if(empty($statsToday)) {
            $statsToday = array();
            $statsToday['views'] = 0;
            $statsToday['hosts'] = 0;
        }

        $statsAll = $visitsDailyCollection->aggregate(array(
            array(
                '$match' => array('magazine' => $url)
            ),
            array(
                '$group' => array(
                    '_id' => null,
                    'views' => array('$sum' => '$views')
                )
            )
        ));

        if(empty($statsAll['result'])) {
            $statsAll['result'] = array(
                    0 => array(
                            'views' => 0
                    )
            );
        }

        return array("today_views" => $statsToday['views'],"today_hosts" => $statsToday['hosts'], "all_views" => $statsAll['result'][0]['views']);
    }

	public static function theStatJour($url = "") {
        $stat = self::getStatJour($url);
        echo '<div class="text-center">';
        if($_SESSION["lang"]!='/en')
        {
            echo "Просмотров сегодня: <span id='today-views-stat'>".$stat['today_views']."</span><br>";
            echo "Уникальных посетителей сегодня: <span id='today-hosts-stat'>".$stat['today_hosts']."</span><br>";
            echo "Просмотров всего: <span id='all-views-stat'>".$stat['all_views']."</span><br>";
        }
        else
        {
            echo "Views today: <span id='today-views-stat'>".$stat['today_views']."</span><br>";
            echo "Unique users today: <span id='today-hosts-stat'>".$stat['today_hosts']."</span><br>";
            echo "Total views: <span id='all-views-stat'>".$stat['all_views']."</span><br>";
        }
        echo "</div>";
        if($url=="") {
            $statId = $_SESSION["jour_url"];
        } else {
            $statId = $url;
        }
        ?>
        <script>
            jQuery( document ).ready(function() {
                jQuery.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/index.php?page_id=1555&ajax_get_views_mode=jour&ajax_stat_id=<?=$statId?><?php if ($_SESSION["lang"] == "/en") echo "&ajax_stat_lang=en";?>',
                    success: function (data) {
                        setCounter(data.today_views,'today-views-stat');
                        setCounter(data.today_hosts,'today-hosts-stat');
                        setCounter(data.all_views,'all-views-stat');
                    }
                })
            });
        </script>
        <?php
    }

	public static function getAllViews($counterName) {
	    global $DB;
        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $visitsDailyCollection = $visitsDb->visits_daily;
        $statsAll = $visitsDailyCollection->aggregate(array(
            array(
                '$match' => array('magazine' => $counterName)
            ),
            array(
                '$group' => array(
                    '_id' => null,
                    'views' => array('$sum' => '$views')
                )
            )
        ));

        if(empty($statsAll['result'])) {
            $statsAll['result'] = array(
                0 => array(
                    'views' => 0
                )
            );
        }

        return $statsAll['result'][0]['views'];
    }

    public static function getStat($counterName) {
        global $DB;
        $date = date("Y-m-d");
        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $ipVisitsTimeCollection = $visitsDb->ip_visits_time;
        $ipVisitsCollection = $visitsDb->ip_visits;
        $visitsDailyCollection = $visitsDb->visits_daily;
        $visitsMonthCollection = $visitsDb->visits;

        if(!empty($_GET["date_from"])) {
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_GET["date_from"])) {
                $date_from = $_GET["date_from"];
            } else {
                $date_from = ((int)date("Y")-1)."-".date("m-d");
            }
        }
        else {
            $date_from = ((int)date("Y")-1)."-".date("m-d");
        }
        if(!empty($_GET["date_to"])) {
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_GET["date_to"])) {
                $date_to = $_GET["date_to"];
            } else {
                $date_to = ((int)date("Y")-1)."-".date("m-d");
            }
        }
        else {
            $date_to = $date;
        }

        $data = array(
            'today' => array(0 => array()),
            'today_group' => array(0 => array()),
            'all' => array(0 => array()),
            'chart' => array(),
            'interval' => array(0 => array()),
        );

        if(empty($_GET["lang"])) {
            $statsToday = $visitsDailyCollection->aggregate(array(
                array('$match' => array(
                    'date' => $date,
                    '$or' => array(
                        array('magazine' => $counterName),
                        array('magazine' => $counterName.'-en')
                    )
                )),
                array(
                    '$group' => array(
                        '_id' => null,
                        'views' => array('$sum' => '$views'),
                        'hosts' => array('$sum' => '$hosts' )
                    )
                )
            ));
            if(empty($statsToday['result'])) {
                $statsToday['result'] = array(
                    0 => array(
                        'views' => 0,
                        'hosts' => 0
                    )
                );
            }
            $data['today'][0]['views'] = $statsToday['result'][0]['views'];
            $data['today'][0]['hosts'] = $statsToday['result'][0]['hosts'];

            $statsTodayGroup = $ipVisitsCollection->distinct('address', array(
                '$or' => array(
                    array('magazine' => $counterName),
                    array('magazine' => $counterName.'-en')
                )
            ));
            $data['today_group'][0]['cnt'] = count($statsTodayGroup);

            $statsAll = $visitsDailyCollection->aggregate(array(
                array('$match' => array(
                    '$or' => array(
                        array('magazine' => $counterName),
                        array('magazine' => $counterName.'-en')
                    )
                )),
                array(
                    '$group' => array(
                        '_id' => null,
                        'views' => array('$sum' => '$views')
                    )
                )
            ));
            if(empty($statsAll['result'])) {
                $statsAll['result'] = array(
                    0 => array(
                        'views' => 0
                    )
                );
            }
            $data['all'][0]['views'] = $statsAll['result'][0]['views'];

            $statsChart = $visitsDailyCollection->aggregate(array(
                array(
                    '$match' => array(
                        '$or' => array(
                            array('magazine' => $counterName),
                            array('magazine' => $counterName.'-en')
                        ),
                    ),
                ),
                array(
                    '$group' => array(
                        '_id' => array('date' => '$date'),
                        'views' => array('$sum' => '$views'),
                        'hosts' => array('$sum' => '$hosts'),
                    ),
                ),
                array(
                    '$project' => array(
                        '_id' => 0,
                        'date' => '$_id.date',
                        'views' => 1,
                        'hosts' => 1,
                    ),
                ),
                array(
                    '$sort' => array('date' => 1),
                )
            ));
            foreach ($statsChart['result'] as $value) {
                $dateComponents = date_parse_from_format('Y-m-d', $value['date']);
                $data['chart'][] = array(
                    'year' => $dateComponents['year'],
                    'month' => (int)$dateComponents['month'] - 1,
                    'day' => (int)$dateComponents['day'],
                    'views' => $value['views'],
                    'hosts' => $value['hosts']
                );
            }

            $statsInterval = $visitsDailyCollection->aggregate(array(
                array(
                    '$match' => array(
                        '$or' => array(
                            array('magazine' => $counterName),
                            array('magazine' => $counterName.'-en')
                        ),
                        'date' => array('$gte' => $date_from, '$lte' => $date_to),
                    ),
                ),
                array(
                    '$group' => array(
                        '_id' => null,
                        'views' => array('$sum' => '$views'),
                        'hosts' => array('$sum' => '$hosts'),
                    ),
                ),
                array(
                    '$project' => array(
                        '_id' => 0,
                        'views' => 1,
                        'hosts' => 1,
                    ),
                )
            ));
            if(empty($statsInterval['result'])) {
                $statsInterval['result'] = array(
                    0 => array(
                        'views' => 0,
                        'hosts' => 0
                    )
                );
            }
            $data['interval'][0]['views'] = $statsInterval['result'][0]['views'];
            $data['interval'][0]['hosts'] = $statsInterval['result'][0]['hosts'];
        } else {
            if($_GET["lang"]=="en")
                $eng_stat = "-en";
            if($_GET["lang"]=="ru")
                $eng_stat = "";

            $statsToday = $visitsDailyCollection->aggregate(array(
                array('$match' => array(
                    'date' => $date,
                    'magazine' => $counterName.$eng_stat
                ))
            ));
            if(empty($statsToday['result'])) {
                $statsToday['result'] = array(
                    0 => array(
                        'views' => 0,
                        'hosts' => 0
                    )
                );
            }
            $data['today'][0]['views'] = $statsToday['result'][0]['views'];
            $data['today'][0]['hosts'] = $statsToday['result'][0]['hosts'];

            $statsTodayGroup = $ipVisitsCollection->distinct('address', array(
                'magazine' => $counterName.$eng_stat
            ));
            $data['today_group'][0]['cnt'] = count($statsTodayGroup);

            $statsAll = $visitsDailyCollection->aggregate(array(
                array('$match' => array(
                    'magazine' => $counterName.$eng_stat
                )),
                array(
                    '$group' => array(
                        '_id' => null,
                        'views' => array('$sum' => '$views')
                    )
                )
            ));
            if(empty($statsAll['result'])) {
                $statsAll['result'] = array(
                    0 => array(
                        'views' => 0
                    )
                );
            }
            $data['all'][0]['views'] = $statsAll['result'][0]['views'];

            $statsChart = $visitsDailyCollection->aggregate(array(
                array(
                    '$match' => array(
                        'magazine' => $counterName.$eng_stat
                    ),
                ),
                array(
                    '$sort' => array('date' => 1),
                )
            ));
            foreach ($statsChart['result'] as $value) {
                $dateComponents = date_parse_from_format('Y-m-d', $value['date']);
                $data['chart'][] = array(
                    'year' => $dateComponents['year'],
                    'month' => (int)$dateComponents['month'] - 1,
                    'day' => (int)$dateComponents['day'],
                    'views' => $value['views'],
                    'hosts' => $value['hosts']
                );
            }

            $statsInterval = $visitsDailyCollection->aggregate(array(
                array(
                    '$match' => array(
                        'magazine' => $counterName.$eng_stat,
                        'date' => array('$gte' => $date_from, '$lte' => $date_to),
                    ),
                ),
                array(
                    '$group' => array(
                        '_id' => null,
                        'views' => array('$sum' => '$views'),
                        'hosts' => array('$sum' => '$hosts'),
                    ),
                ),
                array(
                    '$project' => array(
                        '_id' => 0,
                        'views' => 1,
                        'hosts' => 1,
                    ),
                )
            ));
            if(empty($statsInterval['result'])) {
                $statsInterval['result'] = array(
                    0 => array(
                        'views' => 0,
                        'hosts' => 0
                    )
                );
            }
            $data['interval'][0]['views'] = $statsInterval['result'][0]['views'];
            $data['interval'][0]['hosts'] = $statsInterval['result'][0]['hosts'];
        }

        return array(
            'dates' => array(
                'date_from' => $date_from,
                'date_to' => $date_to
            ),
            'data' => $data
        );
    }

	//вывод статистики
	public static function theStat($counterName,$page,$height=500,$vColumns=10) {
		global $DB;
        $statData = self::getStat($counterName);
        $date_from = $statData['dates']['date_from'];
        $date_to = $statData['dates']['date_to'];
        $stats_today = $statData['data']['today'];
        $stats_today_group = $statData['data']['today_group'];
        $stats_chart = $statData['data']['chart'];
        $stats_all = $statData['data']['all'];
        $stats_interval = $statData['data']['interval'];

		echo "<div id=stats>";
		echo "<p><a href=\"/index.php?page_id=".(int)$_GET["page_id"]."\">К списку страниц</a></p>";
		if(!empty($page[0]['page_id']))
			echo "<p><a href=\"/index.php?page_id=".$page[0]['page_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        if(!empty($page[0]['newsfull_id']))
            echo "<p><a href=\"/index.php?page_id=502&id=".$page[0]['newsfull_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        if(!empty($page[0]['cerspecrub_id']))
            echo "<p><a href=\"/index.php?page_id=1557&id=".$page[0]['cerspecrub_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
		echo "<h1>".$page[0]['page_name']."</h1>";
        if($_GET["lang"]=='en')
            echo "<h2 style='color: red'>Английская</h2>";
        if($_GET["lang"]=='ru')
            echo "<h2 style='color: red'>Русская</h2>";
		$param_get = "";
        foreach ($_GET as $param=>$value) {
            if($param!='td1' && $param!='td2' && $param!='lang' && $param!='page_id')
                $param_get .= "&".$param."=".$value;
        }
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET["page_id"].$param_get."\">Общая статистика</a></p>";
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET["page_id"].$param_get."&lang=en\">Статистика английской версии</a></p>";
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET["page_id"].$param_get."&lang=ru\">Статистика русской версии</a></p>";
        echo "<form method='get'>";
        foreach ($_GET as $param=>$value) {
            if($param!='td1' && $param!='td2' && $param!='date_from' && $param!='date_to')
                echo "<input type='hidden' name='$param' value='$value'/>";
        }

        echo "<input type='date' name='date_from' value='".$date_from."'/><input type='date' name='date_to' value='".$date_to."'/><input type='submit' value='Перейти'/></form>";
        echo "<h2>Просмотров за ".date("d.m.Y", strtotime($date_from))."-".date("d.m.Y", strtotime($date_to)). ": " . $stats_interval[0]['views'] . "</h2>";
        echo "<hr>";
		echo "<h2>Просмотров сегодня: ".$stats_today[0]['views']."</h2>";
//		echo "<h2>Уникальных посетителей сегодня: ".$stats_today[0]['hosts']."</h2>";
		if($stats_today[0]['hosts']==0) {
            $stats_today_group[0]['cnt']=0;
        }
        echo "<h2>Уникальных посетителей сегодня (Без дубля): ".$stats_today_group[0]['cnt']."</h2>";
		echo "<h2>Просмотров всего: ".$stats_all[0]['views']."</h2><img style='width: 50%;' src=/images/logo.png></div>";
		?>

	  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	  <div id="chart_div"></div>
	  <div id="chart_div2" style="margin-right: 15px;"></div>

	  <script type="text/javascript">
		google.charts.load('current', {packages: ['corechart', 'annotationchart'], 'language': 'ru'});
		//google.charts.load('current', {packages: ['annotationchart'], 'language': 'ru'});
		google.charts.setOnLoadCallback(drawBasic);
		function drawBasic() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('date', 'X');
	      data.addColumn('number', 'Просмотров');
	      data.addColumn('number', 'Уникальных посетителей');

	      data.addRows([
	      	<?php
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
	      	height: <?=$height?>,
	        hAxis: {
	          title: 'Дата'
	        },
	        vAxis: {
	          title: 'Статистика',
	          gridlines: {
		          count: <?=$vColumns?>,
		        }
	        },
	        explorer: { axis: 'horizontal' }
	      };

	      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	      //var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div'));

	      chart.draw(data, options);

	    }
	  </script>

	  	  <script type="text/javascript">
		//google.charts.load('current', {packages: ['corechart'], 'language': 'ru'});
		google.charts.load('current', {packages: ['annotationchart'], 'language': 'ru'});
		google.charts.setOnLoadCallback(drawBasic);
		function drawBasic() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('date', 'X');
	      data.addColumn('number', 'Просмотров');
	      data.addColumn('number', 'Уникальных посетителей');

	      data.addRows([
	      	<?php
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
	      	height: <?=$height?>,
	        hAxis: {
	          title: 'Дата'
	        },
	        vAxis: {
	          title: 'Статистика',
	          gridlines: {
		          count: <?=$vColumns?>,
		        }
	        }
	      };

	      //var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	      var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div2'));

	      chart.draw(data, options);

	    }
	  </script>


		<?php
	}

    //вывод статистики
    public static function theStatAdmin($counterName,$page,$height=500,$vColumns=10) {
        global $DB;

//
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        $statData = self::getStat($counterName);
        $date_from = $statData['dates']['date_from'];
        $date_to = $statData['dates']['date_to'];
        $stats_today = $statData['data']['today'];
        $stats_today_group = $statData['data']['today_group'];
        $stats_chart = $statData['data']['chart'];
        $stats_all = $statData['data']['all'];
        $stats_interval = $statData['data']['interval'];

        echo "<div id=stats>";
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic\">К списку страниц</a></p>";
        if(!empty($page[0]['page_id']))
            echo "<p><a href=\"/index.php?page_id=".$page[0]['page_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        if(!empty($page[0]['newsfull_id']))
            echo "<p><a href=\"/index.php?page_id=502&id=".$page[0]['newsfull_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        if(!empty($page[0]['cerspecrub_id']))
            echo "<p><a href=\"/index.php?page_id=1557&id=".$page[0]['cerspecrub_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        echo "<h1>".$page[0]['page_name']."</h1>";
        if($_GET["lang"]=='en')
            echo "<h3 style='color: red'>Английская</h3>";
        if($_GET["lang"]=='ru')
            echo "<h3 style='color: red'>Русская</h3>";
        $param_get = "";
        foreach ($_GET as $param=>$value) {
            if($param!='td1' && $param!='td2' && $param!='lang' && $param!='mod')
                $param_get .= "&".$param."=".$value;
        }
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic".$param_get."\">Общая статистика</a></p>";
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic".$param_get."&lang=en\">Статистика английской версии</a></p>";
        echo "<p><a href=\"/dreamedit/index.php?mod=statistic".$param_get."&lang=ru\">Статистика русской версии</a></p>";
        echo "<form method='get'>";
        foreach ($_GET as $param=>$value) {
            if($param!='td1' && $param!='td2' && $param!='date_from' && $param!='date_to')
                echo "<input type='hidden' name='$param' value='$value'/>";
        }

        echo "<input type='date' name='date_from' value='".$date_from."'/><input type='date' name='date_to' value='".$date_to."'/><input type='submit' value='Перейти'/></form>";
        echo "<h3 style='margin: 10px 0; color: black'>Просмотров за ".date("d.m.Y", strtotime($date_from))."-".date("d.m.Y", strtotime($date_to)). ": " . $stats_interval[0]['views'] . "</h3>";
        echo "<h3 style='margin: 10px 0; color: black'>Сумма уникальных посетителей за ".date("d.m.Y", strtotime($date_from))."-".date("d.m.Y", strtotime($date_to)). ": " . $stats_interval[0]['hosts'] . "</h3>";
        echo "<hr>";
        echo "<h3 style='color: black'>Просмотров сегодня: ".$stats_today[0]['views']."</h3>";
//		echo "<h2>Уникальных посетителей сегодня: ".$stats_today[0]['hosts']."</h2>";
        if($stats_today[0]['hosts']==0) {
            $stats_today_group[0]['cnt']=0;
        }
        echo "<h3 style='color: black'>Уникальных посетителей сегодня (Без дубля): ".$stats_today_group[0]['cnt']."</h3>";
        echo "<h3 style='color: black'>Просмотров всего: ".$stats_all[0]['views']."</h3></div>";
        ?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div id="chart_div"></div>
        <div id="chart_div2" style="margin-right: 15px;"></div>

        <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'annotationchart'], 'language': 'ru'});
            //google.charts.load('current', {packages: ['annotationchart'], 'language': 'ru'});
            google.charts.setOnLoadCallback(drawBasic);
            function drawBasic() {

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'X');
                data.addColumn('number', 'Просмотров');
                data.addColumn('number', 'Уникальных посетителей');

                data.addRows([
                    <?php
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
                    height: <?=$height?>,
                    hAxis: {
                        title: 'Дата'
                    },
                    vAxis: {
                        title: 'Статистика',
                        gridlines: {
                            count: <?=$vColumns?>,
                        }
                    },
                    explorer: { axis: 'horizontal' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                //var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div'));

                chart.draw(data, options);

            }
        </script>

        <script type="text/javascript">
            //google.charts.load('current', {packages: ['corechart'], 'language': 'ru'});
            google.charts.load('current', {packages: ['annotationchart'], 'language': 'ru'});
            google.charts.setOnLoadCallback(drawBasic);
            function drawBasic() {

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'X');
                data.addColumn('number', 'Просмотров');
                data.addColumn('number', 'Уникальных посетителей');

                data.addRows([
                    <?php
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
                    height: <?=$height?>,
                    hAxis: {
                        title: 'Дата'
                    },
                    vAxis: {
                        title: 'Статистика',
                        gridlines: {
                            count: <?=$vColumns?>,
                        }
                    }
                };

                //var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div2'));

                chart.draw(data, options);

            }
        </script>


        <?php
    }

    //вывод статистики
    public static function theStatNew($counterName,$page,$height=500,$vColumns=10) {
        $statData = self::getStat($counterName);
        $date_from = $statData['dates']['date_from'];
        $date_to = $statData['dates']['date_to'];
        $stats_today = $statData['data']['today'];
        $stats_today_group = $statData['data']['today_group'];
        $stats_chart = $statData['data']['chart'];
        $stats_all = $statData['data']['all'];
        $stats_interval = $statData['data']['interval'];

        echo "<div id=stats class='text-center'>";
        echo "<h2>".$page[0]['page_name']."</h2>";
        if(!empty($page[0]['page_id']))
            echo "<p><a href=\"/index.php?page_id=".$page[0]['page_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        if(!empty($page[0]['newsfull_id']))
            echo "<p><a href=\"/index.php?page_id=502&id=".$page[0]['newsfull_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        if(!empty($page[0]['cerspecrub_id']))
            echo "<p><a href=\"/index.php?page_id=1557&id=".$page[0]['cerspecrub_id']."\" target=\"_blank\">Ссылка на страницу(в новой вкладке)</a></p>";
        if($_GET["lang"]=='en')
            echo "<h4 style='color: red'>Английская</h4>";
        if($_GET["lang"]=='ru')
            echo "<h4 style='color: red'>Русская</h4>";
        $param_get = "";
        foreach ($_GET as $param=>$value) {
            if($param!='td1' && $param!='td2' && $param!='lang' && $param!='page_id')
                $param_get .= "&".$param."=".$value;
        }
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET["page_id"].$param_get."\">Общая статистика</a></p>";
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET["page_id"].$param_get."&lang=en\">Статистика английской версии</a></p>";
        echo "<p><a href=\"/index.php?page_id=".(int)$_GET["page_id"].$param_get."&lang=ru\">Статистика русской версии</a></p>";
        echo "<form method='get'>";
        foreach ($_GET as $param=>$value) {
            if($param!='td1' && $param!='td2' && $param!='date_from' && $param!='date_to')
                echo "<input type='hidden' name='$param' value='$value'/>";
        }
        echo "<hr>";
        echo "<input type='date' name='date_from' value='".$date_from."'/><input type='date' name='date_to' value='".$date_to."'/><input type='submit' value='Перейти'/></form>";
        echo "<h5 class='mt-3'>Просмотров за ".date("d.m.Y", strtotime($date_from))."-".date("d.m.Y", strtotime($date_to)). ": " . $stats_interval[0]['views'] . "</h5>";
        echo "<hr>";
        echo "<h5>Просмотров сегодня: ".$stats_today[0]['views']."</h5>";
//		echo "<h2>Уникальных посетителей сегодня: ".$stats_today[0]['hosts']."</h2>";
        if($stats_today[0]['hosts']==0) {
            $stats_today_group[0]['cnt']=0;
        }
        echo "<h5>Уникальных посетителей сегодня: ".$stats_today_group[0]['cnt']."</h5>";
        echo "<h5>Просмотров всего: ".$stats_all[0]['views']."</h5></div>";
        ?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div id="chart_div"></div>
        <div id="chart_div2" class="container-fluid" style="margin-right: 15px;"></div>

        <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'annotationchart'], 'language': 'ru'});
            //google.charts.load('current', {packages: ['annotationchart'], 'language': 'ru'});
            google.charts.setOnLoadCallback(drawBasic);
            function drawBasic() {

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'X');
                data.addColumn('number', 'Просмотров');
                data.addColumn('number', 'Уникальных посетителей');

                data.addRows([
                    <?php
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
                    height: <?=$height?>,
                    hAxis: {
                        title: 'Дата'
                    },
                    vAxis: {
                        title: 'Статистика',
                        gridlines: {
                            count: <?=$vColumns?>,
                        }
                    },
                    explorer: { axis: 'horizontal' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                //var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div'));

                chart.draw(data, options);

            }
        </script>

        <script type="text/javascript">
            //google.charts.load('current', {packages: ['corechart'], 'language': 'ru'});
            google.charts.load('current', {packages: ['annotationchart'], 'language': 'ru'});
            google.charts.setOnLoadCallback(drawBasic);
            function drawBasic() {

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'X');
                data.addColumn('number', 'Просмотров');
                data.addColumn('number', 'Уникальных посетителей');

                data.addRows([
                    <?php
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
                    height: <?=$height?>,
                    hAxis: {
                        title: 'Дата'
                    },
                    vAxis: {
                        title: 'Статистика',
                        gridlines: {
                            count: <?=$vColumns?>,
                        }
                    }
                };

                //var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div2'));

                chart.draw(data, options);

            }
        </script>


        <?php
    }

	public static function getTopNews($interval,$lang="",$limit=5,$title=false) {

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
        global $DB;
        $m = new MongoClient();
        $visitsDb = $m->imemon;
        $visitsDailyCollection = $visitsDb->visits_daily;

        $match = array();

        if($lang=="-en") {
            $regex = '/^newsfull-(\d+)(.*-en$)/';
            $lang_postfix = "_en";
        } else {
            $regex = '/^newsfull-(\d+$)/';
            $lang_postfix = "";
        }
        $match['magazine'] = new MongoRegex($regex);
        if($interval!="") {
            $currentTime = date('Y-m-d', strtotime("- {$interval}days"));
            $match['date'] = array('$gte' => $currentTime);
        }

        $newsStat = $visitsDailyCollection->aggregate(array(
            array(
                '$match' => $match,
            ),
            array(
                '$group' => array(
                    '_id' => '$magazine',
                    'sumviews' => array('$sum' => '$views'),
                ),
            ),
            array(
                '$project' => array(
                    '_id' => 0,
                    'magazine' => '$_id',
                    'sumviews' => 1,
                ),
            ),
            array(
                '$sort' => array('sumviews' => -1),
            ),
            array(
                '$limit' => $limit,
            ),
        ));

        foreach ($newsStat['result'] as $key=>$value) {
            preg_match($regex, $value['magazine'], $matches);
            $newsStat['result'][$key]['news_id'] = intval($matches[1]);
        }

        $ids = array_map(function ($el) { return (int)$el['news_id'];}, $newsStat['result']);
        $idsImploded = implode(',', $ids);
        if(empty($idsImploded)) $idsImploded = '-1';

        $newsData = $DB->select("
            SELECT et.el_id AS ARRAY_KEY, et.el_id, et.itype_id AS type_id, t.icont_text AS title
            FROM adm_ilines_element AS et
            INNER JOIN adm_ilines_content AS t ON et.el_id=t.el_id AND t.icont_var='title".$lang_postfix."'
            WHERE et.el_id IN ({$idsImploded})
        ");
        foreach ($newsStat['result'] as $key=>$value) {
            if(!empty($newsData[$value['news_id']])) {
                $newsStat['result'][$key]['type_id'] = $newsData[$value['news_id']]['type_id'];
                $newsStat['result'][$key]['title'] = $newsData[$value['news_id']]['title'];
            }
        }

        return $newsStat['result'];
    }

    public static function saveTopNews($interval,$lang="") {
	    global $DB;
	    $news = self::getTopNews($interval,$lang);

        $counter=1;
        foreach ($news as $news_element) {
            $DB->query("INSERT INTO page_rating SET news_id = ?d, page_type = ?, interval_days = ?d, place = ?d", $news_element['news_id'], "newsfull".$lang, $interval, $counter);
            $counter++;
        }
    }

    public static function ajaxCounter($mode,$id = -1) {
	    ?>
        <script>
            jQuery( document ).ready(function() {
                jQuery.ajax({
                    type: 'GET',
                    url: '/index.php?page_id=1555&ajax_stat_mode=<?=$mode?><?php if($id != -1) echo "&ajax_stat_id=".$id;?><?php if ($_SESSION["lang"] == "/en") echo "&ajax_stat_lang=en";?>',
                    success: function (data) {
                        console.log('success stat');
                    }
                })
            });
        </script>
        <?php
    }

    public static function getAjaxViews($mode,$id = -1) {
        ?>
        <script>
            jQuery( document ).ready(function() {
                jQuery.ajax({
                    type: 'GET',
                    url: '/index.php?page_id=1555&ajax_get_views_mode=<?=$mode?><?php if($id != -1) echo "&ajax_stat_id=".$id;?><?php if ($_SESSION["lang"] == "/en") echo "&ajax_stat_lang=en";?>',
                    success: function (data) {
                        setCounter(data,'stat-views-counter');
                    }
                })
            });
        </script>
        <?php
    }

    public static function addOsStat() {
	    global $DB;
	    $currentOs = Dreamedit::getOS();
	    if(!empty($currentOs)) {
            $currentStat = $DB->selectRow("SELECT * FROM stat_os WHERE name=?",$currentOs);
            if(!empty($currentStat)) {
                $DB->query("UPDATE stat_os SET `count`=`count`+1 WHERE name=?",$currentOs);
            } else {
                $DB->query("INSERT INTO stat_os(`name`,`count`) VALUES (?,1)",$currentOs);
            }
            if($currentOs=="Unknown") {
                self::addUnknownAgent();
            }
        }
    }

    public static function addBrowserStat() {
        global $DB;
        $currentBrowser = Dreamedit::getBrowser();
        if(!empty($currentBrowser)) {
            if(!empty($currentBrowser['name']) && !empty($currentBrowser['version'])) {
                $currentStat = $DB->selectRow("SELECT * FROM stat_browser WHERE fullname=?", $currentBrowser['name']." ".$currentBrowser['version']);
                if (!empty($currentStat)) {
                    $DB->query("UPDATE stat_browser SET `count`=`count`+1 WHERE fullname=?", $currentBrowser['name']." ".$currentBrowser['version']);
                } else {
                    $DB->query("INSERT INTO stat_browser(`fullname`,`name`,`version`,`count`) VALUES (?,?,?,1)", $currentBrowser['name']." ".$currentBrowser['version'], $currentBrowser['name'], $currentBrowser['version']);
                }
            } elseif(!empty($currentBrowser['name'])) {
                $currentStat = $DB->selectRow("SELECT * FROM stat_browser WHERE fullname=?", $currentBrowser['name']);
                if (!empty($currentStat)) {
                    $DB->query("UPDATE stat_browser SET `count`=`count`+1 WHERE fullname=?", $currentBrowser['name']);
                } else {
                    $DB->query("INSERT INTO stat_browser(`fullname`,`name`,`version`,`count`) VALUES (?,?,?,1)", $currentBrowser['name'], $currentBrowser['name'], "");
                }
            }
            if($currentBrowser['name']=="Unknown") {
                self::addUnknownAgent();
            }
        }
    }

    public static function addUnknownAgent() {
        global $DB;
        if(!empty($_SERVER['HTTP_USER_AGENT'])) {
            $currentStat = $DB->selectRow("SELECT * FROM stat_unknows_agents WHERE name=?", $_SERVER['HTTP_USER_AGENT']);
            if (empty($currentStat)) {
                $DB->query("INSERT INTO stat_unknows_agents(`name`) VALUES (?)", $_SERVER['HTTP_USER_AGENT']);
            }
        }
    }

    public static function addOsAgent() {
        global $DB;
        $currentOs = Dreamedit::getOS();
        if(!empty($currentOs) && !empty($_SERVER['HTTP_USER_AGENT'])) {
            $currentStat = $DB->selectRow("SELECT * FROM stat_os_agents WHERE name=? AND os=?", $_SERVER['HTTP_USER_AGENT'], $currentOs);
            if (empty($currentStat)) {
                $DB->query("INSERT INTO stat_os_agents(`name`,`os`) VALUES (?,?)", $_SERVER['HTTP_USER_AGENT'],$currentOs);
            }
        }
    }

    public static function thePieOs($id, $group = false) {
	    global $DB;
	    $statsDb = $DB->select("SELECT * FROM stat_os");
	    $stats = array();
	    if($group) {
            foreach ($statsDb as $stat) {
                if(substr($stat['name'],0,7)=="Windows") {
                    if(empty($stats['Windows'])) {
                        $stats['Windows']=array('name'=>'Windows','count'=>0);
                    }
                    $stats['Windows']['count']+=$stat['count'];
                }
                elseif(substr($stat['name'],0,6)=="Mac OS") {
                    if(empty($stats['Mac OS'])) {
                        $stats['Mac OS']=array('name'=>'Mac OS','count'=>0);
                    }
                    $stats['Mac OS']['count']+=$stat['count'];
                }
                else {
                    $stats[$stat['name']] = array('name'=>$stat['name'],'count'=>$stat['count']);
                }
            }
        } else {
	        $stats = $statsDb;
        }
	    ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Операционные системы', 'Количество'],
                    <?php foreach ($stats as $stat):?>
                    ['<?=$stat['name']?>', <?=$stat['count']?>],
                    <?php endforeach;?>
                ]);

                var options = {
                    title: 'Операционные системы'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart<?=$id?>'));

                chart.draw(data, options);
            }
        </script>
        <div id="piechart<?=$id?>" style="width: 100%; height: 500px;"></div>
        <?php
    }

    public static function thePieDevice($id) {
        global $DB;
        $statsDb = $DB->select("SELECT * FROM stat_os");
        $stats = array("PC" => array('name'=>"ПК",'count'=>0), "Mobile" => array('name'=>'Мобильные','count'=>0));
        foreach ($statsDb as $stat) {
            if(substr($stat['name'],0,7)=="Windows") {
                $stats['PC']['count']+=$stat['count'];
            }
            elseif(substr($stat['name'],0,6)=="Mac OS") {
                $stats['PC']['count']+=$stat['count'];
            }
            elseif(substr($stat['name'],0,5)=="Linux") {
                $stats['PC']['count']+=$stat['count'];
            }
            elseif(substr($stat['name'],0,7)=="Android") {
                $stats['Mobile']['count']+=$stat['count'];
            }
            elseif(substr($stat['name'],0,6)=="iPhone") {
                $stats['Mobile']['count']+=$stat['count'];
            }
            elseif(substr($stat['name'],0,4)=="iPad") {
                $stats['Mobile']['count']+=$stat['count'];
            }
        }
        ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Устройства', 'Количество'],
                    <?php foreach ($stats as $stat):?>
                    ['<?=$stat['name']?>', <?=$stat['count']?>],
                    <?php endforeach;?>
                ]);

                var options = {
                    title: 'Устройства'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart<?=$id?>'));

                chart.draw(data, options);
            }
        </script>
        <div id="piechart<?=$id?>" style="width: 100%; height: 500px;"></div>
        <?php
    }

    public static function thePieBrowser($id) {
        global $DB;
        $statsDb = $DB->select("SELECT name, SUM(count) AS count FROM stat_browser GROUP BY name");
        $stats = $statsDb;
        ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Браузеры', 'Количество'],
                    <?php foreach ($stats as $stat):?>
                    ['<?=$stat['name']?>', <?=$stat['count']?>],
                    <?php endforeach;?>
                ]);

                var options = {
                    title: 'Браузеры'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart<?=$id?>'));

                chart.draw(data, options);
            }
        </script>
        <div id="piechart<?=$id?>" style="width: 100%; height: 500px;"></div>
        <?php
    }

    public static function getActivePagesCount() {
        global $DB;

        $pages_count = $DB->selectRow("
            SELECT COUNT(*) AS pages_count
            FROM adm_pages
            WHERE page_status=1
        ");

        return $pages_count['pages_count'];
    }

    public static function getActiveNewsCount() {
        global $DB;

        $pages_count = $DB->selectRow("
            SELECT COUNT(*) AS pages_count
            FROM adm_ilines_element AS ae
            INNER JOIN adm_ilines_content AS s ON ae.el_id=s.el_id AND s.icont_var='status' AND s.icont_text=1
            WHERE ae.itype_id=4 OR ae.itype_id=1 OR ae.itype_id=6 OR ae.itype_id=5 OR ae.itype_id=3
        ");

        return $pages_count['pages_count'];
    }

    public static function getActiveArticlesCount() {
        global $DB;

        $pages_count = $DB->selectRow("
            SELECT COUNT(*) AS pages_count
            FROM adm_article
            WHERE page_template='jarticle' AND page_status=1
        ");

        return $pages_count['pages_count'];
    }

    public static function getActivePublsCount() {
        global $DB;

        $pages_count = $DB->selectRow("
            SELECT COUNT(*) AS pages_count
            FROM publ
            WHERE status=1
        ");

        return $pages_count['pages_count'];
    }

    public static function theActiveElementsCount() {
        $articles = self::getActiveArticlesCount();
        $pages = self::getActivePagesCount();
        $publs = self::getActivePublsCount();
        $news = self::getActiveNewsCount();

        ?>
        <div>Количество активных статей: <?=$articles?></div>
        <div>Количество активных страниц: <?=$pages?></div>
        <div>Количество активных элементов инф. лент(Новости, актуальные комментарии, публикации в СМИ, объявления о мероприятиях, Объявления о защите диссертаций): <?=$publs?></div>
        <div>Количество активных публикаций: <?=$news?></div>
        <?php
    }
}

?>