show_new
<?

// Список данных от пользователей

  global $DB,$_CONFIG;
mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

/*if ($_GET['smbl']){
   $result =  mysql_query("select * from persona where surname like '".$_GET['smbl']."%' order by surname");
   echo "<br>";
   while($row = mysql_fetch_array($result)) {
        if ($row[10] != '') echo "<img src='mod/personal/img/about.gif' />";
        if (($row[13] != '')||($row[14] != '')||($row[15] != '')||($row[16] != '')) echo "<img src='mod/personal/img/contact.gif' />";

        if ($_GET['id'] == $row[0]) echo '<b>';
        echo "&nbsp;&bull;&nbsp;<a
href=index.php?mod=personal&smbl=".chr($i)."&oper=show&id=".$row[0].">".$row[1]."&nbsp".$row[2]."&nbsp".$row[3]."</a><br>";
        if ($_GET['id'] == $row[0]) echo '</b>';
   }
   echo "<br>";
  }
*/

if ($_GET['smbl']=='all') $_GET['smbl']='';
if(!$_GET['id'])
 {
  if($_GET['smbl'])

{
   $result =  mysql_query("SELECT persona.*,doljn.text AS dolj,IF(IFNULL(p2.id_persona,''),'<b><font color=red>new</font></b>','') AS new
   						   FROM persona
                           INNER JOIN doljn ON doljn.id=persona.dolj
                           INNER JOIN inter2009.prnd_persona AS p2 ON p2.id_persona=persona.id
                           WHERE surname like '".$_GET['smbl']."%' order by surname");
   echo "<br><table border=1>";
   while($row = mysql_fetch_array($result)) {

	echo "<tr><td width=250>";
//        echo "<a href=index.php?mod=personal&smbl=".chr($i)."&oper=show&id=".$row[0].">".$row[1]."&nbsp".$row[2]."&nbsp".$row[3]."</a>";
        echo "<a href=index.php?mod=personal&smbl=".$row[1][0]."&oper=show&id=".$row[0].
        " title ='".$row[dolj]." ".$row[otdel]."'".
        ">".$row[1]."&nbsp".$row[2]."&nbsp".$row[3]."</a>";
	echo "</td><td width=25 align=center>";
	if ($row[10] != '') echo "<img style='cursor:pointer;' title='Введено CV' src='mod/personal/img/about.gif' />";
	echo "</td><td width=25 align=center>";
        if (($row[13] != '')||($row[14] != '')||($row[15] != '')||($row[16] != '')) echo "<img style='cursor:pointer;' title='Введена контактная информация' src='mod/personal/img/contact.gif' />";
	echo "</td><td width=25 align=center>";
        if ($row[picsmall]!='' || $row[picbig]!='') echo "<img style='cursor:pointer;' title='Есть фотография' src='mod/personal/img/foto.gif' />";
	echo "</td>";
	echo "<td>";

	if ($row[otdel]=='Умершие сотрудники')
	       echo "<img src='/img/died.png' style='cursor:pointer;' title='Умершие сотрудники' />";
	    else
	if ($row[otdel]=='Партнеры')
	       echo "<img src='/img/partners.png' style='cursor:pointer;' title='Партнеры' />";
	    else
	if (!empty($row[year1]))
	{


	    if ($row[year1]>=(date("Y")-40))
           echo "<img src='/img/birthyoung.png' style='cursor:pointer;' title='Молодой ученый' />";
	    else
	       echo "<img src='/img/birth.png' style='cursor:pointer;' title='Введен год рождения' />";

	}
	echo "</td><td>";
	if ($row[stavka]<1.00)
	    echo "<a style='cursor:pointer;' title='Размер ставки'>[".$row[stavka]."]</a>";
	echo "</td>";
	echo "<td>";
	if ($row[aspirant]==1)
	    echo "<a style='cursor:pointer;' title='Состоит в штате'><font color='blue'>[ИС]</font></a>";
	else
	    echo "<A Style='Cursor:Pointer;' Title='Совместитель'><font color='blue'>[S]</font></a>";
	echo "</td>";
	echo "<td><a style='cursor:pointer;' title='Есть новые сведения'>".$row['new']."</a></td>";
	echo "</tr>";


   }
  echo "</table>";
  }
  else
   {
 //   $result =  mysql_query("select * from persona order by surname");
    $result =  mysql_query("SELECT persona.*,doljn.text AS dolj,IF(IFNULL(p2.id_persona,'new'),'<b><font color=red>new</font></b>','') AS new
   						   FROM persona
                           INNER JOIN doljn ON doljn.id=persona.dolj
                           INNER JOIN inter2009.prnd_persona AS p2 ON p2.id_persona=persona.id
                           WHERE 1 order by surname");
    echo "<br><table border=1>";
    while($row = mysql_fetch_array($result)) {
	echo "<tr><td width=250>";
	echo "<a href=index.php?mod=personal&oper=show&id=".$row[0].">".$row[1]."&nbsp".$row[2]."&nbsp".$row[3]."</a>";
	echo "</td><td width=25 align=center>";
	if ($row[about] != '') echo "<img style='cursor:pointer;' title='Введено CV' src='mod/personal/img/about.gif' />";
	echo "</td><td width=25 align=center>";
        if (($row[mail1] != '')||($row[mail2] != '')||($row[tel1] != '')||($row[tel2] != '')) echo "<img style='cursor:pointer;' title='Введена контактная информация'  src='mod/personal/img/contact.gif' />";
	echo "</td><td width=25 align=center>";
        if (!empty($row[picsmall]) || !empty($row[picbig])) echo "<img title='Есть фотография' style='cursor:pointer;' src='mod/personal/img/foto.gif' />";
	echo "</td>";
	echo "<td>";

	if ($row[otdel]=='Умершие сотрудники')
	       echo "<img src='/img/died.png' style='cursor:pointer;' title='Умершие сотрудники' />";
	    else
	if ($row[otdel]=='Партнеры')
	       echo "<img src='/img/partners.png' style='cursor:pointer;' title='Партнеры' />";
	    else
	if (!empty($row[year1]))
	{


	    if ($row[year1]>=(date("Y")-40))
           echo "<img src='/img/birthyoung.png' style='cursor:pointer;' title='Молодой ученый' />";
	    else
	       echo "<img src='/img/birth.png' style='cursor:pointer;' title='Введен год рождения' />";

	}
	echo "</td><td >";
	if ($row[stavka]<1.00)
	    echo "<a style='cursor:pointer;' title='Размер ставки'>[".$row[stavka]."]</a>";
	echo "</td>";
	echo "<td>";
	if ($row[aspirant]==1)
	    echo "<a style='cursor:pointer;' title='Состоит в штате'><font color='blue'>[ИС]</font></a>";
	else
	    echo "<A Style='Cursor:Pointer;' Title='Совместитель'><font color='blue'>[S]</font></a>";
	echo "</td>";
	echo "<td><a style='cursor:pointer;' title='Есть новые сведения'>".$row['new']."</a></td>";
	echo "</tr>";
    }
   echo "</table>";
   }
mysql_close();

 }
// Выбрана персона, надо вывести сведения
else

 {


  $row=$DB->select("SELECT p.*,CONCAT(ss.short,' | ',ss.full) AS uss,
                          CONCAT(zz.short,' | ',zz.full) AS uzz,
			  dd.text as dolj0
                          FROM persona AS p
                          LEFT OUTER JOIN stepen AS ss ON ss.id=p.us
                          LEFT OUTER JOIN zvanie AS zz ON zz.id=p.uz
			  LEFT OUTER JOIN doljn AS dd ON dd.id=p.dolj
                          WHERE p.id = '".$_GET['id']."'");


        echo "id=".$row[0][id]."<br />";

        echo "<table  width=100%><tr><td rowspan=2  width=240 valign=top>";
        echo "<img src=/dreamedit/foto/".$row[0][picbig]." height=240 width=180></td><td width=63 valign='top' >";
        echo "<img src=/dreamedit/foto/".$row[0][picsmall]." height=84 width=63></td>";
        echo "<td valign=top><table width='100%' border='1'><tr><td><b>ФИО</b></td>";
        echo "<td colspan=3>".$row[0][surname]."&nbsp".$row[0][name]."&nbsp".$row[0][fname]."&nbsp"."</td></tr><tr><td><b>Отдел</b></td>";
        echo "<td colspan=3>".$row[0][otdel].
	     "</td></tr><tr><td><b>Ученая степень</b></td>";
        echo "<td>".$row[0][uss]."</td><td><b>Ученое звание</b></td>";
//	echo $row[0][uz];
        echo "<td>".$row[0][uzz].
	     "</td></tr><tr><td><b>Должность</b></td>";
	echo "<td>".$row[0][dolj0].
	     "</td><td><b>Членство в РАН</b></td><td>".$row[0][chlen]."</td></tr><tr>";
        echo "<td><b>Тел 1</b></td><td>".$row[0][tel1]."</td><td><b>Тел 2</b></td><td>".$row[0][tel2]."</td></tr><tr><td>";
        echo "<b>E-mail 1</b></td><td>".$row[0][mail1]."</td><td><b>E-mail 2</b></td><td>".$row[0][mail2]."</td></tr><tr>";


	echo "<td><b>Руководитель</b></td><td>";
	if (!$row[0][ruk]) echo "Нет"; else echo "Да";
        echo "</td><td><b>Ученый секретарь подразделения</b></td>";
        echo "<td>";
        if (!$row[0][usp]) echo "Нет"; else echo "Да";
        echo "</td></tr><tr>";


        echo "<td><b>Доп. регалии</b></td><td colspan=3>".$row[0][rewards]."</td></tr>";
        echo "<td><strong>Год рождения</strong> </td><td colspan='3'>".$row[0][year1]."</td></tr>";
        echo "<tr><td><strong>Кандидатская </strong></td><td colspan='3'>".$row[0][year2]."</td></tr>";
        echo "<tr><td><strong>Докторская </strong></td><td colspan='3'>".$row[0][year3]."</td></tr>";
        echo "</tr><tr>";
		echo "<td><strong>Институт </strong></td><td colspan='3'>".$row[0][year_institute]."</td>";
		echo "</tr><tr>";
		echo "<td><strong>Аспирантура </strong></td><td colspan='3'>".$row[0][year_asp_beg]." - ".$row[0][year_asp_end]."</td>";
		echo "</tr><tr>";
        echo "<tr><td><strong>Ставка: </strong></td><td colspan='3'>".$row[0][stavka]."</td>";
        echo "</tr>";
        echo "<tr><td><strong>Состоит в штате:</td><td colspan='3'>".$row[0][aspirant]."</td></tr>";
        echo "</table></td></tr><tr>";



        echo "<td colspan='2'><b>О себе:</b><br><br>".$row[0][about]."</td></tr>";
        echo "</table>";
        echo "<a href=index.php?mod=personal&oper=remake&oi=".$row[0][id].">Редактировать</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<a href=index.php?mod=personal&oper=delete&id=".$row[0][id].">Удалить</a>";


 }



?>

