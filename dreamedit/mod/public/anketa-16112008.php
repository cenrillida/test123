<form name=publ enctype="multipart/form-data" action=index.php?mod=public&action=add method=post>
<input type=hidden name=sent value=1>
<font color=red>*</font>��������
<br>
<textarea name=name cols=120><? echo $_POST['name']; ?></textarea>
<br>
�������������
<br>
<textarea name=name2 cols=120><? echo $_POST['name2']; ?></textarea>
<br>
<br>
<font color=red>*</font>��� �������
<br>
<input type=text name=date maxlength=4 value='<? echo $_POST['date']; ?>'  style="width: 50">
<br>
<br>

 <input type=checkbox name=imp <? if($_POST['imp'] == 'on') echo "checked"; ?>>&nbsp;������ ����������

<br>
<br>

<table><tr>
<td>
<font color=red>*</font>���
<br>

<?

// ������ ��� � ��� ���������� ������� �� ����



global $DB;


$qq0=$DB->select("SELECT * FROM vid ORDER BY id");

?>
<select name=vid>
 <option value='<? echo $_POST['vid']; ?>'></option>
<?

foreach($qq0 as $k=>$qq)
 echo "<option value='".($k+1)."'>".$qq[text]."</option>";

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
 echo "<option value='".($i+1)."'>".$tip[text]."</option>";

?>


</select>
</td>
</tr></table>

<br>
<b>ISBN</b>
<br>
<textarea name=izdat cols=120><? echo $_POST['izdat']; ?></textarea>
<br>

<?
 include 'spe_selector.php';
?>
<br>
 <input type=checkbox name=as <? if($_POST['as'] == 'on') echo "checked"; ?>>&nbsp;������ �������
<br>
<?
 include 'spe_rubricator.php';
?>

<br>
<font color=red>*</font><b>�������� �����</b>
<br>
<textarea name=keyword cols=60 rows=5><? echo $_POST['keyword']; ?></textarea>
<br>

<br>
<font color=red>*</font><b>���������</b>
<br>
<?
include($_CONFIG["global"]["paths"]["admin_path"]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('annots') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              = $_POST['annots'];
$oFCKeditor->Create() ;

echo "<br>

<b>������ �� ����� ����������</b>
<br>
";

$oFCKeditor2 = new FCKeditor('plink') ;
$oFCKeditor2->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor2->Value              = $_POST['plink'];
$oFCKeditor2->Create() ;

?>
<br>
<br>


<input type=checkbox name=can <? if($_POST['can'] == 'on') echo "checked"; ?>>&nbsp;����� ���������� � ����� ��� ����� ����������
<br>
<br>
<input type=checkbox name=ebook <? if($_POST['ebook'] == 'on') echo "checked"; ?>>&nbsp;��������� �������� "����������� ����������"
<br /><br />
<table> <tr> <td> <b>���� 128x148</b> <br> <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
 <input name="pic1" type="file"> </td> <td>
<b>���� 240x320</b> <br> <input name=pic2 type="file"><br> </td> </tr>
</table>


<br><br>
<input type=submit value=���������>
</form>

