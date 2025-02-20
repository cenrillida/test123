<?
// Страница с кратким архивом
global $DB,$_CONFIG, $site_templater;
if (isset($_REQUEST[en]))
{
   $suff='&en';
   $txt1="No ";$txt2='Topic';
}
   else  
{ 
 $suff='';
  $txt1="№ ";$txt2='Тема номера';
}
 //Архиы номеров
echo "####";
  $pg=new Magazine();

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");

  $rows=$pg->getMagazineAllPublic();

  foreach($rows as $row)
  {
     
      echo "<div class='jrubric'>";
       echo"<a href=".$_SESSION[lang]."/index.php?page_id=".$_TPL_REPLACMENT[NUMBER_ID]."&jid=".$row[jid].$suff.">".
       $txt1.$row[page_name]." ".$row[year].
       "";
       
       echo "</div>";


  }


//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");?>
