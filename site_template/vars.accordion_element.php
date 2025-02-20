<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "accordion_element",
		"value" => "Шаблон элемента типа Аккордеон",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "101",
		"field" => "title",
		"buttons" => "quot",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
    "opened_by_default" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Изначально открыт"),
        "size" => "1",
        "field" => "opened_by_default",
    ),
    "swiper_slider"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Картинки для слайдера"),
        "field" => "swiper_slider",
        "help" => "[SWIPER_SLIDER] - плейсхолдер для вставки слайдера в текст",
    ),
    "swiper_slider_height"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Высота слайдера"),
        "size" => "51",
        "field" => "swiper_slider_height",
        "buttons" => "quot",
    ),
);

?>