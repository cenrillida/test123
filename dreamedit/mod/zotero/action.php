<font color=red>
<?


//ищем ошибки в заполнении анкеты
if ($_POST['sent']) {
 if (!$_POST['ffio0']) echo "Не указаны авторы<br>";
 if (!$_POST['name']) echo "Не указано название<br>";
 if (!$_POST['date']) echo "Не указана дата<br>";
 if (!$_POST['vid']) echo "Не указан вид публикации<br>";
 if (!$_POST['tip']) echo "Не указан тип публикации<br>";
// if (!$_POST['returns']) echo "Не указаны рубрики<br>";
 if (!$_POST['annots']) echo "Введите аннотацию<br>";
 //if (!$_POST['plink']) echo "Не введена ссылка на публикацию<br>";
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
