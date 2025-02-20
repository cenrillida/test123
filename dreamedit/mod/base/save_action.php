<?
include_once dirname(__FILE__)."/../../_include.php";

// ������� ������ ����������� ��������
$query = array();
foreach($mod_array["components"] as $k => $v)
{
	if(!isset($v["field"]) || $k == "id")
		continue;

	$data = @$_REQUEST[$k];
	if($k == "status" || $k == "dell")
		$data = (int)@$_REQUEST[$k];

	if($k == "urlname")
	{
		$urlnameVars = Templater::getVarsFromStr($data);
		$urlData = "";
		if(!empty($urlnameVars))
		{
			$urlData = str_replace(array(".", "/"), array("\.", "\/"), $data);
			$urlData  = "^".preg_replace("/{[A-Z]+[A-Z_]*}/", "([a-zA-Z0-9_]+)", $urlData)."$";
		}
		$query[$v["field"]."_regexp"] = $urlData;
	}

	$query[$v["field"]] = $data;
}

// ������� ������ �������� ��������
$content_query = array();
if(empty($query["page_link"]) && isset($tpl_vars))
{
	foreach($tpl_vars as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$data = "";
		if(isset($_REQUEST[$k]))
			$data = $_REQUEST[$k];

		$content_query[strtoupper($v["field"])] = $data;
	}
}


if(!empty($_REQUEST["id"]))
{
	$DB->query("UPDATE base_publ SET ?a WHERE ".$mod_array["components"]["id"]["field"] . " = ?d", $query, $_REQUEST["id"]);


	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["id"]);
}
else
{
	$id = $DB->query("INSERT INTO base_publ SET ?a", $query);

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$id);
}

?>