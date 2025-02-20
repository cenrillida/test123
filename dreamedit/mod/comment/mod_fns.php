<?
function page_parents()
{
	global $DB;

	$pages = array();
	$pages[0] = array();
	$pages[0]["children"] = array();
	$pages[0]["page_name"] = "Корень";
	$pages[0]["page_id"] = 0;

	$rows = $DB->select("SELECT page_id, page_name, page_parent FROM ?_pages ORDER BY page_parent ASC, page_position ASC");

	foreach($rows as $row)
	{
		$pages[$row["page_id"]] = $row;
		$pages[$row["page_id"]]["children"] = array();
	}

	foreach($pages as $k => $v)
	{
		if(isset($v["page_parent"]))
			$pages[$v["page_parent"]]["children"][] = $k;
	}

	$output = array();
	draw_tree($pages, $output);
	return $output;

}

function draw_tree(&$data, &$output,  $id = 0, $level = 0)
{
	$output[$id] = str_repeat("&nbsp;&nbsp;", $level).$data[$id]["page_name"];
	foreach($data[$id]["children"] as $v)
	{
		draw_tree($data, $output, $v, $level + 1);
	}
	return;
}


function site_templates()
{
	global $_CONFIG;

	$output = array();
	$output["0"] = Dreamedit::translate("Нет шаблона");

	foreach(glob($_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."vars.*.php") as $tpl)
	{
		include $tpl;
		$output[$tpl_vars["label"]["name"]] = $tpl_vars["label"]["value"];
	}

	return $output;
}

//draw_tree($eps, $spe);

?>
