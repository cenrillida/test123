<table>
 <tr>
  <td>
   <b>���</b>
   <br>
   <input type=text name=name />
  </td>
  <td>
   <b>�������</b>
   <br>
   <input type=text name=surname />
  </td>
  <td>
   <b>��������</b>
   <br>
   <input type=text name=fname />
  </td>
 </tr>
</table>

<b>����</b> <br>
<input name=pic type="file"><br>

<?

$fd  = fopen("mod/personal/stepen.txt", "r");
while (!feof($fd)) {
    $buffer .= fgets($fd, 4096);
}
fclose($fd);

//���������� ������ �� ������
$start = 0;
$qq = '';
$num=0;
for($i=0; $i < strlen($buffer); $i++)
 if($buffer[$i] == chr(13))
 {
  for($start; $start<$i; $start++)
   $qq[$num] .= $buffer[$start];
  $num++;
 }

//����� ������ �������

echo "<br><b>������ �������</b><br><select>";
for($i=0; $i < count($qq); $i++)
 echo "<option>".$qq[$i]."</option>";
echo "</select>";

echo "<br>";

$buffer='';

$fd  = fopen("mod/personal/u4.txt", "r");
while (!feof($fd)) {
    $buffer .= fgets($fd, 4096);
}
fclose($fd);

//���������� ������ �� ������
$start = 0;
$qq = '';
$num=0;
for($i=0; $i < strlen($buffer); $i++)
 if($buffer[$i] == chr(13))
 {
  for($start; $start<$i; $start++)
   $qq[$num] .= $buffer[$start];
  $num++;
 }

//����� ������ �������

echo "<br><b>������ ������</b><br><select>";
for($i=0; $i < count($qq); $i++)
 echo "<option>".$qq[$i]."</option>";
echo "</select>";

?>

<br><br>
<b>�������� � ���</b>
<br>
<select>
<option>�� ����</option>
<option>����-����. ���</option>
<option>�������� ���</option>
</select>

<br><br>
<b>�������������� �������</b>
<br>
<textarea cols=50 rows=5></textarea>
<?

$buffer = '';

$fd  = fopen("mod/personal/dolj.txt", "r");
while (!feof($fd)) {
    $buffer .= fgets($fd, 4096);
}
fclose($fd);


//���������� ������ �� ������
$start = 0;
$qq = '';
$num=0;
for($i=0; $i < strlen($buffer); $i++)
 if($buffer[$i] == chr(13))
 {
  for($start; $start<$i; $start++)
   $qq[$num] .= $buffer[$start];
  $num++;
 }

//����� ���������

?>
<table>
<tr>
<?

echo "<br><td><b>��������� 1</b><br><select>";
for($i=0; $i < count($qq); $i++)
 echo "<option>".$qq[$i]."</option>";
echo "</select></td>";

echo "<br><td><b>��������� 2</b><br><select>";
for($i=0; $i < count($qq); $i++)
 echo "<option>".$qq[$i]."</option>";
echo "</select></td>";

?>

</tr>
</table>

<?


echo "<br><br>";



$pg = new Pages();

$podr = $pg->getPages();
$spe = $podr[49][childNodes];

$menu1 = '';
$old = '';
$new = '';

for ($i=0; $i<count($spe); $i++)
 {
 $podpunct1 = $podr[$spe[$i]][childNodes];
  $menu1 .= ("<OPTION value=".($i+1).">".$podr[$spe[$i]][page_name]."</OPTION>");

 if(count($podpunct1)>0)
  {
   for ($j=0; $j<count($podpunct1); $j++)
    {
     $podpunct2 = $podr[$podr[$spe[$i]][childNodes][$j]][childNodes];
      $old[$i] .= ("<option value=".($j+1)." >".$podr[$podr[$spe[$i]][childNodes][$j]][page_name]."</option>");
     if(count($podpunct2)>0)
      {
      for ($k=0; $k<count($podpunct2); $k++)
       {
       $new[$i][$j] .= ("<OPTION VALUE=".($k+1)." >".$podr[$podr[$podr[$spe[$i]][childNodes][$j]][childNodes][$k]][page_name]."</OPTION>");
       }
      }
    }
  }
 }


//������������ �������� ������ ������� �� ���������������� �������� ��� ������ ������

if(!$_POST['menu1'])
{
 echo ("�������� ��� ����� �� ������:<br>");
 echo ("<br><form action=index.php?mod=personal&action=add method=post><select name=menu1 >".$menu1."</select><br><br><input type=submit /></form>");
}
else
 {
  if(!$_POST['menu2'])
  {
   $tid = $_POST['menu1'];
   echo ("<b>".$podr[$spe[$_POST['menu1']-1]][page_name]."</b>");
   if(count($old[$_POST['menu1']-1])>0){
    echo ("<br><br>�������� ���������:<br>");
    echo ("<br>
 	<form action=index.php?mod=personal&action=add method=post>
 	<input type=hidden name=menu1 value=$tid  />
	<select name=menu2 >".
	$old[$_POST['menu1']-1].
	"</select>
	<br><br>
	<input type=submit />
	</form>");}
    else echo ("<br><br>����� ������!");
  }
  else
  {
   echo ("<b>".$podr[$spe[$_POST['menu1']-1]][page_name]." ->
   ".$podr[$podr[$spe[$_POST['menu1']-1]][childNodes][$_POST['menu2']-1]][page_name]."</b>");
   if(!$_POST['menu3'])
   {
    if(count($new[$_POST['menu1']-1][$_POST['menu2']-1])>0){
    echo ("<br><br>�������� ���������:<br>");
    echo ("<br>
        <form action=index.php?mod=personal&action=add method=post>
        <input type=hidden name=menu1 value=".($_POST['menu1'])." />
        <input type=hidden name=menu2 value=".($_POST['menu2'])." />
        <select name=menu3 >".
        $new[$_POST['menu1']-1][$_POST['menu2']-1].
        "</select>
        <br><br>
        <input type=submit />
        </form>");}else echo "<BR><BR>����� ������!";
   } else echo "<b> -> ".$podr[$podr[$podr[$spe[$_POST['menu1']-1]][childNodes][$_POST['menu2']-1]][childNodes][$_POST['menu3']-1]][page_name]."</b>".
	"<BR><BR>����� ������!";
  }
  }

?>

<br><br>
<b>� ����</b>
<br>
<textarea cols=60 rows=15></textarea>

