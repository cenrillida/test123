<?
//
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

global $DB,$_CONFIG, $site_templater;

if(!empty($_REQUEST['article_id'])) {

	$article = new Article();

	$articleEl = $article->getPageById((int)$_REQUEST['article_id'],1);


	if(!empty($articleEl) && isset($_TPL_REPLACMENT["MAIN_JOUR_ID"]) && $articleEl['journal_new']==$_TPL_REPLACMENT["MAIN_JOUR_ID"]) {

		switch ($articleEl['page_template']) {
			case 'jarticle':
				if(!empty($articleEl['article_special_template'])) {
					$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"].$articleEl['article_special_template'].".html");
				} else {
					$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_article.html");
				}
				break;
			case 'jarticle_2021':
				$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_article_2021.html");
				break;
			case 'jnumber':
				$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_number.html");
				break;
			case 'jrubric':
				$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_rubric.html");
				break;
			case '0':
				if($articleEl['page_name']==$articleEl['year']) {
					$_REQUEST["year"] = $articleEl['page_name'];
					$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_rubric_all.html");
				} else {
					$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
					$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
				}
				break;
			default:
				$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
				$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
		}
	} else {
		$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

		echo "<p>Страница не найдена</p>";

		$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
	}


} else {

	if ($_SESSION["lang"] == '/en') {
		$suff = '&en';
		$txt1 = "No.&nbsp;";
		$txt2 = 'Topic';
	} else {
		$suff = '';
		$txt1 = "№&nbsp;";
		$txt2 = 'Тема номера';
	}
	//Архиы номеров

	$pg = new MagazineNew();


	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

	$rows = array();

	if(isset($_TPL_REPLACMENT["MAIN_JOUR_ID"])) {
		$rows = $pg->getMagazineAllPublic($_TPL_REPLACMENT["MAIN_JOUR_ID"]);
	}



	$year = "";
	$i = 0;

	$first = true;

	?>
	<div class="row">
		<div class="col">
			<?php
			if ($_SESSION[lang]!='/en') {
				if (!empty($_TPL_REPLACMENT["ARCHIVE_CONTENT"])) {
					echo $_TPL_REPLACMENT["ARCHIVE_CONTENT"];
				}
			} else {
				if (!empty($_TPL_REPLACMENT["ARCHIVE_CONTENT_EN"])) {
					echo $_TPL_REPLACMENT["ARCHIVE_CONTENT_EN"];
				}
			}
			?>
		</div>
	</div>
	<?php

	echo '<div class="row">';
	foreach ($rows as $row) {
		if ($_SESSION["lang"] == '/en' && !empty($row["page_name_en"]))
			$page_name_number_en = $row["page_name_en"];
		else
			$page_name_number_en = $row["page_name"];


		if ($year != $row["year"]) {
			if ($first) {
				$first = false;
			} else {
				echo "</div>";
			}

			echo "<div class='col-12 col-md-3 col-sm-4 mb-3 text-center'><h4>" . $row["year"] . "</h4>";
			$year = $row["year"];
			$i = 0;
		}

		echo "<div>";
		if ($row["page_name"] < 1) $sp = "&nbsp;&nbsp;"; else $sp = "";

		$translatedName = "";
		if(!empty($row['special_issue_name_en']) && $_SESSION['lang']!='/en') {
			$translatedName .= " [{$row['special_issue_name_en']}]";
		}

		$vol_pos = strripos($row["page_name"], "т.");

		if ($vol_pos === false) {
			if ($_TPL_REPLACMENT["MAIN_JOUR_ID"] == 1665) {
				if ($row["page_name"] == 'Ежегодник') {
					if ($_SESSION["lang"] == "/en")
						echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . "> " .
							"Yearbook" . $translatedName . ",&nbsp;" . $row["year"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					else
						echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . "> " .
							$row["page_name"] . $translatedName . ",&nbsp;выпуск&nbsp;" . $row["year"] . "&nbsp;года</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				} else {
					echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
						$txt1 . $sp . $page_name_number_en . $translatedName . "&nbsp;" . $row["year"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			} elseif ($_TPL_REPLACMENT["MAIN_JOUR_ID"] == 1671 || $_TPL_REPLACMENT["MAIN_JOUR_ID"] == 1666) {
				echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
					$page_name_number_en . $translatedName . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			} else {
				if ($_TPL_REPLACMENT["MAIN_JOUR_ID"] == 1668) {
					if (!is_numeric($page_name_number_en)) {
						$txt1 = '';
						$sp = '';
					} else {
						if ($_SESSION["lang"] != '/en')
							$txt1 = '№ ';
						else
							$txt1 = 'No ';
					}
					if ($row["page_name"] == 'Ежегодник' && $_SESSION["lang"] == '/en')
						echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
							$txt1 . $sp . "Yearbook" . $translatedName . "&nbsp;" . $row["year"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					else {
						echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
							$txt1 . $sp . $page_name_number_en . $translatedName . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				} else {
					if ($row["page_name"] == 'Ежегодник' && $_SESSION["lang"] == '/en')
						echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
							$txt1 . $sp . "Yearbook" . $translatedName . "&nbsp;" . $row["year"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					else {
						if ($_TPL_REPLACMENT["MAIN_JOUR_ID"] != 1667)
							echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
								$txt1 . $sp . $page_name_number_en . $translatedName . ",&nbsp;" . $row["year"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
						else
							echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
								$sp . $page_name_number_en . $translatedName . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					}
				}
			}
		} else {
			$volume = substr($row["page_name"], $vol_pos);
			if ($_SESSION["lang"] == '/en')
				$volume = str_replace("т.", "vol.", $volume);
			$number = explode(",", $row["page_name"]);
			if ($row["page_name"] == 'Ежегодник' && $_SESSION["lang"] == '/en')
				echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
					$txt1 . $sp . "Yearbook" . $translatedName . "&nbsp;" . $row["year"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
			else
				echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["ARCHIVE_ID"] . "&article_id=" . $row["jid"] . ">" .
					$volume . ", " . $txt1 . $sp . $number[0] . $translatedName . ",&nbsp;" . $row["year"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		echo '</div>';
		$i++;
		//}

	}
	if (!$first) {
		echo '</div>';
	}
	echo '</div>';


//echo $_TPL_REPLACMENT[BOOK];
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
}
?>
