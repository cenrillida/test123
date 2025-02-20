<?php
// Страница оглавления
global $DB,$_CONFIG, $site_templater;
$pg=new MagazineNew();

if ($_SESSION['lang']=='/en')
	$suff='_en';
else
	$suff='';
//if (empty($_REQUEST['jid'])) $_REQUEST['jid']=$_SESSION[jour_id];
//$_REQUEST['page_id']=(int)$DB->cleanuserinput($_REQUEST['page_id']);
$_REQUEST['jid']=(int)$DB->cleanuserinput($_REQUEST['article_id']);
$_REQUEST['jj']=(int)$_TPL_REPLACMENT["MAIN_JOUR_ID"];
if (empty($_REQUEST['jid']) ) //Найти свежий номер журнала
{
//
//	$journalId0=$pg->getMagazineJId($_REQUEST['page_id']);
//
//	if (empty($journalId0)) $journalId0[0][journal]=$_SESSION[jour_id];
	$jid0=$pg->getLastMagazineNumber($_TPL_REPLACMENT["MAIN_JOUR_ID"]);

	if (!empty($jid0[0]['journal_new']))
	{
		$_REQUEST['jid']=$jid0[0]['page_id'];
		$_REQUEST['jj']=$jid0[0]['journal_new'];
	}

}
// Сформировать название номера
//echo $_REQUEST['jid'];
if (!empty($_REQUEST['jid']))
{

	if ($_SESSION['lang']!="/en") {
		if($_REQUEST['jj']!=1667) {
			if($_REQUEST['jj']!=1614 && $_REQUEST['jj']!=1672)
				$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,mp.page_name AS journal_name,issn,a.page_name AS number,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
					 CONCAT(mp.page_name,'. № ',a.page_name,' ',a.year) AS title,
					 CONCAT(mp.page_name,'. ',a.page_name,', ',a.year) AS title_cut,
					 CONCAT(mp.page_name,'. ',a.page_name,', вып. ',a.year) AS title_cut_god_planety
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
					INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				    WHERE a.page_id=".(int)$_REQUEST['jid']);
			else
				$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,mp.page_name AS journal_name,issn,a.page_name AS number,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
					 CONCAT(mp.page_name,'. № ',a.page_name,', ',a.year) AS title,
					 CONCAT(mp.page_name,'. ',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
					INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				    WHERE a.page_id=".(int)$_REQUEST['jid']);
		}
		else
			$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,mp.page_name AS journal_name,issn,a.page_name AS number,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
					 CONCAT(a.page_name, '. Ежегодник') AS title,
					 CONCAT(mp.page_name,'. ',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
					INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				    WHERE a.page_id=".(int)$_REQUEST['jid']);
	}
	else {
		if($_REQUEST['jj']!=1614) {
			if($_REQUEST['jj']!=1667)
				$rowsj = $DB->select("SELECT
                     m.page_id AS ppp,mp.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
					 CONCAT(mp.page_name_en,'. <br />No. ',a.page_name,' ',a.year) AS title,
					 CONCAT(mp.page_name_en,'. <br />No. ',a.page_name_en,' ',a.year) AS title_en,
					 CONCAT(mp.page_name_en,'. <br />',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
					INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				    WHERE a.page_id=" . (int)$_REQUEST['jid']);
			else
				$rowsj = $DB->select("SELECT
				 m.page_id AS ppp,mp.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
				 CONCAT(mp.page_name_en,'. <br />No. ',a.page_name,' ',a.year) AS title,
				 a.page_name_en AS title_en,
				 CONCAT(mp.page_name_en,'. <br />',a.page_name,' ',a.year) AS title_cut
				 FROM adm_article AS a
				 INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				WHERE a.page_id=" . (int)$_REQUEST['jid']);
		}
		else
			$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,mp.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
					 CONCAT(mp.page_name_en,'. No. ',a.page_name,', ',a.year) AS title,
					 CONCAT(mp.page_name_en,'. No. ',a.page_name_en,', ',a.year) AS title_en,
					 CONCAT(mp.page_name_en,'. <br />',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal	
					INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				    WHERE a.page_id=".(int)$_REQUEST['jid']);
	}

	if($_REQUEST['jj']==1664) {
		if($_SESSION['lang']!="/en") {
			$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,mp.page_name AS journal_name,issn,a.page_name AS number,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
					 CONCAT(mp.page_name,'. <br />№ ',a.page_name,', ',a.year) AS title,
					 CONCAT(mp.page_name,'. <br />',a.page_name,', ',a.year) AS title_cut,
					 CONCAT(mp.page_name,'. <br />',a.page_name,', вып. ',a.year) AS title_cut_god_planety
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
					INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				    WHERE a.page_id=".(int)$_REQUEST['jid']);
		} else {
			$rowsj = $DB->select("SELECT
                     m.page_id AS ppp,mp.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year, a.special_issue_name, a.special_issue_name_en, a.number_title, a.number_title_en, a.editors_title, a.editors_title_en,
					 CONCAT(mp.page_name_en,'. <br />No. ',a.page_name,', ',a.year) AS title,
					 CONCAT(mp.page_name_en,'. <br />No. ',a.page_name_en,', ',a.year) AS title_en,
					 CONCAT(mp.page_name_en,'. <br />',a.page_name,', ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
					INNER JOIN adm_pages AS mp ON mp.page_id = a.journal_new
				    WHERE a.page_id=" . (int)$_REQUEST['jid']);
		}
	}

}
if (empty($_REQUEST['jj'])) $_REQUEST['jj']=$rowsj[0]['ppp'];

if((empty($rowsj[0]['number_title']) && $_SESSION['lang']!='/en') || (empty($rowsj[0]['number_title_en']) && $_SESSION['lang']=='/en') ) {
	$vol_pos = strripos($rowsj[0]['number'], "т.");
	if ($vol_pos === false) {

		if($_REQUEST['jj']==1665 || $_REQUEST['jj']==1668 || $_REQUEST['jj']==1671 || $_REQUEST['jj']==1666)
		{
			if(is_numeric(substr($rowsj[0]['number'], 1))) {

				$site_templater->appendValues(array("TITLE" => $rowsj[0]['title']));
				$site_templater->appendValues(array("TITLE_EN" => $rowsj[0]['title']));
			}
			else
			{
				if($_REQUEST['jj']==1666) {
					$site_templater->appendValues(array("TITLE" => $rowsj[0]['number']));
					$site_templater->appendValues(array("TITLE_EN" => str_replace("Ежегодник", "Yearbook", $rowsj[0]['number_en'])));
				}
				elseif($_REQUEST['jj']==1671) {

					$site_templater->appendValues(array("TITLE" => $rowsj[0]['number']));
					$site_templater->appendValues(array("TITLE_EN" => $rowsj[0]['number_en']));

					//$site_templater->appendValues(array("TITLE" => str_replace("мир.", "мир ".($rowsj[0]['year']+1).".", $rowsj[0]['journal_name'])));
					//$site_templater->appendValues(array("TITLE_EN" => str_replace("World.", "World ".($rowsj[0]['year']+1).".", $rowsj[0]['journal_name'])));
				}
				else {
					if($_REQUEST['jj']==1665)
						$site_templater->appendValues(array("TITLE" => $rowsj[0]['title_cut_god_planety']));
					else
						$site_templater->appendValues(array("TITLE" => $rowsj[0]['title_cut']));
					$site_templater->appendValues(array("TITLE_EN" => str_replace("Ежегодник", "Yearbook", $rowsj[0]['title_cut'])));
				}
			}
		}
		else
		{
			$site_templater->appendValues(array("TITLE" => $rowsj[0]['title']));
			if(!empty($rowsj[0]['number_en']))
				$site_templater->appendValues(array("TITLE_EN" => $rowsj[0]['title_en']));
			else
				$site_templater->appendValues(array("TITLE_EN" => $rowsj[0]['title']));
		}
	}
	else
	{

		$volume=substr($rowsj[0]['number'], $vol_pos);
		if($_SESSION['lang']=='/en')
			$volume=str_replace("т.", "Vol.",$volume);
		else
			$volume=str_replace("т.", "Т.",$volume);
		$number=spliti(",",$rowsj[0]['number']);
		if($_REQUEST['jj']!=1667)
			$site_templater->appendValues(array("TITLE" => $rowsj[0]['journal_name'].". ".$rowsj[0]['year'].". ".$volume.", № ".$number[0]));
		else
			$site_templater->appendValues(array("TITLE" => $rowsj[0]['journal_name'].". ".$volume.", ".$number[0]));
		$site_templater->appendValues(array("TITLE_EN" => $rowsj[0]['journal_name'].". ".$rowsj[0]['year'].". ".$volume.", No. ".$number[0]));
	}
} else {
	$site_templater->appendValues(array("TITLE" => "{$rowsj[0]['special_issue_name']} <br>[{$rowsj[0]['special_issue_name_en']}]. <br>{$rowsj[0]['editors_title']}. <br>{$rowsj[0]['journal_name']}. {$rowsj[0]['number_title']}. {$rowsj[0]['year']}"));
	$site_templater->appendValues(array("TITLE_EN" => "{$rowsj[0]['special_issue_name_en']}. <br>{$rowsj[0]['editors_title_en']}. <br>{$rowsj[0]['journal_name']}. {$rowsj[0]['number_title_en']}. {$rowsj[0]['year']}."));
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

?>
	<style>
		.h3-title {
			font-size: 1.5rem;
		}
	</style>
<?php

if (!empty($_REQUEST['jj']))
{
//print_r($rowsj);
// echo  "&&&".$rowsj[0]['title']."***";

	if ($_SESSION['lang']!='/en')
		echo "<p align=right><a href=/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"].">Архив номеров</a></p>";
	else
		echo "<p align=right><a href=/en/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"].">Archive numbers</a></p>";

	//echo "<a hidden=true src=bbb>".$_REQUEST['jid']."</a>";

	ini_set('memory_limit', '512M');

	if ($_SESSION['lang']!='/en')
		$rows=$pg->getMagazineNumber($_REQUEST['jid']);
	else
		$rows=$pg->getMagazineNumberEn($_REQUEST['jid']);

// print_r($rows);

//    $rows=$pg->getMagazineNumber($_REQUEST['jid']);
	$rows=$pg->appendContentArticle($rows);

	$numberContent = $pg->getArticleContentByPageId($_REQUEST['jid']);


//  echo "<br /><br /><hr />";print_r($rows);

	$pageid_jour=0;
	if (count($rows)==0 && $_SESSION['lang']=="/en") echo "Does not exist English version";

    $contentsTextFlag = false;

    foreach($rows as $k=>$row) {
        if($row['page_template'] == 'jrubric' || $row['page_template'] == 'jarticle' || $row['page_template'] == 'jarticle_2021') {
            $contentsTextFlag = true;
            break;
        }
    }

	foreach($rows as $k=>$row)
	{
//    echo "<br />";print_r($row);

		if($_SESSION['lang']=='/en')
		{
			if(!empty($row['content']['SUBJECT_EN'])) $row['content']['SUBJECT']=$row['content']['SUBJECT_EN'];
			if(!empty($row['content']['RUBRIC_EN'])) $row['content']['RUBRIC']=$row['content']['RUBRIC_EN'];
			if(!empty($row['name_en'])) $row['name']=$row['name_en'];
			if(!empty($row['content']['CONTENT_EN'])) $row['content']['CONTENT']=$row['content']['CONTENT_EN'];
		}
//echo "<br />";print_r($row);
		//echo "<a hidden=true src=aaa>".$row['page_template']."</a>";
		switch($row['page_template'])
		{


			case "jnumber":
				//    print_r($row);

                if(!empty($row['content']['ISBN_NUMBER'])) {
                    echo '<div><b>ISBN: </b>'.$row['content']['ISBN_NUMBER'].'</div>';
                }
				if(!empty($row['content']['DOI_NUMBER'])) {
					echo '<div><b>DOI: </b>'.$row['content']['DOI_NUMBER'].'</div>';
				}
				if(!empty($row['content']['RINC_NUMBER'])) {
					if ($_SESSION['lang']!='/en')
						echo '<div><a href="'.$row['content']['RINC_NUMBER'].'"><b>Размещено в РИНЦ</b></a></div>';
					else
						echo '<div><a href="'.$row['content']['RINC_NUMBER'].'"><b>SCIENCE INDEX</b></a></div>';
				}
				if(!empty($row['content']['DOI_NUMBER']) || !empty($row['content']['RINC_NUMBER']) || !empty($row['content']['ISBN_NUMBER'])) {
					echo '<p>&nbsp;</p>';
				}

				$signedStyle = "";
				$signedColor = "";
				if(!empty($_TPL_REPLACMENT['MENU_TEXT_COLOR'])) {
					$signedColor = $_TPL_REPLACMENT['MENU_TEXT_COLOR'];
				} elseif(!empty($_TPL_REPLACMENT['MENU_GRADIENT_1'])) {
					$signedColor = $_TPL_REPLACMENT['MENU_GRADIENT_1'];
				}

				if($signedColor != "") {
					$signedStyle = " style=\"color: {$signedColor};\"";
				}

				$signedToPrint = "";
				if(isset($row["content"]["SIGNED_TO_PRINT"]) && !empty($row["content"]["SIGNED_TO_PRINT"])) {
					try {
						$dt = date_create_from_format("Y.m.d H:i",$row["content"]['SIGNED_TO_PRINT']);
						$createdYear = $dt->format('Y');
						$createdDay = $dt->format('d');
						$createdMonth = mb_strtolower(Dreamedit::rus_get_month_name($dt->format('m'), 2), "windows-1251");

						$monthNumber = $dt->format('m');
						$published = "Номер подписан в печать";
						if($_SESSION['lang']=="/en") {
							$published = "Printed edition date:";
							$createdMonth = $dt->format('F');
							$signedToPrint .= "<div{$signedStyle} class=\"mb-3 text-center\"><b>$published $createdMonth $createdDay, $createdYear</b></div>";
						} else {
							$signedToPrint .= "<div{$signedStyle} class=\"mb-3 text-center\"><b>$published $createdDay $createdMonth $createdYear г.</b></div>";
						}

						$expiredTextDateFrom = date_create_from_format("Y.m.d","2022.05.29");

						if($_REQUEST['jj']==1614 && $row['content']['FULL_TEXT_OPEN']!=1 && $dt > $expiredTextDateFrom) {
							if($_SESSION['lang']!="/en") {
								$signedToPrint .= "<div class=\"mb-3 text-center\"><b>По истечении 3-х месяцев он будет открыт в свободный доступ.</b></div>";
							} else {
								$signedToPrint .= "<div class=\"mb-3 text-center\"><b>After 3 months all materials of the issue will be open for free access.</b></div>";
							}
						}

					} catch (Exception $e) {
					}

				}

				if(!empty($signedToPrint) && $_REQUEST['jj']!=1669) {
					echo $signedToPrint;
				}

                if(isset($row["content"]["DATE_OF_PUBLICATION"]) && !empty($row["content"]["DATE_OF_PUBLICATION"])) {
                    try {
                        $dt = date_create_from_format("Y.m.d H:i",$row["content"]['DATE_OF_PUBLICATION']);
                        $createdYear = $dt->format('Y');
                        $createdDay = $dt->format('d');
                        $createdMonth = mb_strtolower(Dreamedit::rus_get_month_name($dt->format('m'), 2), "windows-1251");

                        $monthNumber = $dt->format('m');
                        $published = "Дата выхода в свет";
                        if($_SESSION['lang']=="/en") {
                            $published = "Date of publication:";
                            $createdMonth = $dt->format('F');
                            echo "<div{$signedStyle} class=\"mb-3 text-center\"><b>$published $createdMonth $createdDay, $createdYear</b></div>";
                        } else {
                            echo "<div{$signedStyle} class=\"mb-3 text-center\"><b>$published $createdDay $createdMonth $createdYear г.</b></div>";
                        }

                    } catch (Exception $e) {
                    }

                }

				if(!empty($row['content']['SUBJECT'])&& $row['content']['SUBJECT']<>"<p>&nbsp;</p>") {
					if ($_SESSION['lang']!='/en')
						echo "<div class='jsublect'>".$row['content']['SUBJECT']."</div>";
					else
						echo "<div class='jsublect'>".$row['content']['SUBJECT']."</div>";
				}
				$annot="";
				echo 	$annot.$row['content']['CONTENT']."<hr />";
				if (!empty($row['content']['FULL_TEXT']))
				{
					if(strpos($row['content']['FULL_TEXT'],"https:")==0 && strpos($row['content']['FULL_TEXT'],"http:")==0)
					{
						$row['content']['FULL_TEXT']=str_replace("/files/File/","https://".$_SERVER['HTTP_HOST']."/files/File/",$row['content']['FULL_TEXT']);

					}
					$filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[-A-Z0-9+&@#\/%?= ()~_|!:,.;]\.pdf/i";
					preg_match_all($filter,$row['content']['FULL_TEXT'],$res);
					//  print_r($res); echo "<br />";echo "<br />";
					//  echo $res[0][0]." ".count($res)."**";
					for($i=0;$i<=count($res);$i++)
					{
						if($_REQUEST['jj']!=1614) {
							$row['content']['FULL_TEXT'] = str_replace($res[0][$i], $_SESSION['lang'] . "/index.php?page_id=647&module=article&id=" . $row['page_id'] . "&param=" . str_replace(' ', '^', $res[0][$i]), $row['content']['FULL_TEXT']);
						} else {
							$row['content']['FULL_TEXT']=str_replace($res[0][$i],$_SESSION['lang']."/index.php?page_id=647&module=article&script_download=1&id=".$row['page_id']."&param=".str_replace(' ','^',$res[0][$i]),$row['content']['FULL_TEXT']);
						}

					}

					$linkRegex = array();

					preg_match_all("/<a\s+(?:[^>]*?\s+)?href=['\"]([^\"^']*)['\"][^>]*>(.+)<\/a>/iU",$row['content']['FULL_TEXT'],$linkRegex);

					$text = $linkRegex[2][0];
					$link = $linkRegex[1][0];
					if ($_SESSION['lang'] == '/en') {
						$text = str_replace('Полный текст', 'Full Text', str_replace('Титул и содержание', 'Title and content', str_replace('Содержание номера', 'Contents', $text)));
					}


					if($_REQUEST['jj']!=1614 || $_SESSION['meimo_authorization']==1 || $row['content']['FULL_TEXT_OPEN']==1) {


						if(!empty($row['content']['FULL_TEXT']) && $row['content']['FULL_TEXT']!="<p>&nbsp;</p>") {
							echo '<div style="font-size: 19px;">';
							echo "<i class=\"far fa-file-pdf text-danger\"></i>&nbsp;&nbsp;<a target='_blank' href=\"".$link."\">".$text."</a>";
							echo '</div><br />';
						}
					}

				}

				if(!empty($row["content"]['DATE_PUBLIC']) && ($_REQUEST['jj']==1664 || $_REQUEST['jj']==1668)) {
					try {
						$dt = date_create_from_format("Y.m.d H:i",$row["content"]['DATE_PUBLIC']);
						$createdYear = $dt->format('Y');
						$createdDay = $dt->format('d');
						$createdMonth = mb_strtolower(Dreamedit::rus_get_month_name($dt->format('m'), 2), "windows-1251");
						$monthNumber = $dt->format('m');
						$published = "Дата публикации";
						$yearEnd = " г.";
						if($_SESSION['lang']=="/en") {
							$published = "Published";
							$createdMonth = $dt->format('F');
							$yearEnd = "";
						}

						echo "<div class='mb-3'>$published $createdDay $createdMonth $createdYear$yearEnd</div>";

					} catch (Exception $e) {
					}
				}

                if($contentsTextFlag) {
                    if ($_SESSION['lang']!="/en")
                        echo "<div class=jrubric><h4 style='font-weight: bold'>СОДЕРЖАНИЕ:</h4><br /></div>";
                    else
                        echo "<div class=jrubric><h4 style='font-weight: bold'>CONTENTS:</h4><br /></div>";
                }

				$pageid_jour=$row['page_id'];
				break;
			case "jrubric":
				if (empty($row['name'])) $row['name']=$row['page_name'];
				if ($row['page_parent']==$_REQUEST['jid'])
					echo "<div class='jrubric'><h5 style='font-weight: bold'><a href=".$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$row['page_id'].">".mb_strtoupper($row['name'],'CP1251')."</a></h5></div>";
				else
					echo "<div class='jrubric2 my-3'><h6><a href=".$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$row['page_id'].">".$row['name']."</a></h6></div>";

				break;
			case "jarticle" || "jarticle_2021" :
				if ($_SESSION['lang']!='/en') {
					if($row['page_status']==0) {
						break;
					}
				} else {
					if($row['page_status_en']==0) {
						break;
					}
				}
				//        echo "<br />";print_r($row);
				echo "<div class='jarticle'>";
				if ($_SESSION['lang']!='/en')
				{
					$people0=$pg->getAutors($row['people']);
					$avtbib=$pg->getAutorsBib($row['people']);
				}
				else
				{
					$secondField = false;
					if($_REQUEST['jj']==1669) {
						$secondField = true;
					}
					$people0=$pg->getAutorsEn($row['people'],$secondField);
					$avtbib=$pg->getAutorsBibEn($row['people']);
				}

                $autorBuilder = new AuthorBuilder($people0, $_TPL_REPLACMENT['AUTHOR_ID'], $_SESSION['lang'], false);
                $avtList = $autorBuilder->getAuthorRowWithLinks();
				echo "<div class='autors'>";
				echo $avtList;
				echo "</div>";
				$pages_prefix = "с. ";
				if($_SESSION['lang']=='/en')
					$pages_prefix = "p. ";

				//if (!empty($row[contents]) && $row[contents]!="<p>&nbsp;</p>") $img="<img src=/files/Image/internet_explorer.png >"; else $img='';
				$img="";

				if (!empty($row['name_black'])) {
					$row['name'] = str_replace($row['name_black'], "<span style=\"border: 1px solid black; padding: 0 3px;\">" . $row['name_black'] . "</span>", $row['name']);
				}
				if (!empty($row['name_black_en'])) {
					$row['name'] = str_replace($row['name_black_en'], "<span style=\"border: 1px solid black; padding: 0 3px;\">" . $row['name_black_en'] . "</span>", $row['name']);
				}

				echo "<div class='name'>".$img."<a href=".$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$row['page_id'].">".$row['name']."</a> (".$pages_prefix.$row['pages'].")";
//           echo $avtbib;print_r($row);

				if($_REQUEST['jj']!=1614) {
					if ($_REQUEST['jj'] != 1614) {
						if ($_SESSION['lang'] == '/en') {
							if (!empty($row['link_en']) && $row['link_en'] != '<p>&nbsp;</p>')
								$row['link'] = $row['link_en'];
						}
					}
					$row = $pg->fixLinksForScripts($row);

					$linkRegex = array();
					$linkEnRegex = array();

					preg_match_all("/<a\s+(?:[^>]*?\s+)?href=['\"]([^\"^']*)['\"][^>]*>(.+)<\/a>/iU", $row['link'], $linkRegex);
					preg_match_all("/<a\s+(?:[^>]*?\s+)?href=['\"]([^\"^']*)['\"][^>]*>(.+)<\/a>/iU", $row['link_en'], $linkEnRegex);

					$text = $linkRegex[2][0];
					$link = $linkRegex[1][0];
					$linkEn = $linkEnRegex[1][0];
					if ($_SESSION['lang'] == '/en') {
						$text = str_replace('Текст', 'Text', str_replace('Текст статьи', 'Text', str_replace('Титул и содержание', 'Title and content', $text)));
					}

					if ($_REQUEST['jj'] != 1614 || $_SESSION['meimo_authorization'] == 1 || $row['fulltext_open'] == 1 || $numberContent['FULL_TEXT_OPEN'] == 1) {
						if ($_REQUEST['jj'] != 1614) {
							if (empty($row['link'])) {
								echo "<div class='mb-3'> &nbsp;</div>";
							} else {

								if (!empty($text) && !empty($link)) {
									echo "<div class='mb-3'><i class=\"far fa-file-pdf text-danger\"></i> <a target='_blank' href=\"" . $link . "\">" . $text . "</a></div>";
								}
							}
						} else {
							if (empty($link) && empty($linkEn)) {
								echo "<div class='mb-3'> &nbsp;</div>";
							} else {
								if (!empty($link) && !empty($linkEn)) {
									echo "<div class='mb-3'><a target='_blank' href=\"" . $link . "\"><b>PDF (RUS)</b></a> <b>|</b> <a target='_blank' href=\"" . $linkEn . "\"><b>PDF (ENG)</b></a></div>";
								} elseif (empty($link) && !empty($linkEn)) {
									echo "<div class='mb-3'><a target='_blank' href=\"" . $linkEn . "\"><b>PDF (ENG)</b></a></div>";
								} elseif (!empty($link)) {
									echo "<div class='mb-3'><a target='_blank' href=\"" . $link . "\"><b>PDF (RUS)</b></a></div>";
								}
							}
						}
					} else {
						echo "<div class='mb-3'> &nbsp;</div>";
					}
				} else {
					$pg->echoPdfLinks($row, $numberContent,"mb-3","color: {$_TPL_REPLACMENT['MENU_GRADIENT_1']};");
				}
				echo "</div>";
				echo "</div>";
				$row['jtitle']=$rowsj[0]['journal_name'];
				$row['number']=$rowsj[0]['number'];
				$row['issn']=$rowsj[0]['issn'];
				$row['year']=$rowsj[0]['year'];
				$row['vid']=2;
				//         echo "<br /><br />____".$avtbib."<br />";print_r($row);

				$bib=new BibEntry();
				$aa=$bib->toCoinsMySQL($row,$avtbib);
				print_r($aa);
				break;
		}

	}

	if(!empty($signedToPrint) && $_REQUEST['jj']==1669) {
		echo $signedToPrint;
	}
}

?>

<?=@$_TPL_REPLACMENT["CONTENT"]?>

<?php
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
