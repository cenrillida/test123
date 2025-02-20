<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "grant",
		"value" => "������ ������ �������",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("���������"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),
	"anons"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�����"),
		"field" => "anons",
    	),
    "submenu_filter" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("��������� ������� � ������ �� ����"),
		"size" => "1",
		"field" => "submenu_filter",
	),
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ �� ����"),
		"field" => "links",
	),
	"news_line"     => array(
		"class" => "base::selectnir",
		"prompt" => Dreamedit::translate("�������� �������������� ���"),
		"field" => "news_line",
	),
	"pers_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� �������� � �������"),
		"size" => "10",
		"field" => "pers_id",
		"buttons" => "page_id",
	),

    "tpl_name"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("��� ������� tpl"),
		"size" => "51",
		"field" => "tpl_name",
	),
	"count"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("���������� � ������"),
		"size" => "10",
		"field" => "count",
		"value"=> "1000",
	),

	"sort_field"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("���� ����������"),
		"size" => "51",
		"field" => "sort_field",
	),
	"sort_type"     => array(
		"class" => "base::selectbox",
		"prompt" => Dreamedit::translate("��� ����������"),
		"options" => array("DESC" => "��-�����������", "ASC" => "��-��������"),
		"field" => "sort_type",
	),


);

?>