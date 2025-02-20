<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "persons-by-podr",
		"value" => "Ўаблон списка сотрудников по выбранному подразделению",
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
    "otdel" => array (
	"class" => "base::selectItable", 
	"prompt" => "ѕодразделение",
	"keyname" => "id",
    "field" => "otdel",
	"textname" => "otdel",
	"query" => "SELECT c.page_id AS id,c.page_name AS otdel
                    FROM adm_pages AS c
                    WHERE c.page_parent = 417  ORDER BY c.page_name",
	),
	

);

?>