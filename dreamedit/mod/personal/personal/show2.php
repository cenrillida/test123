<?
//echo $_GET['smbl'];
echo "<B>Сейчас в базе есть следующие записи</B><br>";

  global $_CONFIG;
mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

  if($_GET['smbl'])
   $result =  mysql_query("select * from persona where surname like '".$_GET['smbl']."%'");
  else
   $result =  mysql_query("select * from persona");
  while($row = mysql_fetch_array($result)) {
	echo "<table  width=100%><tr><td rowspan=2  width=240 valign=top>";
	echo "<img src=/dreamedit/foto/".$row[picbig]." height=240 width=180></td><td width=63 valign='top' >";
	echo "<img src=/dreamedit/foto/".$row[picsmall]." height=84 width=63></td>";
	echo "<td valign=top><table width='100%' border='1'><tr><td><b>ФИО</b></td>";
	echo "<td colspan=3>".$row[1]."&nbsp".$row[2]."&nbsp".$row[3]."&nbsp"."</td></tr><tr><td><b>Отдел</b></td>";
	echo "<td colspan=3>".$row[9]."</td></tr><tr><td><b>Ученая степень</b></td>";
	echo "<td>".$row[4]."</td><td><b>Ученое звание</b></td>";
	echo "<td>".$row[5]."</td></tr><tr><td><b>Должность</b></td>";
	echo "<td>".$row[8]."</td><td><b>Членство в РАН</b></td><td>".$row[6]."</td></tr><tr>";
	echo "<td><b>Тел 1</b></td><td>".$row[13]."</td><td><b>Тел 2</b></td><td>".$row[14]."</td></tr><tr><td>";
	echo "<b>E-mail 1</b></td><td>".$row[15]."</td><td><b>E-mail 2</b></td><td>".$row[16]."</td></tr><tr>";


echo "<td><b>Руководитель</b></td><td>";
if (!$row[11]) echo "Нет"; else echo "Да";
echo "</td><td><b>Ученый секретарь подразделения</b></td>";
echo "<td>";
if (!$row[12]) echo "Нет"; else echo "Да";
echo "</td></tr><tr>";


echo "<td><b>Доп. регалии</b></td><td colspan=3>".$row[7]."</td></tr></table></td></tr><tr>";
	echo "<td colspan='2'><b>О себе:</b><br><br>".$row[10]."</td></tr>";
	echo "</table>";
	echo "<a href=index.php?mod=personal&oper=remake&oi=".$row[0].">Редактировать</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href=index.php?mod=personal&oper=delete&oi=".$row[0].">Удалить</a>";
}


mysql_close();

?>

