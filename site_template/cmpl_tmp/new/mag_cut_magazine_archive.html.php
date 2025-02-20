<?
global $DB,$_CONFIG, $site_templater;
if ($_SESSION[lang]=='/en')
{
   $suff='&en';
   $txt1="No&nbsp;";$txt2='Topic';
}
   else  
{ 
 $suff='';
  $txt1="№&nbsp;";$txt2='Тема номера';
}
 //Архиы номеров

  $pg=new Magazine();

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

  $rows=$pg->getMagazineAllPublic();
$year="";
$i=0;
  foreach($rows as $row)
  {
       if($_SESSION[lang]!='/en')
    {
  		     if(!empty($row[content][SUBJECT_EN])) $row[subject]=$row[content][subject_en];

	} 
     
	  if ($year!=$row[year])
	  {
	     echo "<br /><h3>".$row[year]."</h3>";
		 $year=$row[year];
		 $i=0;
	  }
	  //echo "<a hidden=true src=aaa>".$row[page_name]."</a>";
	  if(!empty($row[subject])&& $row[subject]<>"<p>&nbsp;</p>")
      {	

		echo "<div class='jrubric'>";
		if($row[page_name]=='Ежегодник' && $_SESSION[lang]=='/en')
       echo"<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1."Yearbook"." ".$row[year]. "";
	   else
	   echo"<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1.$row[page_name]." ".$row[year]. "";
       if(!empty($row[subject])&& $row[subject]<>"<p>&nbsp;</p>")
         echo str_replace("<p>","<p>".$txt2.": ",$row[subject]);
		echo "</a>";
       echo "</div>";
      }
	  else
	  {
	    if ($i==6)
		{
		   echo "<br />";
		   $i=0;
		}
		if ($row[page_name]<10) $sp="&nbsp;&nbsp;";else $sp="";
		if($row[page_name]=='Ежегодник' && $_SESSION[lang]=='/en')
		echo"<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1.$sp."Yearbook"."&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
	   else
		echo"<a href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].">".
       $txt1.$sp.$row[page_name]."&nbsp;".$row[year]. "</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
	   $i++;
	  }

  }


//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
