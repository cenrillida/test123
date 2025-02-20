<?
ini_set('memory_limit', '512M');
include_once dirname(__FILE__)."/_include.php";

// обновляем информацию о модулх
Dreamedit::updateRegistredObjects();

// чистим старые логи
Dreamedit::cleanLogs();

$cacheResetFlag = false;

if($_ACTIVE["action"]=="save" || $_ACTIVE["action"]=="del" || $_GET['act']=='del' || $_GET["action"]=="save" || $_GET['oper'] == 'delete') {
	$cacheEngine = new CacheEngine();
	$cacheEngine->reset();
}


// устанавливаем шаблон системы администрирования
$global_tmp = $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"].$_CONFIG["action"][$_ACTIVE["action"]]["template"];


$global_templater = new Templater();

// создаем массив заменяемых констант и заполняем его данными из конфигов (системы и активного модуля)
$global_tmp_data = array();

// заменяем все вытащенные значения известными переменными из настроек
foreach($global_templater->getVarsFromPath($global_tmp) as $t_var)
{
	$global_tmp_data[$t_var] = "";

	// если имеется значение JSCRIPT и в настройках мода есть секция jscript - подключаем скрипты указанные в секции
	if($t_var == "JSCRIPT" && isset($_CONFIG["module"][strtolower($t_var)]) && $_GET[debug]!=1)
	{
		$global_tmp_data[$t_var] = "";
		foreach($_CONFIG["module"][strtolower($t_var)] as $script)
		{
			$global_tmp_data[$t_var] .= "<script type=\"text/javascript\" src=\"".$_CONFIG["global"]["paths"]["mod_path"].$script."\"></script>\n";
		}
		continue;
	}

	// если имеется значение CCS и в настройках мода есть секция css - подключаем стили указанные в секции
	if($t_var == "CSS" && isset($_CONFIG["module"][strtolower($t_var)]))
	{
		$global_tmp_data[$t_var] = "";
		foreach($_CONFIG["module"][strtolower($t_var)] as $style)
		{
			$global_tmp_data[$t_var] .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$_CONFIG["global"]["paths"]["mod_path"].$style."\" />\n";
		}
		continue;
	}

	// массив констант путей
	if(isset($_CONFIG["global"]["paths"][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["global"]["paths"][strtolower($t_var)];

	// массив констант из общих настроек
	if(isset($_CONFIG["global"]["general"][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["global"]["general"][strtolower($t_var)];

	// массив констант из активного модуля (если требуется - заменяет общие настройки)
	if(isset($_CONFIG["module"]["general"][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["module"]["general"][strtolower($t_var)];

	// массив констант из активного action'a
	if(isset($_CONFIG["action"][$_ACTIVE["action"]][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["action"][$_ACTIVE["action"]][strtolower($t_var)];
}


// создаем панель action'ов
if(isset($_CONFIG["module"]["actions"]) && is_array($_CONFIG["module"]["actions"]))
{
	$spec_btn = array();

	// устанавливаем шадлоны для action панели
	$actions_tmp = 	$_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."action.html";
	$actions_tmp_spec =	$_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."action_spec.html";
	$actions_tmp_sep  =	$_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."separator_action.html";

	$actions_templater = new Templater();
	$actions_tmp_vars = $actions_templater->getVarsFromPath($actions_tmp);

	foreach($_CONFIG["module"]["actions"] as $act_name => $value)
	{
		// проверяем действие на зависимость от иных объектов
		if(!empty($_CONFIG["action"][$act_name]["check"]))
		{
			$check = explode(",", $_CONFIG["action"][$act_name]["check"]);
			$flag = array();
			foreach($check as $checkFunc)
			{
				$flag[] = call_user_func(array("СheckAction", $checkFunc));
			}

			if(in_array(false, $flag))
				continue;
		}

		if(!Permissions::checkActionPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_ACTIVE["mod"], $act_name))
			continue;

		$actions_tmp_data = array();

		foreach($actions_tmp_vars as $tmpVar)
		{
			// если в шаблоне объявлена переменная form
			if($tmpVar == "FORM")
			{
				$actions_tmp_data[$tmpVar] = $value;
				continue;
			}

			// массив констант путей
			if(isset($_CONFIG["global"]["paths"][strtolower($tmpVar)]))
				$actions_tmp_data[$tmpVar] = $_CONFIG["global"]["paths"][strtolower($tmpVar)];

			// массив констант action'ов
			if(isset($_CONFIG["action"][$act_name][strtolower($tmpVar)]))
				$actions_tmp_data[$tmpVar] = $_CONFIG["action"][$act_name][strtolower($tmpVar)];
		}
		// устанавливаем данные для замены в шаблоне
		$actions_templater->setValues($actions_tmp_data);

		// выбираем нужный шаблон в завистимости от кнопки
		if(isset($_CONFIG["action"][$act_name]["special"]))
			$spec_btn[$act_name] = $actions_templater->getResultFromPath($actions_tmp_spec);
		elseif($act_name == "separator")
			@$global_tmp_data["BUTTON_BLOCK"] .= $actions_templater->getResultFromPath($actions_tmp_sep);
		else
			@$global_tmp_data["BUTTON_BLOCK"] .= $actions_templater->getResultFromPath($actions_tmp);
	}
	// подставляем специальные action'ы в начало панели
	@$global_tmp_data["BUTTON_BLOCK"] = implode($spec_btn).$global_tmp_data["BUTTON_BLOCK"];
}


// получаем контент всех(!) рабочих областей указанных в mod.ini активного модуля
if(isset($_CONFIG["module"]["blocks"]))
{
	foreach($_CONFIG["module"]["blocks"] as $name => $value)
	{
		ob_start();

		include_once $_CONFIG["global"]["paths"]["mod_path"]."/".$value;
		$global_tmp_data[strtoupper($name)] = ob_get_contents();

		ob_end_clean();
	}
}

$global_templater->setValues($global_tmp_data);
$global_templater->displayResultFromPath($global_tmp);



?>
