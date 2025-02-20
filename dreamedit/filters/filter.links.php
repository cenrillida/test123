<?

global $_CONFIG;

$menuRes = $DB->select("SELECT * FROM ?_pages");
$ids = array();
$ids[0] = array();
$ids[0]["children"] = array();
foreach($menuRes as $v)
{
	$ids[$v["page_id"]] = $v;
	$ids[$v["page_id"]]["children"] = array();
}
foreach($ids as $k => $v)
	$ids[$v["page_parent"]]["children"][] = $k;


show_menu($ids, 1);

function show_menu(&$data, $id = 0, $lvl = 0)
{
	global $_CONFIG;
	if($lvl > 2)
		return; 

	$tmp_data = array();
	if(isset($data[$id]) && $lvl != 0)
	{
		foreach($data[$id] as $k => $v)
		{
			if($v == "children")
				continue;

			$tmp = $v;
			if($k == "page_urlname" && empty($v))
				$tmp = "/index.php?page_id=".$id;

			if($k == "page_link" && !empty($v))
			{
				if(intval($v) > 0)
				{
					$tmp = "/index.php?page_id=".$v;
					$link_urlname = $data[$v]["page_urlname"];
					if(!empty($link_urlname))
						$tmp = $link_urlname;
				}
				else
					$tmp = $v;
			}

			$tmp_data[strtoupper($k)] = $tmp;	
		}

		$tmp_data["PAGE_URLNAME"] = !empty($tmp_data["PAGE_LINK"])? $tmp_data["PAGE_LINK"]: $tmp_data["PAGE_URLNAME"]; 
		$news_templater = new Templater();
		$news_templater->setValues($tmp_data);
		$news_templater->displayResultFromPath($_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"]."tpl.menu.html");
	}

	if($lvl + 1 > 2)
		return; 

	if(!empty($data[$id]["children"]) && $lvl == 1)
		echo "<div>";
	foreach($data[$id]["children"] as $v)
		show_menu($data, $v, $lvl + 1);
	if(!empty($data[$id]["children"]) && $lvl == 1)
		echo "</div>";

}

function getIds(&$id_arr, &$ids, $id = 0, $lvl = 0)
{
	if($lvl > 2)
		return;

	$id_arr[] = $id;
	foreach($ids[$id]["children"] as $v)
	{
		getIds($id_arr, $ids, $v, $lvl + 1);		
	}
	return;
}

?>