<?
include_once dirname(__FILE__)."/../../_include.php";


if($type == "l")
{
	$lid = isset($_REQUEST["lid"])? (int)$_REQUEST["lid"]: $DB->query("INSERT INTO ?_polls_element SET itype_id = ?d, el_date = UNIX_TIMESTAMP()", $_REQUEST["id"]);

	$DB->query("DELETE FROM ?_polls_content WHERE el_id = ?d", $lid);	

	foreach($phorm->data() as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$DB->query("INSERT INTO ?_polls_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, $v["field"], $_REQUEST[$k]);
	}

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&type=l&id=".$lid);
}
else
{
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

	if(!empty($id))
	{
		$DB->query("UPDATE ?_polls_type SET ?a WHERE ".$mod_array["components"]["id"]["field"]." = ?d", $query, $id);
	}
	else
	{
		$id = $DB->query("INSERT INTO ?_polls_type SET ?a", $query);
	}

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$id);
}

?>