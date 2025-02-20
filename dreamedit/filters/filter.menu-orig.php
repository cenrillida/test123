<?
global $page_content;

$pg = new Pages();
$menuRes = $pg->getChilds(415, 1);
$menuRes = $pg->appendContent($menuRes);
//print_r($_SERVER);
$page_content["RAZDEL"] = "";

//определяем сколько горизонтальных линий для меню нужно
//$temp = 0;
//foreach($menuRes as $row)
//$temp++;
//
$i = 1;

if(!empty($menuRes))
{
?>
<ul class="menutop">
<?


foreach($menuRes as $row)
{
	
//echo "<br />";print_r($row);
	$news_templater = new Templater();
	$news_templater->setValues($row);
	$news_templater->appendValues($row["content"]);
	$news_templater->appendValues(array("PAGE_URLNAME" => $pg->getPageUrl($row["page_id"]), "LINK_NUM" => $i));
	
	if(($i > 1) && ((empty($row["menu_picture"]) || $row["menu_picture"]=='<p>&nbsp;</p>')))
		echo "<li>|</li>";
	
	echo "<li>";
	
	if (!empty($row["menu_picture"]) && $row["menu_picture"]!='<p>&nbsp;</p>')
	{
			echo '<a alt="'.$row["page_name"].'" href='.$_SESSION[lang]."/index.php?page_id=".$row["page_id"].'>';
			echo str_replace('</p>','',str_replace('<p>','',$row["menu_picture"]));
			echo "</a>";
	}
	else{
		if ($_SESSION[lang]!='/en')
		{
			echo '<a alt="'.$row["page_name"].'" href='.$_SESSION[lang]."/index.php?page_id=".$row["page_id"].'>';
			echo $row["page_name"];
			echo "</a>";
		}
		else
		{
			echo '<a alt="'.$row["page_name_en"].'" href='.$_SESSION[lang].'/index.php?page_id='.$row["page_id"].'>';
			echo $row["page_name_en"];
			echo "</a>";
		}
	}
	$i++;
	
	echo "</li>";
}

?>
<!-- <li>
	<a href="/rssgen.php"><img src="/files/Image/rss.png" /></a>   
</li> /-->
</ul>
<?
}
?>
