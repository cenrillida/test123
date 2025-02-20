<?
$mod_array = array (
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id"		=> array (
			"class"				=> "base::hidden",
			"field"				=> "itype_id",
		),

		"name"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("��������"),
			"size"				=> "51",
			"required"			=> TRUE,
			"field"				=> "itype_name",
			"buttons"			=> "quot",
		),
		"el_structure"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("��������� ����������� ��-���"),
			"help"				=> "��� ����������� �� ������ ������������ ������������ � ������ ���� (field) ���������� �� ��������� ��������.",
			"size"				=> "51",
			"required"			=> TRUE,
			"field"				=> "itype_el_structure",
			"buttons"			=> "quot",
			"value"				=> "{TEXT} - {VALUE}",
		),
		"el_sort"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("���������� ���������"),
			"help"				=> "��� ���������� �� ������� ����� ������� ���������� ������ ���������.<br />(��-��������� ����������� �� ���������� ���� ������� ��-��������)",
			"size"				=> "51",
			"value"				=> "TEXT",
			"field"				=> "itype_el_sort_field",
		),
		"el_sort_type"		=> array (
			"class"				=> "base::selectbox",
			"prompt"			=> Dreamedit::translate("��� ����������"),
			"field"				=> "itype_el_sort_type",
			"options"					=> array("ASC" => "��-�����������", "DESC" => "��-��������"),
		),
		"structure"			=> array (
			"class"				=> "base::textarea",
			"prompt"			=> Dreamedit::translate("���������"),
			"help"				=> Dreamedit::translate("��������� ������ � ������� xml"),
			"required"			=> TRUE,
			"cols"				=> "111",
			"rows"				=> "30",
			"field"				=> "itype_structure",
			"value"				=> "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n<components>\n<element name=\"text\" class=\"base::textbox\" prompt=\"�����\" size=\"51\" field=\"text\" required=\"true\" buttons=\"quot\"/>\n<element name=\"value\" class=\"base::textbox\" prompt=\"��������\" size=\"51\" field=\"value\" required=\"true\" />\n\n</components>",
		),
	),
);

?>
