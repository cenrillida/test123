<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<?
  include_once substr($_CONFIG["global"]["paths"]['admin_path'],0,-10)."classes/guid/guid.php";
  global $DB,$_CONFIG;

// if(!$_POST['reid'])
//  {

     mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
     mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

    $alike=false;

  /*
  $result =  mysql_query("select * from persona where surname = '".$_POST['surname']."'");
  while($row = mysql_fetch_array($result)) {
	if(($row[2] == $_POST['name'])&&($row[3] == $_POST['fname'])) // то пиздец
		$alike=true;
  }


 if ($alike)
 */
 if (!empty($_POST[oi])) {
  $rr=$DB->select("SELECT id FROM persona
                   WHERE surname='".$_POST[surname]."' AND ".
                   "name='".$_POST[name]."' AND fname='".$_POST[fname]."' AND ".
                   " id <> ".$_POST[oi]);
  if (!empty($rr))
  {
     echo "<br><font color=red><b>* Информация об этом человеке уже введена.</b></font><br><br>";
     $alike=true;
 }
}
if (!$alike) echo "<br><font color=red><b>Проверьте правильность ввода и нажмите на кнопку 'Сохранить в БД'</b></font><br><br>";

?>



Вы ввели следующие данные:
<br><br>

<?php

if($_POST['reid']) $id = $_POST['reid'];


// Фотографии
if (!empty($_POST[reid]))
{
   $pic00=$DB->select("SELECT picsmall,picbig FROM persona WHERE id =".$_POST[reid]);
   $filenames=$pic00[0][picsmall];
   $filenameb=$pic00[0][picbig];

}
else
{
   $filenames="";
   $filenameb="";
}
if ($_FILES[pic1][tmp_name]<> "")
{

  $guid=new guid();
  if (empty($filenames)) $filenames=str_replace("-","_",$guid->tostring())."_s.jpg";
  $uploaddir = $_CONFIG['global']['paths'][admin_path]."foto/";

  move_uploaded_file($_FILES['pic1']['tmp_name'], $uploaddir.$filenames) ;


}


if ($_FILES[pic2][tmp_name]<>"")
{
  $guid=new guid();
  if (empty($filenameb)) $filenameb=str_replace("-","_",$guid->tostring())."_b.jpg";

  $uploaddir = $_CONFIG['global']['paths'][admin_path]."foto/";

  move_uploaded_file($_FILES['pic2']['tmp_name'], $uploaddir.$filenameb) ;
}



echo "<table  width=100%><tr><td rowspan=2  width=240 valign=top>";
        echo "<img src=/dreamedit/foto/".$filenameb." height=240 width=180></td><td width=63 valign='top' >";
        echo "<img src=/dreamedit/foto/".$filenames." height=84 width=63></td>";
        echo "<td valign=top><table width='100%'><tr><td><b>ФИО</b></td>";
        echo "<td colspan=3>".$_POST['surname']."&nbsp".$_POST['name']."&nbsp".$_POST['fname']."&nbsp"."</td></tr><tr><td><b>Отдел</b></td>";
        echo "<td colspan=3>".$_POST['otdel']."</td></tr><tr><td><b>Ученая степень</b></td>";


// ученая степень

$buffer=$DB->select("SELECT * FROM stepen WHERE id=".$_POST[us]);
$qq=$buffer[0][short]." | ".$buffer[0][full];

        echo "<td>".$qq."</td>".
	     "<td><b>Ученое звание</b></td>";
// ученая степень

$buffer=$DB->select("SELECT * FROM zvanie WHERE id=".$_POST[uz]);
$qq=$buffer[0][short]." | ".$buffer[0][full];


        echo "<td>".$qq."</td></tr><tr><td><b>Должность</b></td>";


// Доложность


$buffer=$DB->select("SELECT * FROM doljn WHERE id=".$_POST[dolj]);
$qq=$buffer[0][text];


echo "<td>".$qq."</td><td><b>Членство в РАН</b></td><td>".$_POST['4len']."</td></tr><tr>";
        echo "<td><b>Тел 1</b></td><td>".$_POST['tel1']."</td><td><b>Тел 2</b></td><td>".$_POST['tel2']."</td></tr><tr><td>";
        echo "<b>E-mail 1</b></td><td>".$_POST['mail1']."</td><td><b>E-mail 2</b></td><td>".$_POST['mail2']."</td></tr><tr>";


echo "<td><b>Руководитель</b></td><td>";
if (!$_POST['ruk']) echo "Нет"; else echo "Да";
echo "</td><td><b>Ученый секретарь подразделения</b></td>";
echo "<td>";
if (!$_POST['usp']) echo "Нет"; else echo "Да";
echo "</td></tr><tr>";


echo "<td><b>Доп. регалии</b></td><td colspan=3>".$_POST['rewards']."</td></tr></table></td></tr><tr>";
        echo "<td colspan='2'><b>О себе:</b><br><br>".$_POST['about']."</td></tr>";
        echo "</table>";


?>

<form action=index.php?mod=personal&oper=add method=post>
<input type=hidden name=name value="<? echo $_POST['name'];?>" >
<input type=hidden name=surname value="<? echo $_POST['surname'];?>" >
<input type=hidden name=fname value="<? echo $_POST['fname'];?>" >
<input type=hidden name=us value="<? echo $_POST['us'];?>" >
<input type=hidden name=uz value="<? echo $_POST['uz'];?>" >
<input type=hidden name=4len value="<? echo $_POST['4len'];?>" >
<input type=hidden name=rewards value="<? echo $_POST['rewards'];?>" >
<input type=hidden name=dolj value="<? echo $_POST['dolj'];?>" >
<input type=hidden name=otdel value="<? echo $_POST['otdel'];?>" >
<input type=hidden name=about value="<? echo $_POST['about'];?>" >
<input type=hidden name=ruk value="<? echo $_POST['ruk']; ?>" >
<input type=hidden name=usp value="<? echo $_POST['usp']; ?>" >
<input type=hidden name=tel1 value="<? echo $_POST['tel1'];?>" >
<input type=hidden name=tel2 value="<? echo $_POST['tel2'];?>" >
<input type=hidden name=mail1 value="<? echo $_POST['mail1'];?>" >
<input type=hidden name=mail2 value="<? echo $_POST['mail2'];?>" >

<input type=hidden name=save value=y>
<input type=hidden value=do name=test>
<input type=hidden name=oi value=<? echo $_POST['oi']; ?> >
<input type=hidden name=pic1 value="<? echo $filenames; ?>">
 <input type=hidden name=pic2 value="<? echo $filenameb; ?>">
<? if(!$alike) echo "<input type=submit value='Сохранить в БД'>"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<A HREF="javascript:history.back()" onMouseOver="window.status='Назад';return true">НАЗАД</A>
</form>

<?



 if($_POST['save'] == 'y')
 {

  if ($_POST['ruk']=='on') $flag1 = 1; else $flag1 = 0;
  if ($_POST['usp']=='on') $flag2 = 1; else $flag2 = 0;
  global $_CONFIG;



  mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
  mysql_select_db($_CONFIG['global']['db_connect']['db_name']);




   if (empty($_POST[oi]))
   {

       mysql_query("INSERT INTO persona VALUES (0, '".
					$_POST['surname']."', '".
					$_POST['name']."', '".
					$_POST['fname']."', '".
					$_POST['us']."', '".
					$_POST['uz']."', '".
					$_POST['4len']."', '".
					$_POST['rewards']."', '".
					$_POST['dolj']."', '".
					$_POST['otdel']."', '".
					$_POST['about']."',
					$flag1,
					$flag2, '".
					$_POST['tel1']."', '".
					$_POST['tel2']."', '".
					$_POST['mail1']."', '".
					$_POST['mail2']."', '".
					$_POST['pic1']."', '".
					$_POST['pic2']."')");

  }
   else
   {
       mysql_query("UPDATE persona SET ".
					"surname='".$_POST['surname']."', ".
					"name='".$_POST['name']."', ".
					"fname='".$_POST['fname']."', ".
					"us='".$_POST['us']."', ".
					"uz='".$_POST['uz']."', ".
					"chlen='".$_POST['4len']."', ".
					"rewards='".$_POST['rewards']."', ".
					"dolj='".$_POST['dolj']."', ".
					"otdel='".$_POST['otdel']."', ".
					"about='".$_POST['about']."', ".
					"ruk='".$flag1.",', ".
					"usp='".$flag2."', ".
					"tel1='".$_POST['tel1']."', ".
					"tel2='".$_POST['tel2']."', ".
					"mail1='".$_POST['mail1']."', ".
					"mail2='".$_POST['mail2']."', ".
					"picsmall='".$_POST[pic1]."' ,".
					"picbig='".$_POST[pic2].
					"' WHERE id=".$_POST[oi]);
   }
  mysql_close();
  echo "<br /><br /><font color='red' size-'3'><b>Данные записаны!</b></font><br /> Через 2 секунды Вы будете перенаправлены на главную страницу";
  echo "<META HTTP-EQUIV=REFRESH CONTENT='3;/dreamedit/index.php?mod=personal' />";
 }
?>
