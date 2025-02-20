<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jnumber",
		"value" => "Журнал. Номер журнала ?",
	),
    "order" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Показывать в пнглийской версии"),
			"value" => "0",
			"options" => "",
			"field" => "order",
	),		
    "subject"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Тема номера"),
		"field" => "subject",
	),
	"subject_en"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Тема номера (English)"),
		"field" => "subject_en",
	),
	"date_public"    => array(
		"class" => "base::date",
		"buttons" => "calendar",
		"prompt" => Dreamedit::translate("Опубликовать (дата)"),
		"field" => "date_public",
	),
	"icon"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Иконка"),
		"field" => "icon",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Аннотация"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Аннотация (English)"),
		"field" => "content_en",
	),
    "full_text"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Номер целиком"),
		"field" => "full_text",
	),
);

?>