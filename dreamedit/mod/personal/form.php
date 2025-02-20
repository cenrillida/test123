<?

//print_r($_REQUEST);

if($_GET['oper'] == 'show') include 'show.php';
 else
if(($_GET['action'] == 'add')||($_GET['oper'] == 'add'))
 {
  include 'add.php';
 }
else
if ($_REQUEST[oper]=='sovet' || $_REQUEST[oper]=='adm')
{

   include 'sovet.php';

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
else
 if($_GET['oper'] == 'new')
 {
  include 'options.php';
 }
 else
  if($_GET['oper'] == 'delete_img')
  {
   include 'addentry/delete_img.php';
  }
// else include 'menu.php';

?>



