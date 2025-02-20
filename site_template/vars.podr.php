<?
$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "podr",
		"value" => "Шаблон подразделения (одного)",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "101",
		"field" => "title",
		"buttons" => "quot",
        "required" => TRUE,
	),
	"title_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title на английском"),
		"size" => "101",
		"field" => "title_en",
		"buttons" => "quot",
	),
    "title_r"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Название в родительном падеже"),
        "size" => "101",
        "field" => "title_r",
        "required" => TRUE,
    ),
    "title_t"      => array(
        "class" => "base::textbox",
        "prompt" => Dreamedit::translate("Название в творительном падеже"),
        "size" => "101",
        "field" => "title_t",
        "required" => TRUE,
    ),
    "contest_no_include" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить для построения пути в конкурсной комиссии"),
        "field" => "contest_no_include",
    ),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
    "chif" => array(
      "class" => "base::selectItable",
      "prompt" => "Руководитель",
      "keyname" => "id",
      "field" => "chif",
      "textname" => "fio",
      "query" => "SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio  FROM persons
					 ORDER BY surname,name,fname",
      ),
     "sekretar" => array(
      "class" => "base::selectItable",
      "prompt" => "Ученый секретарь",
      "keyname" => "id",
      "field" => "sekretar",
      "textname" => "fio",
      "query" => "SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio  FROM persons
					 ORDER BY surname,name,fname",
      ),
    "content_before_for"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Контент перед направлением деятельности"),
        "field" => "content_before_for",
    ),
    "content_before_for_en"    => array(
        "class" => "base::editor",
        "prompt" => Dreamedit::translate("Контент перед направлением деятельности (En)"),
        "field" => "content_before_for_en",
    ),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент на английском"),
		"field" => "content_en",
	),
    "personal_list_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить список сотрудников"),
        "field" => "personal_list_off",
    ),
    "news_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить ссылку на новости подразделения"),
        "field" => "news_link_off",
    ),
    "events_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить ссылку на мероприятия подразделения"),
        "field" => "events_link_off",
    ),
    "list_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить ссылку в списке подразделений"),
        "field" => "list_link_off",
    ),
    "grant_link_off" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Отключить вывод грантов"),
        "field" => "grant_link_off",
    ),
	
	"submenu_filter" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Поставить субменю в Ссылки по теме"),
		"size" => "1",
		"field" => "submenu_filter",
	),
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	),

        "full_id-p"     => array(
	       "class" => "base::integer",
	       "prompt" => Dreamedit::translate("ID страницы персоны"),
	       "size" => "10",
	       "field" => "full_id_p",
	       "value" => "453",
	       "buttons" => "page_id",
	),
		"people"   => array(
		"class" => "base::people",
		"prompt" => Dreamedit::translate("Люди"),
		"size" => "81",
		"field" => "people",
	),

);

?>