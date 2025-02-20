<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "journal_list",
		"value" => "�������. ������ ��������",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"title_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title English"),
		"size" => "51",
		"field" => "title_en",
		"buttons" => "quot",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"field" => "description",
		"cols" => "51",
		"rows" => "5",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
    "online_resource" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("����������� �������"),
        "size" => "1",
        "field" => "online_resource",
    ),
/*	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("���������"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),*/
	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("���� � ������ �������"),
		"field" => "reclama",
	),

	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�������"),
		"field" => "content",
	),
/*
	"links"   => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ �� ����"),
		"field" => "links",
	),
*/
	"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("����"),
		"size" => "81",
		"field" => "people",
	),
	"bank_check"    => array(
		"class" => "base::textarea",
		"cols" => "51",
		"rows" => "5",
		"prompt" => Dreamedit::translate("��������� ���������� �������<br />� ���������� ����������"),
		"field" => "bank_check",
	),
);

?>