<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "submenu",
		"value" => "Шаблон списка страниц",
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
    "from_this_page" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Начать список с этой страницы"),
        "value" => "0",
        "options" => "",
        "field" => "from_this_page",
    ),
    "noentrytext" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Убрать текст `В этом разделе`"),
        "value" => "0",
        "options" => "",
        "field" => "noentrytext",
    ),
    "bold_links" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Все ссылки жирные"),
        "value" => "0",
        "options" => "",
        "field" => "bold_links",
    ),
    "capitalize_links" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Все ссылки заглавные"),
        "value" => "0",
        "options" => "",
        "field" => "capitalize_links",
    ),
    "font_size_links"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Размер шрифта в пикселях"),
        "size" => "5",
        "field" => "font_size_links",
        "buttons" => "quot",
    ),
    "links_color"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Стандартный цвет ссылок"),
        "size" => "10",
        "field" => "links_color",
        "buttons" => "quot",
        "buttons" => "colorpick",
    ),
    "content_before"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Контент перед списком"),
        "field" => "content_before",
    ),
    "content_before_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Контент перед списком (English)"),
        "field" => "content_before_en",
    ),
);

?>