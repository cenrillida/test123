<?
// Страница оглавления
global $DB,$_CONFIG, $site_templater;
$pg=new Magazine();

if ($_SESSION[lang]=='/en')
   $suff='_en';
 else  
   $suff='';
//if (empty($_REQUEST[jid])) $_REQUEST[jid]=$_SESSION[jour_id];   
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[jid]=(int)$DB->cleanuserinput($_REQUEST[jid]);
$_REQUEST[jj]=(int)$DB->cleanuserinput($_REQUEST[jj]);
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
if (empty($_REQUEST[jid]) ) //Найти свежий номер журнала
{

  $journalId0=$pg->getMagazineJId($_REQUEST[page_id]);

if (empty($journalId0)) $journalId0[0][journal]=$_SESSION[jour_id]; 
  $jid0=$pg->getLastMagazineNumber($journalId0[0][journal]);
 
  if (!empty($jid0[0][journal]))
  {
	$logo=$DB->select("SELECT logo FROM adm_magazine  WHERE page_id=".$jid0[0][journal]);
 // print_r($logo);
	$_REQUEST[jid]=$jid0[0][page_id];
	$_REQUEST[jj]=$jid0[0][journal];
  }	

}
else
    $logo=$DB->select("SELECT logo FROM adm_magazine  WHERE page_id=".((int)$_REQUEST[jid]+1));
// Сформировать название номера
//echo $_REQUEST[jid];
if (!empty($_REQUEST[jid]))
{

if ($_SESSION[lang]!="/en") {
	if($_SESSION[jour_url]!="WER") {
		if($_SESSION[jour_url]!="meimo" && $_SESSION[jour_url]!="RNE")
$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,m.page_name AS journal_name,issn,a.page_name AS number,a.year,
					 CONCAT(m.page_name,'. № ',a.page_name,' ',a.year) AS title,
					 CONCAT(m.page_name,'. ',a.page_name,', ',a.year) AS title_cut,
					 CONCAT(m.page_name,'. ',a.page_name,', вып. ',a.year) AS title_cut_god_planety
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=".(int)$_REQUEST[jid]);
		else
			$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,m.page_name AS journal_name,issn,a.page_name AS number,a.year,
					 CONCAT(m.page_name,'. № ',a.page_name,', ',a.year) AS title,
					 CONCAT(m.page_name,'. ',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=".(int)$_REQUEST[jid]);
}
else
	$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,m.page_name AS journal_name,issn,a.page_name AS number,a.year,
					 CONCAT(a.page_name, '. Ежегодник') AS title,
					 CONCAT(m.page_name,'. ',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=".(int)$_REQUEST[jid]);
}
else {
	if($_SESSION[jour_url]!="meimo") {
		if($_SESSION[jour_url]!="WER")
        $rowsj = $DB->select("SELECT
                     m.page_id AS ppp,m.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year,
					 CONCAT(m.page_name_en,'. <br />No. ',a.page_name,' ',a.year) AS title,
					 CONCAT(m.page_name_en,'. <br />No. ',a.page_name_en,' ',a.year) AS title_en,
					 CONCAT(m.page_name_en,'. <br />',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=" . (int)$_REQUEST[jid]);
		else
		$rowsj = $DB->select("SELECT
				 m.page_id AS ppp,m.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year,
				 CONCAT(m.page_name_en,'. <br />No. ',a.page_name,' ',a.year) AS title,
				 a.page_name_en AS title_en,
				 CONCAT(m.page_name_en,'. <br />',a.page_name,' ',a.year) AS title_cut
				 FROM adm_article AS a
				 INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				WHERE a.page_id=" . (int)$_REQUEST[jid]);
    }
else
	$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,m.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year,
					 CONCAT(m.page_name_en,'. No. ',a.page_name,', ',a.year) AS title,
					 CONCAT(m.page_name_en,'. No. ',a.page_name_en,', ',a.year) AS title_en,
					 CONCAT(m.page_name_en,'. <br />',a.page_name,' ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=".(int)$_REQUEST[jid]);
}

if($_SESSION[jour_url]=="REBQUE") {
	if($_SESSION[lang]!="/en") {
		$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,m.page_name AS journal_name,issn,a.page_name AS number,a.year,
					 CONCAT(m.page_name,'. <br />№ ',a.page_name,', ',a.year) AS title,
					 CONCAT(m.page_name,'. <br />',a.page_name,', ',a.year) AS title_cut,
					 CONCAT(m.page_name,'. <br />',a.page_name,', вып. ',a.year) AS title_cut_god_planety
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=".(int)$_REQUEST[jid]);
	} else {
		$rowsj = $DB->select("SELECT
                     m.page_id AS ppp,m.page_name_en AS journal_name,issn,a.page_name AS number, a.page_name_en AS number_en,a.year,
					 CONCAT(m.page_name_en,'. <br />No. ',a.page_name,', ',a.year) AS title,
					 CONCAT(m.page_name_en,'. <br />No. ',a.page_name_en,', ',a.year) AS title_en,
					 CONCAT(m.page_name_en,'. <br />',a.page_name,', ',a.year) AS title_cut
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=" . (int)$_REQUEST[jid]);
	}
}

}
if (empty($_REQUEST[jj])) $_REQUEST[jj]=$rowsj[0][ppp];

$vol_pos = strripos($rowsj[0][number], "т.");
if ($vol_pos === false) {
					if($_SESSION[jour_url]=="god_planety" || $_SESSION[jour_url]=="oprme" || $_SESSION[jour_url]=="Russia-n-World" || $_SESSION[jour_url]=="SIPRI")
					{
						if(is_numeric(substr($rowsj[0][number], 1))) {

							$site_templater->appendValues(array("TITLE" => $rowsj[0][title]));
					 		$site_templater->appendValues(array("TITLE_EN" => $rowsj[0][title]));
						}
						else
						{
							if($_SESSION[jour_url]=="SIPRI") {
                                $site_templater->appendValues(array("TITLE" => $rowsj[0][number]));
                                $site_templater->appendValues(array("TITLE_EN" => str_replace("Ежегодник", "Yearbook", $rowsj[0][number_en])));
							}
                            elseif($_SESSION[jour_url]=="Russia-n-World") {

								$site_templater->appendValues(array("TITLE" => $rowsj[0][number]));
								$site_templater->appendValues(array("TITLE_EN" => $rowsj[0][number_en]));

                                //$site_templater->appendValues(array("TITLE" => str_replace("мир.", "мир ".($rowsj[0][year]+1).".", $rowsj[0][journal_name])));
                                //$site_templater->appendValues(array("TITLE_EN" => str_replace("World.", "World ".($rowsj[0][year]+1).".", $rowsj[0][journal_name])));
                            }
							else {
								if($_SESSION[jour_url]=="god_planety")
									$site_templater->appendValues(array("TITLE" => $rowsj[0][title_cut_god_planety]));
								else
                                	$site_templater->appendValues(array("TITLE" => $rowsj[0][title_cut]));
                                $site_templater->appendValues(array("TITLE_EN" => str_replace("Ежегодник", "Yearbook", $rowsj[0][title_cut])));
                            }
						}
					}
					else
					{
					 $site_templater->appendValues(array("TITLE" => $rowsj[0][title]));
					 if(!empty($rowsj[0][number_en]))
					 	$site_templater->appendValues(array("TITLE_EN" => $rowsj[0][title_en]));
					 else
					 	$site_templater->appendValues(array("TITLE_EN" => $rowsj[0][title]));
					}
					}
else
{

	$volume=substr($rowsj[0][number], $vol_pos);
	   if($_SESSION[lang]=='/en')
		$volume=str_replace("т.", "Vol.",$volume);
		else
		$volume=str_replace("т.", "Т.",$volume);
		$number=spliti(",",$rowsj[0][number]);
		if($_SESSION[jour_url]!="WER")
			$site_templater->appendValues(array("TITLE" => $rowsj[0][journal_name].". ".$rowsj[0][year].". ".$volume.", № ".$number[0]));
		else
			$site_templater->appendValues(array("TITLE" => $rowsj[0][journal_name].". ".$volume.", ".$number[0]));
		$site_templater->appendValues(array("TITLE_EN" => $rowsj[0][journal_name].". ".$rowsj[0][year].". ".$volume.", No. ".$number[0]));
}
if($_GET[debug_book]==1) {
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.magazine_page.html");
}
else {
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");
}
if (!empty($_REQUEST[jj]))
{
//print_r($rowsj);
// echo  "&&&".$rowsj[0][title]."***";

$pparent=$DB->select("SELECT page_parent FROM adm_pages WHERE page_id=".$_REQUEST[page_id]);
if ($_SESSION[lang]!='/en')
	echo "<p align=right><a href=/jour/".$_SESSION[jour_url]."/index.php?page_id=".$pparent[0][page_parent].">Архив номеров</a></p>";
else
	echo "<p align=right><a href=/en/jour/".$_SESSION[jour_url]."/index.php?page_id=".$pparent[0][page_parent].">Archive numbers</a></p>";
	
  //echo "<a hidden=true src=bbb>".$_REQUEST[jid]."</a>";

ini_set('memory_limit', '512M');

    if ($_SESSION[lang]!='/en')
		$rows=$pg->getMagazineNumber($_REQUEST[jid]);
	else
		$rows=$pg->getMagazineNumberEn($_REQUEST[jid]);

// print_r($rows);

//    $rows=$pg->getMagazineNumber($_REQUEST[jid]); 	
    $rows=$pg->appendContentArticle($rows);

  
//  echo "<br /><br /><hr />";print_r($rows);
    
  $pageid_jour=0;
  if (count($rows)==0 && $_SESSION[lang]=="/en") echo "Does not exist English version";
  foreach($rows as $k=>$row)
  {
//    echo "<br />";print_r($row); 
	
	 if($_SESSION[lang]=='/en')
    {
  		     if(!empty($row[content][SUBJECT_EN])) $row[content][SUBJECT]=$row[content][SUBJECT_EN];
			 if(!empty($row[content][RUBRIC_EN])) $row[content][RUBRIC]=$row[content][RUBRIC_EN];
			 if(!empty($row[name_en])) $row[name]=$row[name_en];
			 if(!empty($row[content][CONTENT_EN])) $row[content][CONTENT]=$row[content][CONTENT_EN];
	}
//echo "<br />";print_r($row);
    //echo "<a hidden=true src=aaa>".$row[page_template]."</a>";
	switch($row[page_template])
      {
      	

		case "jnumber":
 //    print_r($row);  

		if(!empty($row[content][SUBJECT])&& $row[content][SUBJECT]<>"<p>&nbsp;</p>")
			if(false)
			{
				if ($_SESSION[lang]!='/en')
					echo "<div class='jsublect'>Тема номера:<br />".substr(substr($row[content][SUBJECT],0,-4),3)."</div>";
				else
					echo "<div class='jsublect'>Topics of the Issue:<br />".substr(substr($row[content][SUBJECT],0,-4),3)."</div>";
			}
			else
			{
				if ($_SESSION[lang]!='/en')
					echo "<div class='jsublect'>".$row[content][SUBJECT]."</div>";
				else
					echo "<div class='jsublect'>".$row[content][SUBJECT]."</div>";
			}
//      	    if (!empty($logo[0][logo]))
//			    echo "<p>".str_replace("<img ","<img align=left hspace=10 ",str_replace("</p>","",str_replace("<p>",'',($logo[0][logo]))));
			if(false)
			{
			if($_SESSION[lang]!='/en')
				$annot="<h3>Аннотация номера:</h3>";
				else
				$annot="<h3>Аbstract:</h3>";
			}
			else
				$annot="";
			echo 	$annot.$row[content]['CONTENT']."<hr />";
            if (!empty($row[content][FULL_TEXT]))
			{
				if($_SESSION[jour_url]!='meimo') {
					echo '<div style="font-size: 19px;">';
				    if ($_SESSION[lang]!='/en')
						echo "<img align=absmiddle src=/files/Image/pdf.gif>&nbsp;&nbsp;".
						str_replace("</p>","",str_replace("<p>","",$row[content][FULL_TEXT]));
					else
					   echo "<img align=absmiddle src=/files/Image/pdf.gif>&nbsp;&nbsp;".
						str_replace("</p>","",str_replace("<p>","",str_replace('Полный текст','Full Text',str_replace('Титул и содержание', 'Title and content', $row[content][FULL_TEXT]))));
					echo '</div><br />';
				}
				else {
					if(($_SESSION['meimo_authorization']==1) || $row[content][FULL_TEXT_OPEN]==1) {
                        if(strpos($row[content][FULL_TEXT],"https:")==0 && strpos($row[content][FULL_TEXT],"http:")==0)
                        {
                            $row[content][FULL_TEXT]=str_replace("/files/File/","https://".$_SERVER[HTTP_HOST]."/files/File/",$row[content][FULL_TEXT]);

                        }
                        $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[-A-Z0-9+&@#\/%?= ()~_|!:,.;]\.pdf/i";
                        preg_match_all($filter,$row[content][FULL_TEXT],$res);
                        //  print_r($res); echo "<br />";echo "<br />";
                        //  echo $res[0][0]." ".count($res)."**";
                        for($i=0;$i<=count($res);$i++)
                        {
                            $row[content][FULL_TEXT]=str_replace($res[0][$i],$_SESSION[lang]."/jour/meimo/index.php?page_id=1248&file=".str_replace(' ','^',$res[0][$i]),$row[content][FULL_TEXT]);
                        }
                        echo '<div style="font-size: 19px;">';
					    if ($_SESSION[lang]!='/en')
							echo "<img align=absmiddle src=/files/Image/pdf.gif>&nbsp;&nbsp;".
							str_replace("</p>","",str_replace("<p>","",$row[content][FULL_TEXT]));
						else
						   echo "<img align=absmiddle src=/files/Image/pdf.gif>&nbsp;&nbsp;".
							str_replace("</p>","",str_replace("<p>","",str_replace('Полный текст','Full Text',str_replace('Титул и содержание', 'Title and content', $row[content][FULL_TEXT]))));
                        echo '</div><br />';
					}
				}
			
			}
			if ($_SESSION[lang]!="/en")
				echo "<div class=jrubric><h4 style='font-weight: bold'>СОДЕРЖАНИЕ:</h4><br /></div>";
			else	
				echo "<div class=jrubric><h4 style='font-weight: bold'>CONTENTS:</h4><br /></div>";

			$pageid_jour=$row[page_id];
      	   break;
      	case "jrubric":
      	   if (empty($row[name])) $row[name]=$row[page_name];
		   if ($row[page_parent]==$_REQUEST[jid])
	      	   echo "<div class='jrubric'><h5 style='font-weight: bold'><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".mb_strtoupper($row[name],'CP1251')."</a></h5></div>";
           else
	     	   echo "<div class='jrubric2 my-3'><h6><a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".$row[name]."</a></h6></div>";

      	   break;
      	case "jarticle" :
            if ($_SESSION[lang]!='/en') {
                if($row[page_status]==0) {
                	break;
				}
			} else {
            	if($row[page_status_en]==0) {
            		break;
				}
			}
 //        echo "<br />";print_r($row);
      	   echo "<div class='jarticle'>";
      	   if ($_SESSION[lang]!='/en')
		   {
				$people0=$pg->getAutors($row[people]); 
				$avtbib=$pg->getAutorsBib($row[people]);
		   }
		   else
           {		   
				$people0=$pg->getAutorsEn($row[people]); 
				$avtbib=$pg->getAutorsBibEn($row[people]);
			}	
      	   $avtList='';
      	   foreach($people0 as $people)
      	   {
      	      if (!empty($people[id]))
      	      {

			  $fios=$people[fio];
			  if($_SESSION[jour_url]=='meimo' || $_SESSION[jour_url]=='RNE')
			  {
                  if($people[full_name_echo]==1) {
                      $fios = $people[name_surname];
                  } else {
                      if ($_SESSION[lang] != '/en') {
                          $fios = $people[fioshort];
                      } else {
                          $fios = substr(mb_stristr($people[fioshort], " "), 1, 1) . ". " . mb_stristr($people[fioshort], " ", true);
                      }
                  }

			}
			  if($_SESSION[jour_url]=='god_planety') {
				  $fios = $people[name_surname];
			  }
                  if($_SESSION[lang]=='/en' && $_SESSION[jour_url]=='PMB') {
                      $fios = preg_replace("/[ ]/", ", ", $fios, 1);
                  }
//      	      	echo "<br />";print_R($people);
      	      if(substr($people[fio],0,8)!='Редакция' && substr($people[fio],0,8)!=false)
      	      {
      	      if ($people[otdel]!='Умершие сотрудники')
      	          $avtList.="<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a".
      	           "&jid=".$_REQUEST[jid].
      	          ">".$fios."</a>, ";
      	      else

       	           $avtList.="<a style='border:1px solid gray;' href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a".
       	           "&jid=".$_REQUEST[jid].
       	           ">".$fios."</a>, "; //.$people[work].",".$people[mail1]."";
              }
              }
           }
          echo "<div class='autors'>";
           $avtList=substr($avtList,0,-2);
           echo $avtList;
      	   echo "</div>";
           $pages_prefix = "с. ";
           if($_SESSION[lang]=='/en')
              $pages_prefix = "p. ";

           //if (!empty($row[contents]) && $row[contents]!="<p>&nbsp;</p>") $img="<img src=/files/Image/internet_explorer.png >"; else $img='';
      	   $img="";

		   if (!empty($row[name_black])) {
			   $row[name] = str_replace($row[name_black], "<span style=\"border: 1px solid black; padding: 0 3px;\">" . $row[name_black] . "</span>", $row[name]);
		   }
		   if (!empty($row[name_black_en])) {
			   $row[name] = str_replace($row[name_black_en], "<span style=\"border: 1px solid black; padding: 0 3px;\">" . $row[name_black_en] . "</span>", $row[name]);
		   }

			echo "<div class='name'>".$img."<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".$row[name]."</a> (".$pages_prefix.$row[pages].")";
//           echo $avtbib;print_r($row);
      	   if($_SESSION[lang]=='/en') {
      	   	if(!empty($row['link_en']) && $row['link_en']!='<p>&nbsp;</p>')
      	   		$row['link']=$row['link_en'];
      	   }
      	if($_SESSION[jour_url]!='meimo') {
	        if ($_SESSION[lang]=='/en') 
				echo "<div class='article_pdf'>".str_replace("</p>","",str_replace("<p>","",str_replace('Текст','Text',str_replace('Текст статьи','Text',str_replace('Титул и содержание', 'Title and content', $row['link'])))))."</div>";
			else
	           echo "<div class='article_pdf'>".str_replace("</p>","",str_replace("<p>","",$row['link']))."</div>";
			if(empty($row['link'])) {
				echo "<div class='article_pdf'>&nbsp;</div>";
			}
   		}
   		else {
   			if(($_SESSION['meimo_authorization']==1) || $row['fulltext_open']==1) {
                if(strpos($row['link'],"https:")==0 && strpos($row['link'],"http:")==0)
                {
                    $row['link']=str_replace("/files/File/","https://".$_SERVER[HTTP_HOST]."/files/File/",$row['link']);

                }
                if(strpos($row['link_en'],"https:")==0 && strpos($row['link'],"http:")==0)
                {
                    $row['link_en']=str_replace("/files/File/","https://".$_SERVER[HTTP_HOST]."/files/File/",$row['link_en']);

                }
                $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[-A-Z0-9+&@#\/%?= ()~_|!:,.;]\.pdf/i";
                preg_match_all($filter,$row['link'],$res);
                //  print_r($res); echo "<br />";echo "<br />";
                //  echo $res[0][0]." ".count($res)."**";
                for($i=0;$i<=count($res);$i++)
                {
                    $row['link']=str_replace($res[0][$i],$_SESSION[lang]."/jour/meimo/index.php?page_id=1248&file=".str_replace(' ','^',$res[0][$i]),$row['link']);
                }
   			if ($_SESSION[lang]=='/en')
				echo "<div class='article_pdf'>".str_replace("</p>","",str_replace("<p>","",str_replace('Текст','Text',str_replace('Текст статьи','Text',str_replace('Титул и содержание', 'Title and content', $row['link'])))))."</div>";
			else
	           echo "<div class='article_pdf'>".str_replace("</p>","",str_replace("<p>","",$row['link']))."</div>";
	   		}
	   		else
	   			echo "<div class='article_pdf'>&nbsp;</div>";
   		}
      	  echo "</div>";
      	  echo "</div>";
          $row[jtitle]=$rowsj[0][journal_name];
          $row[number]=$rowsj[0][number];
          $row[issn]=$rowsj[0][issn];
          $row[year]=$rowsj[0][year];
          $row[vid]=2;
 //         echo "<br /><br />____".$avtbib."<br />";print_r($row);

      	  $bib=new BibEntry();
		$aa=$bib->toCoinsMySQL($row,$avtbib);
		print_r($aa);
      	   break;
      }

	}
}

?>

    <?=@$_TPL_REPLACMENT["CONTENT"]?>


<?
//echo $_TPL_REPLACMENT[BOOK];

if($_GET[debug_book]==1) {
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.magazine_page.html");
}
else {
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
}
?>
