<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "feedback_view",
		"value" => "������ ������ �������� �����.",
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

	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�������"),
		"field" => "content",
	),
    "count"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("���������� ������� �� ��������"),
		"size" => "10",
		"field" => "count",
	),
	"feedback_full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ��������� ��������"),
		"size" => "10",
		"field" => "feedback_full_id",
		"buttons" => "page_id",
       ),

);

?>