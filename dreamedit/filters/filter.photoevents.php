<?
global $_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;

$months = array(1 => 'Января', 'Февраля', 'Марта','Апреля', 'Мая', 'Июня','Июля', 'Августа', 'Сентября','Октября', 'Ноября', 'Декабря');
$months_en = array(1=> 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$ilines = new Ilines();

$rows = $ilines->getLimitedElementsMultiSort(2, 12, "","DATE", "DESC", "status");

if(!empty($rows))
{
	echo '<div class="jcarousel-skin-wpzoom">';
	echo '<div class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block;">';
	echo '<div class="jcarousel-clip jcarousel-clip-horizontal" style="overflow: hidden; position: relative;">';
	echo '<ul id="jCarousel" class="posts jcarousel-list jcarousel-list-horizontal">'; 

	 
	$rows = $ilines->appendContent($rows); 

	$i=0;
	foreach($rows as $k => $v)
	{
		$i++;
		echo '<li '.(/*$i==6 ? 'class="last"' :*/	 '').'>';
			echo '<div class="cover">';
				preg_match_all('/<img[^>]+>/i', $v["content"]["PHOTO"], $img); 
				preg_match_all('/(src|width|height)=("[^"]*")/i',$img[0][0],$result);
				echo '<a href="'.str_replace("ru/index","ru".$_SESSION[lang]."/index",$v["content"]["URL"]).'" alt="">';
					echo '<img width=145 height=100 src="'.trim($result[2][2],'"').'" alt="">';
				echo '</a>';
				$date_array = date_parse_from_format('Y.m.d H:i',$v["content"]['DATE']);
				if ($_SESSION[lang]!=="/en")
					echo '<time pubdate="" datetime="'.$date_array[day].'.'.$date_array[month].'.'.$date_array[year].'">'.$date_array[day].' '.$months[$date_array[month]].' '.$date_array[year].'</time>';
			    else
				    echo '<time pubdate="" datetime="'.$date_array[day].'.'.$date_array[month].'.'.$date_array[year].'">'.$date_array[day].' '.$months_en[$date_array[month]].' '.$date_array[year].'</time>';
			echo '</div>';
				echo '<h3>';
					echo '<a class="link link_1" href="'.str_replace("ru/index","ru".$_SESSION[lang]."/index",$v["content"]["URL"]).'">';  
					    if ($_SESSION[lang]!="/en")
							echo $v["content"]["TITLE"];
						else
						    echo $v["content"]["TITLE_EN"];
					echo '</a>';
				echo '</h3>';
			echo '<div class="cleaner">&nbsp;</div>';
		echo '</li>';	
	}
	
	echo '</ul>';
	echo '</div>';
	echo '<div class="jcarousel-prev jcarousel-prev-horizontal" style="display: block;"></div>';
	echo '<div class="jcarousel-next jcarousel-next-horizontal" style="display: block;"></div>';
	echo '</div>';
	echo '</div>';
	?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#jCarousel').jcarousel2({
							scroll: 1,
					visible: 6,
					wrap: 'circular'
				});
			});
		</script> 
	<?
}
/*
$news_count = $ilines->countElements($page_content["NEWS_BLOCK_LINE"],"status");
$pagination = new Pagination();
//$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, @$_REQUEST["p"]);
$pages = $pagination->createPages($news_count[$page_content["NEWS_BLOCK_LINE"]], $page_content["NEWS_BLOCK_COUNT"], 3, 1);
*/
/*
$pg = new Pages();
foreach($pages as $v)
{
	echo "<a href=\"".$pg->getPageUrl($page_id)."?p=".$v[0]."\">".$v[1]."</a>&nbsp;&nbsp;";
}
*/
//echo "<a href=/news.html>другие новости</a>";
?>
