<?
include_once dirname(__FILE__)."/../../_include.php";


include_once "form.php";
include_once "mod_fns.php";

$phorm = new mod_phorm($mod_array);
$ilines = new Ilines();

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
		$el = $ilines->getElementById($id);
		$id = $el["itype_id"];

		getStructure($id);
		$phorm->add_comp("lid", array("class" => "base::hidden", "value" => $lid));
		$el = $ilines->appendContent(array($lid => $el));
		$data = array();
		foreach($phorm->data() as $k => $v)
		{
			if(!array_key_exists(strtoupper($k), $el[$lid]["content"]))
				continue;

			$data[$k] = is_null($el[$lid]["content"][strtoupper($k)])? "": $el[$lid]["content"][strtoupper($k)];
		}
        if(!empty($el[$lid]["content"]['GET_CODE'])):
        ?>
        <p>—сылка по специцальному коду: <a target="_blank" href="https://<?=$_SERVER["SERVER_NAME"]?>/index.php?page_id=502&id=<?=$_GET["id"]?>&code=<?=$el[$lid]["content"]['GET_CODE']?>">https://<?=$_SERVER["SERVER_NAME"]?>/index.php?page_id=502&id=<?=$_GET["id"]?>&code=<?=$el[$lid]["content"]['GET_CODE']?></a></p>
        <?php
        endif;
//		print_r($data);
	}
	else
	{
		$row = $ilines->getTypeById($id);
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
		$el = $ilines->getElementById($_GET['id']);

		// id = lid
		// удал€ем все записи (элемент и контент элемента) из базы
		$DB->query("DELETE FROM ?_ilines_content WHERE el_id = ?d", $_GET["id"]);
		$DB->query("DELETE FROM ?_ilines_element WHERE el_id = ?d", $_GET["id"]);

        $cacheEngine = new CacheEngine();
        $cacheEngine->reset();

		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"] . "&id=".$el["itype_id"]);
	}
	else
	{
		// выбираем ID всех элементов дл€ уничтожени€ ненужного контента
		$el_ids = $ilines->getElementsByType(array($id));

		if(!empty($el_ids))
			$DB->query("DELETE FROM ?_ilines_content WHERE el_id IN (?a)", array_keys($el_ids));
		$DB->query("DELETE FROM ?_ilines_element WHERE itype_id = ?d", $id);
		$DB->query("DELETE FROM ?_ilines_type WHERE itype_id = ?d", $id);

        $cacheEngine = new CacheEngine();
        $cacheEngine->reset();

		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]);
	}
}

if($_ACTIVE["action"] == "open_on_site_iline")
{
    Dreamedit::sendHeaderByCode(301);
    Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/index.php?page_id=502&id=".$_GET["id"]);

    exit;
}

if($_ACTIVE["action"] == "open_rating_iline")
{
    include_once 'rating.php';
}

?>