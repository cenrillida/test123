<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "video_gallery",
		"value" => "Шаблон видео галереи",
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
    "person"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("ID персоны в видео"),
        "help" => "Если пусто выводятся все видео",
        "size" => "51",
        "field" => "person",
        "buttons" => "quot",
    ),
    "templ" => array(
        "class" => "base::selectbox",
        "prompt" => Dreamedit::translate("Шаблон"),
        "options" => array("grey" => "Серый", "red" => "Красный"),
        "field" => "templ",
    ),
);

?>