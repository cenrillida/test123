<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "jnumber",
		"value" => "Журнал. Номер журнала ?",
	),
    "order" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Показывать в английской версии"),
			"value" => "0",
			"options" => "",
			"field" => "order",
	),
    "slider_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить в слайдере"),
        "value" => "0",
        "options" => "",
        "field" => "slider_off",
    ),
    "rinc_number"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("РИНЦ номера"),
        "size" => "51",
        "field" => "rinc_number",
    ),
    "doi_number"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("DOI номера"),
        "size" => "51",
        "field" => "doi_number",
    ),
    "isbn_number"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("ISBN номера"),
        "size" => "51",
        "field" => "isbn_number",
    ),
    "signed_to_print"    => array(
        "class" => "base::date",
        "buttons" => "calendar",
        "prompt" => Dreamedit::translate("Номер подписан в печать (дата)"),
        "field" => "signed_to_print",
    ),
    "date_of_publication"    => array(
        "class" => "base::date",
        "buttons" => "calendar",
        "prompt" => Dreamedit::translate("Дата выхода в свет"),
        "field" => "date_of_publication",
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
	"full_text_open" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Номер целиком для общего доступа"),
		"value" => "0",
		"options" => "",
		"field" => "full_text_open",
	),
);

?>