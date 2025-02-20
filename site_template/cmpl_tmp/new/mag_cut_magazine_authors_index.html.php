<?
global $DB,$_CONFIG, $site_templater;
// Индекс авторов
$pg=new Magazine();
//$_REQUEST[jid]=3650;$_REQUEST[jj]=85;
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
  $_REQUEST[jj]=$jid0[0][journal];

}

if (!empty($_REQUEST[jj]))
{
   $rows=$DB->select("SELECT page_name,page_name_en FROM adm_magazine WHERE page_id=".$_REQUEST[jj]);
if ($_SESSION[lang]!='/en')   
	$site_templater->appendValues(array("TITLE" => $rows[0][page_name].". Авторский указатель"));
else	
	$site_templater->appendValues(array("TITLE_EN" => $rows[0][page_name_en].". Index of Authors"));

}


$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


if (empty($_REQUEST[alf])) 
{
   if ($_SESSION[lang]!='/en') 	$_REQUEST[alf]="А"; else $_REQUEST[alf]="A";
}
if ($_SESSION["lang"]!="/en") $a=$pg->getAuthorsAll2($_REQUEST[jj],$_REQUEST[alf]);
else  $a=$pg->getAuthorsAll2En($_REQUEST[jj],$_REQUEST[alf]);



$ii=0;
echo "<br />";
if ($_SESSION[lang]!='/en')
{
 for ($i = ord("А"); $i <= ord("Я"); $i++)
 	    if ((chr($i) != 'Ъ') && (chr($i) != 'Ь') && (chr($i) != 'Ы'))
         echo "<a style='text-decoration: none;' href="."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&alf=".chr($i)."><b>".chr($i)." </b></a>&nbsp";
         echo "<a style='text-decoration: none;' href="."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&alf=z><b>A...Z</b></a><br><br>";
}  
else
{
for ($i = ord("A"); $i <= ord("Z"); $i++)
 	    
         echo "<a style='text-decoration: none;' href=/en/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_REQUEST[page_id]."&alf=".chr($i)."><b>".chr($i)." </b></a>&nbsp";
         

}
echo "<hr />";
echo "<div id='authors_list'>";
echo "<table border='0' width=100% >";
foreach($a as $nid=>$nn)
{
   echo "<tr>";
   echo "<td valign='top' width=250px>";
   

    echo "<a class='authors_list' style='border:none;' href=".$_SESSION["lang"]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[PERSONA_ID]."&id=".$nn[avtor_id].
	"&jid=".$_REQUEST[jid]."&jj=".$_REQUEST[jj]." title='Об авторе'".
	"> ".str_replace(". .",".",$nid)."</a>&nbsp;&nbsp;";
	echo	"</td><td>";
   $art=explode(" | ",$nn[j]);
   $idd=explode(" | ",$nn[id]);
   $i=0;

   $arta=array();$ida=array();
   foreach($art as $a)
   {
      $arta[$i]=$a;
	  $i++;
	}	  
    $i=0;	
	foreach($idd as $a)
   {
      $ida[$i]=$a;
	  $i++;
	}	 

    foreach($arta as $k=>$a)	
	{
		if ($a!='')
		echo "<a href=".$_SESSION["lang"]."/jour_cut/".$_SESSION[jour_url]."/index.php?page_id=".$_TPL_REPLACMENT[ARTICLE_ID]."&id=".$ida[$k].">".$a."</a> | ";
   
   }
   	
   echo "</td></tr>";


   echo "<tr><td colspan='3'>";
   echo "<div id='".$ii."a' style='display:none;padding-left:60px;'>"; 

  

}
echo "</table>";
echo "</div>";

echo $_TPL_REPLACMENT["CONTENT"];
//echo $_TPL_REPLACMENT[BOOK];
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
