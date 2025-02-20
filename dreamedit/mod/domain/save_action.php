<?
include_once dirname(__FILE__)."/../../_include.php";


$query = array();
foreach($phorm->data() as $k => $v)
{
	if(!isset($v["field"]) || $k == "id")
		continue;

	$data = $_REQUEST[$k];
	if(!isset($_REQUEST[$k]))
		$data = 0;

	$query[$v["field"]] = $data;
}

if(!empty($_REQUEST["id"]))
{
	$DB->query("UPDATE ?_domain SET ?a WHERE ".$mod_array["components"]["id"]["field"] . " = ?d", $query, $_REQUEST["id"]);
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["id"]);
}
else
{
	$id = $DB->query("INSERT INTO ?_domain SET ?a", $query);
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$id);
}

?>