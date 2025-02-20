<?
// Список дических журналов
global $DB,$_CONFIG;

$mg = new Magazine();
$rows=$mg->getMagazineNameAllMain();
//print_r($rows);
$i=0;
if ($_SESSION[lang]!="/en") $suff=''; else $suff='_en';

foreach($rows as $row)
{
   $jall[$i]=$row;
   $i++;
}
//print_r($jall);
//echo str_replace("</p>","",str_replace("<p>","",$jall[0]["logo"]));
echo "<table>";
for($ii=0;$ii<(count($jall));$ii=$ii+2) //(count($jall)/2+1)
{
    echo "<tr>";
	echo "<td valign=top>";
//	echo $jall[journal_page];print_r($jall);
	if (!empty($jall[$ii][journal_page]))
		echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$jall[$ii][journal_page].">";
	else 
	    echo "<a href=#>";
	echo "<h3>".$jall[$ii]["page_name".$suff]."</h3>";
	echo "</a>";
	echo "<br />";
	echo str_replace("<img ","<img align='left' hspace=10 ",str_replace("</p>","",str_replace("<p>","",$jall[$ii]["logo"])));
	echo "<b>".$jall[$ii]['series'.$suff]."</b><br />".$jall[$ii]['issn'];
	echo $jall[$ii]['info'.$suff];
	echo "</td>";
	echo "<td>&nbsp;&nbsp;&nbsp;</td>";
	echo "<td valign=top>";
	if (!empty($jall[$ii+1][journal_page]))
		echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$jall[$ii+1][journal_page].">";
	else 
		echo "<a href=#>";
	echo "<h3>".$jall[($ii+1)]["page_name".$suff]."</h3></a><br />";
	echo str_replace("<img ","<img align='left' hspace=10 ",str_replace("</p>","",str_replace("<p>","",$jall[($ii+1)]["logo"])));
	echo "<b>".$jall[($ii+1)]['series'.$suff]."</b><br />".$jall[($ii+1)]['issn'];
	echo $jall[($ii+1)]['info'.$suff];
	echo "</td>";
    echo "</tr>";
}
echo "</table>";
?>
