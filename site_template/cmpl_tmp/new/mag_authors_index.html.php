<?php
global $DB,$_CONFIG, $site_templater;
$_REQUEST['jj']=(int)$_TPL_REPLACMENT["MAIN_JOUR_ID"];
// Индекс авторов
$pg=new MagazineNew();

$title_flag = false;
if($_SESSION["lang"]=="/en" && !empty($_TPL_REPLACMENT["TITLE_EN"])) {
    $title_flag = true;
}
if($_SESSION["lang"]!="/en" && !empty($_TPL_REPLACMENT["TITLE"])) {
    $title_flag = true;
}

if(!$title_flag) {

    if (!empty($_REQUEST["jj"])) {
        $rows = $DB->select("SELECT page_name,page_name_en FROM adm_pages WHERE page_id=" . (int)$_TPL_REPLACMENT["MAIN_JOUR_ID"]);
        if ($_SESSION["lang"] != '/en')
            $site_templater->appendValues(array("TITLE" => $rows[0]["page_name"] . ". Авторский указатель"));
        else
            $site_templater->appendValues(array("TITLE_EN" => $rows[0]["page_name_en"] . ". Index of Authors"));

    }
}


$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");


if (empty($_REQUEST["alf"])) 
{
   if ($_SESSION["lang"]!='/en') 	$_REQUEST["alf"]="А"; else $_REQUEST["alf"]="A";
}
if ($_SESSION["lang"]!="/en") $a=$pg->getAuthorsAll2($_TPL_REPLACMENT["MAIN_JOUR_ID"],$_REQUEST["alf"]);
else  {
    $secondField = false;
    if($_REQUEST['jj']==1669) {
        $secondField = true;
    }
    $a=$pg->getAuthorsAll2En($_TPL_REPLACMENT["MAIN_JOUR_ID"],$_REQUEST["alf"],$secondField);
}



$ii=0;
echo "<br />";
if ($_SESSION["lang"]!='/en')
{
 for ($i = ord("А"); $i <= ord("Я"); $i++)
 	    if ((chr($i) != 'Ъ') && (chr($i) != 'Ь') && (chr($i) != 'Ы'))
         echo "<a style='text-decoration: none;' href="."/index.php?page_id=".$_REQUEST["page_id"]."&alf=".chr($i)."><b>".chr($i)." </b></a>&nbsp";
         echo "<a style='text-decoration: none;' href="."/index.php?page_id=".$_REQUEST["page_id"]."&alf=z><b>А...Я</b></a><br><br>";
}  
else
{
for ($i = ord("A"); $i <= ord("Z"); $i++)
 	    
         echo "<a style='text-decoration: none;' href=/en/index.php?page_id=".$_REQUEST["page_id"]."&alf=".chr($i)."><b>".chr($i)." </b></a>&nbsp";
         

}
echo "<hr />";
echo "<div id='authors_list'>";
echo "<table border='0' width=100% >";

foreach($a as $nid=>$nn)
{
   echo "<tr>";
   echo "<td valign='top' width=250px>";
   

    echo "<a class='authors_list' style='border:none;' href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["AUTHOR_ID"]."&id=".$nn["avtor_id"]." title='Об авторе'".
	"> ".str_replace(". .",".",$nid)."</a>";
    if(!empty($nn['rewards'])) {
        echo " <b style='color: grey'>(" . $nn["rewards"] . ")</b>";
    }
    if(!empty($nn['orcid'])) {
        echo " <a target='_blank' href=\"https://orcid.org/{$nn['orcid']}\"><i class=\"fab fa-orcid\" style=\"color: #a5cd39\"></i></a>";
    }
    echo "&nbsp;&nbsp;";
	echo	"</td><td>";
   $art=explode(" | ",$nn["j"]);
   $idd=explode(" | ",$nn["id"]);
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
		if ($a!='') {
            $vol_pos = strripos($a, "т.");
            if ($vol_pos !== false) {
                $numberExpl = explode(',', $a);
                $volumeExpl = explode('-', $numberExpl[1]);

                if(!is_null($numberExpl) && !is_null($volumeExpl) && !is_null($volumeExpl[1]) && !is_null($numberExpl[1])) {
                    $a = ltrim($volumeExpl[0]).', '.$numberExpl[0].'-'.$volumeExpl[1];
                }
            }
            echo "<a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["ARCHIVE_ID"]."&article_id=".$ida[$k].">".str_replace("Запад - Во-", "Запад - Восток - Россия ", $a)."</a> | ";

        }
   
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
