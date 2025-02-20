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
			"prompt" => Dreamedit::translate("������"),
			"value" => (int)@$_REQUEST["id"],
			"field" => "page_parent",
			"size" => "10",
			"buttons" => "page_id",
		),
		"name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("��������"),
			"required" => TRUE,
			"size" => "51",
			"field" => "page_name",
		),
		"urlname" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("����� ��������"),
			"size" => "51",
			"field" => "page_urlname",
		),
		"link" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("������"),
			"size" => "51",
			"field" => "page_link",
			"buttons" => "page_id",
		),
		"template" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("������"),
			"options" => site_templates(),
			"field" => "page_template",
		),

		"status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("������"),
			"value" => "1",
			"options" => "",
			"field" => "page_status",
		),
	),
);


?>