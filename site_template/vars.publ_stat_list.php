<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "publ_stat_list",
		"value" => "����������. ������� ����������",
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
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�������"),
		"field" => "content",
	),
	"count"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("���������� ���������� �� ��������"),
		"size" => "10",
		"field" => "count",
	),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������� ����������"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
       ),
	"full_id_p"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ��������� ��������"),
		"size" => "10",
		"field" => "full_id_p",
		"buttons" => "page_id",
       ),
   	"full_id_a"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������"),
		"size" => "10",
		"field" => "full_id_a",
		"buttons" => "page_id",
       ),
    "pers_publ"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ���������� �������"),
		"size" => "10",
		"field" => "pers_publ",
		"buttons" => "page_id",
       ),
    "menu_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ������� �������� ����"),
		"size" => "10",
		"field" => "menu_id",
		"buttons" => "page_id",
       ),

);

?>