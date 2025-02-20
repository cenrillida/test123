<?
global $DB,$_CONFIG, $site_templater;

if ($_SESSION[lang]=='/en')
{
   $suff='';
   $txt1="No ";
   $txt2='Rubric';
   $txt3= 'download free';
   $txt4='Content ';
   $suff2="_en";
   $txtpage="P.";
}
   else  
  { 
   $suff='';$suff2="";
   $txt1="№ ";$txt2='Рубрика';$txt3='скачать бесплатно';$txt4='Оглавление номера ';
   $txtpage="С.";
   }
//print_r($_REQUEST);

  $pg=new Magazine();
if (!empty($_SESSION[jour_id])) 
  {
	$_REQUEST[jid]=$_SESSION[jour_id];
    $_REQUEST[jj]=$_SESSION[jour_id];
  }
 if (empty($_REQUEST[jid])) //Найти свежий номер журнала
{

  $jid0=$pg->getLastMagazineNumber();

  $_REQUEST[jid]=$jid0[0][page_id];
  $_REQUEST[jj]=$jid0[0][journal];

}
$jour0=$pg->getMagazineByArticleId($_REQUEST[id]);
//print_r($jour0);

$rows=$DB->select("SELECT  name AS title,name_en AS title_en,CONCAT('".$txt1." ',number,', ',year) AS jname 
   FROM adm_article WHERE  page_id=".$_REQUEST[id]);
 //print_r($rows);  
  $_REQUEST[jid]=$jour0[0][page_id];
 $_REQUEST[jj]=$jour0[0][journal];
//print_r($rows);
if ($_SESSION[lang]!='/en')
{
	$jname=$txt1.$jour0[0][page_name].", ".$jour0[0][year];
	$title=$rows[0][jname];
}
else
{
     
     $jname=$txt1.$rows[0][title_en].", ".$jour0[0][year];
	 $title=$rows[0][jname];
}	
//print_r($rows);
$site_templater->appendValues(array("TITLE" => $rows[0][title]));
$site_templater->appendValues(array("TITLE_EN" => $rows[0][title_en]));
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
  $rowas=$pg->getArticleById($_REQUEST[id]);
//  print_r($rowas);
  if (!empty($rowas[0][page_parent]))
  {
  $rowrs=$DB->select("SELECT page_id, IFNULL(name,page_name) AS rubric,name_en AS rubric_en ". 
 // cv_text AS rubric FROM adm_article_content  AS pc
  " FROM adm_article ".
  " WHERE  page_id=".$rowas[0][page_parent]." AND page_status=1 AND page_template='jrubric'"  ); //." AND cv_name='rubric".$suff2."'");

  $rowj=$DB->select("SELECT page_id,page_name AS journal,page_name_en AS journal_en FROM adm_magazine WHERE page_id=".$_REQUEST[jj]);
  }
  foreach($rowas as $k=>$row)
  {
//print_r($row);echo "name".$suff2." ".$row[name.$suff2];
      	   echo "<div class='jarticle'>";
		   if (!isset($_REQUEST[en]))
		   {
			   $people0=$pg->getAutors($row[people]);
			   $avtbib=$pg->getAutorsBib($row[people]);
		   }
		   else
		   {
			   $people0=$pg->getAutorsEn($row[people]);
			   $avtbib=$pg->getAutorsBibEN($row[people]);
		   
		   }
		   echo "<div class='autors_a'>";
      	   foreach($people0 as $people)
      	   {
      	      if (!empty($people[id]) && $people[id] != '488' && $people[id]!='270')
      	      {
			  $fios=$people[fio];
				if($_SESSION[jour_url]=='meimo')
			  {
				if ($_SESSION[lang]!='/en')
				{
					$fios=$people[fioshort];
				}
				else
				{
					$fios=substr(mb_stristr($people[fioshort]," "),1,1).". ".mb_stristr($people[fioshort]," ",true);
				}
			}
      	      if ($people[otdel]!='Умершие сотрудники')
      	      {
      	       echo "<br />".
      	         "<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].$suff.">".
      	            $fios."</a>";
      	            if (!empty($people[work])) echo ",<br />".$people[work];
      	            if (!empty($people[mail1]) && $people[mail1]!='no' && $_SESSION[jour_url]!='meimo') echo ", <a href=mailto:".$people[mail1].">".$people[mail1]."</a>";
      	      }
      	      else
      	       echo "<br /><span style='border:1px solid gray;'>".
      	       "<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id]."&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj].$suff.">".
      	     	       $fios."</a></span>";
      	      }
      	   }
      	   echo "</div>";
      	   echo "<div class='jrubric'>".$row['name'.$suff2]."<br />// ".$rowj[0]['journal'.$suff2].". ". $row[year].". ".$txt1." ".$row[number];
$jourissue= $rowj[0]['journal'.$suff2].". ". $row[year].". ".$txt1." ".$row[number];   
$issuename=  $rowj[0]['journal'.$suff2];
$issueyear=	  $row[year];
$issuenumber=$row[number];
		  if (!empty($row[pages]))
      	      echo ". ".$txtpage." ".$row[pages];
      	   echo  "</div><br />";
      	   if (!empty($rowrs[0][rubric]) && $rowrs[0][rubric]!='1')
	      	   echo "<div class='jrubric_a'>".
			   $txt2.": <a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[RUBRIC_ID].
			   "&id=".$rowrs[0][page_id].
			   ">".$rowrs[0]['rubric'.$suff2]."</a>".
	
			"</div><br />";
			echo "<div style='font-size:10px;'>".$row['affiliation'.$suff2]."</div><br />";
           if (!empty($row[annots]) && $_SESSION[lang]!='/en')
           {
	           if (!empty($row[annots]) && $row[annots]!='<p>&nbsp;</p>') 
			   {
				echo "<div class='jrubric_a'><b>Аннотация</b></div>";
				echo "<div class='annot_text'>".$row[annots]."</div><br />";
				}
           }
	/*
		    if (!empty($row[contents]) && $_SESSION[lang]!='/en')
          {
	  
	  //   if (!empty($row[contents]) && $row[contents]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>Аннотация</b></div>";
	         echo "<div class='annot_text'>".$row[contents]."</div><br />";
        }
*/
		if (!empty($row[annots_en]) && isset($_REQUEST[en]))
           {
	           if (!empty($row[annots_en]) && $row[annots_en]!='<p>&nbsp;</p>') echo "<br /><div class='jrubric_a'><b>Abstract</b></div>";
	           echo "<div class='annot_text'>".$row[annots_en]."</div><br ?>";
           }
       //    if (!empty($row[keyword]) || ! empty($row[keyword_en]))
        //   {
	           if (!empty($row[keyword]) && $row[keyword]!='<p>&nbsp;</p>' && $_SESSION[lang]!='/en')
			   {
				   echo "<div class='jrubric_a'><b>Ключевые слова</b></div>";
				   echo "<div class='annot_text'>".$row[keyword]."</div><br />";
	           }
			   if (!empty($row[keyword_en]) && $_SESSION[lang]=='/en')
	           {
	           if (!empty($row[keyword_en]) && $row[keyword_en]!='<p>&nbsp;</p>') echo "<div class='jrubric_a'><b>Keywords</b></div>";
    	       echo "<div class='annot_text'>".$row[keyword_en]."</div>";
    	       }
  //         }
           if (!empty($row[rinc])) 
		   {
		   if($_SESSION[lang]!='/en')
		   echo "<a href=".$row[rinc].">Размещено в РИНЦ</a>";
		   else echo "<a href=".$row[rinc].">Registered in system SCIENCE INDEX</a>";
		   }
           if (empty($row[annots]) && !empty($row['contents'])) echo $row[contents];

/////////

if (strpos($row['link'],'href=',0) >0)
{
    if(strpos($row['link'],"http:")==0)
   {
     $row['link']=str_replace("/files/File/","http://".$_SERVER[HTTP_HOST]."/files/File/",$row['link']);

   }
   $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]\.pdf/i";

   preg_match_all($filter,$row['link'],$res);
 //  print_r($res); echo "<br />";echo "<br />";
 //  echo $res[0][0]." ".count($res)."**";
   for($i=0;$i<=count($res);$i++)
   {
      $row['link']=str_replace($res[0][$i],$_SESSION[lang]."/index.php?page_id=647&id=".$_REQUEST[id]."&param=".str_replace(' ','^',$res[0][$i]),$row['link']);
   }

//   echo $row['link'];
    echo "<div class='jrubric_a'>".str_replace("<a ","<a title='".$txt3."' ",$row['link'])."</div>";
}
//////////

           echo "</div>";
		   $jidcurr=$row[jid];

	}
   echo "<hr />";
////////////// тэги
/////////////////  Когда будут тэги
//  $tags=explode(";",trim($row[tags]));
//  echo "тэги: ";
//  foreach ($tags as $tag)
//  {
//     if (!empty($tag))
//	     echo "<a href='index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_LIST]."&key='".$tag."' >".$tag."</a> | ";
//
//  }

/*
  if ($_REQUEST[at]=="a")
  {

       $rowns=$pg->getMagazineNumber($_REQUEST[jid]);





  echo "<div class='jrubric'>Все статьи автора в этом номере (".$rows[0][title]."):</div>";

  foreach($rowns as $k=>$row)
  {
  if (strpos($row[people],">".$_REQUEST[pid]."<")>0 ||substr($row[people],0,strlen($_REQUEST[pid])+1)==$_REQUEST[pid]."<")

  {


         echo "<div class='jarticle'>";
      	   $people0=$pg->getAutors($row[people]);
      	   echo "<div class='autors'>";
      	   foreach($people0 as $people)
      	   {
      	      echo "<a href=http://www.isras.ru/pers_about.html?id=".$people[id].">".$people[fio]."</a>"; //.$people[work].",".$people[mail1]."";
      	   }
      	   echo "</div>";
      	   echo "<div class='name'><a href=/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id]."&at=a>".$row[name]."</a></div>";
      	   echo "</div>";
	}
  }
  }
  echo "<hr />";
*/
  echo "<div class='jrubric'>";
//  print_r($_REQUEST[jid]);
  echo $txt4;echo "<a style='text-decoration:underline;' href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$jidcurr."&jj=".$_REQUEST[jj].$suff.">".
        $jourissue."</a>";

  echo "</div>";  echo "<br clear='all'>";
 //	 print_r($jour0);
        //  $row[jtitle]=$jour0[0]['j_name'.$suff2];
		  $row[jtitle]=$jour0[0]['page_name'.$suff2];
          $row[number]=$issuenumber;//$jour0[0]['page_name'];
          $row[issn]=$jour0[0][issn];
          $row[year]=$jour0[0][year];
          $row[issue]=$jour0[0]['page_name'];
          $row[vid]=2;
 //         echo "<br /><br />____".$avtbib."<br />";print_r($row);

 //echo "<br />";print_r($row); echo "<br />";print_r($jour0);
   $bib=new BibEntry();
		$aa=$bib->toCoinsMySQL($row,$avtbib);
		print_r($aa);
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
