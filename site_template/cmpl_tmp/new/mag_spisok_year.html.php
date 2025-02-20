<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[jj]=(int)$_TPL_REPLACMENT["MAIN_JOUR_ID"];
$_REQUEST[year]=(int)$DB->cleanuserinput($_REQUEST[year]);

$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
 
$pageid=(int)$_REQUEST[page_id];

if ($_SESSION[lang]=='/en')
{
   $suff='_en';
   $txt1="Rubrics";
   $txt2="Аnnual maintenance ";
   $txt3="";
   $ntxt="No ";
}
else
{
   $suff="";   
   $txt1="Список рубрик";
   $txt2="Ежегодное оглавление ";
   $txt3=" г.";
   $ntxt="№ ";
}
   //Статьи за год по авторам

  $pg=new MagazineNew();

    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

$rows=$pg->getMagazineAllYear($_REQUEST[jj]);
  $ymax=1900; 
  foreach($rows as $row)
  {
     echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$pageid."&year=".$row[year].">".$row[year]."</a> | ";
	 if ($ymax < $row[year]) $ymax=$row[year];
  }
  if (empty($_REQUEST[year])) $_REQUEST[year]=$ymax;
  if ($_REQUEST[year]>$ymax) $_REQUEST[year]=$ymax;

  $yearmain=$_REQUEST[year]; 
 
 echo "<br /><br /><h2>".$_REQUEST[year]."</h2>";
  
  
  if ($_SESSION["lang"]!='/en')
  {
	$rows=$pg->getRubricAll($_REQUEST[jj],1,' ',' ' ,$yearmain);
	
  }
  else	
  {
	
	$rows=$pg->getRubricAllEn($_REQUEST[jj],1,' ',' ' ,$yearmain);
  }	
 //  $yearmain=$_REQUEST[year]; echo "<br /><br /><h2>".$_REQUEST[year]."</h2>";
  $rows=$DB->select("SELECT a.page_id,IFNULL(a.name,a.page_name) AS name,IFNULL(a.name_en,a.page_name) AS name_en,
		a.people,a.number,a.number_en,
        IFNULL(n.page_id,r.page_id) AS jid,r.page_id AS r,n.page_id AS n,n.page_template,a.page_parent,a.journal_new 
		FROM `adm_article` AS a 
		LEFT OUTER JOIN adm_article AS r ON r.page_id=a.page_parent 
		LEFT OUTER JOIN adm_article AS n ON (n.page_id=IFNULL(r.page_parent,a.page_parent)) AND  n.page_template='jnumber' 
		WHERE a.date_public<>'' AND a.page_template='jarticle' 
		AND IFNULL(a.name,a.page_name) <> 'Авторы этого номера' AND a.year=".$yearmain." AND a.journal_new=".$_REQUEST[jj]
		);
  $avt=Array();
 // print_r($rows);
  foreach($rows as $row)
  {
//print_r($row);
  if ($_SESSION["lang"]!='/en') $people0=$pg->getAutors($row[people]);
	   else {
           $secondField = false;
           if($_REQUEST['jj']==1669) {
               $secondField = true;
           }
           $people0=$pg->getAutorsEn($row['people'],$secondField);
       }

	 
       $ifio=0;	   
	   foreach($people0 as $people)
        {
	   
	   if (!empty($people[id]))
      	{
		  if (1==1) //   if(substr($people[fio],0,8)!='редакция' && substr($people[fio],0,8)!='Редакция') //907
      	  {
		      if ($ifio==0) 
			  {
				$fio=$people[fio]."_".$row[page_id];
				$avt[$fio][bukva]=substr($people[fio],0,1);
			  }	
			  $avt[$fio][id]=$row[page_id];
			  $avt[$fio][name]=$row['name'.$suff];
        if($_SESSION[lang]=='/en' && !empty($row[number_en]))
         $avt[$fio][number]=$row[number_en];   
        else
			   $avt[$fio][number]=$row[number];
			  if (($people[fio]!='Редакция . '|| $avt[$fio][fio]=='' ) && !empty($people[fio]))
			  $avt[$fio][fio].="<a href=".$_SESSION[lang]."/index.php?page_id=".
			  $_TPL_REPLACMENT[AUTHOR_ID]."&id=".$people[id].
			  ">".
			  str_replace('Редакция .','Редакция','<em>'.$people[fio].'</em>')."</a>, ";
			  
			  $ifio++;
		  }
		  
		 } 
      
	  }
      	  
  }
//  print_r($avt);
  ksort($avt);
  $alf="";

  foreach($avt as $a)
  {
     echo "<br />";
	 if ($alf!=$a[bukva])
	 {
	    $alf=$a[bukva];
		echo "<b>".$alf."</b><br />";
	 }
	 echo substr($a[fio],0,-2)."<br />";
	 echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID]."&article_id=".$a[id].">".
	 $a['name']."</a><br />";

	 if($_REQUEST[jj]==1665 || $_REQUEST[jj]==1668) {
         if (!is_numeric($a[number]))
             $ntxt = '';
         else {
            if($_SESSION[lang]!='/en')
             $ntxt = '№ ';
            else
                $ntxt = 'No ';
         }
     }
	 echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[ARCHIVE_ID].
	 "&article_id=".$row[jid].">".
	 $ntxt.$a[number].", ".$yearmain."</a><br />";
  
  }
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
