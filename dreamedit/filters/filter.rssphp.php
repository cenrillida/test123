<?

require_once 'rss_php.php';

    $rss = new rss_php;

    $rss->load('http://static.feed.rbc.ru/rbc/internal/rss.rbc.ru/rbc.ru/politics.rss');

   $items = $rss->getItems();

    $html = '';
	$i =0;



    foreach($items as $index => $item) {

	if($i < 4)
	{
		$link = $item['link'];
		$title = iconv("utf-8","windows-1251",$item['title']);

        	$html .=
		'<p><a href="'.$link.'" title="'.$title.'"><strong>'.$title.'</strong></a>'.'&nbsp;&nbsp;&nbsp;<a href="'.$link.'">'.'<img src="/files/Image/str_black.jpg" alt="подробнее" /></a></p>';
	}
	$i++;
    }

echo "<style>.mf-viral{display: none;}  </style>";


   echo "<div class='rssnews'>".$html."</div>\n";

?>