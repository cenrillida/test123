
<form enctype="multipart/form-data" id="data_form" action=index.php?mod=personal&oper=add method=post>
<input type=hidden value=do name=test>
<input type=hidden name=oi value=<? echo $_POST['oi']; ?>>
<table>
 <tr>
  <td>
   <b>�������</b>
   <br>
   <input type=text name=surname value=<? echo $_POST['surname']; ?>>
  </td>
  <td>
   <b>���</b>
   <br>
   <input type=text name=name value=<? echo $_POST['name']; ?>>
  </td>
  <td>
   <b>��������</b>
   <br>
   <input type=text name=fname value=<? echo $_POST['fname']; ?>>
  </td>
 </tr>
</table>

<table>
<tr>
<td>
<b>���� 63x84</b> <br>
<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
<input name="pic1" type="file">
</td>
<td>
<b>���� 180x240</b> <br>
<input name=pic2 type="file"><br>
</td>
</tr>
</table>

<?
global $DB,$_CONFIG;
$buffer=$DB->select("SELECT * FROM stepen ORDER BY id");
$qq='';
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[short]." | ".$qq0[full];
}
//����� ������ �������

echo "<br><b>������ �������</b><br><select name=us>";
if ($_POST['us'])
 echo "<option value='".$_POST['us']."'>".$qq[$_POST['us']]."</option>";
else echo "<option value='-1'>&nbsp;</option>";
for($i=0; $i < count($qq); $i++)
 echo "<option value='".$i."'>".$qq[$i]."</option>";
echo "</select>";

echo "<br>";

$buffer='';
$qq='';
$buffer=$DB->select("SELECT * FROM zvanie ORDER BY id");
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[short]." | ".$qq0[full];
}



//����� ������� ������

echo "<br><b>������ ������</b><br><select name=uz>";
if ($_POST['uz'])
 echo "<option value='".$_POST['uz']."'>".$qq[$_POST['uz']]."</option>";
else echo "<option value='-1'>&nbsp;</option>";
for($i=0; $i < count($qq); $i++)
 echo "<option value='".$i."'>".$qq[$i]."</option>";
echo "</select>";

?>

<br><br>
<b>�������� � ���</b>
<br>
<select name=4len>
<option value='<? echo $_POST['4len']; ?>' ><? echo $_POST['4len']; ?></option>
<option value="�� ����"></option>
<option value="����-����. ���">����-������������� ���</option>
<option value="�������� ���">�������� ���</option>
</select>

<br><br>
<b>�������������� �������</b>
<br>
<textarea cols=100 rows=5 name=rewards><? echo $_POST['rewards']; ?></textarea>
<br>

<?

$buffer = '';

$qq='';
$buffer=$DB->select("SELECT * FROM doljn ORDER BY id");
foreach($buffer as $i=>$qq0)
{
   $qq[$i]=$qq0[text];
}


//����� ���������

?>
<br>
<?

echo "<br><b>���������</b><br><select name=dolj><option value='".$_POST['dolj']."'>".$qq[$_POST['dolj']]."</option>";
for($i=0; $i < count($qq); $i++)
 echo "<option value='".$i."'>".$qq[$i]."</option>";
echo "</select>";

?>
<br>

<? include 'mod/personal/addentry/otdel.php'; ?>
<br><br>
<b>���������� ����������</b>
<br>
<table><tr>
<td><b>������� 1</b>
<br>
<input name=tel1 value=<? echo $_POST['tel1']; ?> >
</td>
<td><b>������� 2</b>
<br>
<input name=tel2 value=<? echo $_POST['tel2']; ?> >
</td></tr>
<tr>
<td><b>e-mail 1</b>
<br>
<input name=mail1 value=<? echo $_POST['mail1']; ?> >
</td>
<td><b>e-mail 2</b>
<br>
<input name=mail2 value=<? echo $_POST['mail2']; ?> >
</td>
<td width=250 align=right><input type=submit value="���������">
</td>

</tr></table>
<br>
<b>� ����</b>
<br>
<?
//include("/../../../includes/FCKEditor/fckeditor.php") ;
include($_CONFIG["global"]["paths"]["admin_path"]."/includes/FCKEditor/fckeditor.php") ;

$oFCKeditor = new FCKeditor('about') ;
$oFCKeditor->BasePath   = "/dreamedit/includes/FCKEditor/" ;
$oFCKeditor->Value              = $_POST['about'];
$oFCKeditor->Height = 500;
$oFCKeditor->Create() ;
?>
<br>
<br>
<input type=checkbox name=ruk>&nbsp;������������
<br>
<input type=checkbox name=usp>&nbsp;������ ��������� �������������
<br><br>
<input type=submit value="������������">


</form>

