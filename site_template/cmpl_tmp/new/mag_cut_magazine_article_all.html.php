<?
// Полный список статей (за все годы)
global $DB,$_CONFIG, $site_templater;
  
$pageid=$_REQUEST[page_id];
if ($_SESSION[lang]=='/en')
{
   $suff='_en';
   $txt1="Rubrics";
   $txt2="Article Index ";
   $txt3="";
   $ntxt="No ";
}
else
{
   $suff="";   
   $txt1="Список рубрик";
   $txt2="Указатель статей ";
   $txt3=" г.";
   $ntxt="№ ";
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
$_REQUEST[jj]=$_SESSION[jour_id];
//print_r($_REQUEST);
if (!empty($_REQUEST[jj]))
{
   $rows=$DB->select("SELECT page_name FROM adm_magazine WHERE page_id=".$_REQUEST[jj]);
   
	$site_templater->appendValues(array("TITLE" => $txt2));   
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if (empty($_REQUEST[alf]))
{ 
  if ($_SESSION[lang]!='/en') $_REQUEST[alf]="А";
  else $_REQUEST[alf]="A";
}  

if ($_SESSION[lang]!='/en')
{
  if ($_TPL_REPLACMENT[SHORT_LIST]!=1)	
	$rows=$pg->getPagesArticleNonePubl(1,null,null,$_REQUEST[alf]);
  else	
    $rows=$pg->getPagesArticleNonePublA(1,null,null,$_REQUEST[alf]);
}
	else
	$rows=$pg->getPagesArticleNonePublEn(1,null,null,$_REQUEST[alf]);
//print_r($rows);	
$alf0=array();
$alf20=array();
$i=0;
if ($_TPL_REPLACMENT[SHORT_LIST]!=1)
{
foreach($rows as $row)
{
   
   $alf0[substr($row[name],0,1)]=substr($row[name],0,1);
   $alf02[substr($row[name],0,2)]=$i;
   $i++;
}
}
else
{
foreach($rows as $row)
{
   
   $alf0[$row[pref]]=$row[pref];
   $alf02[$row[pref]]=$i;
   $i++;
}



}
//print_r($_SESSION);
echo "<br />";
if ($_SESSION[lang]!='/en')
{
 for ($i = ord("А"); $i <= ord("Я"); $i++)
 {
        if (empty($_TPL_REPLACMENT[COUNT_ART])) 
		$href="<a style='text-decoration: none;' href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&alf=".chr($i).">";
	    else $href="<a href='#". $i."'>";	
 	    if ((chr($i) != 'Ъ') && (chr($i) != 'Ь') && (chr($i) != 'Ы'))
		echo $href."<b>".chr($i)." </b></a>&nbsp";
  }  
  echo "<a style='text-decoration: none;' href=/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&alf=z><b>A...Z</b></a><br><br>";
}  
else
{
for ($i = ord("A"); $i <= ord("Z"); $i++)
 	    
         echo "<a style='text-decoration: none;' href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&alf=".chr($i)."><b>".chr($i)." </b></a>&nbsp";
         

}
echo "<hr />";

//print_r($rows);
 
  $avt=Array();
//  print_r($rows);
echo "<h1>".$_REQUEST[alf]."</h1>";
//print_r($alf02);
foreach($alf02 as $k=>$a)
{
   if ($k!='0')
   echo "<a style='text-decoration:underline;' href='#".$a."'>".$k."</a>&nbsp;&nbsp;&nbsp; "; 
}
echo "<br /><br />";
 $alf2=""; 
  foreach($rows as $row)
  {
  if ($alf2!=substr($row[name],0,2))
  {
	if ($_TPL_REPLACMENT[SHORT_LIST]!=1) 
	{
		echo "<a name='".$alf02[substr($row[name],0,2)]."'></a>";
		$alf2=substr($row[name],0,2);
	}
	else
	{
		echo "<a name='".$alf02[$row[pref]]."'></a>";
		$alf2=$row[pref];

	}	
  }	
  if ($_SESSION["lang"]!='/en') $people0=$pg->getAutors($row[people]);
  else $people0=$pg->getAutorsEn($row[people]);  


if ($_TPL_REPLACMENT[	SHORT_LIST]!=1) 
    echo "<br /><a title='Информация о статье' href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id].">".
	 $row['name']."</a><br />"; 	  
  
//  print_r($avt);
 
  $alf="";
  foreach($people0 as $a)
  {
     
	 echo "<a title='Информация об авторе' href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$a[id].">".$a[fio].'</a> ';
  }
 
 if ($_TPL_REPLACMENT[SHORT_LIST]==1) 
    echo "<br /><a title='Информация о статье' href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$row[page_id].">".
	 $row['name']."</a>"; 
 
 if (!empty($row[page_name]))
  echo "<br /><a title='Содержание выпуска' href=".$_SESSION[lang]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[CONTENT_ID].
	 "&jid=".$row[jid].">".
	 $ntxt.$row[number].", ".$row[year]."</a><br />";
if ($_TPL_REPLACMENT[SHORT_LIST]==1) echo "<br />";	 
}
  //echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
