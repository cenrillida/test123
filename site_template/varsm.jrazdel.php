<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "text",
		"value" => "������ ��������� ��������",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"field" => "description",
		"cols" => "51",
		"rows" => "5",
		"buttons" => "quot",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
		"buttons" => "quot",
	),

	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("��������� ����"),
		"field" => "reclama",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�������"),
		"field" => "content",
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
	 "menu_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ������� �������� ����"),
		"size" => "10",
		"field" => "menu_id",
		"buttons" => "page_id",
       ),
	"year"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("���"),
		"siz�" => "4",
		"field" => "year",
	),
	"month"   => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("�������� ������"),
		"size" => "81",
		"field" => "month",
	),
	"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("����"),
		"size" => "81",
		"field" => "people",
	),
);

?>