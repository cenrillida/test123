<font color=red>
<?


//���� ������ � ���������� ������
if ($_POST['sent']) {
 if (!$_POST['ffio0']) echo "�� ������� ������<br>";
 if (!$_POST['name']) echo "�� ������� ��������<br>";
 if (!$_POST['date']) echo "�� ������� ����<br>";
 if (!$_POST['vid']) echo "�� ������ ��� ����������<br>";
 if (!$_POST['tip']) echo "�� ������ ��� ����������<br>";
// if (!$_POST['returns']) echo "�� ������� �������<br>";
 if (!$_POST['annots']) echo "������� ���������<br>";
 //if (!$_POST['plink']) echo "�� ������� ������ �� ����������<br>";
/* if (($_POST['name']) && ($_POST['date']) && ($_POST['vid']) && ($_POST['tip']) && ($_POST['matrix'])
   && ($_POST['annots']) && ($_POST['plink']) && ($_POST['returns']))
  $allright=true;
 else
  $allrigth=false;
}
*/
 if (($_POST['name']) && ($_POST['date']) && ($_POST['vid']) && ($_POST['tip']) && ($_POST['ffio0'])
   && ($_POST['annots']) )
  $allright=true;
 else
  $allrigth=false;
}
?>
<br>
</font>

<?

if($_POST['sent'])
 include "preview.php";
//else
// include "edit.php";

?>
