<?
include_once dirname(__FILE__)."/../../_include.php";


include_once "mod_fns.php";

$polls = new Polls();

// ����������� ���� ��������
$type_rows = $polls->getTypes();

// ����������� ��� �������� ��������
$el_rows = array();
foreach($type_rows as $k => $v)
	$el_rows = $el_rows + $polls->getElementsByType(array($k), @$v["itype_el_sort_field"], @$v["itype_el_sort_type"]);


// ������������ ������� � �������� ������� ������ ��� ���������� ������
$rows = Dreamedit::createTreeArrayFromPolls($type_rows, $polls->appendContent($el_rows));

// ������ ������
$tree = new WriteTree("d", $rows);
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("������"), "t0");

// ��������� ������ �� $openTo
$openTo = "t".(int)@$_GET["id"];
if(isset($_GET["type"]) && $_GET["type"] == "l")
	$openTo = "l".(int)@$_GET["id"];

$tree->openTreeTo($openTo);

?>