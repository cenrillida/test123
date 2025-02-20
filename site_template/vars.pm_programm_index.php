<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pm_programm_index",
		"value" => "Шаблон корневой страницы деловой программы",
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
    "logo"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Логотип"),
        "field" => "logo",
    ),
    "logo_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Логотип (English)"),
        "field" => "logo_en",
    ),
);

?>