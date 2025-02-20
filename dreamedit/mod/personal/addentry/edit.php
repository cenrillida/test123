Редактирование (edit)

<?

  global $DB,$_CONFIG;
 /* $news=$DB->select("SELECT * FROM persona_user WHERE id_persona=".$_REQUEST['oi']);
  if (count($news)>0)
  {
     echo "<br /><font color=red><b>Есть ввод от пользователя<b></font>"; $new=$news[0];
  }
 */ 
$cow='';

  if (!empty($new[photo]))
     echo "<br /><img src=../photo_bank/".$new[photo]. ">";

  $result =  $DB->select('SELECT * from persons where id='.$_REQUEST['oi']);

//Проверить, нет ли изменений

echo "<br /><font color='red'>".$rowsnew[0][comment]."</font>";

  foreach($result as $cow) {
}
?>

<form enctype="multipart/form-data" action=index.php?mod=personal&oper=add method=post>
<input type=hidden value=<? echo $cow[oi]; ?> name=reid>
<input type=hidden value=do name=test>
<input type=hidden name=oi value=<? echo $_GET['oi']; ?>>
<table>
 <tr>
  <td width='60%'>
   <b>Фамилия</b><br />
   <input type=text name=surname value="<? echo $cow[surname]; ?>" >
  <br />
   <b>Имя</b><br />
   <input type=text name=name value="<? echo $cow[name]; ?>">

  <br />
   <b>Отчество</b><br />
      <input type=text name=fname value="<? echo $cow[fname]; ?>">
   <br />
<?
   if (!empty($news[0][fio_en]))
	   echo "<font color=red><b>".$news[0][fio_en]."</b></font><br />";
?>
   <b>ФИО на английском: </b>
      <input type=text size=100 name=Autor_en value="<? echo $cow[Autor_en]; ?>">

   <br />
   <br />
   <b>Фамилия на английском ( для правильного вывода)</b><br />
   <input type=text name=LastName_EN value="<? echo $cow[LastName_EN]; ?>" >
  <br />
   <b>Имя на английском ( для правильного вывода)</b><br />
   <input type=text name=Name_EN value="<? echo $cow[Name_EN]; ?>">

  <br /><input type=checkbox name='full_name_echo'  <? if($cow['full_name_echo']==1) echo checked; ?>
      >&nbsp;Выводить полное имя
      <br /><br />
   <b>Заменить фотографии</b> <br />
   Фото 63x84
   <br>
   <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
   <input name="pic1" type="file">
   <br />
   Фото 180x240
   <br>
   <input name=pic2 type="file"><br>
      <br>
      <br>
      <a href="?mod=personal&oi=<?=$_GET['oi'];?>&oper=delete_img" target="_blank" onclick="return confirm('Вы уверены, что хотите удалить фотографии?')" style="border: 1px solid gray; padding: 5px; color: gray;">Удалить фотографии</a>
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
$buffer=$DB->select("SELECT id,CONCAT(surname, ' ', name, ' ', fname) AS full
						FROM persons
						ORDER BY surname");


//Выбор другой анкеты

echo "<br><b>Дублирующая персона(Профиль персоны со старой фамилией)</b><br><select name=second_profile>";
echo "<option value='-1'>&nbsp;</option>";

foreach ($buffer as $qq)
{
    if (($cow[second_profile]) == $qq[id]) $sel='selected'; else $sel="";
    echo "<option value='".$qq[id]."' ".$sel.">".$qq[full]."</option>";

}
echo "</select>";

echo "<br>";

$buffer="";
$qq='';
$buffer=$DB->select("SELECT c.el_id AS id,c.icont_text AS full
						FROM adm_directories_content AS c
                        INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=7
						WHERE icont_var='text'
							ORDER BY c.icont_text");

//Выбор ученой степени

echo "<br><b>Ученая степень</b><br>
<select name=us><option value='-1'></option>";
//<option value='".$cow[4]."'>".$qq[$cow[4]]."</option><option value=-1>&nbsp;</option>";

foreach($buffer as $qq)
{
//for($i=0; $i < count($qq); $i++)
 if (($cow[us]) == $qq[id]) $sel='selected'; else $sel="";
 echo "<option value='".$qq[id]."' ".$sel.">".$qq[full]."</option>";
}
echo "</select>";

echo "<br>";

$buffer="";
$qq='';
$buffer=$DB->select("SELECT c.el_id AS id,c.icont_text AS full
						FROM adm_directories_content AS c
                        INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=8
						WHERE icont_var='text'
							ORDER BY c.icont_text");

//Выбор ученой степени

echo "<br><b>Ученое звание</b><br>
<select name=uz>";
//<option value='".$cow[5]."'>".$qq[$cow[5]].
echo "</option><option value=-1>&nbsp;</option>";
foreach($buffer as $qq)
{
 if (($cow[uz]) == $qq[id]) $sel='selected'; else $sel="";
 echo "<option value='".$qq[id]."' ".$sel.">".$qq[full]."</option>";
}
echo "</select>";

$rans=$DB->select("SELECT c.el_id AS id,c.icont_text AS full FROM adm_directories_content AS c
                  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=10
						WHERE icont_var='value'
						ORDER BY c.icont_text");
?>

<br><br>
<b>Членство в РАН</b>
<br>
<?
echo "<select name=4len><option value=''></option>";

foreach($rans as $qq)
{

 if (($cow[ran]) == $qq[id]) $sel='selected'; else $sel="";
 	echo "<option value='".$qq[id]."' ".$sel.">".$qq[full]."</option>";
}
?>
</select>
<br /><br />
<b>Специальность (для членов дисcовета)</b><br />
<?
$specdss=$DB->select("SELECT c.el_id AS id,c.icont_text AS full FROM adm_directories_content AS c
                  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=17
						WHERE icont_var='text'
						ORDER BY c.icont_text");
for($i=1;$i<=4;$i++) {
  $spec_num=$i;
  if($i==1)
    $spec_num="";

  echo "<br /><b>";
  switch ($i) {
    case 1:
      echo "Д 002.003.01";
      break;

    case 2:
      echo "Д 002.003.02";
      break;

    case 3:
      echo "Д 002.003.03";
      break;
    
    default:
      echo $i;
      break;
  }
  echo "</b><br />";
  echo "<select name='spec_ds".$spec_num."' id='spec_ds".$spec_num."'>";


  if($cow['spec_ds'.$spec_num]==0)
  {
  	echo "<option value=0 selected></option>";
  }
  else
  {
  	echo "<option value=0></option>";
  }

  foreach($specdss as $ds)
  {
     if (($cow['spec_ds'.$spec_num]) == $ds[id]) $sel=' selected '; else $sel="";
     echo "<option title='".$ds[full]."' value=".$ds[id].$sel.">".substr($ds[full],0,80)."</option>";

  }

  echo "</select>";
}
?>
<br><br>
    <b>Годы жизни</b>
    <br>
    <input type=text name=rewards value=<? echo $cow['rewards']; ?>>
    <!--<br>
    <b>Дополнительные регалии на английском</b>
    <br>-->
    <input type=hidden name=rewards_en value=<? echo $cow['rewards_en']; ?>>
    <br>
<?

$buffer="";
$qq='';
$buffer=$DB->select("SELECT c.el_id AS id,c.icont_text AS text
                      FROM adm_directories_content AS c
                      INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=9
						WHERE icont_var='text'
							ORDER BY c.icont_text");

//Выбор должности

?>
<br>
<?
echo "<br><b>Должность</b><br><select name=dolj><option value='-1'></option>";
foreach ($buffer as $qq)
{
 if ($qq[id]==($cow[dolj])) $sel=' selected ';else $sel='';
 echo "<option value='".($qq[id])."' ".$sel.">".$qq[text]."</option>";
}
echo "</select><br />";

echo "<b>Подразделение</b><br />";
$_POST[otd_name]='otdel';
include 'mod/personal/addentry/otdel.php';

echo "<br><b>Должность2</b><br><select name=dolj2><option value='-1'></option>";
foreach ($buffer as $qq)
{
 if ($qq[id]==($cow[dolj2])) $sel=' selected ';else $sel='';
 echo "<option value='".($qq[id])."' ".$sel.">".$qq[text]."</option>";
}
echo "</select><br />";
echo "<b>Подразделение</b><br />";
$_POST[otd_name]='otdel2';
include 'mod/personal/addentry/otdel.php';

echo "<br><b>Должность3</b><br><select name=dolj3><option value='-1'></option>";
foreach ($buffer as $qq)
{
 if ($qq[id]==($cow[dolj3])) $sel=' selected ';else $sel='';
 echo "<option value='".($qq[id])."' ".$sel.">".$qq[text]."</option>";
}
echo "</select><br />";
echo "<b>Подразделение</b><br />";
$_POST[otd_name]='otdel3';
include 'mod/personal/addentry/otdel.php';
?>
<br /><br />
<b>Строка для сайта</b>
<br>
<textarea cols=100 rows=2 name=ForSite><? echo $cow['ForSite']; ?></textarea>
<br />
<b>Строка для сайта на английском</b>
<br>
<textarea cols=100 rows=2 name=ForSite_en><? echo $cow['ForSite_en']; ?></textarea>
<br>
<br />

<!-- -->


<br >
<strong>Контактная информация</strong>

<table cellspacing=3 width=70%><tr>
<td valign='top'><b>Телефон публичный</b>
<br>
<input name=tel1 value='<? echo $cow[tel1]; ?>' >
</td>
<td valign='top'><b>Телефон для администрации</b>
<br>
<input name=tel2 value='<? echo $cow[tel2]; ?>' >
</td></tr>
<tr>
<td><b>e-mail публичный</b>
<br>
<input name=mail1 value=<? echo $cow[mail1]; ?> >
</td>
<td><b>e-mail для администрации</b>
<br>
<input name=mail2 value=<? echo $cow[mail2]; ?> >
</td>
<td width=250 align=right>
</td>
</tr></table>

    <br>
    <p>
        <b>Все e-mail для рассылки(через запятую, без пробелов)</b>
    </p>
    <p><input style="width: 400px;" name=emails_for_mailing value=<? echo $cow["emails_for_mailing"]; ?> ></p>
    <br>
    <p>
        <b>ORCID</b>
    </p>
    <p><input style="width: 150px;" name=orcid value=<? echo $cow["orcid"]; ?> ></p>
    <br>
    <p>
        <b>Ссылка на сторонний ресурс (Только для списка дис. советов и ученого совета)</b>
    </p>
    <p><input style="width: 400px;" name=external_link value=<? echo $cow["external_link"]; ?> ></p>
    <br>
<br>
<b>О себе</b>
<br>

    <?
    echo "<textarea tag=\"about\" name=\"about\" id=\"about\">" . htmlspecialchars($cow['about']) . "</textarea>\n";
    ?>
    <script>
        var editorElement = CKEDITOR.document.getById( 'about' );
        CKEDITOR.replace( 'about', {
            on: {
                paste: function(e) {
                    if (e.data.dataValue !== 'undefined')
                        e.data.dataValue = e.data.dataValue.replace(/(\<br ?\/?\>)+/gi, '<p>');
                }
            },
            filebrowserBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html?Type=Images',
            filebrowserUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserWindowWidth : '1000',
            filebrowserWindowHeight : '700'
        } );
        CKEDITOR.add
        CKEDITOR.config.contentsCss = [ '/newsite/css/bootstrap.min.css', '/newsite/css/product.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/product.css");?>', '/newsite/css/ck_additional.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/ck_additional.css");?>','https://use.fontawesome.com/releases/v5.15.3/css/all.css'] ;
    </script>
<br>

<b>О себе на английском</b>
<br>

    <?
    echo "<textarea tag=\"about_en\" name=\"about_en\" id=\"about_en\">" . htmlspecialchars($cow['about_en']) . "</textarea>\n";
    ?>
    <script>
        var editorElement = CKEDITOR.document.getById( 'about_en' );
        CKEDITOR.replace( 'about_en', {
            on: {
                paste: function(e) {
                    if (e.data.dataValue !== 'undefined')
                        e.data.dataValue = e.data.dataValue.replace(/(\<br ?\/?\>)+/gi, '<p>');
                }
            },
            filebrowserBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html?Type=Images',
            filebrowserUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserWindowWidth : '1000',
            filebrowserWindowHeight : '700'
        } );
        CKEDITOR.add
        CKEDITOR.config.contentsCss = [ '/newsite/css/bootstrap.min.css', '/newsite/css/product.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/product.css");?>', '/newsite/css/ck_additional.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/ck_additional.css");?>','https://use.fontawesome.com/releases/v5.15.3/css/all.css'] ;
    </script>


<br>
<input type=checkbox name='grant_ac_council'  <? if($cow['grant_ac_council']==1) echo checked; ?>
 >&nbsp;Почетный член Ученого совета (!Для вывода должен находится в списке членов Ученого Совета!)
 <br>
 <br>
<input type=checkbox name='full'  <? if($cow['full']==1) echo checked; ?>
 >&nbsp;Не показывать в списке сотрудников
    <br>
    <input type=checkbox name='is_closed'  <? if($cow['is_closed']==1) echo checked; ?>
    >&nbsp;Закрыть личную страницу
<br>
<br>


<br><br>
<input type=submit value="Проверить">


</form>
