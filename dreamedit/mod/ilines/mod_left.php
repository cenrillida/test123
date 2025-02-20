<?
include_once dirname(__FILE__)."/../../_include.php";


include_once "mod_fns.php";

$ilines = new Ilines();

// вытаскиваем типы инфолент
$type_rows = $ilines->getTypes();

// вытаскиваем все элементы инфолент
$el_rows = array();
foreach($type_rows as $k => $v)
	$el_rows = $el_rows + $ilines->getElementsByType(array($k), @$v["itype_el_sort_field"], @$v["itype_el_sort_type"]);


// присоединяем контент и получаем готовый массив для построения дерева
$rows = Dreamedit::createTreeArrayFromIlines($type_rows, $ilines->appendContent($el_rows));

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