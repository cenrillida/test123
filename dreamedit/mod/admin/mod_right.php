<?
include_once dirname(__FILE__)."/../../_include.php";

include_once "mod_fns.php";
include_once "form.php";

$phorm = new mod_phorm($mod_array);


if($_ACTIVE["action"] == "add")
{
	$phorm->edit_comp("pass", "required", TRUE);
	$phorm->display();
}


if($_ACTIVE["action"] == "permissions")
{
	getPermissions(@$_REQUEST["id"]);
	

	$data = array();
	$permit = $DB->select("SELECT * FROM ?_permissions WHERE a_id = ?d", @$_REQUEST["id"]);
	foreach($permit as $v)
		 $data = array_merge_recursive($data, modString2array($v["permit_obj"]));

	$phorm->mod_phorm_values(array("permissions" => $data));
	$phorm->display();
}


if($_ACTIVE["action"] == "edit")
{
	$data = array();
	$row = $DB->selectRow("SELECT * FROM ?_admin WHERE a_id = ?d", $_REQUEST["id"]);
	foreach($mod_array["components"] as $k => $v)
	{
		if($k == "pass")
			continue;

		$tmp = $row[$v["field"]];

		$data[$k] = $tmp;
	}

	$phorm->mod_phorm_values($data);
	$phorm->display();
}


if($_ACTIVE["action"] == "save")
{
	if(isset($_REQUEST["save_permissions"]))
		getPermissions(@$_REQUEST["save_permissions"]);

	$phorm->mod_phorm_values($_REQUEST);

	if(!$phorm->validate())
	{
		$phorm->display();
		return;
	}


	if(isset($_REQUEST["save_permissions"]))
		include_once "save_permissions.php";
	else
		include_once "save_action.php";
}

if($_ACTIVE["action"] == "del")
{
	$DB->query("DELETE FROM ?_admin WHERE a_id = ?d", $_REQUEST["id"]);
	$DB->query("DELETE FROM ?_permissions WHERE a_id = ?d", $_REQUEST["id"]);
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]);
}


?>