<?

// Показать по список по одной букве

global $DB,$_CONFIG;

if(!empty($_GET['smbl'])) {
    if($_GET['smbl']!='all')
        echo 'Список персон, у которых фамилия начинается с буквы "' . $_GET['smbl'] . '"';
    else
        echo 'Список всех персон';
}
if(!empty($_GET['search']))
    echo 'Поиск по ФИО: "'.$_GET['search'].'"';

if ($_GET['smbl']=='all') $_GET['smbl']='';
if(!$_GET['id'])
 {
  if($_GET['smbl'])

{
   $result =  $DB->select("SELECT persons.*,doljn.icont_text AS dolj,podr.page_name AS otdel,IF(n.id<>'','new','') AS new
   						   FROM persons
                           LEFT OUTER JOIN adm_directories_content AS doljn ON doljn.el_id=persons.dolj AND doljn.icont_var='text' 
                           LEFT OUTER JOIN adm_pages AS podr ON podr.page_id=persons.otdel
                           LEFT OUTER JOIN persona_user AS n ON n.id_persona=persons.id
                           WHERE substring(surname,1,1)='".$_REQUEST['smbl']."' AND surname <>'' order by surname");

 //  print_r($result);
   echo "<br><table border=1>";
   foreach($result as $row) {

	echo "<tr><td width=250>";
//        echo "<a href=index.php?mod=personal&smbl=".chr($i)."&oper=show&id=".$row[0].">".$row[1]."&nbsp".$row[2]."&nbsp".$row[3]."</a>";
        echo "<a href=index.php?mod=personal&smbl=".$row[surmame][0]."&oper=show&id=".$row[id].
        " title ='".$row[dolj]." ".$row[otdel]."'".
        ">".$row[surname]."&nbsp".$row[name]."&nbsp".$row[fname]."</a>";
	echo "</td><td width=25 align=center>";
	if ($row[about] != '' && $row[about]!='<p>&nbsp;</p>' && $row[about]!='<p> </p>') echo "<img style='cursor:pointer;' title='Введено CV' src='mod/personal/img/about.gif' />";
	echo "</td><td width=25 align=center>";
        if (($row[mail1] != '')||($row[mail2] != '')||($row[tel1] != '')||($row[tel2] != '')) echo "<img style='cursor:pointer;' title='Введена контактная информация' src='mod/personal/img/contact.gif' />";
	echo "</td><td width=25 align=center>";
        if ($row[picsmall]!='' || $row[picbig]!='') echo "<img style='cursor:pointer;' title='Есть фотография' src='mod/personal/img/foto.gif' />";
	echo "</td>";
	echo "<td>";

	if ($row[otdel]=='Умер')
	       echo "<img src='mod/personal/img/died.png' style='cursor:pointer;' title='Умер' />";
	    else
	if ($row[otdel]=='Партнеры')
	       echo "<img src='/images/partners.png' style='cursor:pointer;' title='Партнеры' />";
   	if (!empty($row[year1]))
	{


	    if ($row[year1]>=(date("Y")-40))
           echo "<img src='mod/personal/img/birthyoung.png' style='cursor:pointer;' title='Молодой ученый' />";
	    else
	       echo "<img src='mod/personal/img/birth.png' style='cursor:pointer;' title='Введен год рождения' />";

	}
	echo "</td>";


	echo "<td>";
	if ($row['full']==1)
		echo "<a style='cursor:pointer;' title='Не показывать в списке сотрудников'><img src=/images/Ok-icon.png></a>";
	echo "</td>";
	echo "<td>".$row[jnumber]."</td>";

//	if (!empty($row['new']))
  	  echo "<td><font color='red'>".$row['new']."</font></td>";

    echo "</tr>";
   }
  echo "</table>";
  }
  else
   {
 //   $result =  mysql_query("select * from persona order by surname");
    if(empty($_GET['search']))
        $result =  $DB->select("SELECT persons.*,doljn.icont_text AS dolj,podr.page_name AS otdel,IF(n.id<>'','new','') AS new
   						   FROM persons
                           LEFT OUTER JOIN adm_directories_content AS doljn ON doljn.el_id=persons.dolj AND doljn.icont_var='text'
                           LEFT OUTER JOIN adm_pages AS podr ON podr.page_id=persons.otdel
                           LEFT OUTER JOIN persona_user AS n ON n.id_persona=persons.id
                           WHERE 1 order by surname");
    else {
        $result = $DB->select("SELECT persons.*,doljn.icont_text AS dolj,podr.page_name AS otdel,IF(n.id<>'','new','') AS new
   						   FROM persons
                           LEFT OUTER JOIN adm_directories_content AS doljn ON doljn.el_id=persons.dolj AND doljn.icont_var='text'
                           LEFT OUTER JOIN adm_pages AS podr ON podr.page_id=persons.otdel
                           LEFT OUTER JOIN persona_user AS n ON n.id_persona=persons.id
                           WHERE CONCAT(persons.surname, ' ', persons.name, ' ', persons.fname) LIKE '" . $_REQUEST['search'] . "%' order by surname");
        $used_ids = array();
        foreach($result as $k => $v) {
            $used_ids[] = $v['id'];
            $count++;
        }
        $result2 = $DB->select("SELECT persons.*,doljn.icont_text AS dolj,podr.page_name AS otdel,IF(n.id<>'','new','') AS new
   						   FROM persons
                           LEFT OUTER JOIN adm_directories_content AS doljn ON doljn.el_id=persons.dolj AND doljn.icont_var='text'
                           LEFT OUTER JOIN adm_pages AS podr ON podr.page_id=persons.otdel
                           LEFT OUTER JOIN persona_user AS n ON n.id_persona=persons.id
                           WHERE CONCAT(persons.surname, ' ', persons.name, ' ', persons.fname) LIKE '%" . $_REQUEST['search'] . "%' order by surname");
        foreach($result2 as $k => $v) {
            if(!in_array($v['id'],$used_ids))
                $result[] = $v;
        }
    }


    echo "<br><table border=1>";
    foreach($result as $row) {
	echo "<tr><td width=250>";
	echo "<a href=index.php?mod=personal&oper=show&id=".$row[id].">".$row[surname]."&nbsp".$row[name]."&nbsp".$row[fname]."</a>";
	echo "</td><td width=25 align=center>";
	if ($row[about] != '' && $row[about]!='<p>&nbsp;</p>' && $row[about]!='<p> </p>') echo "<img style='cursor:pointer;' title='Введено CV' src='mod/personal/img/about.gif' />";
	echo "</td><td width=25 align=center>";
        if (($row[mail1] != '')||($row[mail2] != '')||($row[tel1] != '')||($row[tel2] != '')) echo "<img style='cursor:pointer;' title='Введена контактная информация'  src='mod/personal/img/contact.gif' />";
	echo "</td><td width=25 align=center>";
        if (!empty($row[picsmall]) || !empty($row[picbig])) echo "<img title='Есть фотография' style='cursor:pointer;' src='mod/personal/img/foto.gif' />";
	echo "</td>";
	echo "<td>";

	if ($row[otdel]=='Умер')
	       echo "<img src='mod/personal/img/died.png' style='cursor:pointer;' title='Умер' />";
	    else
	if ($row[otdel]=='Партнеры')
	       echo "<img src='/images/partners.png' style='cursor:pointer;' title='Партнеры' />";

	echo "</td>";
    echo "<td>";
    if ($row['full']==1)
        echo "<a style='cursor:pointer;' title='Не показывать в списке сотрудников'><img src=/images/Ok-icon.png></a>";
    echo "</td>";
	echo "<td>".$row[jnumber]."</td>";
	echo "<td><font color='red'>".$row['new']."</font></td>";
	echo "</tr>";
    }
   echo "</table>";
   }
//mysql_close();

 }
// Выбрана персона, надо вывести сведения
else

 {

  $row=$DB->select("SELECT p.*,CONCAT(ss.icont_text,' | ',ss2.icont_text) AS uss,
                          CONCAT(zz.icont_text,' | ',zz2.icont_text) AS uzz,ran.icont_text AS ran,
			  dd.icont_text as dolj0,otd.page_name AS otdel 
                          FROM persons AS p
                          LEFT OUTER JOIN adm_directories_content AS ss ON ss.el_id=p.us AND ss.icont_var='text'
						  LEFT OUTER JOIN adm_directories_content AS ss2 ON ss2.el_id=p.us AND ss2.icont_var='value'
                          LEFT OUTER JOIN adm_directories_content AS zz ON zz.el_id=p.uz AND zz.icont_var='text'
						  LEFT OUTER JOIN adm_directories_content AS zz2 ON zz2.el_id=p.uz AND zz2.icont_var='value'
						  LEFT OUTER JOIN adm_directories_content AS ran ON ran.el_id=p.ran AND ran.icont_var='value'
			              INNER JOIN adm_directories_content AS dd ON dd.el_id=p.dolj AND dd.icont_var='text'
						  INNER JOIN adm_pages AS otd ON otd.page_id=p.otdel
                          WHERE p.id = '".$_GET['id']."'");

//print_r($row);

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
	     "</td><td><b>Членство в РАН</b></td><td>".$row[0][ran]."</td></tr><tr>";
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



        echo "<td colspan='2'><b>О себе:</b><br><br>".$row[0][about]."";
		echo "<br><br><b>О себе Английский:</b><br><br>".$row[0][about_en]."</td></tr>";
        echo "</table>";
        echo "<a href=index.php?mod=personal&oper=remake&oi=".$_REQUEST[id].">Редактировать</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<a href=index.php?mod=personal&oper=delete&id=".$_REQUEST[id].">Удалить</a>";


 }



?>

