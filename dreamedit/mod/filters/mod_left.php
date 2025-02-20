<?
include_once dirname(__FILE__)."/../../_include.php";


$cell_prefx = "filter_";
$rows = $DB->select("SELECT * FROM ?_filters ORDER BY filter_title DESC");

$ico = array(
	"en"  => "document_text.gif",
	"dis" => "document_text_dis.gif",
);

if(empty($rows))
{
	echo Dreamedit::translate("Постфильтры отсутствуют");
	return;
}

$mod_templater = new Templater();
$mod_tmp = $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."mod_left.html";
$mod_active_tmp = $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["skin_path"]."mod_left_active.html";

$mod_tmp_data = array();
foreach($rows as $row)
{
	// сморим активный элемент или нет
	if(@$_REQUEST["id"] == $row[$cell_prefx."id"])
		$mod_tmp_vars = $mod_templater->getVarsFromPath($mod_active_tmp);
	else
		$mod_tmp_vars = $mod_templater->getVarsFromPath($mod_tmp);

	foreach($mod_tmp_vars as $tmpVar)
	{
		// если в шаблоне объявлена переменная id
		if($tmpVar == "IMG")
		{
			$mod_tmp_data[$tmpVar] = $ico["en"];
			continue;
		}

		if($tmpVar == "NAME")
		{
			$mod_tmp_data[$tmpVar] = $row[$cell_prefx."title"];
			continue;
		}		

		// массив констант путей
		if(isset($_CONFIG["global"]["paths"][strtolower($tmpVar)]))
			$mod_tmp_data[$tmpVar] = $_CONFIG["global"]["paths"][strtolower($tmpVar)];
		// массив констант из mod.ini текущего мода
		if(isset($_CONFIG["module"]["general"][strtolower($tmpVar)]))
			$mod_tmp_data[$tmpVar] = $_CONFIG["module"]["general"][strtolower($tmpVar)];

		if(isset($row[$cell_prefx.strtolower($tmpVar)]))
			$mod_tmp_data[$tmpVar] = $row[$cell_prefx.strtolower($tmpVar)];
	}
	
	// устанавливаем данные для замены в шаблоне
	$mod_templater->setValues($mod_tmp_data);

	// показываем результат в нужном шаблоне
	if(@$_REQUEST["id"] == $row[$cell_prefx."id"])
		$mod_templater->displayResultFromPath($mod_active_tmp);
	else
		$mod_templater->displayResultFromPath($mod_tmp);
}

?>