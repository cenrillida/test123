<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";

if($_ACTIVE["action"] == "index")
{
     include_once "formNumber.php";
	 
}

$phorm = new mod_phorm($mod_array);

if($_ACTIVE["action"] == "index")
{
	if($_GET['reset']==1) {
		echo "��� ������";
	}
	$phorm->display();
}


if($_ACTIVE["action"] == "save")
{

// print_r($_POST);
     include_once "formNumber.php";
	$phorm = new mod_phorm($mod_array);

	$phorm->mod_phorm_values($_REQUEST);
//print_r($phorm);

	if(!$phorm->validate())
	{
		$phorm->display();
		return;
	}


	include_once "save_action.php";

}

?>
