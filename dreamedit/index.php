<?
ini_set('memory_limit', '512M');
include_once dirname(__FILE__)."/_include.php";

// ��������� ���������� � ������
Dreamedit::updateRegistredObjects();

// ������ ������ ����
Dreamedit::cleanLogs();

$cacheResetFlag = false;

if($_ACTIVE["action"]=="save" || $_ACTIVE["action"]=="del" || $_GET['act']=='del' || $_GET["action"]=="save" || $_GET['oper'] == 'delete') {
	$cacheEngine = new CacheEngine();
	$cacheEngine->reset();
}


// ������������� ������ ������� �����������������
$global_tmp = $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"].$_CONFIG["action"][$_ACTIVE["action"]]["template"];


$global_templater = new Templater();

// ������� ������ ���������� �������� � ��������� ��� ������� �� �������� (������� � ��������� ������)
$global_tmp_data = array();

// �������� ��� ���������� �������� ���������� ����������� �� ��������
foreach($global_templater->getVarsFromPath($global_tmp) as $t_var)
{
	$global_tmp_data[$t_var] = "";

	// ���� ������� �������� JSCRIPT � � ���������� ���� ���� ������ jscript - ���������� ������� ��������� � ������
	if($t_var == "JSCRIPT" && isset($_CONFIG["module"][strtolower($t_var)]) && $_GET[debug]!=1)
	{
		$global_tmp_data[$t_var] = "";
		foreach($_CONFIG["module"][strtolower($t_var)] as $script)
		{
			$global_tmp_data[$t_var] .= "<script type=\"text/javascript\" src=\"".$_CONFIG["global"]["paths"]["mod_path"].$script."\"></script>\n";
		}
		continue;
	}

	// ���� ������� �������� CCS � � ���������� ���� ���� ������ css - ���������� ����� ��������� � ������
	if($t_var == "CSS" && isset($_CONFIG["module"][strtolower($t_var)]))
	{
		$global_tmp_data[$t_var] = "";
		foreach($_CONFIG["module"][strtolower($t_var)] as $style)
		{
			$global_tmp_data[$t_var] .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$_CONFIG["global"]["paths"]["mod_path"].$style."\" />\n";
		}
		continue;
	}

	// ������ �������� �����
	if(isset($_CONFIG["global"]["paths"][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["global"]["paths"][strtolower($t_var)];

	// ������ �������� �� ����� ��������
	if(isset($_CONFIG["global"]["general"][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["global"]["general"][strtolower($t_var)];

	// ������ �������� �� ��������� ������ (���� ��������� - �������� ����� ���������)
	if(isset($_CONFIG["module"]["general"][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["module"]["general"][strtolower($t_var)];

	// ������ �������� �� ��������� action'a
	if(isset($_CONFIG["action"][$_ACTIVE["action"]][strtolower($t_var)]))
		$global_tmp_data[$t_var] = $_CONFIG["action"][$_ACTIVE["action"]][strtolower($t_var)];
}


// ������� ������ action'��
if(isset($_CONFIG["module"]["actions"]) && is_array($_CONFIG["module"]["actions"]))
{
	$spec_btn = array();

	// ������������� ������� ��� action ������
	$actions_tmp = 	$_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."action.html";
	$actions_tmp_spec =	$_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."action_spec.html";
	$actions_tmp_sep  =	$_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."separator_action.html";

	$actions_templater = new Templater();
	$actions_tmp_vars = $actions_templater->getVarsFromPath($actions_tmp);

	foreach($_CONFIG["module"]["actions"] as $act_name => $value)
	{
		// ��������� �������� �� ����������� �� ���� ��������
		if(!empty($_CONFIG["action"][$act_name]["check"]))
		{
			$check = explode(",", $_CONFIG["action"][$act_name]["check"]);
			$flag = array();
			foreach($check as $checkFunc)
			{
				$flag[] = call_user_func(array("�heckAction", $checkFunc));
			}

			if(in_array(false, $flag))
				continue;
		}

		if(!Permissions::checkActionPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_ACTIVE["mod"], $act_name))
			continue;

		$actions_tmp_data = array();

		foreach($actions_tmp_vars as $tmpVar)
		{
			// ���� � ������� ��������� ���������� form
			if($tmpVar == "FORM")
			{
				$actions_tmp_data[$tmpVar] = $value;
				continue;
			}

			// ������ �������� �����
			if(isset($_CONFIG["global"]["paths"][strtolower($tmpVar)]))
				$actions_tmp_data[$tmpVar] = $_CONFIG["global"]["paths"][strtolower($tmpVar)];

			// ������ �������� action'��
			if(isset($_CONFIG["action"][$act_name][strtolower($tmpVar)]))
				$actions_tmp_data[$tmpVar] = $_CONFIG["action"][$act_name][strtolower($tmpVar)];
		}
		// ������������� ������ ��� ������ � �������
		$actions_templater->setValues($actions_tmp_data);

		// �������� ������ ������ � ������������ �� ������
		if(isset($_CONFIG["action"][$act_name]["special"]))
			$spec_btn[$act_name] = $actions_templater->getResultFromPath($actions_tmp_spec);
		elseif($act_name == "separator")
			@$global_tmp_data["BUTTON_BLOCK"] .= $actions_templater->getResultFromPath($actions_tmp_sep);
		else
			@$global_tmp_data["BUTTON_BLOCK"] .= $actions_templater->getResultFromPath($actions_tmp);
	}
	// ����������� ����������� action'� � ������ ������
	@$global_tmp_data["BUTTON_BLOCK"] = implode($spec_btn).$global_tmp_data["BUTTON_BLOCK"];
}


// �������� ������� ����(!) ������� �������� ��������� � mod.ini ��������� ������
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
