<br>
Отобразить записи, начинающиеся с буквы
<br>
<br>

<?
/*
for ($i = ord("А"); $i <= ord("Я"); $i++)
 {
  $num = 0;
  $result2 =  mysql_query("select * from persona where surname like '".chr($i)."%'");
  while($count = mysql_fetch_array($result2)) $num++;
  if ($num != 0)
   {
    	if(chr($i) == $_GET['smbl']) echo "<b>";
	echo "<a href=/dreamedit/index.php?mod=personal&oper=show&smbl=".chr($i).">".chr($i)." [".$num."]"."</a><br>";
    	if(chr($i) == $_GET['smbl']) echo "</b>";
   }
 }
*/
echo "<BR>";

global $DB;
$ss=$DB->select("SELECT substring(surname,1,1)as aa ,count(*) as cc FROM persona GROUP BY substring(surname,1,1)");
$summa=0;
foreach($ss as $i=>$bukva)
{
    echo "<br /><a href=/dreamedit/index.php?mod=personal&oper=show&smbl=".$bukva[aa].">".$bukva[aa]." [".$bukva[cc]."]"."</a>";
    $summa=$summa+$bukva[cc];
}
//print_r($ss);
echo "<br /><br />";



//$num = 0;
//  $result3 =  mysql_query("select * from persona");
//  while($count = mysql_fetch_array($result3)) $num++;

?>

<a href=/dreamedit/index.php?mod=personal&oper=show&smbl=all>ВСЕ [<? echo $summa; ?>]</a>

