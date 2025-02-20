<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "magazine_article_send",
		"value" => "�������. ��������� ������",
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
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"cols" => "51",
		"rows" => "5",
		"field" => "description",
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
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������� (English)"),
		"field" => "content_en",
	),

	"result"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("���������"),
		"field" => "result",
	),
	"result_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("��������� (English)"),
		"field" => "result_en",
	),

	/*
	"congr_page"  => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("�������� � �����������"),
		"field" => "congr_page",
		"buttons" => "page_id",
	),
*/
);

?>