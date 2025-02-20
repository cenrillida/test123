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
			"value"				=> "{DATE} - {TITLE}",
		),
		"el_sort"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("���������� ���������"),
			"help"				=> "��� ���������� �� ������� ����� ������� ���������� ������ ���������.<br />(��-��������� ����������� �� ���������� ���� ������� ��-��������)",
			"size"				=> "51",
			"field"				=> "itype_el_sort_field",
		),
		"el_sort_type"		=> array (
			"class"				=> "base::selectbox",
			"prompt"			=> Dreamedit::translate("��� ����������"),
			"field"				=> "itype_el_sort_type",
			"options"					=> array("ASC" => "��-�����������", "DESC" => "��-��������"),
		),
		"el_status"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("���������� �������"),
			"help"				=> Dreamedit::translate("���������� �� ��������� ���������, ������������ ������ ���������� ��������<br />(���� ���� ������ - ������� ���������)."),
			"size"				=> "51",
			"field"				=> "itype_el_status",
		),
		"structure"			=> array (
			"class"				=> "base::textarea",
			"prompt"			=> Dreamedit::translate("���������"),
			"help"				=> Dreamedit::translate("��������� ������ � ������� xml"),
			"required"			=> TRUE,
			"cols"				=> "111",
			"rows"				=> "30",
			"field"				=> "itype_structure",
		    "value"             => "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n<components>\n\n
								    <element name=\"date\" class=\"base::date\" prompt=\"���� ���������:\" size=\"51\" field=\"date\" required=\"true\" buttons=\"calendar\"/>\n
                                    <element name=\"title\" class=\"base::textbox\" prompt=\"�������� (��� �������):\" size=\"151\" field=\"title\" required=\"true\" buttons=\"quot\"/>\n
                                    <element name=\"year_beg\" class=\"base::selectyear\" prompt=\"��� ������:\"  field=\"year_beg\" rang=\"-2|3\" />\n
                                    <element name=\"year_end\" class=\"base::selectyear\" prompt=\"��� ���������:\"  field=\"year_end\" rang=\"-2|3\" />\n
                                    <element name=\"number\" class=\"base::textbox\" prompt=\"�����:\" size=\"51\" field=\"number\" required=\"true\" buttons=\"quot\"/>\n
                                   

                                    <element name=\"chif\" class=\"base::selectItable\" prompt=\"������������\" keyname=\"id\"  field=\"chif\"  textname=\"fio\"
                                    query=\"SELECT persona.id,CONCAT(surname,' ',name,' ',fname) AS fio,ran,IFNULL(d1.short,'') AS stepen,IFNULL(d2.short,'') AS zvanie  FROM persons AS persona
                                         LEFT OUTER JOIN stepen AS d1 ON d1.id=persona.us
                                         LEFT OUTER JOIN zvanie AS d2 ON d2.id=persona.uz
                                         WHERE NOT (persona.otdel = '��������'   OR persona.otdel ='������� ����������')
                                         ORDER BY fio\"   /> \n
                                   <element name=\"status\" class=\"base::checkbox\" prompt=\"������������\" options=\"\"   field=\"status\" value=\"0\"/>\n
                                   </components>",
                            		),
		"itype_sort"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("���������� �����"),
			"help"				=> "����� �� �������",
			"size"				=> "51",
			"field"				=> "itype_sort",
		),
	),
);
/* <element name=\"source\" class=\"base::selectItable\" prompt=\"�������� ��������������:\"  keyname=\"id\"  field=\"source\"  textname=\"text\" required=\"true\"
                                    query=\"SELECT a.el_id AS id,a.icont_text AS text FROM adm_directories_content AS a
                                            INNER JOIN adm_directories_content AS s ON s.el_id=a.el_id AND s.icont_var='value'
	                                        INNER JOIN adm_directories_element AS e ON e.el_id=a.el_id AND e.itype_id='6'
	                                        WHERE a.icont_var='text'
	                                        ORDER BY s.icont_text\"
                                    />\n
*/
?>

