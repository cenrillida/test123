<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pers",
		"value" => "���������� �� ��������",
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
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ (English)"),
		"field" => "content_en",
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
		"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� � �������"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
	),
//	    	"full_id_c"     => array(
//	        "class" => "base::integer",
//		"prompt" => Dreamedit::translate("ID ������ ������"),
//		"size" => "10",
//		"field" => "full_id_c",
//		"buttons" => "page_id",
//	),
	    	"full_id_a"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ������ �� �������"),
		"size" => "10",
		"field" => "full_id_a",
		"buttons" => "page_id",
        ),


);

?>