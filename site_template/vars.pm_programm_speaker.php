<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pm_programm_speaker",
		"value" => "Шаблон выступающего деловой программы",
	),

    "photo"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Фотография 100х100"),
        "field" => "photo",
    ),
    "info"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Информация"),
        "field" => "info",
    ),
    "info_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Информация English"),
        "field" => "info_en",
    ),
);

?>