<?

$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id"		=> array (
			"class"				=> "base::hidden",
			"field"				=> "page_id",
		),

		"name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название"),
			"required" => TRUE,
			"size" => "101",
			"field" => "name",
		),
       "tema" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Подтема"),
			"size" => "101",
			"field" => "tema",
		),
		"plink" => array(
			"class" => "base::editor",
			"prompt" => Dreamedit::translate("Ссылка"),
			"size" => "101",
			"type" =>"Basic",
			"field" => "plink",
		),
		"rubric" => array(
			"class" => "base::selectItable",
			"query"=>"SELECT DISTINCT id AS rubric,name AS rubricname FROM base_rubric ORDER BY sort,name ",
			"size" => "1",
            "keyname" => "rubric",
			"textname"=> "rubricname",
			"required" => TRUE,
			"prompt" => Dreamedit::translate("рубрика"),
			"field" => "rubric",

		),
        "subrubric" => array(
			"class" => "base::selectItable",
			"query"=>"SELECT DISTINCT id AS subrubric,name AS subrubricname FROM base_subrubric ORDER BY sort,name ",
			"size" => "1",
            "keyname" => "subrubric",
			"textname"=> "subrubricname",
      		"prompt" => Dreamedit::translate("подрубрика"),
			"field" => "subrubric",

		),
/*
		"status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Статус"),
			"value" => "1",
			"options" => "",
			"field" => "page_status",
		),
*/
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