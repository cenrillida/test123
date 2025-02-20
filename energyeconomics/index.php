<?php
if($_GET[debug]==55) {
} else {
    include "../index.php";
    exit;
}

$link = mysqli_connect("localhost","imemon", "phai5reRe3","imemon") or die("Error " . mysqli_error($link));
if (!empty($_GET['page_id']))
    $p_id=(int)$_GET['page_id'];
else
    $p_id=1107;

$pageRows = $link->query("SELECT * FROM adm_pages WHERE page_id=".$p_id." LIMIT 1");

while($pageRow=mysqli_fetch_array($pageRows)) {
    if(!empty($pageRow['page_link'])) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$pageRow['page_link']);
        exit;
    }
}



?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" lang="ru-ru" dir="ltr" g_init="6859"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="robots" content="index, follow">

	
	<?php 

	/*if($_GET[closed]!="2") {
		echo "Раздел находится в разработке";
		exit;
	}*/
	

	
	$id_menu=1108;

	$conf_feetpost_main_block_id=11;
	$conf_sidebar_main_block_id=12;
	$conf_feetpost_sob_block_id=9;
	$conf_sidebar_sob_block_id=10;
	$conf_feetpost_smi_block_id=13;
	$conf_sidebar_smi_block_id=14;
	$conf_feetpost_akt_block_id=19;
	$conf_sidebar_akt_block_id=17;
	$conf_feetpost_director_block_id=15;
	$conf_sidebar_director_block_id=16;
	$conf_feetpost_contacts_block_id=20;
	$conf_sidebar_contacts_block_id=18;

	

	
// !!! Лучше прочитать файл _config.ini
	mysqli_set_charset($link, "utf8");
	
	if($_GET[statistic]==1)
	{
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
			padding-top: 150px;
		}
		</style>
		<?php
		$date = date("Y-m-d");
		$stats_today = $link->query("SELECT views, hosts FROM magazine_visits WHERE magazine='energyeconomics' AND date='".$date."'");
		$stats_all = $link->query("SELECT SUM(views) AS 'views' FROM magazine_visits WHERE magazine='energyeconomics'");
		$stats_today = mysqli_fetch_array($stats_today);
		$stats_all = mysqli_fetch_array($stats_all);
		if($_SESSION[lang]!='/en')
		{
			echo "<div id=stats><h1>Статистика:</h1><br>";
			echo "<h2>Просмотров сегодня: ".$stats_today['views']."</h2>";
			echo "<h2>Уникальных посетителей сегодня: ".$stats_today['hosts']."</h2>";
			echo "<h2>Просмотров всего: ".$stats_all['views']."</h2><img style='width: 50%;' src=/images/logo_ces.png></div>";
		}
		else
		{
			echo "Views today: ".$stats_today['views']."<br>";
			echo "Unique users today: ".$stats_today['hosts']."<br>";
			echo "Total views: ".$stats_all['views']."<br>";
		}
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
		      	$stats_chart = $link->query("SELECT MONTH(date)-1 AS month, YEAR(date) AS year, DAY(date) AS day, hosts, views FROM magazine_visits WHERE magazine='energyeconomics' ORDER BY date");
		      	$first = true;
		      	while($row=mysqli_fetch_array($stats_chart)) {
		      		if($first)
		      			$first=false;
		      		else
		      			echo ',';
		      		echo '[new Date(\''.$row['year'].'\',\''.$row['month'].'\',\''.$row['day'].'\'), '.$row['views'].', '.$row['hosts'].']';
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
		<?
		break;
	}
	
	
	include_once("counter.php");
	
	$result = $link->query("SELECT * FROM adm_pages WHERE page_id=".$p_id." LIMIT 1"); 

	//display information: 

	while($row=mysqli_fetch_array($result)) {
		if($_GET['lang']!='eng')
		echo "<title>".$row['page_name']."</title>";
		else
		echo "<title>".$row['page_name_en']."</title>";
		
		$sections = explode(",", $row[rightblock]);
		$feetposts_id = $sections[0];
		$sidebar_id = $sections[1];
	}
	?>
	
	<meta name="keywords" content="мировая экономика, международные отношения, ИМЭМО, эксперты, Дынкин А.А.
">
	<meta name="description" content="Официальный сайт Института мировой экономики и международных отношений  Российской академии наук
">
	
	<link type="text/css" href="css/style.css" rel="stylesheet">
	<link type="text/css" href="css/menu.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="jcarousel.connected-carousels.css">
	
	<script type="text/javascript" async="" src="css/ga.js"></script><script src="jquery-1.12.3.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="jquery.jcarousel.min.js"></script> 
	<script type="text/javascript" src="jcarousel.connected-carousels.js"></script>

	<!--[if IE 7.0]>
	<link rel="stylesheet" type="text/css" href="css/style_ie7.css" />
	<![endif]-->
	
</head>
<body class="home blog">
	<div id="container">
	<div id="container">
		<div id="header">
			<div class="wrappersoc">
				<div class="fright">
					<nav>
						<ul class="menutop">
					<li><a alt="Facebook" href="/index.php?page_id=862"><img alt="" src="https://www.imemo.ru/files/Image/facebook.png" height="16" width="16"></a></li><li><a alt="Twitter" href="/index.php?page_id=864"><img alt="" src="/files/Image/twitter.png" height="16" width="16"></a></li><li><a alt="Youtube" href="/index.php?page_id=863"><img alt="" src="/files/Image/youtube.png" height="16" width="16"></a></li><li><a alt="RSS" href="/index.php?page_id=861"><img src="https://www.imemo.ru/files/Image/rss(1).png" alt="" height="16" width="16"></a></li><!-- <li>
					<a href="/rssgen.php"><img src="/files/Image/rss.png" /></a>   
					</li> /-->
					</ul>
					</nav>
					<div class="cleaner">&nbsp;</div>
				</div>
				<div class="cleaner">&nbsp;</div>
			</div><!-- end .wrapper -->
			<div class="wrapperlogo">
				<div id="logo">
				<?php 
				if($_GET['lang']!='eng')
					echo "<h1 class=logo_main>
						<a style='color:white;' href=/>ИМЭМО РАН Центр энергетических исследований</a><span style='font-size:16px;color:white;'></span>
					</h1>";
					else
					echo "<h1 class=logo_main_en>
						<a style='color:white;' href=/en>IMEMO RAS</a><span style='font-size:16px;color:white;'></span>
					</h1>";
					?>
					
				</div><!-- end #logo -->
				<div class="fright">
					<div class="cleaner">&nbsp;</div>
				</div>
				<div class="cleaner">&nbsp;</div>
			</div><!-- end .wrapper -->
		</div><!-- end #header -->
		<div class="wrappermenu">
			<div id="navigation">
				<img height="34" width="3" class="alignleft" alt="" src="css/men_crn_left.png">
				<div class="dropdown" id="menu">
					<ul id="topnav" class="clearfix">
  <li class="home"> 
  <?php
  if($_GET['lang']!='eng')
echo "<a rel=nofollow href=/energyeconomics/>";
else
echo "<a rel=nofollow href=index.php?lang=eng>";
?>
<img height="34" width="37" alt="" src="css/men_icon_home.png">
</a>
</li>

<?php 

//consultation: 

$query = "SELECT * FROM adm_pages WHERE page_parent=".$id_menu." ORDER BY page_position" or die("Error in the consult.." . mysqli_error($link)); 

//execute the query. 

$result = $link->query($query); 

//display information: 
$first=true;


while($row = mysqli_fetch_array($result)) 
{ 
	if(!$first)
	{
	//echo '<li id="nav" class="razdel-r">&nbsp;&nbsp;&nbsp;&nbsp;</li>';
	}
	else
	$first=false;
if($row[page_id]!=$p_id)
{
if($_GET['lang']!='eng')
  echo '<li id="nav" class="first-level"><a class="first-level " id="m" onmouseout="this.id=&#39;m&#39;;" onmouseover="this.id=&#39;over_m&#39;;" onclick="document.location=&#39;/energyeconomics/index.php?page_id='.$row[page_id].'&#39;" nowrap="nowrap">'.$row["page_name"].'</a>';
else
  echo '<li id="nav" class="first-level"><a class="first-level " id="m" onmouseout="this.id=&#39;m&#39;;" onmouseover="this.id=&#39;over_m&#39;;" onclick="document.location=&#39;/energyeconomics/index.php?page_id='.$row[page_id].'&lang=eng&#39;" nowrap="nowrap">'.$row["page_name_en"].'</a>';
}
else
{
if($_GET['lang']!='eng')
  echo '<li id="nav" class="first-level"><a class="first-level-text " id="m" onmouseout="this.id=&#39;m&#39;;" onmouseover="this.id=&#39;over_m&#39;;" onclick="document.location=&#39;/energyeconomics/index.php?page_id='.$row[page_id].'&#39;" nowrap="nowrap">'.$row["page_name"].'</a>';
else
  echo '<li id="nav" class="first-level"><a class="first-level-text " id="m" onmouseout="this.id=&#39;m&#39;;" onmouseover="this.id=&#39;over_m&#39;;" onclick="document.location=&#39;/energyeconomics/index.php?page_id='.$row[page_id].'&lang=eng&#39;" nowrap="nowrap">'.$row["page_name_en"].'</a>';

}
	$result2=$link->query("SELECT * FROM adm_pages WHERE page_parent=".$row[page_id]." ORDER BY page_position");
	if($result2->num_rows>0):
	?>
		<div style="margin-left: -17px;" class="topnav-dd-outer topnav-dd-outer-featured topnav-dd-outer-one-col-featured">
			<div class="topnav-dd-inner clearfix">
				<ul class="one-col clearfix">
					<?
						while($row2 = mysqli_fetch_array($result2)) 
						{
							if($_GET['lang']!='eng')
							echo "<li><a href=/energyeconomics/index.php?page_id=".$row2[page_id].">".$row2["page_name"]."</a>
								</li> ";
							else
							echo "<li><a href=/energyeconomics/index.php?page_id=".$row2[page_id]."&lang=eng>".$row2["page_name_en"]."</a>
								</li> ";
						}
						?>
				</ul>
			</div>
		</div>
	<?
	endif;
	echo '<!--/ .topnav-dd-outer, .topnav-dd-inner -->
</li>';
//echo '<li id="nav" class="first-level"><h1 class="razdel_img"><a style="color:white;" href="/">ИМЭМО РАН</a><span style="font-size:16px;color:white;"></span></h1></li>';
} 
?>

<li class="cleaner">&nbsp;</li>
</ul>				</div><!-- end #menu -->
			</div><!-- end #navigation -->
			
			<div id="navigation2">
				<div id="menuSocial">
					<ul>
					<?php
					/*
					echo	"<li>";
					if($_GET['lang']!='eng')
					echo "<b>РУС</b> /";
					else
					echo "<a style=text-decoration:underline; href=index.php?page_id=".$_GET['page_id'].">РУС /</a>";	
					
					echo	"</li>";				
					echo 	"<li>";
					if($_GET['lang']=='eng')
					echo "<b>EN</b>";
					else 
echo "<a style=text-decoration:underline; href=index.php?page_id=".$_GET['page_id']."&lang=eng>EN</a>";							
							
					echo	"</li>";
					*/
						?>
					</ul>
				</div><!-- end #menuSocial -->
				<ul id="nav2" class="menu">
				<?php
				if($_GET['lang']!='eng')
				echo	'<li><a alt="Официальный сайт ИМЭМО РАН" href="/">Официальный сайт ИМЭМО РАН</a></li>';
				else	
				echo	'<li><a alt="Official site IMEMO RAN" href="/en">Official site IMEMO RAN</a></li>';
				
?>
</ul>
			</div><!-- end #navigation2 -->
		</div>
		<div class="wrapper">
			<div id="frame"> 
				<?php
  function compare ($v1, $v2) {
    if ($v1["date"] == $v2["date"]) return 0;
    return ($v1["date"] < $v2["date"])? -1: 1;
  }
  function compare_desc ($v1, $v2) {
    if ($v1["date"] == $v2["date"]) return 0;
    return ($v1["date"] > $v2["date"])? -1: 1;
  }
				
include_once("feetposts.php");
include_once("sidebar.php");
				 ?>
<div class="cleaner"> </div>
                <div style="display: none;">
                    <script type="text/javascript" src="//rf.revolvermaps.com/0/0/2.js?i=56ovy43nr90&amp;m=8&amp;s=142&amp;c=002540&amp;t=1" async="async"></script>
                </div>
				</div> <!-- frame /-->
			</div> <!-- wrapper /-->
		</div>
	
</div><script type="text/javascript">(function(window){ window.price_context=window.price_context || {}; window.price_context.appId = "10000075";})(Function("return this")());</script></body></html>
