<?

$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id"		=> array (
			"class"				=> "base::textbox",
			"field"				=> "page_id",
		),

		"text_new" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("Текст комментария"),
			"rows" => "5",
			"cols"=>"101",
			"field" => "text_new",
		),
        "nic"		=> array (
			"class"				=> "base::hidden",
			"field"				=> "nic",

		),
		"verdict" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Опубликовать"),
			"value" => "1",
			"options" => "",
			"field" => "verdict",
		),
        "admin" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("Администрация"),
            "value" => "0",
            "options" => "",
            "field" => "admin",
        ),
		"corr" => array(
			"class" => "base::hidden",
			"field" => "corr",
		),
	),
);


if($_CONFIG["global"]["general"]["test"])
{
	$mod_array["components"]["dell"] = array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Защищенная"),
		"value" => "0",
		"options" => "",
		"field" => "page_dell",
	);
}
?>