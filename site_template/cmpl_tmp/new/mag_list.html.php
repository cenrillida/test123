<?
global $_CONFIG, $site_templater;

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

    $pg = new Pages();

    $allMagazines = $pg->getChilds($_REQUEST[page_id],1);
    $allMagazines = $pg->appendContent($allMagazines);


echo "<div class='container-fluid'>";
foreach ($allMagazines as $allMagazine)
{
	if($allMagazine['page_template']!="mag_index") {
		continue;
	}

	echo "<div class='row'>";
	echo "<div class='col-12'>";

	echo "<a href=\"".$_SESSION[lang]."/index.php?page_id=".$allMagazine['page_id']."\">";

	if ($_SESSION[lang]!='/en') echo "<h3>".$allMagazine["page_name"]."</h3>";
	else echo "<h3>".$allMagazine["page_name_en"]."</h3>";
	echo "</a>";
	echo "</div></div>";
	echo "<div class='row mb-3'><div class='col-12 col-md-3 text-center text-lg-left'>";
	echo "<div>";

	$img_link = "";
	$img_alt = "";
	if (!empty($allMagazine["content"]["LOGO"]) && $allMagazine["content"]["LOGO"] != '<p>&nbsp;</p>') {
		preg_match_all('@src="([^"]+)"@', $allMagazine["content"]["LOGO"], $imgSrc);
		preg_match_all('@alt="([^"]+)"@', $allMagazine["content"]["LOGO"], $imgAlt);

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
		echo "<b>".$allMagazine["content"]['SERIES']."</b><br />".$allMagazine["content"]['ISSN'];
	else
		echo "<b>".$allMagazine["content"]['SERIES_EN']."</b><br />".str_replace(" ","&nbsp;",$allMagazine["content"]['ISSN']);
	echo "</div>";
	echo "</div>";
	echo "<div class='col-12 col-md-9'>";
	if ($_SESSION[lang]!='/en')
		echo $allMagazine["content"]['INFO'];
	else	
	    echo $allMagazine["content"]['INFO_EN'];


	if ($_SESSION[lang] != '/en') {
		echo "<a href=\"/index.php?page_id=".$allMagazine['page_id']."\">подробнее</a>";
		if(!empty($allMagazine["content"][SUMMARY_ID])) {
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=\"/index.php?page_id=" . $allMagazine["content"][SUMMARY_ID] . "\">свежий номер</a>";
		}
		if(!empty($allMagazine["content"][ARCHIVE_ID])) {
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=\"/index.php?page_id=" . $allMagazine["content"][ARCHIVE_ID] . "\">архив номеров</a>";
		}
	} else {
		echo "<a href=\"/en/index.php?page_id=".$allMagazine['page_id']."\">more</a>";
		if(!empty($allMagazine["content"][SUMMARY_ID])) {
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=\"/en/index.php?page_id=" . $allMagazine["content"][SUMMARY_ID] . "\">Current Issue</a>";
		}
		if(!empty($allMagazine["content"][ARCHIVE_ID])) {
			echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
			echo "<a href=\"/en/index.php?page_id=" . $allMagazine["content"][ARCHIVE_ID] . "\">Archive</a>";
		}
	}
	echo "</div>";
    echo "</div>";
}
echo "</div>";
					

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
