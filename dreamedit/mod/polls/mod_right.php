<?
include_once dirname(__FILE__)."/../../_include.php";


include_once "form.php";
include_once "mod_fns.php";

$phorm = new mod_phorm($mod_array);
$headerss = new Polls();

$id = (int)@$_REQUEST["id"];
$type = isset($_REQUEST["type"])? "l": "";

if($_ACTIVE["action"] == "add")
{
	$phorm->display();
}

if($_ACTIVE["action"] == "addEl")
{
	// должен прийти t_id
	getStructure($id);
	$phorm->display();
}


if($_ACTIVE["action"] == "edit")
{
	if($type == "l")
	{
		$lid = (int)@$_REQUEST["id"];
		$el = $polls->getElementById($id);
		$id = $el["itype_id"];

		getStructure($id);
		$phorm->add_comp("lid", array("class" => "base::hidden", "value" => $lid));
		$el = $polls->appendContent(array($lid => $el));
		$data = array();
		foreach($phorm->data() as $k => $v)
		{
			if(!array_key_exists(strtoupper($k), $el[$lid]["content"]))
				continue;

			$data[$k] = is_null($el[$lid]["content"][strtoupper($k)])? "": $el[$lid]["content"][strtoupper($k)];
		}
	}
	else
	{
		$row = $polls->getTypeById($id);
		$data = array();
		foreach($phorm->data() as $k => $v)
		{
			if(!isset($v["field"]))
				continue;

			$data[$k] = $row[$v["field"]];
		}
	}

	$phorm->mod_phorm_values($data);
	$phorm->display();
}


if($_ACTIVE["action"] == "save")
{
	// должен прийти t_id
	if($type == "l")
	{
		getStructure($id);

		if(isset($_REQUEST["lid"]))
			$phorm->add_comp("lid", array("class" => "base::hidden", "value" => $_REQUEST["lid"]));
	}
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
	if($type == "l")
	{
		$el = $polls->getElementById($id);

		// id = lid
		// удаляем все записи (элемент и контент элемента) из базы
		$DB->query("DELETE FROM ?_polls_content WHERE el_id = ?d", $_GET["id"]);
		$DB->query("DELETE FROM ?_polls_element WHERE el_id = ?d", $_GET["id"]);

		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"] . "&id=".$el["itype_id"]);
	}
	else
	{
		// выбираем ID всех элементов для уничтожения ненужного контента
		$el_ids = $polls->getElementsByType(array($id));

		if(!empty($el_ids))
			$DB->query("DELETE FROM ?_polls_content WHERE el_id IN (?a)", array_keys($el_ids));
		$DB->query("DELETE FROM ?_polls_element WHERE itype_id = ?d", $id);
		$DB->query("DELETE FROM ?_polls_type WHERE itype_id = ?d", $id);
		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]);
	}
}

?>