<?
global $DB,$_CONFIG, $site_templater;

include $_CONFIG['global']['paths']['template_path'].'src/func.php';

$pg = new Pages();



$podr = $pg->getPages(1);
$spe = $podr[417][childNodes];


$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>
<?

if($result == 0)
    {
    echo $_TPL_REPLACMENT["CONTENT"];
}
if ($_SESSION[lang]!="/en")
echo "<br /><a style='text-decoration: none;' href=/index.php?page_id=".$_TPL_REPLACMENT["FULL_ID_A"].">ПО АЛФАВИТУ</a> |
        <a style='text-decoration: none;' href=/index.php?page_id=".$_REQUEST[page_id]."><strong>ПО ПОДРАЗДЕЛЕНИЯМ</strong></a><br /><br /><br />";
		else
		echo "<br /><a style='text-decoration: none;' href=/en/index.php?page_id=".$_TPL_REPLACMENT["FULL_ID_A"].">ALPHABETICAL</a> |
        <a style='text-decoration: none;' href=/en/index.php?page_id=".$_REQUEST[page_id]."><strong>BY DEPARTMENT</strong></a><br /><br /><br />";
		


//Все страницы с Центрами (первый уровень иерархии
$spodr=$pg->getChilds(417,1);
$spodr=$pg->appendContent($spodr);
// print_r($spodr);
foreach($spodr as $s0)
 {
     $podrTitle = $_SESSION['lang']!="/en" ? $s0['page_name'] : $s0['page_name_en'];

     if($s0['page_id']==618) {
         continue;
     } else {
         if($s0['content']['LIST_LINK_OFF']!=1) {
             echo "<a  href='{$_SESSION['lang']}/index.php?page_id={$_TPL_REPLACMENT["FULL_ID_C"]}&dep={$s0['page_id']}&p=0'><h3>". $podrTitle."</h3></a>";
         } else {
             echo "<h3>$podrTitle</h3>";
         }

     }

// ПОлучить всех подчиненных

    $s_otdel=$pg->getChilds($s0['page_id'],1);
//	print_r($s_otdel);
    echo "<ul>";
    foreach($s_otdel AS $s)
    {
        $subPodrTitle = $_SESSION['lang']!="/en" ? $s['page_name'] : $s['page_name_en'];

         echo "<li><a href='{$_SESSION['lang']}/index.php?page_id={$_TPL_REPLACMENT["FULL_ID_C"]}&dep={$s['page_id']}&p=0'>".$subPodrTitle."</a></li>";


// Третий уровень (группы)
/*
	    $s_group=$pg->getChilds($s[page_id]);
            echo "<ul>";
            foreach(s_group as $ss)
            {

                  echo "<li>".$ss[page_name]."</li>";

            }
	    echo "</ul>";
*/
     }
     echo "</ul>";
//echo "</a>";

}

//print_r($spodr);




$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
