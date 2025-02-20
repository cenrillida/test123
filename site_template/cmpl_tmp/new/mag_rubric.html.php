<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[year]=(int)$DB->cleanuserinput($_REQUEST[year]);
$_REQUEST['article_id']=(int)$DB->cleanuserinput($_REQUEST['article_id']);

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


  $pg=new MagazineNew();
  $where=1;
  if (!empty($_REQUEST['article_id']))
  {
	 $where="a.page_id=".(int)$_REQUEST['article_id'];
  }

	
	if ($_SESSION["lang"]!='/en')
	$rows=$DB->select("SELECT a.page_id,CONCAT('№ ',n.page_name,' ',n.year) AS title,
					IFNULL(a.name,a.page_name) AS rubric,n.journal_new 
					 FROM  adm_article AS a
					 INNER JOIN adm_article AS n ON n.page_id=a.page_parent
					 WHERE ".$where);
	else
	$rows=$DB->select("SELECT a.page_id,CONCAT('No ',n.name_en,' ',n.year) AS title,a.name_en AS rubric,n.journal_new 
					 FROM adm_article AS a 
					 INNER JOIN adm_article AS n ON n.page_id=a.page_parent
					 WHERE ".$where);
	$whererub="IFNULL(r.name".$suff.",r.page_name) ='". $rows[0][rubric]."'";
	$_REQUEST[rub]=	$rows[0][rubric];


$site_templater->appendValues(array("TITLE" => 'Рубрика: '.str_replace('_',' ',$_REQUEST[rub])));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
 echo "<br />"; 
  if ($_SESSION["lang"]!='/en')
  {
	echo "<a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT['RUBRICS_ID'].">К списку рубрик</a><br />";
	// echo "<div class='jrubric'>Статьи в рубрике: <br />".$rows[0][rubric]."</div><br />";
  }
  else	
  {
	echo "<a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT['RUBRICS_ID'].">Rubrics List</a><br />";
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
$rows=$DB->select("SELECT a.page_id,a.name".$suff.",a.people,a.year,a.number,a.page_template 
					FROM 	adm_article AS a
                   INNER JOIN adm_article AS r ON r.page_id=a.page_parent  AND ".
				   $whererub.
				  " AND r.page_template='jrubric' AND r.page_status=1 ".
				   " WHERE a.journal_new=".$_TPL_REPLACMENT["MAIN_JOUR_ID"]." AND (a.page_template='jarticle' OR a.page_template='jarticle_2021') AND a.date_public <> '' 
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

	      	   echo "<div class='jrubric2'><a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$row[page_id].">".$row[page_name]."</a></div>";

      	   break;
      	case "jarticle" || "jarticle_2021" :
           echo "<div class='jarticle'>";
		   if ($_SESSION["lang"]!='/en')
			$people0=$pg->getAutors($row[people]);
			else {
				$secondField = false;
				if($_REQUEST['jj']==1669) {
					$secondField = true;
				}
				$people0=$pg->getAutorsEn($row['people'],$secondField);
			}
      	   echo "<div class='autors'>";
		   $avt22='';
      	   foreach($people0 as $people)
      	   {
				if($people['fio'] == 'Редакция . ') {
				 	$people['fio'] = 'Редакция';
				}
				if (!empty($people[fio]) && $people[fio]!='Круглый ст . ' && $people[fio]!='Round Table of the ‘Polis’ Journal' && $people[fio]!='Информация . ' && $people[fio]!='Information.'
				&& $people[fio]!="От редакци . " && $people[fio]!="Editorial Introduction.")
				$avt22.=" <a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT[AUTHOR_ID]."&id=".$people[id].">".$people[fio]."</a>,"; //.$people[work].",".$people[mail1]."";
				if ($people[fio]=='Круглый ст . ') $avt22.='Круглый стол: ';
				if ($people[fio]=='Round Table of the ‘Polis’ Journal') echo 'Round Table of the ‘Polis’ Journal: ';
      	   }
		   if (!empty($avt22)) $avt22=substr($avt22,0,(strlen($avt22)-1));
		   echo $avt22;
      	   echo "</div>";
      	   echo "<div class='name'><a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$row[page_id].">".$row['name'.$suff]."</a></div>";
      	   echo "</div>";
           break;
      }
	}



//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
