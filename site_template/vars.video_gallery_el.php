<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "video_gallery_el",
		"value" => "Шаблон элемента видео галереи",
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
    "templ" => array(
        "class" => "base::selectbox",
        "prompt" => Dreamedit::translate("Шаблон"),
        "options" => array("grey" => "Серый", "red" => "Красный"),
        "field" => "templ",
    ),
);

?>