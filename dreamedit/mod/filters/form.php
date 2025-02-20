<?

$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id" => array(
			"class" => "base::hidden",
			"field" => "filter_id",
		),
		"title" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название"),
			"required" => TRUE,
			"size" => "51",
			"field" => "filter_title",
		),
		"placeholder" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Имя плейсхолдера"),
			"help"	=> Dreamedit::translate("Этот плейсхолдер Вы сможете использовать в контенте страницы."),
			"required" => TRUE,
			"size" => "51",
			"field" => "filter_placeholder",
		),
		"filename" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Испоняемый файл"),
			"help" => Dreamedit::translate("Испоняемый файл должен находиться в директории для фильтров (директория указывается в настройках)"),
			"required" => TRUE,
			"size" => "51",
			"field" => "filter_filename",
		),
		"filter_sort" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Сортировка"),
			"required" => TRUE,
			"size" => "11",
			"field" => "filter_sort",
			"value" => "1",
		),
        "piar_filter" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("PR(старый) и ЦЭИ фильтр"),
            "required" => TRUE,
            "size" => "11",
            "field" => "piar_filter",
            "value" => "0",
        ),
        "extra_fields"			=> array (
            "class"				=> "base::textarea",
            "prompt"			=> Dreamedit::translate("Дополнительные поля"),
            "help"				=> Dreamedit::translate("Структура данных дополнительных полей в фотмате xml"),
            "cols"				=> "111",
            "rows"				=> "30",
            "field"				=> "extra_fields",
            "value"				=> "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n<components>\n\n  <element name=\"date\" class=\"base::date\" prompt=\"Дата:\" size=\"51\" field=\"date\" required=\"true\" buttons=\"calendar\"/>\n  <element name=\"title\" class=\"base::textbox\" prompt=\"Название:\" size=\"51\" field=\"title\" required=\"true\" buttons=\"quot\"/>\n\n</components>",
        ),
	),
);

?>