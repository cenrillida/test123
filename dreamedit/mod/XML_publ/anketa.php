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
      alert("��� ����� ��� �������");
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
      alert("��� ����� ��� �������");
}
function chcr()
{
	document.publ.copyright.value='�'+document.publ.copyright.value;

}
</script>

<form name=publ enctype="multipart/form-data" action=index.php?mod=public&action=add method=post>
<input type=hidden name=sent value=1>
<font color=red>*</font>�������� (������ ����������������� ������)
<br>
<textarea name=name cols=120><? echo $_POST['name']; ?></textarea>
<br>
�������� �� ����������
<br>
<textarea name=name2 cols=120><? echo $_POST['name2']; ?></textarea>
<br>
<br>
<table>
<tr>
<td>
<font color=red>*</font>��� �������
<br>
<input type=text name=date maxlength=4 value='<? echo $_POST['date']; ?>'  style="width: 50">
</td>
<td>
<font color=red></font>���� ���������� (���� �����)
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
<font color=red>*</font>���
<br>

<?

// ������ ��� � ��� ���������� ������� �� ����



global $DB;
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/jscalendar/calendar.inc.php";

$qq0=$DB->select("SELECT * FROM vid ORDER BY id");

?>
<select name=vid>
 <option value='<? echo $_POST['vid']; ?>'></option>
<?

foreach($qq0 as $k=>$qq)
 echo "<option value='".$qq[id]."'>".$qq[text]."</option>";

?>
</select>
</td><td>


<?

$tip0=$DB->select("SELECT * FROM type ORDER BY id");

?>


<font color=red>*</font>���
<br>
<select name=tip>
 <option value='<? echo $_POST['tip']; ?>'></option>
<?

foreach($tip0 as $i=>$tip)
 echo "<option value='".$tip[id]."'>".$tip[text]."</option>";

?>


</select>
</td>
</td>
<td><font color=red>*</font>������
<br>
<select name=format>
<?
 if ($bow[format]==0 || empty($bow[format])) $sel='selected';
 else $sel="";
 echo "<option value=0 ".$sel." >�����</option>";
 if ($bow[format]==1) $sel='selected';
 else $sel="";
 echo "<option value=1 ".$sel." >�����</option>";
 if ($bow[format]==2) $sel='selected';
 else $sel="";
 echo "<option value=2 ".$sel." >�����</option>";
?>
</select>


</td>
</tr></table>

<br>
<b>ISBN</b>


<br>
<textarea name=izdat cols=120><? echo $_POST['izdat']; ?></textarea>
<br>
<!--
<br>
<b>��������</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onClick=chcr() style='cursor:pointer;cursor:hand;'>��������� ���� �</a>
<br>
<textarea name=copyright cols=120><? echo $bow[copyright]; ?></textarea>
<br>
-->
<br>
<b>�������� �� �������</b>
<br>
<?
if ($_POST[formain]=="on" || $_POST[formain]==1)
   echo "<input type=checkbox name=formain checked></input>";
else
   echo "<input type=checkbox name=formain ></input>";
?>

<br>
<br />
<font color=red>*</font><b>������������ �������</b><br />
1 - <select name='rubric2'>
<option value=''></option>
<?
$rub0=$DB->select("SELECT r.el_id AS id,r.icont_text AS name,rr.icont_text AS name_en FROM
adm_directories_content AS r
INNER JOIN adm_directories_element AS e ON e.el_id=r.el_id AND e.itype_id=2
INNER JOIN adm_directories_content AS rr ON rr.el_id=r.el_id AND rr.icont_var='text_en'
INNER JOIN adm_directories_content AS s ON s.el_id=r.el_id AND s.icont_var='order'
 WHERE r.icont_var='text'
 ORDER BY s.icont_text");
foreach($rub0 as $rub)
{
	if ($rub[id]==$bow[rubric2]) $sel='selected';
	else $sel="";
	echo "<option value=".$rub[id]." ". $sel.">".$rub[name]."</option>";
}
?>                                              i
</select>
<input type='checkbox' name='r1'>�������������</input>
<br>
<br>
2 - <select name='rubric2d'>
<option value=''></option>
<?

foreach($rub0 as $rub)
{
	if ($rub[id]==$bow[rubric2d]) $sel='selected';
	else $sel="";
	echo "<option value=".$rub[id]." ". $sel.">".$rub[name]."</option>";
}
?>
</select>
<input type='checkbox' name='r2'>�������������</input>
<br>
<br>
3 - <select name='rubric2_3'>
<option value=''></option>
<?

foreach($rub0 as $rub)
{
	if ($rub[id]==$bow[rubric2_3]) $sel='selected';
	else $sel="";
	echo "<option value=".$rub[id]." ". $sel.">".$rub[name]."</option>";
}
?>
</select>
<input type='checkbox' name='r3'>�������������</input>
<br>
<br>
4 - <select name='rubric2_4'>
<option value=''></option>
<?

foreach($rub0 as $rub)
{
	if ($rub[id]==$bow[rubric2_4]) $sel='selected';
	else $sel="";
	echo "<option value=".$rub[id]." ". $sel.">".$rub[name]."</option>";
}
?>
</select>
<input type='checkbox' name='r4'>�������������</input>
<br>
<br>
5 - <select name='rubric2_5'>
<option value=''></option>
<?

foreach($rub0 as $rub)
{
	if ($rub[id]==$bow[rubric2_5]) $sel='selected';
	else $sel="";
	echo "<option value=".$rub[id]." ". $sel.">".$rub[name]."</option>";
}
?>
</select>
<input type='checkbox' name='r5'>�������������</input>
<br /><br />
<?
 include 'spe_selector.php';      //������
?>
<br>
 <input type=checkbox name=hide_autor <? if($_POST['hide_autor'] == 'on') echo "checked"; ?>>&nbsp;������ �������
<br>
<?
// include 'spe_rubricator.php';
?>

<br>
<font color=red>*</font><b>�������� ����� (����������� ������ � �������)</b>
<br>

<!------------------------------------------------------------------>
<?
$val0=explode(";",$_POST[keyword]);
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
	      <textarea name=keyword cols=60 rows=5><? echo $_POST['keyword']; ?></textarea>
      </td>
      <td valign='top'>
      <!-- ������� ���� -->
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
<br>
<font color=red>*</font><b>�������� ����� �� ����������(����������� ������ � �������)</b>
<br>

<!------------------------------------------------------------------>
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
	      <textarea name=keyword_en cols=60 rows=5><? echo $_POST['keyword_en']; ?></textarea>
      </td>
      <td valign='top'>
      <!-- ������� ���� -->
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
<br>

<br>
<font color=red>*</font><b>���������</b>
<br>
<?
include($_CONFIG["global"]["paths"]["admin_path"]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('annots') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              = $_POST['annots_en'];
$oFCKeditor->Create() ;
?>
<br>
<font color=red>*</font><b>��������� �� ����������</b>
<br>
<?
include($_CONFIG["global"]["paths"]["admin_path"]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('annots_en') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              = $_POST['annots_en'];
$oFCKeditor->Create() ;

echo "<br>

<b>������ �� ����� ����������</b>
<br>
";
if (empty($_POST['plink'])) $_POST['plink']='<img height="19" width="19" src="http://www.socioprognoz.ru/files/Image/pdf.gif" alt="" />';
$oFCKeditor2 = new FCKeditor('plink') ;
$oFCKeditor2->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor2->Value              = $_POST['plink'];
$oFCKeditor2->Create() ;

?>
<br>
<?
echo "<br>

<b>������ �� ����� ���������� (����������)</b>
<br>
";

$oFCKeditor2 = new FCKeditor('plink_en') ;
$oFCKeditor2->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor2->Value              = $_POST['plink_en'];
$oFCKeditor2->Create() ;

?>
<br>
<!--
<br>
<input type=checkbox name=ebook <? if($_POST['ebook'] == 'on') echo "checked"; ?>>&nbsp;��������� ������� ������������ �����������
<br>
-->
<br>
<table> <tr> <td>
<b>�������� �����������:</b>
</td></tr>
<tr><td>
<b>���� 70xXXX
</b> <br> <input
type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input name="pic1" type="file"> </td> <td> <b>����
180x240
</b>
<br>
<input name=pic2 type="file"><br> </td>
<td> <b>���� ��� �������
134x154
</b>
<br>
<input name=pic3 type="file"><br> </td>
</tr><tr>
<?

// echo "<td valign='top'><img  src='http://".
//        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picsmall]."' /></td>";
// echo "<td valign='top'><img  src='http://".
//        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picbig]."' /></td>";
// echo "<td valign='top'><img  src='http://".
//        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picmain]."' /></td>";
?>
<br>
 <input type=checkbox name=status <? if($bow[status] == '1') echo "checked"; ?>>&nbsp;�����������
<br>
</td></tr>
</table>


<br><br>
<input type=submit value=���������>
</form>
<?
function cln($btnName,$name){


   echo "<img src=\""."/files/Image/".$btnName.".jpg\" id=\"button_".$btnName."_".$name."\"
        style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" width=\"17\" height=\"17\" alt=\"".
        Dreamedit::translate("������� ����")."\" title=\"".Dreamedit::translate("������� ����")."\" />";
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
