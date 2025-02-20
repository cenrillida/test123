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
	),
);

?>