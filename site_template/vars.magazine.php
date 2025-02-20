<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "magazine",
		"value" => "�������. �������� �������",
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

     "full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ��������� � ���������� ����������"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
	),
	"summary_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� � �����������"),
		"size" => "10",
		"field" => "summary_id",
		"buttons" => "page_id",
	),
	 "archive_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������ �������"),
		"size" => "10",
		"field" => "archive_id",
		"buttons" => "page_id",
	),
    "art_archive_en_id"     => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("ID �������� ������ ������ �� ����������"),
        "size" => "10",
        "field" => "art_archive_en_id",
        "buttons" => "page_id",
    ),
	 "authors_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������� �������"),
		"size" => "10",
		"field" => "authors_id",
		"buttons" => "page_id",
	),
	"author_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������ (��� ������ ������)"),
		"size" => "10",
		"field" => "author_id",
		"buttons" => "page_id",
	),
	"rubrics_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������� ������"),
		"size" => "10",
		"field" => "rubrics_id",
		"buttons" => "page_id",
	),
	"years_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ����������"),
		"size" => "10",
		"field" => "years_id",
		"buttons" => "page_id",
	),
	"autors_years_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ���������� (������)"),
		"size" => "10",
		"field" => "autors_years_id",
		"buttons" => "page_id",
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
		"prompt" => Dreamedit::translate("ID �������� ������� (������ � �������)"),
		"size" => "10",
		"field" => "rubric_id",
		"buttons" => "page_id",
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
    "for_number"    => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("������ ����� ����������"),
		"field" => "for_number",
	),

);

?>