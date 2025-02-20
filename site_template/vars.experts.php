<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "experts",
		"value" => "Шаблон страницы персон с выпадающим описанием",
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
	"experts_module_id"      => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID Ленты персон"),
		"size" => "51",
		"field" => "experts_module_id",
	),
	"experts_id_top"      => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID Ленты персон, закрепленных"),
		"size" => "51",
		"field" => "experts_id_top",
	),
    "margin_name"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("Расстояние между именем и фамилией"),
        "size" => "51",
        "field" => "margin_name",
    ),
    "margin_image"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("Расстояние между именем и картинкой"),
        "size" => "51",
        "field" => "margin_image",
    ),
    "font_size_name"      => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("Размер шрифта имени"),
        "size" => "51",
        "field" => "font_size_name",
    ),
    "border_hover"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Рамка при наведении"),
        "size" => "51",
        "help" => "Код цвета, например #FFFFFF",
        "field" => "border_hover",
        "buttons" => "colorpick",
    ),
    "font_weight_name"     => array(
        "class" => "base::selectbox",
        "prompt" => Dreamedit::translate("Жирность имени"),
        "options" => array("bold" => "Жирная", "normal" => "Обычная", "bolder" => "Максимально жирная"),
        "field" => "font_weight_name",
        "value" => "bold",
    ),
);

?>