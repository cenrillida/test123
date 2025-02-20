<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "magazine_article_all",
		"value" => "������. ��������� ������",
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
	 "article_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������"),
		"size" => "10",
		"field" => "article_id",
		"buttons" => "page_id",
       ),
       "rubric_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������ � �������"),
		"size" => "10",
		"field" => "rubric_id",
		"buttons" => "page_id",
       ),
      "persona_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� �������"),
		"size" => "10",
		"field" => "persona_id",
		"buttons" => "page_id",
		),
		"content_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ����������"),
		"size" => "10",
		"field" => "content_id",
		"buttons" => "page_id",
		),
      "short_list" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("�� �������"),
		"size" => "1",
		"field" => "short_list",
	),
);

?>