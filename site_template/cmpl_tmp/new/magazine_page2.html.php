<?
// Страница оглавления
global $DB,$_CONFIG, $site_templater;
$pg=new Magazine();

if (isset($_REQUEST[en]))
   $suff='&en';
 else  
   $suff='';
if (empty($_REQUEST[jid])) //Найти свежий номер журнала
{

  $journalId0=$pg->getMagazineJId($_REQUEST[page_id]);


  $jid0=$pg->getLastMagazineNumber($journalId0[0][journal]);
  
  $logo=$DB->select("SELECT logo FROM adm_magazine  WHERE page_id=".$jid0[0][journal]);
 // print_r($logo);
  $_REQUEST[jid]=$jid0[0][page_id];
  $_REQUEST[jj]=$jid0[0][journal];

}
else
    $logo=$DB->select("SELECT logo FROM adm_magazine  WHERE page_id=".($_REQUEST[jid]+1));
// Сформировать название номера
if ($_SESSION[lang]!="/en")
$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,m.page_name AS journal_name,issn,a.page_name AS number,a.year,
					 CONCAT(m.page_name,'. № ',a.page_name,' ',a.year) AS title
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=".(int)$_REQUEST[jid]);
else
$rowsj=$DB->select("SELECT
                     m.page_id AS ppp,m.page_name_en AS journal_name,issn,a.page_name AS number,a.year,
					 CONCAT(m.page_name_en,'. No ',a.page_name,' ',a.year) AS title
                     FROM adm_article AS a
                     INNER JOIN adm_magazine AS m ON m.page_id=a.journal
				    WHERE a.page_id=".(int)$_REQUEST[jid]);

//print_r($rowsj);

					 $site_templater->appendValues(array("TITLE" => $rowsj[0][title]));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
//print_r($rowsj);
// echo  "&&&".$rowsj[0][title]."***";
$pparent=$DB->select("SELECT page_parent FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
if ($_SESSION[lang]!='/en')
	echo "<p align=right><a href=/index.php?page_id=".$pparent[0][page_parent].">Архив номеров</a></p>";
else
	echo "<p align=right><a href=/index.php?page_id=".$pparent[0][page_parent].">Archive numbers</a></p>";
	
    if ($_SESSION[lang]!='/en')
		$rows=$pg->getMagazineNumber($_REQUEST[jid]);
	else
		$rows=$pg->getMagazineNumberEn($_REQUEST[jid]);
// print_r($rows);
    $rows=$pg->getMagazineNumber($_REQUEST[jid]); 	
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
    
	switch($row[page_template])
      {
      	

		case "jnumber":
 //    print_r($row);  

		if(!empty($row[content][SUBJECT])&& $row[content][SUBJECT]<>"<p>&nbsp;</p>")

      	    echo "<div class='jsublect'>Тема номера:<br />".substr(substr($row[content][SUBJECT],0,-4),3)."</div>";
      	    if (!empty($logo[0][logo])) 
			    echo "<p>".str_replace("<img ","<img align=left hspace=10 ",str_replace("</p>","",str_replace("<p>",'',($logo[0][logo]))));
			echo 	ltrim($row[content]['CONTENT'],"<p>")."<hr />";
            if (!empty($row[content][FULL_TEXT]))
			{
			    if ($_SESSION[lang]!='/en')
					echo "<img align=absmiddle src=/files/Image/pdf.gif>&nbsp;&nbsp;".
					str_replace("</p>","",str_replace("<p>","",$row[content][FULL_TEXT]))."<br />";
				else
				   echo "<img align=absmiddle src=/files/Image/pdf.gif>&nbsp;&nbsp;".
					str_replace("</p>","",str_replace("<p>","",str_replace('Полный текст','Full Text',$row[content][FULL_TEXT])))."<br />";
			
			}
			if ($_SESSION[lang]!="/en")
				echo "<div class=jrubric>СОДЕРЖАНИЕ:<br /></div>";
			else	
				echo "<div class=jrubric>CONTENT:<br /></div>";

			$pageid_jour=$row[page_id];
      	   break;
      	case "jrubric":
      	   if (empty($row[name])) $row[name]=$row[page_name];
		   if ($row[page_parent]==$pageid_jour)
	      	   echo "<div class='jrubric'><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".mb_strtoupper($row[name],'CP1251')."</a></div>";
           else
	     	   echo "<div class='jrubric2'><a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".$row[name]."</a></div>";

      	   break;
      	case "jarticle" :
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
//      	      	echo "<br />";print_R($people);
      	      if(substr($people[fio],0,8)!='Редакция')
      	      {
      	      if ($people[otdel]!='Умершие сотрудники')
      	          $avtList.="<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a".
      	           "&jid=".$_REQUEST[jid].
      	          ">".$people[fio2]."</a>, ";
      	      else

       	           $avtList.="<a style='border:1px solid gray;' href=".$_SESSION[lang]."/index.php?page_id".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&at=a".
       	           "&jid=".$_REQUEST[jid].
       	           ">".$people[fio2]."</a>, "; //.$people[work].",".$people[mail1]."";
              }
              }
           }
          echo "<div class='autors'>";
           $avtList=substr($avtList,0,-2);
           echo $avtList;
      	   echo "</div>";

           if (!empty($row[contents]) && $row[contents]!="<p>&nbsp;</p>") $img="<img src=/files/Image/internet_explorer.png >"; else $img='';
      	   echo "<div class='name'>".$img."<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".$row[name]."</a>";
//           echo $avtbib;print_r($row);
        if ($_SESSION[lang]=='/en')
			echo "<div class='article_pdf'>".str_replace("</p>","",str_replace("<p>","",str_replace('Текст статьи','Text',$row['link'])))."</div>";
		else
           echo "<div class='article_pdf'>".str_replace("</p>","",str_replace("<p>","",$row['link']))."</div>";
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


?>

    <?=@$_TPL_REPLACMENT["CONTENT"]?>


<?
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
