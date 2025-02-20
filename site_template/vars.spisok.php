<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "spisok",
		"value" => "Список дирекции, ученого совета",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
		"title_en"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title English"),
		"size" => "51",
		"field" => "title_en",
		"buttons" => "quot",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"field" => "description",
		"cols" => "51",
		"rows" => "5",
		"buttons" => "quot",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
		"buttons" => "quot",
	),
    "sovet" => array (
	"class" => "base::selectItable", 
	"prompt" => "Диссовет",
	"keyname" => "id",
    "field" => "sovet",
	"textname" => "name",
	"query" => "SELECT c.el_id AS id,c.icont_text AS name
                    FROM adm_directories_content AS c
                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=16 
                    WHERE c.icont_var = 'text'  ORDER BY c.icont_text",
	),				
   "number"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("К-во заместителей"),
		"size" => "11",
		"field" => "number",
	),
	"content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент"),
		"field" => "content",
	),
	"content_en"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Контент (English)"),
		"field" => "content_en",
	),
/*	"submenu_filter" => array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("Поставить субменю в Ссылки по теме"),
		"size" => "1",
		"field" => "submenu_filter",
	),
*/	
	"links"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("Ссылки по теме"),
		"field" => "links",
	),
	"types"    => array(
		"class" => "base::selectItable",
		"prompt" => Dreamedit::translate("Тип списка"),
		"field" => "types",
		"keyname" => "id",
		"textname" => "name",
		"query" => "SELECT DISTINCT c.type AS id,IF(c.type=100,'Администрация',
					IF(c.type=200,'Ученый совет',
					IF(c.type=300,'Эксперты',
					IFNULL(e.icont_text,'')))) AS name
                    FROM Admin AS c
                    LEFT OUTER JOIN adm_directories_content AS e ON e.el_id=c.type AND e.icont_var='text' AND c.type<>100 AND c.type<>200
                    ORDER BY e.icont_text",
	),
    "no_secretary" => array(
        "class" => "base::checkbox",
        "prompt" => Dreamedit::translate("Ученый секретарь отсутствует"),
        "size" => "1",
        "field" => "no_secretary",
    ),
	

);

?>