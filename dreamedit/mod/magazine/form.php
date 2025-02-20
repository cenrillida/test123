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
		"parent" => array(
			"class" => "base::integer",
			"prompt" => Dreamedit::translate("Внутри"),
			"value" => (int)@$_REQUEST["id"],
			"field" => "page_parent",
			"size" => "10",
			"buttons" => "magazine_id",
		),
		"name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название"),
			"required" => TRUE,
			"size" => "51",
			"field" => "page_name",
		),
		"name_en" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название на английском"),
			"size" => "51",
			"field" => "page_name_en",
		),
		"priority" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Порядковый номер в списке"),
			"required" => FALSE,
			"size" => "11",
			"field" => "priority",
		),
		"journame" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название в URL"),
			"required" => FALSE,
			"size" => "51",
			"field" => "page_journame",
			
		),
		"menuname" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название краткое"),
			"required" => FALSE,
			"size" => "51",
			"field" => "page_menuname",
		),
		"menuname_en" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Название краткое (English)"),
			"required" => FALSE,
			"size" => "51",
			"field" => "page_menuname_en",
		),
		"urlname" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Адрес страницы"),
			"size" => "51",
			"field" => "page_urlname",
					),
		"link" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Ссылка"),
			"size" => "51",
			"field" => "page_link",
			"buttons" => "page_id",
		),
        "link_en" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("Ссылка (English)"),
            "size" => "51",
            "field" => "page_link_en",
            "buttons" => "page_id",
        ),
        "link_false" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("Выключить ссылку в меню"),
            "value" => "0",
            "options" => "",
            "field" => "link_false",
        ),
		"template" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("Шаблон"),
			"options" => site_templates(),
			"field" => "page_template",
		),
		"status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Опубликовать"),
			"value" => "1",
			"options" => "",
			"field" => "page_status",
		),
        "publisher"   => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("Издатель"),
            "field" => "publisher",
            "cols" => "51",
            "rows" => "5",
        ),
        "publisher_en"   => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("Издатель (English)"),
            "field" => "publisher_en",
            "cols" => "51",
            "rows" => "5",
        ),
        "online_resource" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("Электронный ресурс"),
            "value" => "0",
            "options" => "",
            "field" => "online_resource",
        ),
		"issn" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("ISSN"),
			"size" => "51",
			"field" => "issn",
		),
		"eLibrary" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Номер в eLibrary"),
			"size" => "51",
			"field" => "eLibrary",
		),
		"series" => array(
		     "class" => "base::selecttextbox" ,
			 "prompt" => Dreamedit::translate("Периодичность"), 
			 "size" =>"1", 
			 "field" => "series", 
			 "texts" => "|Ежемесячный журнал|Ежеквартальный журнал|Бюллетень|Ежеквартальный бюллетень|Ежегодник|Журнал",
		),
		"series_en" => array(
		     "class" => "base::selecttextbox" ,
			 "prompt" => Dreamedit::translate("Периодичность на англ"), 
			 "size" =>"1", 
			 "field" => "series_en", 
			 "texts" => "|Monthly|Quarterly|Bulletin|Yearbook|Journal|Quarterly Bulletin",
		),	
		"numbers" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Количество номеров в год"),
			"size" => "11",
			"field" => "numbers",
		), 		
		"logo" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("Обложка 62х"),
			"size" => "51",
			"field" => "logo",
		),
		"info" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("Краткая информация"),
			"size" => "51",
			"field" => "info",
		),
		"info_en" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("Краткая информация на английском"),
			"size" => "51",
			"field" => "info_en",
		),
        "logo_main" => array(
            "class" => "base::editor",
            "type" => "Basic",
            "prompt" => Dreamedit::translate("Обложка на главную"),
            "size" => "51",
            "field" => "logo_main",
        ),
        "logo_main_info" => array(
            "class" => "base::editor",
            "type" => "Full",
            "prompt" => Dreamedit::translate("Информация под обложкой"),
            "size" => "101",
            "field" => "logo_main_info",
        ),
        "logo_main_info_en" => array(
            "class" => "base::editor",
            "type" => "Full",
            "prompt" => Dreamedit::translate("Информация под обложкой (En)"),
            "size" => "101",
            "field" => "logo_main_info_en",
        ),
        "logo_slider" => array(
            "class" => "base::editor",
            "type" => "Basic",
            "prompt" => Dreamedit::translate("Обложка для слайдера"),
            "size" => "51",
            "field" => "logo_slider",
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