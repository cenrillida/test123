show_new
<?

// ������ ������ �� �������������

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
	if ($row[10] != '') echo "<img style='cursor:pointer;' title='������� CV' src='mod/personal/img/about.gif' />";
	echo "</td><td width=25 align=center>";
        if (($row[13] != '')||($row[14] != '')||($row[15] != '')||($row[16] != '')) echo "<img style='cursor:pointer;' title='������� ���������� ����������' src='mod/personal/img/contact.gif' />";
	echo "</td><td width=25 align=center>";
        if ($row[picsmall]!='' || $row[picbig]!='') echo "<img style='cursor:pointer;' title='���� ����������' src='mod/personal/img/foto.gif' />";
	echo "</td>";
	echo "<td>";

	if ($row[otdel]=='������� ����������')
	       echo "<img src='/img/died.png' style='cursor:pointer;' title='������� ����������' />";
	    else
	if ($row[otdel]=='��������')
	       echo "<img src='/img/partners.png' style='cursor:pointer;' title='��������' />";
	    else
	if (!empty($row[year1]))
	{


	    if ($row[year1]>=(date("Y")-40))
           echo "<img src='/img/birthyoung.png' style='cursor:pointer;' title='������� ������' />";
	    else
	       echo "<img src='/img/birth.png' style='cursor:pointer;' title='������ ��� ��������' />";

	}
	echo "</td><td>";
	if ($row[stavka]<1.00)
	    echo "<a style='cursor:pointer;' title='������ ������'>[".$row[stavka]."]</a>";
	echo "</td>";
	echo "<td>";
	if ($row[aspirant]==1)
	    echo "<a style='cursor:pointer;' title='������� � �����'><font color='blue'>[��]</font></a>";
	else
	    echo "<A Style='Cursor:Pointer;' Title='������������'><font color='blue'>[S]</font></a>";
	echo "</td>";
	echo "<td><a style='cursor:pointer;' title='���� ����� ��������'>".$row['new']."</a></td>";
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
	if ($row[about] != '') echo "<img style='cursor:pointer;' title='������� CV' src='mod/personal/img/about.gif' />";
	echo "</td><td width=25 align=center>";
        if (($row[mail1] != '')||($row[mail2] != '')||($row[tel1] != '')||($row[tel2] != '')) echo "<img style='cursor:pointer;' title='������� ���������� ����������'  src='mod/personal/img/contact.gif' />";
	echo "</td><td width=25 align=center>";
        if (!empty($row[picsmall]) || !empty($row[picbig])) echo "<img title='���� ����������' style='cursor:pointer;' src='mod/personal/img/foto.gif' />";
	echo "</td>";
	echo "<td>";

	if ($row[otdel]=='������� ����������')
	       echo "<img src='/img/died.png' style='cursor:pointer;' title='������� ����������' />";
	    else
	if ($row[otdel]=='��������')
	       echo "<img src='/img/partners.png' style='cursor:pointer;' title='��������' />";
	    else
	if (!empty($row[year1]))
	{


	    if ($row[year1]>=(date("Y")-40))
           echo "<img src='/img/birthyoung.png' style='cursor:pointer;' title='������� ������' />";
	    else
	       echo "<img src='/img/birth.png' style='cursor:pointer;' title='������ ��� ��������' />";

	}
	echo "</td><td >";
	if ($row[stavka]<1.00)
	    echo "<a style='cursor:pointer;' title='������ ������'>[".$row[stavka]."]</a>";
	echo "</td>";
	echo "<td>";
	if ($row[aspirant]==1)
	    echo "<a style='cursor:pointer;' title='������� � �����'><font color='blue'>[��]</font></a>";
	else
	    echo "<A Style='Cursor:Pointer;' Title='������������'><font color='blue'>[S]</font></a>";
	echo "</td>";
	echo "<td><a style='cursor:pointer;' title='���� ����� ��������'>".$row['new']."</a></td>";
	echo "</tr>";
    }
   echo "</table>";
   }
mysql_close();

 }
// ������� �������, ���� ������� ��������
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
        echo "<td valign=top><table width='100%' border='1'><tr><td><b>���</b></td>";
        echo "<td colspan=3>".$row[0][surname]."&nbsp".$row[0][name]."&nbsp".$row[0][fname]."&nbsp"."</td></tr><tr><td><b>�����</b></td>";
        echo "<td colspan=3>".$row[0][otdel].
	     "</td></tr><tr><td><b>������ �������</b></td>";
        echo "<td>".$row[0][uss]."</td><td><b>������ ������</b></td>";
//	echo $row[0][uz];
        echo "<td>".$row[0][uzz].
	     "</td></tr><tr><td><b>���������</b></td>";
	echo "<td>".$row[0][dolj0].
	     "</td><td><b>�������� � ���</b></td><td>".$row[0][chlen]."</td></tr><tr>";
        echo "<td><b>��� 1</b></td><td>".$row[0][tel1]."</td><td><b>��� 2</b></td><td>".$row[0][tel2]."</td></tr><tr><td>";
        echo "<b>E-mail 1</b></td><td>".$row[0][mail1]."</td><td><b>E-mail 2</b></td><td>".$row[0][mail2]."</td></tr><tr>";


	echo "<td><b>������������</b></td><td>";
	if (!$row[0][ruk]) echo "���"; else echo "��";
        echo "</td><td><b>������ ��������� �������������</b></td>";
        echo "<td>";
        if (!$row[0][usp]) echo "���"; else echo "��";
        echo "</td></tr><tr>";


        echo "<td><b>���. �������</b></td><td colspan=3>".$row[0][rewards]."</td></tr>";
        echo "<td><strong>��� ��������</strong> </td><td colspan='3'>".$row[0][year1]."</td></tr>";
        echo "<tr><td><strong>������������ </strong></td><td colspan='3'>".$row[0][year2]."</td></tr>";
        echo "<tr><td><strong>���������� </strong></td><td colspan='3'>".$row[0][year3]."</td></tr>";
        echo "</tr><tr>";
		echo "<td><strong>�������� </strong></td><td colspan='3'>".$row[0][year_institute]."</td>";
		echo "</tr><tr>";
		echo "<td><strong>����������� </strong></td><td colspan='3'>".$row[0][year_asp_beg]." - ".$row[0][year_asp_end]."</td>";
		echo "</tr><tr>";
        echo "<tr><td><strong>������: </strong></td><td colspan='3'>".$row[0][stavka]."</td>";
        echo "</tr>";
        echo "<tr><td><strong>������� � �����:</td><td colspan='3'>".$row[0][aspirant]."</td></tr>";
        echo "</table></td></tr><tr>";



        echo "<td colspan='2'><b>� ����:</b><br><br>".$row[0][about]."</td></tr>";
        echo "</table>";
        echo "<a href=index.php?mod=personal&oper=remake&oi=".$row[0][id].">�������������</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<a href=index.php?mod=personal&oper=delete&id=".$row[0][id].">�������</a>";


 }



?>

