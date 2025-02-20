<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "mag_archive",
		"value" => "Журналы(Новый модуль). Архив",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
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
    "archive_content"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Контент"),
        "field" => "archive_content",
    ),
    "archive_content_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Контент (English)"),
        "field" => "archive_content_en",
    ),
);

?>