Ввод информации о персоне
<form enctype="multipart/form-data" id="data_form" action=index.php?mod=personal&oper=add method=post>
<input type=hidden value=do name=test>
<input type=hidden name=oi value=<? echo $_POST['oi']; ?>>
<table width=70%>
 <tr>
  <td>
   <b>Фамилия</b>
   <br>
   <input type=text name=surname value=<? echo $_POST['surname']; ?>>
  </td>
  </tr><tr>
  <td>
   <b>Имя</b>
   <br>
   <input type=text name=name value=<? echo $_POST['name']; ?>>
  </td>
  </tr><tr>
  <td>
   <b>Отчество</b>
   <br>
   <input type=text name=fname value=<? echo $_POST['fname']; ?>>
  </td>
  </tr><tr>

  <td >
   <b>ФИО на английском: </b>
      <input type=text size=100 name=Autor_en value=<? echo $_POST['Autor_en']; ?>>
  </td>
 </tr><tr>
        <td >
            <b>Фамилия на английском ( для правильного вывода): </b>
            <br>
            <input type=text name=LastName_EN value=<? echo $_POST['LastName_EN']; ?>>
        </td>
    </tr><tr>

        <td >
            <b>Имя на английском ( для правильного вывода): </b>
            <br>
            <input type=text name=Name_EN value=<? echo $_POST['Name_EN']; ?>>
        </td>
    </tr>
    <tr>
        <td>
            <input type=checkbox name='full_name_echo'> Выводить полное имя
        </td>
    </tr>
</table>

<table>
<tr>
<td>
<b>Фото 63x84</b> <br>
<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input name="pic1" type="file">
</td>
<td>
<b>Фото 180x240</b> <br>
<input name=pic2 type="file"><br>
</td>
</tr>
</table>

<?
global $DB,$_CONFIG;

$qq='';
$buffer=$DB->select("SELECT id,CONCAT(surname, ' ', name, ' ', fname) AS full
						FROM persons
						ORDER BY surname");


//Выбор другой анкеты

echo "<br><b>Дублирующая персона(Профиль персоны со старой фамилией)</b><br><select name=second_profile>";
echo "<option value='-1'>&nbsp;</option>";

foreach ($buffer as $qq)
{

    echo "<option value='".$qq[id]."'>".$qq[full]."</option>";

}
echo "</select>";

echo "<br>";

$buffer='';
$qq='';
$buffer=$DB->select("SELECT c.el_id AS id,c.icont_text AS full
						FROM adm_directories_content AS c
                        INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=7
						WHERE icont_var='text'
						ORDER BY c.icont_text");


//Выбор ученой степени

echo "<br><b>Ученая степень</b><br><select name=us>";
//if ($_POST['us'])
// echo "<option value='".$_POST['us']."'>".$qq[$_POST['us']]."</option>";
echo "<option value='-1'>&nbsp;</option>";

foreach ($buffer as $qq)
{

  if (($_POST[us]+1) == $qq[id]) $sel='selected'; else $sel="";
//for($i=0; $i < count($qq); $i++)
 echo "<option value='".$qq[id]."'>".$qq[full]."</option>";

}
echo "</select>";

echo "<br>";

$buffer='';
$qq='';
$buffer=$DB->select("SELECT c.el_id AS id,c.icont_text AS full
						FROM adm_directories_content AS c
                        INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=8
						WHERE icont_var='text'
							ORDER BY c.icont_text");
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[full];
}



//Выбор ученого звания

echo "<br><b>Ученое звание</b><br><select name=uz>";
if ($_POST['uz'])
 echo "<option value='".$_POST['uz']."'>".$qq[$_POST['uz']]."</option>";
else echo "<option value='-1'>&nbsp;</option>";
for($i=0; $i < count($qq); $i++)
 echo "<option value='".$i."'>".$qq[$i]."</option>";
echo "</select>";

?>

<br><br>
<b>Членство в РАН</b>
<br>

<?
echo "<select name=4len><option value=''></option>";
$rans=$DB->select("SELECT c.el_id AS id,c.icont_text AS full FROM adm_directories_content AS c
                  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=10
						WHERE icont_var='value'
						ORDER BY c.icont_text");
foreach($rans as $qq)
{

 	echo "<option value='".$qq[id]."' >".$qq[full]."</option>";
}
?>

</select>
<br /><br />
<b>Специальность (для членов дисcовета)</b><br />
<?
$specdss=$DB->select("
						SELECT c.el_id AS id,c.icont_text AS full FROM adm_directories_content AS c
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
echo "<select name='spec_ds".$spec_num."' id='spec_ds".$spec_num."'><option value=''></option>";

foreach($specdss as $ds)
{
    echo "<option title='".$ds[full]."' value=".$ds[id].">".substr($ds[full],0,80)."</option>";

}

echo "</select>";
}
?>
<br><br>
<b>Годы жизни</b>
<br>
    <input type=text name=rewards value=<? echo $_POST['rewards']; ?>>
    <!--<br>
    <b>Дополнительные регалии на английском</b>
    <br>-->
    <input type=hidden name=rewards_en value=<? echo $_POST['rewards_en']; ?>>
<br>

<?

$buffer = '';

$qq='';
$buffer=$DB->select("SELECT c.el_id AS id,c.icont_text AS text
                      FROM adm_directories_content AS c
                      INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=9
						WHERE icont_var='text'
							ORDER BY c.icont_text");
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[text];
}


//Выбор должности

?>
<br>
<?

echo "<br><b>Должность</b><br><select name=dolj><option value=''></option>";
//<option value='".$_POST['dolj']."'>".$qq[$_POST['dolj']]."</option>";
//for($i=0; $i < count($qq); $i++)
foreach($buffer as $qq)
 echo "<option value='".$qq[id]."'>".$qq[text]."</option>";
echo "</select><br />";
echo "<b>Подразделение</b><br />";
$_POST[otd_name]='otdel';
include 'mod/personal/addentry/otdel.php'; 


echo "<br><b>Должность2</b><br><select name=dolj2><option value=''></option>";
//<option value='".$_POST['dolj']."'>".$qq[$_POST['dolj']]."</option>";
//for($i=0; $i < count($qq); $i++)
foreach($buffer as $qq)
 echo "<option value='".$qq[id]."'>".$qq[text]."</option>";
echo "</select><br />";
echo "<b>Подразделение</b><br />";
$_POST[otd_name]='otdel2';
include 'mod/personal/addentry/otdel.php'; 


echo "<br><b>Должность3</b><br><select name=dolj3><option value=''></option>";
//<option value='".$_POST['dolj']."'>".$qq[$_POST['dolj']]."</option>";
//for($i=0; $i < count($qq); $i++)
foreach($buffer as $qq)
 echo "<option value='".$qq[id]."'>".$qq[text]."</option>";
echo "</select><br />";
echo "<b>Подразделение</b><br />";
$_POST[otd_name]='otdel3';
include 'mod/personal/addentry/otdel.php'; 

?>
<br /><br />
<b>Аффилиация</b>
<br>
<textarea cols=100 rows=2 name=ForSite><? echo $_POST['ForSite']; ?></textarea>
<br>
<br />
<b>Аффилиация на английском</b>
<br>
<textarea cols=100 rows=2 name=ForSite_en><? echo $_POST['ForSite_en']; ?></textarea>
<br>



<br /><br />


<br>
<b>Контактная информация</b>
<br>
<table width=70%><tr>
<td><b>Телефон публичный</b>
<br>
<input name=tel1 value=<? echo $_POST['tel1']; ?> >
</td>
<td><b>Телефон для администрации</b>
<br>
<input name=tel2 value=<? echo $_POST['tel2']; ?> >
</td></tr>
<tr>
<td><b>e-mail публичный</b>
<br>
<input name=mail1 value=<? echo $_POST['mail1']; ?> >
</td>
<td><b>e-mail для администрации</b>
<br>
<input name=mail2 value=<? echo $_POST['mail2']; ?> >
</td>
<td width=250 align=right><input type=submit value="Проверить">
</td>

</tr></table>
    <br>
    <p>
        <b>Все e-mail для рассылки(через запятую, без пробелов)</b>
    </p>
    <p><input style="width: 400px;" name=emails_for_mailing value=<? echo $_POST['emails_for_mailing']; ?> ></p>
    <br>
    <p>
        <b>ORCID</b>
    </p>
    <p><input style="width: 150px;" name=orcid value=<? echo $_POST['orcid']; ?> ></p>
    <br>
    <p>
        <b>Ссылка на сторонний ресурс (Только для списка дис. советов и ученого совета)</b>
    </p>
    <p><input style="width: 400px;" name=external_link value=<? echo $_POST['external_link']; ?> ></p>
<br>
<b>О себе</b>
<br>

    <?
    echo "<textarea tag=\"about\" name=\"about\" id=\"about\">" . htmlspecialchars($_POST['about']) . "</textarea>\n";
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
    echo "<textarea tag=\"about_en\" name=\"about_en\" id=\"about_en\">" . htmlspecialchars($_POST['about_en']) . "</textarea>\n";
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

<br>
<input type=checkbox name=ruk>&nbsp;Руководитель
<br>
<input type=checkbox name=usp>&nbsp;Ученый секретарь подразделения
<br>
<input type=checkbox name='full'>&nbsp;Не показывать в списке сотрудников
<br>
<input type=checkbox name='is_closed'>&nbsp;Закрыть личную страницу
<br>
<br>
<input type=submit value="Предпросмотр">


</form>

