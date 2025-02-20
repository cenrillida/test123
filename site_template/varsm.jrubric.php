<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jrubric",
		"value" => "Журнал. Рубрика",
	),

	"name"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Название для админки"),
		"size" => "51",
		"field" => "page_name",
		"buttons" => "quot",
	),

	"rubric"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Название рубрики"),
		"size" => "101",
		"field" => "rubric",
		"buttons" => "quot",
	),
	"rubric_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Название рубрики (English)"),
		"size" => "101",
		"field" => "rubric_en",
		"buttons" => "quot",
	),
	"icon"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Иконка"),
		"field" => "icon",
	),
	"content"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Комментарий"),
		"field" => "content",
	),

);

?>