<?

function test_valid()
{
 $allow = true;
 if(!$_POST['name'])
 {
  echo "<font color=red>Имя не указано!</font><br>";
  $allow = false;
 }
 if(!$_POST['surname'])
 {
  echo "<font color=red>Фамилия не указана!</font><br>";
  $allow = false;
 }
 if($_POST['otdel']=="1239" || $_POST['otdel2']=="1239" || $_POST['otdel3']=="1239")
 {
  if(!$_POST['rewards']) {
      echo "<font color=red>Не указаны годы жизни!</font><br>";
      $allow = false;
  }
 }
// if(!$_POST['fname'])
// {
//  echo "<font color=red>Отчество не указано!</font><br>";
//  $allow = false;
// }
 /*if(!$_POST['otdel'])
 {
  echo "<font color=red>Подразделение не указано!</font><br>";
  $allow = false;
 }*/
/* if(!$_POST['dolj'])
 {
  echo "<font color=red>Должность не указана!</font><br>";
  $allow = false;
 }*/
 return $allow;
}

if(!test_valid()) include 'anketa.php';
else include 'preview.php';
?>

