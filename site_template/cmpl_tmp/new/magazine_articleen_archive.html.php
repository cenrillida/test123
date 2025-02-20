<?
global $DB,$_CONFIG, $site_templater;

   $suff='&en';
if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
	$txt1="No.&nbsp;";$txt2='Topic';
} else {
	if ($_SESSION[lang] != "/en") {
		$txt1="№&nbsp;";$txt2='Тема';
	} else {
		$txt1="No.&nbsp;";$txt2='Topic';
	}
}


 //Архиы номеров

  $pg=new Magazine();

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

  $rows=$pg->getMagazineAllPublic();

$year="";
$i=0;

$first = true;

echo '<div class="row">';
  foreach($rows as $row)
  {
  	if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
		$articles = $pg->getEnArticlesByNumber($row[jid]);
	}
  	else {
  		$articles = $pg->getAllArticlesByNumber($row[jid]);
	}
  	if(empty($articles)) {
  		continue;
	}

	  $rowj=$DB->select("SELECT page_id,page_name AS journal,page_name_en AS journal_en FROM adm_magazine WHERE page_id=".$row[journal]);

if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
	if (!empty($row[page_name_en]))
		$page_name_number_en = $row[page_name_en];
	else
		$page_name_number_en = $row[page_name];
} else {
	if($_SESSION[lang]!="/en") {
		$page_name_number_en = $row[page_name];
	} else {
		if (!empty($row[page_name_en]))
			$page_name_number_en = $row[page_name_en];
		else
			$page_name_number_en = $row[page_name];
	}
}


	  if ($year!=$row[year])
	  {
		  if($first) {
			  $first = false;
		  } else {
			  echo "</div>";
		  }

	     echo "<div class='col-12 col-md-12 col-sm-12 mb-3'><h4>".$row[year]."</h4>";
		 $year=$row[year];
		 $i=0;
	  }

//
	  echo "<div>";
		if ($row[page_name]<1) $sp="&nbsp;&nbsp;";else $sp="";
		
		$vol_pos = strripos($row[page_name], "т.");
		
		if ($vol_pos === false) {


                    if ($row[page_name] == 'Ежегодник' && $_SESSION[lang] == '/en')
                        echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . ">" .
                            $txt1 . $sp . "Yearbook" . "&nbsp;" . $row[year] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    else {
                        if ($_SESSION[jour_url] != "WER")
                            echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . "><b>" .
                                $txt1 . $sp . $page_name_number_en . ",&nbsp;" . $row[year] . "</b></a>&nbsp;&nbsp;&nbsp;&nbsp;";
                        else
                            echo "<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $_TPL_REPLACMENT[NUMBER_ID] . "&jid=" . $row[jid] . "><b>" .
                                $sp . $page_name_number_en . "</b></a>&nbsp;&nbsp;&nbsp;&nbsp;";
                    }


	   }
	   else
	   {
		$volume=substr($row[page_name], $vol_pos);
	   if($_SESSION[lang]=='/en')
		$volume=str_replace("т.", "vol.",$volume);
		$number=spliti(",",$row[page_name]);
	   if($row[page_name]=='Ежегодник' && $_SESSION[lang]=='/en')
		echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1.$sp."Yearbook"."&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
	   else
		echo"<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $volume.", ".$txt1.$sp.$number[0].",&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
	   }



	   echo '</div>';
	   $i++;
	  //}

	  foreach ($articles as $article) {
		  $rowas = $pg->getArticleById($article["page_id"]);
		  foreach ($rowas as $k=>$row) {

			  if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
				  $people0 = $pg->getAutorsEn($row[people]);
			  } else {
				  if ($_SESSION[lang] != "/en") {
					  $people0 = $pg->getAutors($row[people]);
				  } else {
					  $people0 = $pg->getAutorsEn($row[people]);
				  }
			  }
			  if(empty($row['people'])) {
			  	continue;
			  }

			  $avt_list="";
			  $avt_list_short="";
			  $avt_list_short_side="";
			  foreach($people0 as $people)
			  {
				  if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
					  if (!empty($people[id]) && $people[id] != '488' && $people[id] != '270') {
						  $fios = $people[fio];
						  if ($_SESSION[jour_url] != 'god_planety') {
							  if ($people[full_name_echo] == 1) {
								  $fios = $people[name_surname];
							  } else {

								  $fios = substr(mb_stristr($people[fioshort], " "), 1, 1) . ". " . mb_stristr($people[fioshort], " ", true);
								  $people[fioshort_side] = mb_stristr($people[fioshort], " ", true) . " " . substr(mb_stristr($people[fioshort], " "), 1, 1) . ".";

							  }
						  }
						  $avt_list .= $fios . ", ";
						  if ($people[full_name_echo] == 1) {
							  $avt_list_short .= $people[name_surname] . ", ";
							  $avt_list_short_side .= $people[name_surname] . ", ";
						  } else {
							  $avt_list_short .= $people[fioshort_side] . ", ";
							  $avt_list_short_side .= $people[fioshort] . ", ";
						  }

					  }
				  } else {
					  if (!empty($people[id]) && $people[id] != '488' && $people[id]!='270')
					  {
						  $fios=$people[fio];
						  if($_SESSION[jour_url]!='god_planety')
						  {
							  if ($_SESSION[lang]!='/en')
							  {
								  $fios=$people[fioshort];
							  }
							  else
							  {
								  $fios=substr(mb_stristr($people[fioshort]," "),1,1).". ".mb_stristr($people[fioshort]," ",true);
								  $people[fioshort_side]=mb_stristr($people[fioshort]," ",true)." ".substr(mb_stristr($people[fioshort]," "),1,1).".";
							  }
						  }
						  $avt_list.=$fios.", ";
						  $avt_list_short.=$people[fioshort_side].", ";
						  $avt_list_short_side.=$people[fioshort].", ";
					  }
				  }

			  }
			  if (!empty($avt_list)) $avt_list=substr($avt_list,0,-2);
			  if (!empty($avt_list_short)) $avt_list_short=substr($avt_list_short,0,-2);
			  if (!empty($avt_list_short_side)) $avt_list_short_side=substr($avt_list_short_side,0,-2);


			  if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
				  if(!empty($row[number_en])) {
					  $row[number] = $row[number_en];
				  }
			  } else {
				  if ($_SESSION[lang] != "/en") {
				  } else {
					  if(!empty($row[number_en])) {
						  $row[number] = $row[number_en];
					  }
				  }
			  }



			  echo "<div class='py-2'>";
			  if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
				  echo $avt_list_short . " <a href=\"" . $_SESSION[lang] . "/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$article["page_id"]."\">" . $article["name_en"] . "</a>. " . $rowj[0]['journal_en'] . ", " . $row[year] . ", " . $txt1 . " " . str_replace("т.", "vol.", $row[number]);
			  } else {
				  if ($_SESSION[lang] != "/en") {
					  echo $avt_list_short . " <a href=\"" . $_SESSION[lang] . "/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$article["page_id"]."\">" . $article["name"] . "</a>. " . $rowj[0]['journal'] . ", " . $row[year] . ", " . $txt1 . " " . str_replace("т.", "vol.", $row[number]);
				  } else {
					  echo $avt_list_short . " <a href=\"" . $_SESSION[lang] . "/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$article["page_id"]."\">" . $article["name_en"] . "</a>. " . $rowj[0]['journal_en'] . ", " . $row[year] . ", " . $txt1 . " " . str_replace("т.", "vol.", $row[number]);
				  }
			  }




			  if($_TPL_REPLACMENT["ENGLISH_ONLY"]==1) {
				  if (!empty($row[pages]))
					  echo ", " . "pp." . " " . $row[pages];
			  } else {
				  if ($_SESSION[lang] != "/en") {
					  if (!empty($row[pages]))
						  echo ", " . "cc." . " " . $row[pages];
				  } else {
					  if (!empty($row[pages]))
						  echo ", " . "pp." . " " . $row[pages];
				  }
			  }

			  if (!empty($row[doi])) echo ". <a href=\"https://doi.org/" . $row[doi] . "\">https://doi.org/" . $row[doi] . "</a>";
			  echo "</div>";
		  }
	  }

  }
  if(!$first) {
  	echo '</div>';
  }
  echo '</div>';


//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
