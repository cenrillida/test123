<?
include_once dirname(__FILE__)."/../../_include.php";


$id = (int)@$_REQUEST["save_permissions"];
if(empty($id))
	return;

// удаляем старые записи о правах доступа
$DB->query("DELETE FROM ?_permissions WHERE a_id = ?d", $id);

// пишем новые права
foreach(modArray2string($_REQUEST["permissions"]) as $v)
{
	$DB->query("INSERT INTO ?_permissions SET a_id = ?d, permit_obj = ?, permit_value = ?d", $id, $v, 1);
}

Dreamedit::sendLocationHeader("https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_REQUEST["mod"] . "&action=permissions&id=" . $id);

?>