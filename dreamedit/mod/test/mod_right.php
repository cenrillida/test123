<?
include_once dirname(__FILE__)."/../../_include.php";


include_once "form.php";

$phorm = new mod_phorm($mod_array);

if($_ACTIVE["action"] == "add")
{
	$phorm->display();
}

if($_ACTIVE["action"] == "edit")
{
	$data = array();
	$row = $DB->selectRow("SELECT * FROM ?_filters WHERE filter_id = ?d", $_REQUEST["id"]);

	foreach($phorm->data() as $k => $v)
	{
		$tmp = $row[$v["field"]];

		$data[$k] = $tmp;
	}

	$phorm->mod_phorm_values($data);
	$phorm->display();
}

if($_ACTIVE["action"] == "save")
{
	$phorm->mod_phorm_values($_REQUEST);

	if(!$phorm->validate())
	{
		$phorm->display();
		return;
	}

	include_once "save_action.php";
}

if($_ACTIVE["action"] == "del")
{
	$DB->query("DELETE FROM ?_filters WHERE filter_id = ?d", $_REQUEST["id"]);
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]);
}

?>