<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "comment_reg",
		"value" => "�����������. �����������",
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
	"result"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("����� �����������"),
		"field" => "result",
	),

	"final"  => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("������ �����������"),
		"field" => "final",

	),

);

?>