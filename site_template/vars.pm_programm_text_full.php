<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pm_programm_text_full",
		"value" => "Шаблон текстовой страницы сайта с меню деловой программы",
	),

    "menu_page_id"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("Страница элементов меню"),
        "size" => "51",
        "field" => "menu_page_id",
        "buttons" => "page_id",
    ),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title Russian"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"title_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title English"),
		"size" => "51",
		"field" => "title_en",
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
/*	"header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Заголовок"),
		"size" => "51",
		"field" => "header",
		"buttons" => "quot",
	),*/
	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Блок в правую колонку"),
		"field" => "reclama",
	),
    "reclama_en"    => array(
        "class" => "base::editor",
        "type" => "Basic",
        "prompt" => Dreamedit::translate("Блок в правую колонку (английский)"),
        "field" => "reclama_en",
    ),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Конент (English)"),
		"field" => "content_en",
	),
/*
	"links"   => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	),
*/
	"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("Люди"),
		"size" => "81",
		"field" => "people",
	),
	"bank_check"    => array(
		"class" => "base::textarea",
		"cols" => "51",
		"rows" => "5",
		"prompt" => Dreamedit::translate("Поставить назначение платежа<br />к банковским реквизитам"),
		"field" => "bank_check",
	),
);

?>