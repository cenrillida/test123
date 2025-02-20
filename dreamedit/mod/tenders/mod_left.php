<?
include_once dirname(__FILE__)."/../../_include.php";


include_once "mod_fns.php";

$tender = new Tenders();

// вытаскиваем типы инфолент
$type_rows = $tender->getTypes();

// вытаскиваем все элементы инфолент
$el_rows = array();
foreach($type_rows as $k => $v)
	$el_rows = $el_rows + $tender->getElementsByType(array($k), @$v["itype_el_sort_field"], @$v["itype_el_sort_type"]);


// присоедин€ем контент и получаем готовый массив дл€ построени€ дерева
$rows = Dreamedit::createTreeArrayFromTenders($type_rows, $tender->appendContent($el_rows));

// русуем дерево
$tree = new WriteTree("d", $rows);
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("√олосовани€"), "t0");

// открываем дерево до $openTo
$openTo = "t".(int)@$_GET["id"];
if(isset($_GET["type"]) && $_GET["type"] == "l")
	$openTo = "l".(int)@$_GET["id"];

$tree->openTreeTo($openTo);

?>