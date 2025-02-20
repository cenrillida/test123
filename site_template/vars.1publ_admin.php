<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "1publ_admin",
		"value" => "���������� 1 ����������",
	),

    "title"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Title Russian"),
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
	"menu_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ������� �������� ����"),
		"size" => "10",
		"field" => "menu_id",
		"buttons" => "page_id",
       ),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �� ������� ����������"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
	),
	"full_id_a"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������"),
		"size" => "10",
		"field" => "full_id_a",
		"buttons" => "page_id",
        ),
    "article_mode" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("���������� �� ������ \"������ � �������\""),
		"size" => "1",
		"field" => "article_mode",
	),
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ �� ����"),
		"field" => "links",
	),
/*	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("���������"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),*/
);

?>