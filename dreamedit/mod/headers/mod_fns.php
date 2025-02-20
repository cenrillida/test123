<?
function getStructure($tid)
{
	global $DB, $phorm, $headers;

	$phorm->remove_all();
    $phorm->add_comp("type", array("class" => "base::hidden", "value" => "l"));
    $phorm->add_comp("id", array("class" => "base::hidden", "value" => $tid));

	$itype_struct = $headers->getTypeById($tid);
	addStructure($itype_struct["itype_structure"]);
}

function addStructure($structure) {
    global $DB, $phorm, $headers;

    $structure = xml_get_array_from_xml_string($structure);
    $components = getComps($structure);

    $phorm->add_comps($components);
}

function getComps($structure) {
    $components = array();

    // если только 1 элемент формы, то строим подходящий нам массив
    if(!isset($structure["components"]["element"][0]))
        $structure["components"]["element"] = array($structure["components"]["element"]);

    foreach($structure["components"]["element"] as $key => $struct)
    {
        $el_name = $struct["name"];
        unset($struct["name"]);
        $components[$el_name] = $struct;
    }

    return $components;
}
/*
function elements_sort_func($a, $b)
{
	global $el_cont, $type_rows;

	if($a["itype_id"] != $b["itype_id"])
		return 0;

	$sort_field = strtoupper($type_rows[$a["itype_id"]]["itype_el_sort_field"]);
	$sort_type  = $type_rows[$a["itype_id"]]["itype_el_sort_type"];

	if(empty($sort_field) || !isset($el_cont[$a["el_id"]][$sort_field]))
		return strcmp($a["el_id"]["el_date"], $b["el_id"]["el_date"]);

	if($sort_type == "ASC")
		return strcmp($el_cont[$a["el_id"]][$sort_field], $el_cont[$b["el_id"]][$sort_field]);

	return strcmp($el_cont[$b["el_id"]][$sort_field], $el_cont[$a["el_id"]][$sort_field]);
}*/
?>