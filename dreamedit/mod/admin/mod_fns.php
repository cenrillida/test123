<?

function getSkins()
{
	global $_CONFIG;

	$data = array();
	foreach(glob($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_dir"]."*") as $v)
	{
		$data[basename($v)] = basename($v);
	}
	return $data;
}


function getLangs()
{
	global $_CONFIG;

	$data = array();
	foreach(glob($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["translate"]."*") as $v)
	{
		$data[basename($v)] = basename($v);
	}
	return $data;
}

// сздаем массив прав доступа дл€ дерева чекбоксов
// все права будут содержатьс€ в массиве с именем $name
function permissionTree($name, $prompt = "ѕрава доступа")
{
	global $DB, $_CONFIG;

	$modules = $DB->select("SELECT * FROM ?_modules ORDER BY mod_name");
	$actions = $DB->select("SELECT ?_actions.act_name AS ARRAY_KEY, ?_actions.* FROM ?_actions ORDER BY act_name");
	$permissions = array();
	$permissions[$name."[all]"] = array("title" => "ѕолные права", "check" => true, "children" => array());
	foreach($modules as $v)
	{
		// если модуль "по-умолчанию" - пропускаем
		if($v["mod_name"] == $_CONFIG["global"]["general"]["default_mod"])
			continue;

		$modConf = Dreamedit::parseConfigIni($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_dir"].$v["mod_name"]."/mod.ini", ":");

		$permissions[$name."[all]"]["children"][] = $name."[modules][".$modConf["general"]["name"]."]";

		$permissions[$name."[modules][".$modConf["general"]["name"]."]"] = array(
			"title" => $modConf["general"]["title"],
			"check" => true,
			"children" => array(),
		);

		foreach($modConf["actions"] as $act_name => $act_data)
		{
			if(isset($actions[$act_name]))
			{
				$permissions[$name."[modules][".$modConf["general"]["name"]."]"]["children"][] = $name."[actions][".$modConf["general"]["name"]."][".$act_name."]";

				$permissions[$name."[actions][".$modConf["general"]["name"]."][".$act_name."]"] = array(
					"title" => $_CONFIG["action"][$act_name]["descr"],
					"check" => true,
					"children" => array(),
				);
			}
		}
	}

	return array(
		"class" => "base::checktree",
		"prompt" => Dreamedit::translate($prompt),
		"options" => $permissions,
		"start" => $name."[all]",
		"field" => "mod_id",
	);
}

function getPermissions($id)
{
	global $DB, $phorm;
	$id = (int)$id;
		// убираем старые компоненты
	$phorm->remove_all();
	// создаем массив дл€ дерева прав доступа
	$tmp = permissionTree("permissions", "ѕрава доступа дл€ пользовател€ <b>".$DB->selectCell("SELECT a_name FROM ?_admin WHERE a_id = ?d", $id)."</b>");

	$phorm->add_comp("save_permissions", array("class" => "base::hidden","value" => $id,));
	$phorm->add_comp("permissions", $tmp);

}


// конверси€ массива в строку (см. компонент phorm - checktree)
function modArray2string($val)
{
	$retStr = array();
	foreach($val as $k => $v)
	{
		if(is_array($v))
		{
			$tmp = modArray2string($v);
			foreach($tmp as $l)
				$retStr[] = $k."|".$l;
		}
		else
			$retStr[] = $k;
	}
	return $retStr;
}

// конверси€ строки в массив (обратна€ ф-ци€ дл€ modArray2string)
function modString2array($val)
{
	$valueArr = explode("|", $val);
	$retArr = 1;
	while(!empty($valueArr))
	{
		$tmp = array();
		$f = array_pop($valueArr);
		$tmp["".$f] = $retArr;
		$retArr = $tmp;
	}

	return $tmp;
}
?>