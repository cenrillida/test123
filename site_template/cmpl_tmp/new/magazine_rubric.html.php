<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[year]=(int)$DB->cleanuserinput($_REQUEST[year]);
$_REQUEST[rub]=$DB->cleanuserinput($_REQUEST[rub]);
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
$_REQUEST[jid]=(int)$DB->cleanuserinput($_REQUEST[jid]);
$_REQUEST[jj]=(int)$DB->cleanuserinput($_REQUEST[jj]);

if ($_SESSION["lang"]=='/en')
{
   $suff="_en";
   $numname='No ';
}
   else 
   {   
	$suff="";   
	$numname='№ ';
	}
 //Статьи в одной рубрике


  $pg=new Magazine();
  $where=1;
  if (!empty($_REQUEST[id]))
  {
	 $where="a.page_id=".(int)$_REQUEST[id];
  }	
  if (!empty($_REQUEST[rub]))
  {
	 $where="n.name LIKE '".str_replace("_"," ",$_REQUEST[rub])."%'";
  }	

if (empty($_REQUEST[rub]))
{	
	
	if ($_SESSION["lang"]!='/en')
	$rows=$DB->select("SELECT a.page_id,CONCAT('№ ',n.page_name,' ',n.year) AS title,
					IFNULL(a.name,a.page_name) AS rubric,n.journal 
                     FROM  adm_article AS a
                     INNER JOIN adm_article AS n ON n.page_id=a.page_parent
                     INNER JOIN adm_magazine AS m ON m.page_id=n.journal
                     WHERE ".$where);
	else
	$rows=$DB->select("SELECT a.page_id,CONCAT('No ',n.name_en,' ',n.year) AS title,a.name_en AS rubric,n.journal 
                     FROM adm_article AS a 
                     INNER JOIN adm_article AS n ON n.page_id=a.page_parent
                     INNER JOIN adm_magazine AS m ON m.page_id=n.journal
                     WHERE ".$where);
	$whererub="IFNULL(r.name".$suff.",r.page_name) ='". $rows[0][rubric]."'";	
    $_REQUEST[rub]=	$rows[0][rubric];

}
else
{
	$rub = str_replace("_"," ",$_REQUEST[rub]);
  
   $rows=$DB->select("SELECT page_id,IFNULL(name".$suff.",page_name) AS rubric,journal FROM adm_article
                      WHERE  date_public<>'' AND page_template='jrubric' AND journal=".$_SESSION[jour_id]." 
					  AND IFNULL(name".$suff.",page_name) LIKE ?",$rub);
 //print_r($rows);
   $whererub="";
   foreach($rows as $row)
   {
				$whererub="IFNULL(r.name".$suff.",r.page_name)='". $row[rubric]."' OR ";
   
   }
     if (!empty($whererub)) $whererub="(".substr($whererub,0,-4).")";
	 }					 

$jid=$rows[0][journal];
$site_templater->appendValues(array("TITLE" => 'Рубрика: '.str_replace('_',' ',$_REQUEST[rub])));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
 echo "<br />"; 
  if ($_SESSION["lang"]!='/en')
  {
	echo "<a href=".$_SESSION["lang"]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT['RUBRICS_ID'].">К списку рубрик</a><br />";
	// echo "<div class='jrubric'>Статьи в рубрике: <br />".$rows[0][rubric]."</div><br />";
  }
  else	
  {
	echo "<a href=".$_SESSION["lang"]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT['RUBRICS_ID'].">Rubrics List</a><br />";
	echo "<div class='jrubric'>Articles in Rubric: <br />".$rows[0][rubric]."</div><br />";
	
  }
echo "<br />"; 
 //  $rows=$pg->getChildsArticle($rows[0][page_id]);
  $pageid_jour=$rows[0][page_id];
//  $rows=$pg->getMagazineNumber($rows[0][page_id]);
//   $rows=$pg->appendContentArticle($rows);

//// номера журнала!!!!!!

//echo $whererub;
if (empty($whererub)) $whererub=1;
if (empty($jid)) $jid=49;
$rows=$DB->select("SELECT a.page_id,a.name".$suff.",a.people,a.year,a.number,a.page_template 
					FROM 	adm_article AS a
                   INNER JOIN adm_article AS r ON r.page_id=a.page_parent  AND ".
				   $whererub.
				  " AND r.page_template='jrubric' AND r.page_status=1 ".
				   " WHERE a.journal=".$jid." AND a.page_template='jarticle' AND a.date_public <> '' 
				   AND  a.page_status=1 
				   ORDER BY year DESC,a.date_public DESC, number DESC,a.page_position,a.name".$suff);
				   
$year=0;$number=0;
  foreach($rows as $k=>$row)
  {
      if ($year!=$row[year])
	  {
	     echo "<h3>".$row[year]."</h3>";
		 $year=$row[year];
		 $number=0;
	  }
  	  if ($number!=$row[number])
      {
		echo "<b>".$numname.$row[number]."-".$row[year]."</b><br />";
	    $number=$row[number];

      }	  
  	  switch($row[page_template])
      {
      	case "jnumber":
      	   echo "<div class='jsublect'>Тема номера:<br />".substr(substr($row[content][SUBJECT],0,-4),3)."</div>";
      	   $pageid_jour=$row[page_id];
      	   break;
      	case "jrubric":

		   if (!($row[page_id]==$pageid_jour))

	      	   echo "<div class='jrubric2'><a href=".$_SESSION["lang"]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".$row[page_name]."</a></div>";

      	   break;
      	case "jarticle" :
           echo "<div class='jarticle'>";
		   if ($_SESSION["lang"]!='/en')
			$people0=$pg->getAutors($row[people]);
			else $people0=$pg->getAutorsEn($row[people]);
      	   echo "<div class='autors'>";
		   $avt22='';
      	   foreach($people0 as $people)
      	   {
      	      if (!empty($people[fio]) && $people[fio]!='Круглый ст . ' && $people[fio]!='Round Table of the ‘Polis’ Journal' && $people[fio]!='Информация . ' && $people[fio]!='Information.'
			  && $people[fio]!="От редакци . " && $people[fio]!="Editorial Introduction.")
			  $avt22.=" <a href=".$_SESSION["lang"]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id].
			//  "&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].
			  ">".$people[fio]."</a>,"; //.$people[work].",".$people[mail1]."";
			  if ($people[fio]=='Круглый ст . ') $avt22.='Круглый стол: ';
			  if ($people[fio]=='Round Table of the ‘Polis’ Journal') echo 'Round Table of the ‘Polis’ Journal: ';
      	   }
		   if (!empty($avt22)) $avt22=substr($avt22,0,(strlen($avt22)-1));
		   echo $avt22;
      	   echo "</div>";
      	   echo "<div class='name'><a href=".$_SESSION["lang"]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].">".$row['name'.$suff]."</a></div>";
      	   echo "</div>";
           break;
      }
	}



//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
