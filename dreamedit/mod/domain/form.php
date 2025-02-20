<?

$mod_array = array (
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id" => array(
			"class" => "base::hidden",
			"field" => "dmn_id",
		),
		"name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название сайта"),
			"required" => TRUE,
			"size" => "51",
			"field" => "dmn_name",
		),
		"list" => array(
			"class" => "base::textarea",
			"prompt" => Dreamedit::translate("Домены"),
			"help" => Dreamedit::translate("Список доменов (разделитель - перенос строки)"),
			"required" => TRUE,
			"cols" => "51",
			"rows" => "10",
			"field" => "dmn_list",
		),
		"indexId" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Главная страница"),
			"help" => Dreamedit::translate("ID главной страницы сайта (если не выбрана - то берётся корневая страница)"),
			"size" => "51",
			"field" => "dmn_index",
			"buttons" => "page_id",
		),
		"error" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Страница не найдена"),
			"help" => Dreamedit::translate("ID страницы ошибки 404"),
			"size" => "51",
			"field" => "dmn_error",
			"buttons" => "page_id",
		),
		"redirect" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Перенаправление"),
			"size" => "51",
			"field" => "dmn_redirect",
		),
	),
);

?>