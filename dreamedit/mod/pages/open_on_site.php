<?
include_once dirname(__FILE__)."/../../_include.php";

// подключаем файл соединения с базой
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/site.fns.php";


$pg = new Pages();

// получаем аттрибуты требуемой страницы
foreach($mod_array["components"] as $k => $v)
{
	if(!isset($v["field"]))
		continue;

	$page_attr[$v["field"]] = $_REQUEST[$k];
}

if(empty($page_attr["page_template"]))
	die("Не задан шаблон отображения");

$page_attr["page_id"];

Dreamedit::sendHeaderByCode(301);
Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/index.php?page_id=".$page_attr["page_id"]);

exit;

?>