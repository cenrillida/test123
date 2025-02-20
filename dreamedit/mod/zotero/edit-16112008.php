<?
print_r($_GET);

global $DB,$_CONFIG;
mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);
$result =  mysql_query("select * from publ where id=".$_GET['id']);
while($bow = mysql_fetch_array($result))
{

?>

<form name=publ enctype="multipart/form-data" action=index.php?mod=public&action=add method=post>
<input type=hidden name=sent value=1>
<font color=red>*</font>Название
<br>
<textarea name=name cols=120><? echo $bow[name]; ?></textarea>
<br>
Вторая часть библиографической ссылки
<br>
<textarea name=name2 cols=120><? echo $bow[name2]; ?></textarea>
<br>
<br>
<font color=red>*</font>Год выпуска
<br>
<input type=text name=date maxlength=4 value='<? echo $bow[year]; ?>'  style="width: 50">
<br>
<br>

 <input type=checkbox name=imp <? if($bow[15] == 'on') echo "checked"; ?>>&nbsp;Важная публикация


<br>
<br>

<table><tr>
<td>
<font color=red>*</font>Вид
<br>
<?
// Читаем виды публикаций

$vid0=$DB->select("SELECT * FROM vid ORDER BY id");



echo "<select name=vid>";

echo "<option value='".$bow[3]."'>".$vid0[$bow[vid]-1][text]."</option>";
echo "<option value=-1></option>";


foreach($vid0 as $i=>$vid)
 echo "<option value='".($i+1)."'>".$vid[text]."</option>";

?>
</select>


</td><td>

<?


$type0=$DB->select("SELECT * FROM type ORDER BY id");


?>


<font color=red>*</font>Тип
<br>
<select name=tip>
 <option value='<? echo $bow[4]; ?>'><? echo $type0[$bow[tip]-1][text]; ?></option>
 <option value=-1></option>
<?

foreach($type0 as $i=>$type)
 echo "<option value='".($i+1)."'>".$type[text]."</option>";

?>


</select>


</td>
</tr></table>

<br>
<b>ISBN</b>
<br>
<textarea name=izdat cols=120><? echo $bow[12]; ?></textarea>
<br>

<?
 include 'spe_selector.php';
?>
<br>
 <input type=checkbox name=as <? if($bow[14] == 'on') echo "checked"; ?>>&nbsp;Скрыть авторов
<br>
<?
 include 'spe_rubricator.php';
?>



<br>
<font color=red>*</font><b>Ключевые слова</b>
<br>
<textarea name=keyword cols=60 rows=5><? echo $bow[11]; ?></textarea>
<br>
<br>
<font color=red>*</font><b>Аннотация</b>
<br>
<?
include($_CONFIG["global"]["paths"]["admin_path"]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('annots') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              = $bow[7];
$oFCKeditor->Create() ;

echo "<br>

<b>Ссылка на текст публикации</b>
<br>
";

$oFCKeditor2 = new FCKeditor('plink') ;
$oFCKeditor2->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor2->Value              = $bow[8];
$oFCKeditor2->Create() ;

?>
<br>
<br>


<input type=checkbox name=can <? if($bow[9] == 'on') echo "checked"; ?>>&nbsp;Может появляться в блоке «Из наших публикаций»
<br>
<br>
<table> <tr> <td>
<b>Заменить изображения:</b>
</td></tr>
<tr><td>
<b>Фото 128x148
</b> <br> <input
type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input name="pic1" type="file"> </td> <td> <b>Фото
240x320 >
</b>
<br>
<input name=pic2 type="file"><br> </td> </tr><tr><td>
<?

 echo "<img width=128 height=148 src='http://".
        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picsmall]."' />";
 echo "<img width=240 height=320 src='http://".
        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picbig]."' />";
?>
</tr>
</table>
<br><br>
<input type=submit value=Проверить>
<input type=hidden name=eid value=<? echo $bow[0]; ?>>
<input type=hidden name=pic1 value=<? echo $bow[picsmall] ?>>
<input type=hidden name=pic2 value=<? echo $bow[picbig] ?>>
</form>
<?
}

?>
