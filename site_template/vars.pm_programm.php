<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pm_programm",
		"value" => "Шаблон страницы деловой программы",
	),

    "files_page"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("Страница файлов"),
        "size" => "51",
        "field" => "files_page",
        "buttons" => "page_id",
    ),

    "days_page"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("Страница дней"),
        "size" => "51",
        "field" => "days_page",
        "buttons" => "page_id",
    ),

    "countdown_date"      => array(
        "class" => "base::date",
        "prompt" => Dreamedit::translate("Дата счетчика"),
        "field" => "countdown_date",
        "buttons" => "calendar",
    ),

    "countdown_title"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Заголовок счетчика"),
        "size" => "51",
        "field" => "countdown_title",
        "buttons" => "quot",
    ),
    "countdown_title_en"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Заголовок счетчика (En)"),
        "size" => "51",
        "field" => "countdown_title_en",
        "buttons" => "quot",
    ),

    "countdown_text"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Текст счетчика"),
        "size" => "51",
        "field" => "countdown_text",
        "buttons" => "quot",
    ),
    "countdown_text_en"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Текст счетчика (En)"),
        "size" => "51",
        "field" => "countdown_text_en",
        "buttons" => "quot",
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