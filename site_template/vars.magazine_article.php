<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "magazine_article",
		"value" => "�������. �������� ������",
	),

	"journal" => array(
			"class" => "base::selectItable",
			"prompt" => Dreamedit::translate("������"),
			"value" => (int)@$_REQUEST["id"],
			"keyname" => "jid",
			"textname"=> "page_name",
			"query"=>"SELECT DISTINCT page_id AS jid,page_name FROM adm_magazine WHERE page_parent=0 ORDER BY page_name ",
			"field" => "itype_jour",
			"size" => "1",

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
	 "content_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ����������"),
		"size" => "10",
		"field" => "content_id",
		"buttons" => "page_id",
       ),
       "rubric_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� �������"),
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
		"number_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������"),
		"size" => "10",
		"field" => "number_id",
		"buttons" => "page_id",
		) ,
		"article_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������"),
		"size" => "10",
		"field" => "article_id",
		"buttons" => "page_id",
		) ,
);

?>