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
		"el_structure"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("Структура отображения эл-тов"),
			"help"				=> "Для отображения Вы можете использовать плейсхолдеры с именем поля (field) переменной из структуры элементы.",
			"size"				=> "51",
			"required"			=> TRUE,
			"field"				=> "itype_el_structure",
			"buttons"			=> "quot",
			"value"				=> "{DATE} - {TITLE}",
		),
		"el_sort"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("Сортировка элементов"),
			"help"				=> "Имя переменной по которой будет вестись сортировка списка элементов.<br />(по-умолчанию сортируется по внутренней дате вставки по-убыванию)",
			"size"				=> "51",
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
		    "value"             => "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n<components>\n\n
								    <element name=\"date\" class=\"base::date\" prompt=\"Дата занесения:\" size=\"51\" field=\"date\" required=\"true\" buttons=\"calendar\"/>\n
                                    <element name=\"title\" class=\"base::textbox\" prompt=\"Название (без кавычек):\" size=\"151\" field=\"title\" required=\"true\" buttons=\"quot\"/>\n
                                    <element name=\"year_beg\" class=\"base::selectyear\" prompt=\"Год начала:\"  field=\"year_beg\" rang=\"-2|3\" />\n
                                    <element name=\"year_end\" class=\"base::selectyear\" prompt=\"Год окончания:\"  field=\"year_end\" rang=\"-2|3\" />\n
                                    <element name=\"number\" class=\"base::textbox\" prompt=\"Номер:\" size=\"51\" field=\"number\" required=\"true\" buttons=\"quot\"/>\n
                                   

                                    <element name=\"chif\" class=\"base::selectItable\" prompt=\"Руководитель\" keyname=\"id\"  field=\"chif\"  textname=\"fio\"
                                    query=\"SELECT persona.id,CONCAT(surname,' ',name,' ',fname) AS fio,ran,IFNULL(d1.short,'') AS stepen,IFNULL(d2.short,'') AS zvanie  FROM persons AS persona
                                         LEFT OUTER JOIN stepen AS d1 ON d1.id=persona.us
                                         LEFT OUTER JOIN zvanie AS d2 ON d2.id=persona.uz
                                         WHERE NOT (persona.otdel = 'Партнеры'   OR persona.otdel ='Умершие сотрудники')
                                         ORDER BY fio\"   /> \n
                                   <element name=\"status\" class=\"base::checkbox\" prompt=\"Опубликовать\" options=\"\"   field=\"status\" value=\"0\"/>\n
                                   </components>",
                            		),
		"itype_sort"		=> array (
			"class"				=> "base::textbox",
			"prompt"			=> Dreamedit::translate("Сортировка ленты"),
			"help"				=> "Номер по порядку",
			"size"				=> "51",
			"field"				=> "itype_sort",
		),
	),
);
/* <element name=\"source\" class=\"base::selectItable\" prompt=\"Источник финансирования:\"  keyname=\"id\"  field=\"source\"  textname=\"text\" required=\"true\"
                                    query=\"SELECT a.el_id AS id,a.icont_text AS text FROM adm_directories_content AS a
                                            INNER JOIN adm_directories_content AS s ON s.el_id=a.el_id AND s.icont_var='value'
	                                        INNER JOIN adm_directories_element AS e ON e.el_id=a.el_id AND e.itype_id='6'
	                                        WHERE a.icont_var='text'
	                                        ORDER BY s.icont_text\"
                                    />\n
*/
?>

