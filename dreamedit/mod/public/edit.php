<script language="JavaScript">
function tag_select(tt)
{

   for(i=0;i<document.publ.tags_select.length;i++)
   {
   	   if(document.publ.tagslist.value==document.publ.tags_select[i].value)
   	      break;
   }

   if (i>=document.publ.tags_select.length)
   {
	   var txt=document.publ.keyword;

	   if (txt.value!=null && txt.value!="")
	       txt.value=txt.value+';'+ document.publ.tagslist.value;
	   else
	       txt.value=document.publ.tagslist.value;
   }
   else
      alert("Это слово уже выбрано");
}
function tag_select_en(tt)
{

   for(i=0;i<document.publ.tags_select_en.length;i++)
   {
   	   if(document.publ.tagslist_en.value==document.publ.tags_select_en[i].value)
   	      break;
   }

   if (i>=document.publ.tags_select_en.length)
   {
	   var txt=document.publ.keyword_en;

	   if (txt.value!=null && txt.value!="")
	       txt.value=txt.value+';'+ document.publ.tagslist_en.value;
	   else
	       txt.value=document.publ.tagslist_en.value;
   }
   else
      alert("Это слово уже выбрано");
}
function parent()
{
  var pid=document.getElementById('parent_id').options[document.getElementById('parent_id').selectedIndex].text;
  var ppp=pid.split('# ');
 
  document.getElementById('date').value=ppp[1];
  document.getElementById('tip').value=441;
  document.getElementById('vid').value=446;
}
function PublCheck() {

  if (document.publ.name.value=="" ) {
	alert("Не введено название");
	return false;
  }
  if (document.publ.date.value=="" ) {
	alert("Не введен год выпуска");
	return false;
  }

  if (document.publ.vid.value=="" || document.publ.vid.value<1) {
	alert("Не выбран классификатор ГРНТИ");
	return false;
  }
  if (document.publ.tip.value=="" || document.publ.tip.value<1) {
	alert("Не выбран тип публикации");
	return false;
  }

  if (document.publ.matrix.value=="" ) {
	alert("Не указаны авторы");
	return false;
  }
    if (document.publ.rubric.value=="" ) {
	alert("Не введена рубрика");
	return false;
  }
   if (document.publ.annots.value==""  || document.publ.annots.value=="<p>&nbsp;</p>") {
	alert("Не введена аннотация");
	return false;
  }
  if (document.publ.keyword.value=="" ) {
	alert("Не введены ключевые слова");
	return false;
  }

}

</script>

<?


global $DB,$_CONFIG;
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/jscalendar/calendar.inc.php";
//mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
//mysql_select_db($_CONFIG['global']['db_connect']['db_name']);
//$result =  mysql_query("select * from publ where id=".$_GET['id']);
$bow0=$DB->select("SELECT * FROM publ WHERE id=".$_REQUEST[id]); ?>

<?php
//while($bow = mysql_fetch_array($result))
foreach($bow0 as $bow)
{
echo "<b>EDIT</b> id=".$bow[id];
?>

<form name=publ enctype="multipart/form-data" action=index.php?mod=public&action=save method=post onSubmit="return PublCheck()">
<input type=hidden name=sent value=1>
<font color=red>*</font>Название (полная библиографическая ссылка)
<br>
<textarea name=name cols=120 class="publ_search"><? echo $bow[name]; ?></textarea>
<br>
Название на английском
<br>
<textarea name=name2 cols=120><? echo $bow[name2]; ?></textarea>
<br>
Название(титул)
<br>
<textarea name=name_title cols=120><? echo $bow[name_title]; ?></textarea>
<br>
<br>
<b>Адрес публикации на сайте</b>


<br>
<input size="200" name=uri value="<? echo $bow[uri]; ?>">
    <p class="form_help">Если поле пустое - заполняется по названию, если название пустое - то адрес будет в виде publ-x (где x - ID публикации)</p>
<br>
<b>Головная публикация</b>
<?

$publmain=$DB->select("SELECT id,name,year FROM publ WHERE (vid=453 OR vid=427) ORDER BY name");

echo "<select name='parent_id' id='parent_id' onchange=parent()>";
echo "<option value=''></option>";
foreach ($publmain as $pmain)
{
   if ($bow[parent_id]==$pmain[id]) $sel=" selected "; else $sel="";
   echo "<option value=".$pmain[id].$sel.">".substr($pmain[name],0,100)." # ".$pmain[year]."</option>";
}

echo "</select>";

?>
<br /><br />
<b>Начальная страница: </b><input name='page_beg' id='page_beg' value='<?=@$bow[page_beg]?>'></ipput>
<br /><br />
<table>
<tr>
<td>
<font color=red>*</font>Год выпуска
<br>
<input type=text name=date id='date' maxlength=4 value='<? echo $bow[year]; ?>'  style="width: 50">
</td>
<td>
<font color=red></font>Точная дата публикации (если нужно)
<br>
<input type=text size='10' id=date_fact name=date_fact value='<? echo $bow[date_fact]; ?>'  > <br>
    <?php
//    error_reporting(E_ALL);
//    ini_set('display_errors', 1);

	$btnName='calendar';
    $namecln='date_fact';
    $dt=cln($btnName,$namecln);
?>
</td>
</tr>
</table>

<br>
<?

$dateTime = DateTime::createFromFormat('d.m.y', $bow['date']);
if(!empty($dateTime)) {
    $newDateString = $dateTime->format("Y-m-d");
}
?>
    <br>
    Дата публикации
    <br>
    <input type="date" id="date_publ" name="date_publ" value="<? echo $newDateString?>" >
    <br>
    <br>
    <?

$lands=$DB->select("SELECT c.icont_text AS land,c.el_id
                    FROM adm_directories_content AS c
                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=22
					WHERE c.icont_var='text'
					ORDER BY c.icont_text
					");
			//		print_r($bow);
echo "<b>Страна</b>";
echo "<select name='land' id='land'>";
echo "<option value=''></option>";

foreach($lands as $land)
{
   if ($land[el_id]==$bow[land]) $sel=" selected "; else $sel="";
   echo "<option value='".$land[el_id]."'".$sel.">".$land[land],"</option>";
}	
echo "</select>";				
?>
<br />


<br>

<table><tr>
<td>
<font color=red>*</font>Вид
<br>
<?
// Читаем виды публикаций

$vid0=$DB->select("SELECT c.icont_text AS vid,c.el_id AS id 
                    FROM adm_directories_content AS c
                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=19
					WHERE c.icont_var='text'
					ORDER BY c.icont_text");
$dr=new Directories();

//print_r($rows);
echo "<select name=vid id='vid'>";

//echo "<option value='".$bow[3]."'>".$vid0[$bow[vid]][text]."</option>";
echo "<option value=-1></option>";
$gruppa='';
foreach($vid0 as $i=>$vid)
{
 if ($bow[vid]==$vid[id]) $sel='selected'; else $sel="";

 echo "<option value='".$vid[id]."' ".$sel." >".$vid[vid]."</option>";
}

?>
</select>


</td><td>

<?

$type0=$DB->select("SELECT c.icont_text AS text,c.el_id AS id 
                    FROM adm_directories_content AS c
                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=21
					WHERE c.icont_var='text'
					ORDER BY c.icont_text");
$dr=new Directories();
//$rows=$dr->getRubricsAll();
?>

<font color=red>*</font>Тип
<br>
<select name=tip id='tip'>

 <option value=-1></option>
<?

foreach($type0 as $i=>$type)
{
 if ($bow[tip]==$type[id]) $sel='selected'; 
 else $sel="";
 echo "<option value='".$type[id]."' ".$sel." >".$type[text]."</option>";
}
?>


</select>

</td>

<td>
Формат
<br>
<select name=format>
<?
 if ($bow[format]==0 || empty($bow[format])) $sel='selected';
 else $sel="";
 echo "<option value=0 ".$sel." >Текст</option>";
 if ($bow[format]==1) $sel='selected';
 else $sel="";
 echo "<option value=1 ".$sel." >Аудио</option>";
 if ($bow[format]==2) $sel='selected';
 else $sel="";
 echo "<option value=2 ".$sel." >Видео</option>";
?>
</select>


</td>
</tr>

<tr

</table>

<br>
<b>ISBN/ISSN</b>

<br>
<input name=izdat value="<? echo $bow[izdat]; ?>">

<br>
<br>
<b>DOI</b>


<br>
<input name=doi value="<? echo $bow[doi]; ?>">

<br>

<br>
<b>Выводить на главной</b>
<br>
<?
if ($bow[formain]=="on" || $bow[formain]==1)
   echo "<input type=checkbox name=formain checked></input>";
else
   echo "<input type=checkbox name=formain ></input>";
?>


<?
 include 'spe_selector.php';
?>
<br>
 <input type=checkbox name=hide_autor <? if($bow[hide_autor] == 'on') echo "checked"; ?>>&nbsp;Скрыть авторов
<br>

<?
    include 'spe_selector2.php';


// Рубрики
$rowsrub=$DB->select("SELECT c.el_id, c.icont_text AS rubric FROM adm_directories_content AS c 
                      INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=23
					  WHERE c.icont_var='text'
					  ORDER BY c.icont_text");
echo "<br /><br /><b>Рубрики:</b><br />";
echo "<select name='rubric' id='rubric'>";
echo "<option value=''></option>";
foreach ($rowsrub as $r)
{
   if ($bow[rubric]==$r[el_id]) $sel=" selected ";else $sel='';
   echo "<option value=".$r[el_id].$sel.">".$r[rubric]."</option>";
}
echo "</select><br />";

echo "<select name='rubric2' id='rubric2'>";
echo "<option value=''></option>";
foreach ($rowsrub as $r)
{
   if ($bow[rubric2]==$r[el_id]) $sel=" selected ";else $sel='';
   echo "<option value=".$r[el_id].$sel.">".$r[rubric]."</option>";
}
echo "</select><br />";
?>

<br>
<font color=red>*</font><b>Ключевые слова (отделяются точкой с запятой)</b>
<br>

<!------------------------------------------------------------------>
<?
$val0=explode(";",$bow[keyword]);
	echo "<div style='display:none;'>";
	echo "<select name='tags_select' type='hidden'>";
	foreach($val0 as $val)
	{
		echo "<option value='".$val."'></options>";
	}
	echo "</select>";
	echo "</div >";



$rows=$DB->select("SELECT keyword FROM publ ");

foreach($rows as $row)
{
  $kws=explode(";",trim($row[keyword]));
  foreach($kws as $k=>$kw)
  {
  	$k=trim($kw);
  	if (!empty($kw) && trim($kw)!="-" && trim($kw)!="." && $kw!="")
  	{
  		if (empty($tags[strtolower($kw)])) $tags[strtolower($kw)]=0;
  		$tags[strtolower($kw)]++;

  	}
  }

}
if (count($tags)>0) ksort($tags);
?>
<table>
   <tr>
      <td valign='top'>
	      <textarea name=keyword cols=160 rows=5><? echo $bow['keyword']; ?></textarea>
      </td>
   </tr>
</table>
<!------------------------------------------------------------------>
<font color=red></font><b>Ключевые слова на английском(разделяются точкой с запятой)</b>
<?
$val0=explode(";",$_POST[keyword_en]);
	echo "<div style='display:none;'>";
	echo "<select name='tags_select_en' type='hidden'>";
	foreach($val0 as $val)
	{
		echo "<option value='".$val."'></options>";
	}
	echo "</select>";
	echo "</div >";



$rows=$DB->select("SELECT keyword_en FROM publ ");

foreach($rows as $row)
{
  $kws=explode(";",trim($row[keyword_en]));
  foreach($kws as $k=>$kw)
  {
  	$k=trim($kw);
  	if (!empty($kw) && trim($kw)!="-" && trim($kw)!="." && $kw!="")
  	{
  		if (empty($tags[strtolower($kw)])) $tags_en[strtolower($kw)]=0;
  		$tags_en[strtolower($kw)]++;

  	}
  }

}
if (count($tags_en)>0) ksort($tags_en);
?>
<table>
   <tr>
      <td valign='top'>
	      <textarea name=keyword_en cols=160 rows=5><? echo $bow['keyword_en']; ?></textarea>
      </td>
   </tr>
</table>
<!------------------------------------------------------------------>




<br>
<br>
<font color=red>*</font><b>Аннотация</b>
<br>
<?
echo "<textarea tag=\"annots\" name=\"annots\" id=\"annots\">" . htmlspecialchars($bow['annots']) . "</textarea>\n";
?>
<script>
    var editorElement = CKEDITOR.document.getById( 'annots' );
    CKEDITOR.replace( 'annots', {
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
<b>Аннотация на английском</b>
<br>
    <?
    echo "<textarea tag=\"annots_en\" name=\"annots_en\" id=\"annots_en\">" . htmlspecialchars($bow['annots_en']) . "</textarea>\n";
    ?>
    <script>
        var editorElement = CKEDITOR.document.getById( 'annots_en' );
        CKEDITOR.replace( 'annots_en', {
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
<?

echo "<br>

<b>Ссылка на текст публикации</b>
<br>
"; ?>
    <?
    echo "<textarea tag=\"plink\" name=\"plink\" id=\"plink\">" . htmlspecialchars($bow['link']) . "</textarea>\n";
    ?>
    <script>
        var editorElement = CKEDITOR.document.getById( 'plink' );
        CKEDITOR.replace( 'plink', {
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
<?
echo "<br>

<b>Ссылка на текст публикации (английский)</b>
<br>
";
?>
    <?
    echo "<textarea tag=\"plink_en\" name=\"plink_en\" id=\"plink_en\">" . htmlspecialchars($bow['link_en']) . "</textarea>\n";
    ?>
    <script>
        var editorElement = CKEDITOR.document.getById( 'plink_en' );
        CKEDITOR.replace( 'plink_en', {
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
<input type=checkbox name=vid_inion <? if($bow['vid_inion'] == '1') echo "checked"; ?>>&nbsp;
Не включать в общий список
<br>
<br>
<br>
Размещено в РИНЦ
<input type=edit size=50 name=rinc id='rinc' value='<?=@$bow[rinc]?>'></input>

<br>

<!--
<br>
<input type=checkbox name=ebook <? if($_POST['ebook'] == 'on') echo "checked"; ?>>&nbsp;Поставить логотип «Электронная публикация»
<br>
<br>
<input type=checkbox name=epolis <? if($_POST['epolis'] == 'on') echo "checked"; ?>>&nbsp;Поставить логотип «Публикация в Полисе»
<br>
<br>
-->
<table> <tr> <td>
<b>Заменить изображения:</b>
</td></tr>
<tr><td>
<b>Фото 70x100
</b> <br> <input
type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input name="pic1" type="file"> </td> <td> <b>Фото
180x240
</b>
<br>
<input name=pic2 type="file"><br> </td>
</tr><tr>
<?

 echo "<td valign='top'><img  src='https://".
        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picsmall]."' /></td>";
 echo "<td valign='top'><img  src='https://".
        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picbig]."' /></td>";
?>
</tr>
</table>
    <br>
    <table>
        <tr>
            <td><input type=checkbox name=elogo id='elogo'>Поставить логотип </td><td><img width=35 height=42 align=absmiddle src=pfoto/e_logo.jpg /></td>
        </tr>
    </table>
<br>
 <input type=checkbox name=status <? if($bow[status] == '1') echo "checked"; ?>>&nbsp;Публиковать
<br>
<br><br>
<input type=checkbox name=out_from_print <? if($bow[out_from_print] == '1') echo "checked"; ?>>&nbsp;Вышла из печати
<br><br>
<input type=checkbox name=no_publ_ofp <? if($bow[no_publ_ofp] == '1') echo "checked"; ?>>&nbsp;Не выводить в "Вышли из печати"
<br><br>
<!--<input type=submit value=Проверить>-->
 <input type=submit value='Сохранить в БД'>&nbsp;<a href="javascript:history.back()" onMouseOver="window.status='Назад';return true">назад</A>

<input type=hidden name=eid value=<? echo $bow[id]; ?>>

<input type=hidden name=pic1 value=<? echo $bow[picsmall] ?>>
<input type=hidden name=pic2 value=<? echo $bow[picbig] ?>>
<input type=hidden name=pic3 value=<? echo $bow[picmain] ?>>
</form>
<?

}
function cln($btnName,$name){


   echo "<img src=\""."/files/Image/".$btnName.".jpg\" id=\"button_".$btnName."_".$name."\"
        style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" width=\"17\" height=\"17\" alt=\"".
        Dreamedit::translate("Выбрать дату")."\" title=\"".Dreamedit::translate("Выбрать дату")."\" />";
?>
     <script>
    Calendar.setup({
        inputField     :    "<?=$name?>",
        ifFormat       :    "%Y.%m.%d ",
        button         :    "button_<?=$btnName?>_<?=$name?>",
        showsTime      :    true,
        align          :    "br"
    });
</script>
<?
}
?>
