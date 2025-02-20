<?
$mod_array = array (
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id"		=> array (
			"class"				=> "base::hidden",
			"field"				=> "itype_id",
		),

		"name"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("Название"),
			"size"				=> "51",
			"required"			=> TRUE,
			"field"				=> "itype_name",
			"buttons"			=> "quot",
		),
		"name_en"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("Название на английском"),
			"size"				=> "51",
			"field"				=> "itype_name_en",
			"buttons"			=> "quot",
		),
        "el_structure"		=> array (
            "class"				=> "base::textbox",
            "prompt"			=> Dreamedit::translate("Структура отображения эл-тов"),
            "help"				=> "Для отображения Вы можете использовать плейсхолдеры с именем поля (field) переменной из структуры элементы.",
            "size"				=> "51",
            "required"			=> TRUE,
            "field"				=> "itype_el_structure",
            "buttons"			=> "quot",
            "value"				=> "{TEXT} - {VALUE}",
        ),
        "el_sort"		=> array (
            "class"				=> "base::textbox",
            "prompt"			=> Dreamedit::translate("Сортировка элементов"),
            "help"				=> "Имя переменной по которой будет вестись сортировка списка элементов.<br />(по-умолчанию сортируется по внутренней дате вставки по-убыванию)",
            "size"				=> "51",
            "value"				=> "TEXT",
            "field"				=> "itype_el_sort_field",
        ),
		"el_sort_type"		=> array (
			"class"				=> "base::selectbox",
			"prompt"			=> Dreamedit::translate("Тип сортировки"),
			"field"				=> "itype_el_sort_type",
			"options"					=> array("ASC" => "По-возрастанию", "DESC" => "По-убыванию"),
		),
		"el_status"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("Переменные статуса"),
			"help"				=> Dreamedit::translate("Переменная из структуры элементов, обозначающая статус активности элемента<br />(если поле пустое - элемент неактивен)."),
			"size"				=> "51",
			"field"				=> "itype_el_status",
		),
		"structure"			=> array (
			"class"				=> "base::textarea",
			"prompt"			=> Dreamedit::translate("Структура"),
			"help"				=> Dreamedit::translate("Структура данных в фотмате xml"),
			"required"			=> TRUE,
			"cols"				=> "111",
			"rows"				=> "30",
			"field"				=> "itype_structure",
			"value"				=> "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n<components>\n\n  <element name=\"date\" class=\"base::date\" prompt=\"Дата:\" size=\"51\" field=\"date\" required=\"true\" buttons=\"calendar\"/>\n  <element name=\"title\" class=\"base::textbox\" prompt=\"Название:\" size=\"51\" field=\"title\" required=\"true\" buttons=\"quot\"/>\n\n</components>",
		),
	),
);

?>
