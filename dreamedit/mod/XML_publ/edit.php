<?
global $DB,$_CONFIG;
?>
<script language="JavaScript">
function ZTCheck(avt)
{
	if (document.publ.name.value=="") {
		alert("Не введено название");
		return false;
	}
    if (document.publ.date.value=="") {
		alert("Не указан год издания");
		return false;
	}

    if (document.publ.vid.value=="" || document.publ.vid.value<1) {
	alert("Не выбран классификатор ГРНТИ");
	return false;
  }
	if(document.publ.tip.selectedIndex==0) {
		alert("Не выбран тип публикации");
		return false;
	}
	if(document.publ.rubric2.selectedIndex==0) {
		alert("Не выбрана рубрика");
		return false;
	}
	var f_list='';
	for(var i=0;i<avt;i=i+1)
	{
//		alert(document.getElementById("ffioname"+i).innerHTML);
		if (document.getElementById("ffio"+i).selectedIndex==0)
		{
   			f_list=f_list+document.getElementById("ffioname"+i).innerHTML+"<br>";
   		}
   		else
   		{
   		   var a=document.getElementById("ffio"+i);
   		   b=a[a.selectedIndex].value;
   		   f_list=f_list+b+"<br>";
   		}
	}
//	document.getElementById('matrix').innerHTML="<input type=hidden size=100 name='matrix' >" + f_list + "</input>";
	document.publ.matrix.value=f_list;
	alert(f_list+" * "+document.getElementById('matrix').innerHTML);

	return true;
}
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

</script>

<?

//$result =  $DB->select("select * from publ where id=".$_REQUEST['id']);
//foreach($result as $bow)
//{
echo "<b>EDIT</b> ";
//echo $_REQUEST["file"];
//$doc = new DomDocument;
$doc=new DOMDocument('1.0', 'UTF-8');
$doc->validateOnParse = true;
$uploaddir = $_CONFIG['global']['paths'][admin_path]."XMLPubl/";
$doc->load($uploaddir.$_REQUEST["file"],$int);

//echo "<br />".$uploaddir.$_REQUEST["file"]."___".$int."<br />";print_r($doc);
$booktype=$doc->getElementsByTagName("bookType");
$l=$booktype->length;
//echo "<br />l=".$l."<br />";
print $booktype->item(0)->nodeValue;
//print_r($booktype);
for($i=0;$i<$l;$i++)
{
	print $booktype->item($i)->nodeValue;
//	echo $booktype->item(0);
}
$auhtor=$doc->getElementsByTagName("surname");
$auhtor2=$doc->getElementsByTagName("fname");
$auhtorin=$doc->getElementsByTagName("initials");
$auhtorlang=$doc->getElementsByTagName("individInfo");
$title=$doc->getElementsByTagName("title");
$publ=$doc->getElementsByTagName("publ");
$placePubl=$doc->getElementsByTagName("placePubl");

$titleAdd=$doc->getElementsByTagName("titleAdd");
$resp=$doc->getElementsByTagName("resp");
$year=$doc->getElementsByTagName("dateUni");
$year0= convutf8($year->item(0)->nodeValue);
$pages=$doc->getElementsByTagName("pages");
$annots=$doc->getElementsByTagName("abstracts");

$isbn=$doc->getElementsByTagName("isbn");
$seria0=$doc->getElementsByTagName("serName");
$seria=convutf8($seria0->item(0)->nodeValue);
if (!empty($seria)) $seria=" &dash; (".$seria.")";
//$avt00=convutf8($bow->fields[author]);
//$avt0=explode(" and ",$avt00);

?>

<form name=publ enctype="multipart/form-data" action=index.php?mod=XML_publ&action=save method=post  onSubmit="return ZTCheck(<?=@count($avt0)?>)">
<input type=hidden name=sent value=1>
<font color=red>*</font>Название (полная библиографическая ссылка)
<br>
<textarea name=name cols=120><? echo convutf8($title->item(0)->nodeValue).': '.
convutf8($titleAdd->item(0)->nodeValue).' / '.convutf8($resp->item(0)->nodeValue)
; ?> &dash; М.: ИНИОН РАН, <? echo $year0.".".$seria ?>. </textarea>
<br>
Название на английском
<br>
<!--<textarea name=name2 cols=120><? echo convutf8($placePubl->item(0)->nodeValue).".".convutf8($publ->item(0)->nodeValue); ?></textarea>-->
<textarea name=name2 cols=120></textarea>
<br>
<table>
<tr>
<td>
<font color=red>*</font>Год выпуска
<br>
<input type=text name=date maxlength=4 value='<? echo $year0 ?>'  style="width: 50">
</td>
<td>
<font color=red></font>Дата публикации (если нужно)
<br>
<input type=text size='10' id=date_fact name=date_fact   >
<?
	$btnName='calendar';
    $namecln='date_fact';
    $dt=cln($btnName,$namecln);
?>
</td>
</tr>
</table>
<br>
<br>

<table><tr>
<td>
<font color=red>*</font>Вид
<br>
<?
// Читаем виды публикаций

$vid0=$DB->select("SELECT * FROM vid ORDER BY id");


////////////////////////////////////
$dr=new Directories();
$rows=$dr->getRubricsAll();
//print_r($rows);
echo "<select name=vid>";

//echo "<option value='".$bow[3]."'>".$vid0[$bow[vid]][text]."</option>";
echo "<option value=-1></option>";
$gruppa='';
foreach($rows as $i=>$vid)
{
  if (($bow->fields[type]=="article" || $bow->fields[type]=="journal")&& $vid[text]=='Раздел, глава, статья') $sel='selected';
 else $sel="";
 if ($bow->fields[type]=="boor" && $vid[text]=='Монография, сборник') $sel='selected';
 else $sel="";
 if ($gruppa!=$vid[gruppa])
 {
 	echo "<option value=''><b>".mb_strtoupper($vid[gruppa],'cp1251')."</b></option>";
 	$gruppa=$vid[gruppa];
 }
 echo "<option value='".$vid[id]."' ".$sel." >".$vid[gruppa]." - ".$vid[rubrica]."</option>";
}

?>
</select>


</td><td>

<?


$type0=$DB->select("SELECT * FROM type ORDER BY id");

?>


<font color=red>*</font>Тип
<br>
<select name=tip>

 <option value=-1></option>
<?

foreach($type0 as $i=>$type)
{
 if ($bow->fields[type]=="book" && $type[text]=='Книга') $sel='selected';
 else
 {
 if (($bow->fields[type]=="article" || $bow->fields[type]=="journal")&& $type[text]=='Журнал') $sel='selected';
 else $sel="";
 }

 echo "<option value='".$type[id]."' ".$sel." >".$type[text]."</option>";
}
?>


</select>


</td>
<td><font color=red>*</font>Формат
<br>
<select name=format>
<?

 echo "<option value=0 ".$sel." >Текст</option>";

 echo "<option value=1 ".$sel." >Аудио</option>";

 echo "<option value=2 ".$sel." >Видео</option>";
?>
</select>

</td>
</tr>

<tr>
<td colspan='3'>
Вид публикации ИНИОН
<br>
<?
/*
$vidi=$DB->select("SELECT a.el_id AS id,CONCAT(g.icont_text,' - ',a.icont_text) AS text
                  FROM adm_directories_content AS a
                  INNER JOIN adm_directories_content AS s ON s.el_id=a.el_id AND s.icont_var='text'
                  INNER JOIN adm_directories_element AS e ON e.el_id=a.el_id AND e.itype_id=12
                  INNER JOIN adm_directories_content AS gg ON gg.el_id=a.el_id AND gg.icont_var='gruppa'
                  INNER JOIN adm_directories_content AS g ON g.el_id=gg.icont_text AND g.icont_var='text'
                  WHERE a.icont_var='text'
                   ORDER BY s.icont_text");

*/
$vidi=$DB->select("SELECT a.el_id AS id,CONCAT(a.icont_text) AS text
                  FROM adm_directories_content AS a
                  INNER JOIN adm_directories_content AS s ON s.el_id=a.el_id AND s.icont_var='text'
                  INNER JOIN adm_directories_element AS e ON e.el_id=a.el_id AND e.itype_id=12
                  INNER JOIN adm_directories_content AS gg ON gg.el_id=a.el_id AND gg.icont_var='gruppa'
                  INNER JOIN adm_directories_content AS g ON g.el_id=gg.icont_text AND g.icont_var='text'
                  WHERE a.icont_var='text'
                   ORDER BY s.icont_text");


echo "<select name='vid_inion'>";
echo "<option value=-1></option>";
foreach($vidi as $vi)
{
// if ($bow[vid_inion]==$vi[id]) $sel='selected';
// else $sel="";
 echo "<option value='".$vi[id]."' ".$sel." >".$vi[text]."</option>";
}
echo "</select>";
?>

</td>
</tr></table>

<br>
<b>ISBN</b>

<br>
<textarea name=izdat cols=120 rows=1><? echo convutf8($isbn->item(0)->nodeValue); ?></textarea>
<br>
<b>Название журнала</b>

<br>
<input name='journal' size=80 value='<? echo convutf8($bow->fields[journal]); ?>'></input>
<br>
<br />
<b>Номер журнала</b>

<br>
<input name=number value='<? echo convutf8($bow->fields[journal]);  ?>'></input>

<br><br />
<b>Номера cтраниц</b>

<br>
<input name=pages size=80 value='<? echo convutf8($pages->item(0)->nodeValue) ?>'></input>

<br>

<br>
<b>Выводить на главной</b>
<br>
<?

   echo "<input type=checkbox name=formain ></input>";
?>

<br>

<?
// Авторы

$authors_in_base=$DB->select("SELECT id,CONCAT(surname,' ',name,' ',fname,' ') AS fio, surname
   FROM persons ORDER BY surname,name,fname");
echo "<hr><b>АВТОРЫ</b><table>";
$iavt=0;
foreach($auhtor as $k=>$avt0)
{
//   echo  "**".$auhtorlang->item($k)->getAttribute("lang");
   $avt=trim(convutf8($avt0->nodeValue))." ".trim(convutf8($auhtor2->item($k)->nodeValue));
   $surname=trim(convutf8($avt0->nodeValue));
   echo "<tr><td><div id='ffioname".$iavt."'<b>".$avt." "."</b></div></td>";
   echo "<td>&nbsp;&nbsp;&nbsp;</td>";
//   $aa=explode(" ",str_replace(",","",$avt));
   echo "<td><select name='ffio".$iavt."' id='ffio".$iavt."' >";
   echo "<option value=''></option>";
   foreach($authors_in_base as $a)
   {
   	   if($surname == trim($a[surname])) $sel=' selected '; else $sel='';
   	   echo "<option value=".$a[id].$sel.">".$a[fio]."</option>";
   }
   echo "</select></td></tr>";
   $iavt++;
}
echo "</table><hr />";

// include 'spe_selector.php';
?>
<br>
 <input type=checkbox name=hide_autor >&nbsp;Скрыть авторов</input>
<br>
	 <input type='edit' name=aa value=''>
<input type=hidden  name='matrix' value=''>
<br>
<font color=red>*</font><b>Ключевые слова (отделяются запятой)</b>
<br>
<!------------------------------------------------------------------>
<?

$val0=explode(",",convutf8($bow->fields[keywords]));
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
	      <textarea name=keyword cols=60 rows=5><? echo str_replace(",",";",convutf8($bow->fields[keywords])); ?></textarea>
      </td>
      <td valign='top'>
      <!-- Вывести тэги -->
          <select name='tagslist' size=10 onChange=tag_select(this) >
<?
                foreach($tags as $tag=>$count)
                {
                     echo "<option value='".$tag."' index >".$tag."</a>";
                }
?>
          </select>
     </td>
   </tr>
</table>
<!------------------------------------------------------------------>
<?
$val0=explode(",",convutf8($bow->fields[keywords]));
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
	      <textarea name=keyword_en cols=60 rows=5><? echo str_replace(",",";",convutf8($bow->fields[keywords])); ?></textarea>
      </td>
      <td valign='top'>
      <!-- Вывести тэги -->
          <select name='tagslist_en' size=10 onChange=tag_select_en(this) >
<?
                foreach($tags_en as $tag=>$count)
                {
                     echo "<option value='".$tag."' index >".$tag."</a>";
                }
?>
          </select>
     </td>
   </tr>
</table>
<!------------------------------------------------------------------>
<?

?>
<br>
<br>

<font color=red>*</font><b>Аннотация</b>
<br>
<?
//echo  $annots->item(0)->getAttribute("lang");
include($_CONFIG["global"]["paths"]["admin_path"]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('annots') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              =convutf8($annots->item(0)->nodeValue);
$oFCKeditor->Create() ;

?>
<br>
<b>Аннотация на английском</b>
<br>
<?
include($_CONFIG["global"]["paths"]["admin_path"]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('annots_en') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              = convutf8($bow->fields['abstract']);
$oFCKeditor->Create() ;


/*
echo "<br>

<b>Ссылка на текст публикации</b>
<br>
";
if (empty($bow['link'])) $bow['link']='<img height="19" width="19" src="http://www.socioprognoz.ru/files/Image/pdf.gif" alt="" />';

$oFCKeditor2 = new FCKeditor('plink') ;
$oFCKeditor2->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor2->Value              = $bow['link'];
$oFCKeditor2->Create() ;
*/
?>

<br>
<?
/*
echo "<br>

<b>Ссылка на текст публикации (английский)</b>
<br>
";

$oFCKeditor2 = new FCKeditor('plink_en') ;
$oFCKeditor2->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor2->Value              = $bow['plink_en'];
$oFCKeditor2->Create() ;
*/
?>
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
<b>Фото 70xXXX
</b> <br> <input
type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input name="pic1" type="file"> </td> <td> <b>Фото
180x240
</b>
<br>
<input name=pic2 type="file"><br> </td>
<td> <b>Фото для главной
134x154
</b>
<br>
<input name=pic3 type="file"><br> </td>
</tr><tr>

<br>
 <input type=checkbox name=status >&nbsp;Публиковать
<br>
</tr>
</table>
<br><br>
<input type=submit value=Проверить>
<input type=hidden name=eid >

<input type=hidden name=pic1 >
<input type=hidden name=pic2 >
<input type=hidden name=pic3 >
</form>
<?

//} Общего цикла
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
