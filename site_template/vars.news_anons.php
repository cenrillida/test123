<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "news_anons",
		"value" => "������ ���. ����� c �������",
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
	"anons_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("����� (English)"),
		"field" => "anons_en",
    	),	
	"news_line"     => array(
		"class" => "base::selectIline",
		"prompt" => Dreamedit::translate("�����"),
		"field" => "news_line",
	),
    "news_line_all" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("�������� �� ���� ����"),
        "value" => "0",
        "options" => "",
        "field" => "news_line_all",
    ),
	"rubric" => array(
      "class" => "base::selectItable",
      "prompt" => "�������",
      "keyname" => "id",
      "field" => "rubric",
      "textname" => "rubric",
      "query" => "SELECT c.el_id AS id,c.icont_text AS rubric 
					FROM adm_directories_content AS c
					INNER JOIN adm_directories_content AS s ON s.el_id=c.el_id AND s.icont_var='sort'
					INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=3
					WHERE c.icont_var='text'
					ORDER BY s.icont_text,c.icont_text",
      ),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ��������� � ������ ��������"),
		"size" => "10",
		"field" => "full_id",
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