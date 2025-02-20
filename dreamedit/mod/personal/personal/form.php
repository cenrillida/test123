<?

if($_GET['oper'] == 'show') include 'show.php';
 else
if(($_GET['action'] == 'add')||($_GET['oper'] == 'add'))
 {
  include 'add.php';
 }
else
 if($_GET['oper'] == 'edit')
 {
  include 'options.php';
 }
else
 if($_GET['oper'] == 'remake')
 {
  include 'addentry/edit.php';
 }
else
 if($_GET['oper'] == 'delete')
 {
  include 'addentry/delete.php';
 }
 else include 'menu.php'; 

?>

