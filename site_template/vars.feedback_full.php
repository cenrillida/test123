<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "feedback_full",
		"value" => "Шаблон обратная связь (подробно)",
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
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
	"full_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID со списком"),
		"size" => "10",
		"field" => "full_id",
		"buttons" => "page_id",
	),

);

?>