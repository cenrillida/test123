<?
include_once dirname(__FILE__)."/../../_include.php";


//include_once "mod_fns.php";

$ilines = new Ilines();

// вытаскиваем типы инфолент
$type_rows = $ilines->getTypes();

// присоединяем контент и получаем готовый массив для построения дерева
$rows = Dreamedit::createTreeArrayFromIlinesForAuto($type_rows);

// русуем дерево
$tree = new WriteTree("d", $rows);
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("Информационные ленты"), "t0");

// открываем дерево до $openTo
$openTo = "t".(int)@$_GET["id"];
if(isset($_GET["type"]) && $_GET["type"] == "l")
	$openTo = "l".(int)@$_GET["id"];

$tree->openTreeTo($openTo);

?>