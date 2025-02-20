<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "specrub_page",
		"value" => "Шаблон страницы спецрубрики",
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
    "comment_color" => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Код цвета комментариев"),
        "size" => "10",
        "field" => "comment_color",
        "buttons" => "colorpick",
    ),
	"extra_section"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("HTML секция"),
		"field" => "extra_section",
	),
	"extra_section_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("HTML секция (English)"),
		"field" => "extra_section_en",
	),
    "full_smi_id"     => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("ID документа с полной новостью"),
        "size" => "10",
        "field" => "full_smi_id",
        "buttons" => "page_id",
    ),

    "count"     => array(
        "class" => "base::integer",
        "prompt" => Dreamedit::translate("Количество к показу"),
        "size" => "10",
        "field" => "count",
    ),

    "row_count"     => array(
        "class" => "base::selectbox",
        "prompt" => Dreamedit::translate("Количество элементов в строке"),
        "options" => array("" => "", "1" => "1", "3" => "3"),
        "field" => "row_count",
    ),

    "sort_field"     => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Поле сортировки"),
        "size" => "51",
        "field" => "sort_field",
    ),
    "sort_type"     => array(
        "class" => "base::selectbox",
        "prompt" => Dreamedit::translate("Тип сортировки"),
        "options" => array("DESC" => "По-возрастанию", "ASC" => "По-убыванию"),
        "field" => "sort_type",
    ),
    "tpl_name"     => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Имя шаблона tpl"),
        "size" => "51",
        "field" => "tpl_name",
    ),
);

?>