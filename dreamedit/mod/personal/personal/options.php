Пока вводите краткую и полную формы ввиде: краткая/полная<br>
Потом я это пропарсю
<br>
ВРЕМЕННО НЕОБХОДИМО, ЧТОБЫ КАЖДОЕ ПОЛЕ ЗАКАНЧИВАЛОСЬ ПУСТОЙ СТРОКОЙ!
<BR>


<?
global $DB;
print_r($_POST);
echo "<br />_______________";
print_r($_POST['safe']);

empty($stepen_edit);
foreach($_POST as $i =>$kk)
{
if ($kk=="edit") 
{ 

   $stepen_edit=substr($i,2)-1; 
   echo "stepen ".$stepen_edit;   
}
}
if ($_POST['stepen'])
{
$fd  = fopen("mod/personal/stepen.txt", "w+");
fputs ($fd, $_POST['stepen']);
fclose($fd);


}
/*
$fd  = fopen("mod/personal/stepen.txt", "r");
while (!feof($fd)) {
    $buffer .= fgets($fd, 4096);    

}
fclose($fd);
*/
// Читаем степени
$buffer0=$DB->select("SELECT * FROM stepen ORDER BY id");
empty($buffer);
foreach($buffer0 as $i=>$buf)
{
    $buffer.=$buf[short]."\n";
}


if ($_POST['u4'])
{
$fd  = fopen("mod/personal/u4.txt", "w+");
fputs ($fd, $_POST['u4']);
fclose($fd);
}

$fd  = fopen("mod/personal/u4.txt", "r");
while (!feof($fd)) {
    $buffer1 .= fgets($fd, 4096);
}
fclose($fd);

if ($_POST['dolj'])
{
$fd  = fopen("mod/personal/dolj.txt", "w+");
fputs ($fd, $_POST['dolj']);
fclose($fd);
}

$fd  = fopen("mod/personal/dolj.txt", "r");
while (!feof($fd)) {
    $buffer2 .= fgets($fd, 4096);
}
fclose($fd);


echo "
<html>
<br>
<FORM ACTION=index.php?mod=personal&oper=edit METHOD=POST>
Виды научных степеней
<br>";
echo "<table cellspacing='1' cellpadding='1'  border='1'>";

empty($vals);
empty($valf);
foreach($buffer0 as $i=>$buf)
{
  
  if ( $i==$stepen_edit) 
  {
    $vals=$buf[short];
    $valf=$buf[full];
  }    
  echo "<tr>";
  echo "<td align='right'> <input value='edit' name='ss".($i+1)."' type='submit' cols=5></td>"; 
  echo "<td bgcolor=#efefef width=10% >".($i+1)."</td>
       <td bgcolor=#efefef><textbox>".trim($buf[short])."</textbox></td>";
  echo "<td bgcolor=#efefef><textbox>".$buf[full]."</textbox></td></tr>";
}
  echo "<tr>";
  echo "<td><input name='safe' type='submit' value='safe'></input></td>";
  echo "<td>".(count($buffer0)+1)."</td><td><input type=edit name=newsshort value='".$vals."'>$news</input></td>".
       "<td width=60%><input name=newfull type=edit size=60 cols=40 rows=1 value='".$valf."'>".$newf."</input></td>";
  echo "</tr>";       
echo "</table>";       
//<textarea name=stepen cols=40 rows=5>$buffer</textarea>
echo "<br>
Ученые звания
<br>
<textarea name=u4 cols=40 rows=5>$buffer1</textarea>
<br>
Должности 
<br>
<textarea name=dolj cols=40 rows=5>$buffer2</textarea>
<br>
<input type=submit></input>
</form>
</html>
";

?>
