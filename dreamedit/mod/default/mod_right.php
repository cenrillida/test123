<?
include_once dirname(__FILE__)."/../../_include.php";


$mod_templater = new Templater();
$mod_tmp = $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."mod_default_right.html";
$mod_tmp_vars = $mod_templater->getVarsFromPath($mod_tmp);

$mod_tmp_data = array();
foreach(glob($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_dir"]."*/mod.ini") as $modIni)
{
	$tmp_conf = array();
	$tmp_conf = Dreamedit::parseConfigIni($modIni, ":");

	// ���� ������ ��-��������
	if($tmp_conf["general"]["name"] == $_CONFIG["global"]["general"]["default_mod"])
		continue;

	if(!Permissions::checkModPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $tmp_conf["general"]["name"]))
		continue;

	foreach($mod_tmp_vars as $tmpVar)
	{
		// ������ �������� �����
		if(isset($_CONFIG["global"]["paths"][strtolower($tmpVar)]))
			$mod_tmp_data[$tmpVar] = $_CONFIG["global"]["paths"][strtolower($tmpVar)];
		// ������ �������� �� mod.ini ��������� ����
		if(isset($tmp_conf["general"][strtolower($tmpVar)]))
			$mod_tmp_data[$tmpVar] = $tmp_conf["general"][strtolower($tmpVar)];
	}
	
	// ������������� ������ ��� ������ � �������
	$mod_templater->setValues($mod_tmp_data);
	// ���������� ���������
	$mod_templater->displayResultFromPath($mod_tmp);
}
?>