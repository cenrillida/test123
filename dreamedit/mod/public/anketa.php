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
function parent()
{
  var pid=document.getElementById('parent_id').options[document.getElementById('parent_id').selectedIndex].text;
  var ppp=pid.split('# '); 
  document.getElementById('date').value=ppp[1];
  document.getElementById('tip').value=441;
  document.getElementById('vid').value=446;
}
function chcr()
{
	document.publ.copyright.value='�'+document.publ.copyright.value;

}
function PublCheck() {

  if (document.publ.name.value=="" ) {
	alert("�� ������� ��������");
	return false;
  }
  if (document.publ.date.value=="" ) {
	alert("�� ������ ��� �������");
	return false;
  }
 if (document.publ.vid.value=="" || document.publ.vid.value<1) {
	alert("�� ������ ��� ����������");
	return false;
  }

  if (document.publ.tip.value=="" || document.publ.tip.value<1) {
	alert("�� ������ ��� ����������");
	return false;
  }

  if (document.publ.matrix.value=="" ) {
	alert("�� ������� ������");
	return false;
  }
  if (document.publ.rubric.value=="" ) {
	alert("�� ������� �������");
	return false;
  }

  if (document.publ.keyword.value=="" ) {
	alert("�� ������� �������� �����");
	return false;
  }

}
</script>

<form name=publ enctype="multipart/form-data" action=index.php?mod=public&action=save method=post  onSubmit="return PublCheck()">
<input type=hidden name=sent value=1>
<font color=red>*</font><b>�������� (������ ����������������� ������)</b>
<br>
<textarea name=name cols=120 class="publ_search"><? echo $_POST['name']; ?></textarea>
<br>
<b>�������� �� ����������</b>
<br>
<textarea name=name2 cols=120><? echo $_POST['name2']; ?></textarea>
<br>
<b>�������� (�����)</b>
<br>
<textarea name=name_title cols=120><? echo $_POST['name_title']; ?></textarea>
<br>
    <br>
    <b>����� ���������� �� �����</b>


    <br>
    <input size="200" name=uri value="<? echo $_POST['uri']; ?>">
    <p class="form_help">���� ���� ������ - ����������� �� ��������, ���� �������� ������ - �� ����� ����� � ���� publ-x (��� x - ID ����������)</p>
<br>
<b>�������� ����������</b>
<?
$publmain=$DB->select("SELECT id,name,year FROM publ WHERE (vid=453 OR vid=427) ORDER BY name");

echo "<select name='parent_id' id='parent_id' onchange=parent()>";
echo "<option value=''></option>";
foreach ($publmain as $p)
{
   echo "<option value=".$p[id].">".substr($p[name],0,100)." # ".$p[year]."</option>";
}
echo "</select>";
?>
<br /><br />
<b>��������� ��������: </b><input name='page_beg' id='page_beg'></ipput>
<br /><br />
<table>
<tr>

<td>
<font color=red>*</font><b>��� �������</b>
<br>
<input type=text name=date maxlength=4 id='date' value='<? echo $_POST['date']; ?>'  style="width: 50">
</td>
<td>
<font color=red></font>������ ���� ���������� (���� �����)
<br>
<input type=text size='10' id=date_fact name=date_fact   >
<?
	
	include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/jscalendar/calendar.inc.php";
	$btnName='calendar';
    $namecln='date_fact';
    $dt=cln($btnName,$namecln);
?>
</td>
</tr>
</table>
<br>

    <br>
    ���� ����������
    <br>
    <input type="date" id="date_publ" name="date_publ" value="<?=date("Y-m-d");?>" >
    <br>
    <br>

<?
$lands=$DB->select("SELECT c.icont_text AS land,c.el_id
                    FROM adm_directories_content AS c
                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=22
					WHERE c.icont_var='text'
					ORDER BY c.icont_text
					");
echo "<b>������</b>";
echo "<select name='land' id='land'>";
echo "<option value=''></option>";
foreach($lands as $land)
{
   echo "<option value=".$land[el_id].">".$land[land],"</option>";
}	
echo "</select>";				
?>
<br />
<br>

<table><tr>
<td>
<font color=red>*</font><b>���</b>
<br>

<?

// ��� � ��� ���������� ������� �� ����



global $DB;


$vid0=$DB->select("SELECT c.el_id AS id,c.icont_text AS text FROM adm_directories_content AS c
                   INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=19 
				   WHERE c.icont_var='text' 
				   ORDER BY id");
$dr=new Directories();
$rows=$dr->getRubricsAll();
//print_r($rows);
echo "<select name=vid id='vid'>";

//echo "<option value='".$bow[3]."'>".$vid0[$bow[vid]][text]."</option>";
echo "<option value=-1></option>";
$gruppa='';
foreach($vid0 as $i=>$vid)
{
 
 echo "<option value='".$vid[id]."' ".$sel." >".$vid[text]."</option>";
}

?>
</select>
</td><td>


<?


$type0=$DB->select("SELECT c.el_id AS id,c.icont_text AS text FROM adm_directories_content AS c
                   INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=21 
				   WHERE c.icont_var='text' 
				   ORDER BY id");
				 
$dr=new Directories();
$rows=$dr->getRubricsAll();
?>

<font color=red>*</font><b>���</b>
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
</tr>
<tr>

</tr>
</table>

<br>
<b>ISBN</b>


<br>
<input name=izdat value="<? echo $_POST['izdat']; ?>">
<br>
<br>
<b>DOI</b>


<br>
<input name=doi value="<? echo $_POST['doi']; ?>">
<br>


<?
 include 'spe_selector.php';      //������
 $temp = $_POST['matrix'];
$i=0;
$avt="";

$avt0=explode("<br>",trim($temp));

foreach($avt0 as $k=>$avtor)
{

    if (!empty($avtor))
    {

    	   $ff=explode(' ',trim($avtor));
    	   $ff0=$DB->select("SELECT id FROM persons WHERE surname='".$ff[0]."' AND name='".$ff[1]."' AND fname='".$ff[2]."'");
           if (isset($ff0[0][id]))
              $avtors[$i]=$ff0[0][id];
           else
              $avtors[$i]=$avtor;
           $avt.=$avtors[$i]."<br>";
           $i++;
     }
}
echo "<br />".$avt;
?>
<br>
 <input type=checkbox name=hide_autor <? if($_POST['hide_autor'] == 'on') echo "checked"; ?>>&nbsp;������ �������
<br>
    <br>
<?
include 'spe_selector2.php';
// include 'spe_rubricator.php';
// �������
$rowsrub=$DB->select("SELECT c.el_id, c.icont_text AS rubric FROM adm_directories_content AS c 
                      INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=23
					  WHERE c.icont_var='text'
					  ORDER BY c.icont_text");
echo "<br /><br /><b>�������:</b><br />";
echo "<select name='rubric' id='rubric'>";
echo "<option value=''></option>";
foreach ($rowsrub as $r)
{
   echo "<option value=".$r[el_id].">".$r[rubric]."</option>";
}
echo "</select><br />";

echo "<select name='rubric2' id='rubric2'>";
echo "<option value=''></option>";
foreach ($rowsrub as $r)
{
   echo "<option value=".$r[el_id].">".$r[rubric]."</option>";
}
echo "</select><br />";
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
	      <textarea name=keyword cols=160 rows=5><? echo $_POST['keyword']; ?></textarea>
      </td>
   </tr>
</table>
<br>
<b>�������� ����� �� ����������(����������� ������ � �������)</b>
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
	      <textarea name=keyword_en cols=160 rows=5><? echo $_POST['keyword_en']; ?></textarea>
      </td>
   </tr>
</table>
<!------------------------------------------------------------------>
<br>

<br>
<font color=red>*</font><b>���������</b>
<br>
    <?
    echo "<textarea tag=\"annots\" name=\"annots\" id=\"annots\">" . htmlspecialchars($_POST['annots']) . "</textarea>\n";
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
<b>��������� �� ����������</b>
<br>
    <?
    echo "<textarea tag=\"annots_en\" name=\"annots_en\" id=\"annots_en\">" . htmlspecialchars($_POST['annots_en']) . "</textarea>\n";
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

<b>������ �� ����� ����������</b>
<br>
";
?>
    <?
    echo "<textarea tag=\"plink\" name=\"plink\" id=\"plink\">" . htmlspecialchars($_POST['plink']) . "</textarea>\n";
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

<b>������ �� ����� ���������� (����������)</b>
<br>
";
?>
    <?
    echo "<textarea tag=\"plink_en\" name=\"plink_en\" id=\"plink_en\">" . htmlspecialchars($_POST['plink_en']) . "</textarea>\n";
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
<input type=checkbox name=vid_inion <? if($_POST['vid_inion'] == '1') echo "checked"; ?>>&nbsp;�� �������� � ����� ������
<br><br>
    ��������� � ���� <input type=edit name=rinc id='rinc'><?=@$bow[rinc]?></input>
<br>
<br>
<input type=checkbox name=ebook <? if($_POST['ebook'] == 'on') echo "checked"; ?>>&nbsp;��������� ������� ������������ �����������
<br>
<br>
<table> <tr> <td>
<b>�������:</b>
</td></tr>
<tr><td>
<b>���� 70x100
</b> <br> <input
type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input name="pic1" type="file"> </td> <td> <b>����
180x240
</b>
<br>
<input name=pic2 type="file"><br> </td>
</tr><tr>
<?

// echo "<td valign='top'><img  src='http://".
//        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picsmall]."' /></td>";
// echo "<td valign='top'><img  src='http://".
//        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picbig]."' /></td>";
// echo "<td valign='top'><img  src='http://".
//        $_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$bow[picmain]."' /></td>";
?>
<td valign=middle>
 <input type=checkbox name=elogo id='elogo'>��������� ������� </td><td><img width=35 height=42 align=absmiddle src=pfoto/e_logo.jpg />
 </td></tr>

</table>
    <br>

    <input type=checkbox name=status <? if($bow[status] == '1') echo "checked"; ?>>&nbsp;�����������
<br><br>
<input type=checkbox name=out_from_print <? if($bow[out_from_print] == '1') echo "checked"; ?>>&nbsp;����� �� ������
<br><br>
<input type=checkbox name=no_publ_ofp <? if($bow[no_publ_ofp] == '1') echo "checked"; ?>>&nbsp;�� �������� � "����� �� ������"
<br><br>

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
