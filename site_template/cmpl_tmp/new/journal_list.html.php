<?
global $_CONFIG, $site_templater;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

    $mg = new Magazine();

    $online_resource=0;

    if($_TPL_REPLACMENT['ONLINE_RESOURCE']=="1")
    	$online_resource=1;

    $rows=$mg->getMagazineNameAllMain($online_resource);
	
	$i=0;
//print_r($rows);	
foreach($rows as $row)
{
   $jall[$i]=$row;
   $i++;
}
echo "<div class='container-fluid'>";
for($ii=0;$ii<(count($jall));$ii++) //(count($jall)/2+1)
{
    $pages=$mg->magazine_pages($jall[$ii][journal_page]);
	
	echo "<div class='row'>";
	echo "<div class='col-12'>";
	if (!empty($jall[$ii][journal_page]) || !empty($jall[$ii][page_link])) {
		//	echo "<a href=".$_SESSION[lang]."/jour?jrid=".$jall[$ii][page_id].">";
		if($jall[$ii][page_journame]!="afjournal") {
			echo "<a href=" . $_SESSION[lang] . "/jour/" . $jall[$ii][page_journame] . ">";
		} else {
			echo "<a href=\"https://afjournal.ru".$_SESSION[lang]."\">";
		}
	}
	else 
	    echo "<a href=#>";
	if ($_SESSION[lang]!='/en') echo "<h3>".$jall[$ii]["page_name"]."</h3>";
	else echo "<h3>".$jall[$ii]["page_name_en"]."</h3>";
	echo "</a>";
	echo "</div></div>";
	echo "<div class='row mb-3'><div class='col-12 col-md-3 text-center text-lg-left'>";
	echo "<div>";

	if (!empty($jall[$ii]["logo"]) && $jall[$ii]["logo"] != '<p>&nbsp;</p>') {
		preg_match_all('@src="([^"]+)"@', $jall[$ii]["logo"], $imgSrc);
		preg_match_all('@alt="([^"]+)"@', $jall[$ii]["logo"], $imgAlt);

		$imgSrc = array_pop($imgSrc);
		$imgAlt = array_pop($imgAlt);
		if(!empty($imgSrc[0])) {
			$img_link = $imgSrc[0];
		}
		if(!empty($imgAlt[0])) {
			$img_alt = $imgAlt[0];
		}
	}

	echo "<img src='$img_link'/>";


    echo "</div><div>";
	
	if ($_SESSION[lang]!='/en')
		echo "<b>".$jall[$ii]['series']."</b><br />".$jall[$ii]['issn'];
	else
		echo "<b>".$jall[$ii]['series_en']."</b><br />".str_replace(" ","&nbsp;",$jall[$ii]['issn']);
	echo "</div>";
	echo "</div>";
	echo "<div class='col-12 col-md-9'>";
	if ($_SESSION[lang]!='/en')
		echo $jall[$ii]['info'];
	else	
	    echo $jall[$ii]['info_en'];
	if(!empty($pages)) {
		if ($_SESSION[lang] != '/en') {
			echo "<a href=/jour/" . $jall[$ii][page_journame] . ">подробнее</a>";
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=/jour/" . $jall[$ii][page_journame] . "/index.php?page_id=" . $pages[SUMMARY_ID] . ">свежий номер</a>";
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=/jour/" . $jall[$ii][page_journame] . "/index.php?page_id=" . $pages[ARCHIVE_ID] . ">архив номеров</a>";
		} else {
			echo "<a href=/en/jour/" . $jall[$ii][page_journame] . ">more</a>";
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=/en/jour/" . $jall[$ii][page_journame] . "/index.php?page_id=" . $pages[SUMMARY_ID] . ">Last Number</a>";
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=/en/jour/" . $jall[$ii][page_journame] . "/index.php?page_id=" . $pages[ARCHIVE_ID] . ">Archive</a>";
		}
	}
	echo "</div>";
    echo "</div>";
}
echo "</div>";
					

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
