<?
global $DB,$_CONFIG, $site_templater;

if (isset($_REQUEST[printmode])) $_REQUEST[printmode]=$DB->cleanuserinput($_REQUEST[printmode]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);
$_REQUEST[jid]=(int)$DB->cleanuserinput($_REQUEST[jid]);
$_REQUEST[jj]=(int)$DB->cleanuserinput($_REQUEST[jj]);
$_REQUEST[year]=(int)$DB->cleanuserinput($_REQUEST[year]);

$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
 
$pageid=(int)$_REQUEST[page_id];
if($_SESSION[jour_url]!='god_planety')
{
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
}
else
{
if ($_SESSION[lang]=='/en')
{
   $suff='_en';
   $txt1="Rubric index";
   $txt2="Authors of the year ";
   $txt3="";
   $ntxt="No ";
}
else
{
   $suff="";   
   $txt1="Индекс рубрик";
   $txt2="Авторы за год ";
   $txt3=" г.";
   $ntxt="№ ";
}
}
   //Статьи за год по авторам

  $pg=new Magazine();
/*  
 if ($_REQUEST[page_id]=464)
  {
     $_REQUEST[jid]=876;
	 $_REQUEST[jj]=85;
  }  
*/
  if (!empty($_SESSION[jour_id])) 
  {
	$_REQUEST[jid]=$_SESSION[jour_id];
    $_REQUEST[jj]=$_SESSION[jour_id];
  }
  if (empty($_REQUEST[jid])) //Найти свежий номер журнала
{

  $jid0=$pg->getMagazineJId($_REQUEST[page_id]);
				$jid=$jid0[0][journal];

 $jid0=$pg->getLastMagazineNumber($jid0[0][journal]);

  $_REQUEST[jid]=$jid0[0][page_id];
  $_REQUEST[jj]=$jid0[0][journal]; //id d Журналах

}
//if (empty($_REQUEST[year])) $_REQUEST[year]='2014';
if (empty($rows[0][page_name])) $rows[0][page_name]=$rows[0][name];

$title_flag = false;
if($_SESSION[lang]=="/en" && !empty($_TPL_REPLACMENT["TITLE_EN"])) {
    $title_flag = true;
}
if($_SESSION[lang]!="/en" && !empty($_TPL_REPLACMENT["TITLE"])) {
    $title_flag = true;
}

if(!$title_flag) {


    if (!empty($_REQUEST[jj])) {
        $rows = $DB->select("SELECT page_name FROM adm_magazine WHERE page_id=" . $_REQUEST[jj]);

        $site_templater->appendValues(array("TITLE" => $txt2));
    }
    }
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

$rows=$pg->getMagazineAllYear($_REQUEST[jj]);
  $ymax=1900; 
  foreach($rows as $row)
  {
     echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$pageid."&year=".$row[year].">".$row[year]."</a> | ";
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
        IFNULL(n.page_id,r.page_id) AS jid,r.page_id AS r,n.page_id AS n,n.page_template,a.page_parent,a.journal 
		FROM `adm_article` AS a 
		LEFT OUTER JOIN adm_article AS r ON r.page_id=a.page_parent 
		LEFT OUTER JOIN adm_article AS n ON (n.page_id=IFNULL(r.page_parent,a.page_parent)) AND  n.page_template='jnumber' 
		WHERE a.date_public<>'' AND a.page_template='jarticle' 
		AND IFNULL(a.name,a.page_name) <> 'Авторы этого номера' AND a.year=".$yearmain." AND a.journal=".$_REQUEST[jj] 
		);
  $avt=Array();
 // print_r($rows);
  foreach($rows as $row)
  {
//print_r($row);
  if ($_SESSION["lang"]!='/en') $people0=$pg->getAutors($row[people]);
	   else $people0=$pg->getAutorsEn($row[people]);  

	 
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
			  $avt[$fio][fio].="<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".
			  $_TPL_REPLACMENT[PERSONA_ID]."&id=".$people[id].
			  "&jid=".$row[jid]."&jj=".$row[journal].
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
	 echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$a[id].">".
	 $a['name']."</a><br />";

	 if($_SESSION[jour_url]=='god_planety' || $_SESSION[jour_url]=='oprme') {
         if (!is_numeric($a[number]))
             $ntxt = '';
         else {
            if($_SESSION[lang]!='/en')
             $ntxt = '№ ';
            else
                $ntxt = 'No ';
         }
     }
	 echo "<a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[CONTENT_ID].
	 "&jid=".$row[jid].">".
	 $ntxt.$a[number].", ".$yearmain."</a><br />";
  
  }
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
