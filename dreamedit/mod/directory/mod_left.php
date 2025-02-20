<?
include_once dirname(__FILE__)."/../../_include.php";


include_once "mod_fns.php";

$directories = new Directories();

// ����������� ���� ��������
$type_rows = $directories->getTypes();

// ����������� ��� �������� ��������
$el_rows = array();
foreach($type_rows as $k => $v)
	$el_rows = $el_rows + $directories->getElementsByType(array($k), @$v["itype_el_sort_field"], @$v["itype_el_sort_type"]);

//print_r($el_rows);
// ������������ ������� � �������� ������� ������ ��� ���������� ������
$rows = Dreamedit::createTreeArrayFromDirectories($type_rows, $directories->appendContent($el_rows));

// ������ ������

$tree = new WriteTree("d", $rows);
$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
$tree->displayTree(Dreamedit::translate("�������������� �����"), "t0");

// ��������� ������ �� $openTo
$openTo = "t".(int)@$_GET["id"];
if(isset($_GET["type"]) && $_GET["type"] == "l")
	$openTo = "l".(int)@$_GET["id"];

$tree->openTreeTo($openTo);

?>