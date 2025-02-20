Пока вводите краткую и полную формы ввиде: краткая/полная<br>
Потом я это пропарсю
<br>
НЕОБХОДИМО, ЧТОБЫ КАЖДОЕ ПОЛЕ ЗАКАНЧИВАЛОСЬ ПУСТОЙ СТРОКОЙ!
<BR>


<?

if ($_POST['vid'])
{
$fd  = fopen("mod/public/ini/vid", "w+");
fputs ($fd, $_POST['vid']);
fclose($fd);
}

$fd  = fopen("mod/public/ini/vid", "r");
while (!feof($fd)) {
    $buffer1 .= fgets($fd, 4096);    
}
fclose($fd);


if ($_POST['tip'])
{
$fd  = fopen("mod/public/ini/tip", "w+");
fputs ($fd, $_POST['tip']);
fclose($fd);
}

$fd  = fopen("mod/public/ini/tip", "r");
while (!feof($fd)) {
    $buffer2 .= fgets($fd, 4096);
}
fclose($fd);

echo("
<html>
<br>
<FORM ACTION=index.php?mod=public&act=set METHOD=POST>
Вид
<br>
<textarea name=vid cols=40 rows=5>$buffer1</textarea>
<br>
<br>
<textarea name=tip cols=40 rows=5>$buffer2</textarea>
<br>
<br>
<input type=submit value=Сохранить></input>
</form>
</html>
");

?>
