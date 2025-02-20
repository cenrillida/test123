Редактирование

<?

  global $_CONFIG;
mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

$cow='';
  $result =  mysql_query('select * from persona where id='.$_GET['oi']);
  while($row = mysql_fetch_array($result)) {$cow=$row;
}

mysql_close();

?>

<form enctype="multipart/form-data" action=index.php?mod=personal&oper=add method=post>
<input type=hidden value=<? echo $cow[0]; ?> name=reid>
<input type=hidden value=do name=test>
<input type=hidden name=oi value=<? echo $_GET['oi']; ?>>
<table>
 <tr>
  <td width='60%'>
   <b>Фамилия</b><br />
   <input type=text name=surname value=<? echo $cow[1]; ?> >
  <br /><br />
   <b>Имя</b><br />
   <input type=text name=name value=<? echo $cow[2]; ?>>

  <br /><br />
   <b>Отчество</b><br />
      <input type=text name=fname value=<? echo $cow[3]; ?>>


   <br /><br />
   <b>Заменить фотографии</b> <br />
   Фото 63x84
   <br>
   <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
   <input name="pic1" type="file">
   <br />
   Фото 180x2400
   <br>
   <input name=pic2 type="file"><br>
   <?
 echo "</td><td>";
 echo "<img width=63 height=84 src='https://".
        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."foto/".$cow[picsmall]."' />";
  echo '&nbsp;&nbsp;&nbsp;';
 echo "<img width=180 height=240 src='https://".
        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."foto/".$cow[picbig]."' />";
?>
  </td>
 </tr>
</table>




<?
global $DB,$_CONFIG;
$buffer="";
$qq='';
$buffer=$DB->select("SELECT * FROM stepen ORDER BY id");
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[short]." | ".$qq0[full];
}

//Выбор ученой степени

echo "<br><b>Ученая степень</b><br><select name=us><option value='".$cow[4]."'>".$qq[$cow[4]]."</option><option value=-1>&nbsp;</option>";
for($i=0; $i < count($qq); $i++)
 echo "<option value='".$i."'>".$qq[$i]."</option>";
echo "</select>";

echo "<br>";

$buffer="";
$qq='';
$buffer=$DB->select("SELECT * FROM zvanie ORDER BY id");
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[short]." | ".$qq0[full];
}

//Выбор ученой степени

echo "<br><b>Ученое звание</b><br><select name=uz>><option value='".$cow[5]."'>".$qq[$cow[5]]."</option><option value=-1>&nbsp;</option>";
for($i=0; $i < count($qq); $i++)
 echo "<option value='".$i."'>".$qq[$i]."</option>";
echo "</select>";

?>

<br><br>
<b>Членство в РАН</b>
<br>
<? echo "<select name=4len><option value='".$cow[6]."'>".$cow[6]."</option>"; ?>
<option value="Не член"></option>
<option value="Член-корр. РАН">Член-корреспондент РАН</option>
<option value="Академик РАН">Академик РАН</option>
</select>

<br><br>
<b>Дополнительные регалии</b>
<br>
<textarea cols=100 rows=5 name=rewards><? echo $cow[7]; ?></textarea>
<?

$buffer="";
$qq='';
$buffer=$DB->select("SELECT * FROM doljn ORDER BY id");
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[text];
}

//Выбор должности

?>
<br>
<?

echo "<br><b>Должность</b><br><select name=dolj><option value='".$cow[8]."'>".$qq[$cow[8]]."</option>";
for($i=0; $i < count($qq); $i++)
 echo "<option value='".$i."'>".$qq[$i]."</option>";
echo "</select>";

?>

<br>

<? include 'mod/personal/addentry/otdel.php'; ?>
<br>

<table><tr>
<td><b>Телефон 1</b>
<br>
<input name=tel1 value='<? echo $cow[13]; ?>' >
</td>
<td><b>Телефон 2</b>
<br>
<input name=tel2 value='<? echo $cow[14]; ?>' >
</td></tr>
<tr>
<td><b>e-mail 1</b>
<br>
<input name=mail1 value=<? echo $cow[15]; ?> >
</td>
<td><b>e-mail 2</b>
<br>
<input name=mail2 value=<? echo $cow[16]; ?> >
</td>
<td width=250 align=right><input type=submit value="Проверить">
</td>
</tr></table>


<br>
<b>О себе</b>
<br>
<?
//include("/../../../includes/FCKEditor/fckeditor.php") ;
include($_CONFIG["global"]["paths"][admin_path]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('about') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              = $cow[10];
$oFCKeditor->Create() ;
?>
<br>

<input type=checkbox name=ruk
<? if($cow[11]==1) echo checked; ?>
 >&nbsp;Руководитель
<br>
<input type=checkbox name=usp
<? if($cow[12]==1) echo checked; ?>
 >&nbsp;Ученый секретарь подразделения
<br>
<br><br>
<input type=submit value="Проверить">


</form>
