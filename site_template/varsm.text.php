<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "text",
		"value" => "Шаблон текстовой страницы журнала",
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
    "title_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить заголовок на главной"),
        "size" => "1",
        "field" => "title_off",
    ),
    "title_off_en" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить заголовок на главной (English)"),
        "size" => "1",
        "field" => "title_off_en",
    ),
	"reclama"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Для главной страницы журнала"),
		"field" => "reclama",
	),
	"reclama_en"    => array(
		"class" => "base::editor",
		"type" => "Basic",
		"prompt" => Dreamedit::translate("Для главной страницы журнала (English)"),
		"field" => "reclama_en",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент (English)"),
		"field" => "content_en",
	),
    "more_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить ссылку подробнее на главной"),
        "size" => "1",
        "field" => "more_off",
    ),
    "more_off_en" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить ссылку подробнее на главной (En)"),
        "size" => "1",
        "field" => "more_off_en",
    ),
	"submenu_filter" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Поставить субменю в Ссылки по теме"),
		"size" => "1",
		"field" => "submenu_filter",
	),
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	),
	 "menu_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID главной страницы меню"),
		"size" => "10",
		"field" => "menu_id",
		"buttons" => "page_id",
       ),
	"year"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Год"),
		"sizе" => "4",
		"field" => "year",
	),
	"month"   => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Выходные данные"),
		"size" => "81",
		"field" => "month",
	),
	"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("Люди"),
		"size" => "81",
		"field" => "people",
	),
);

?>