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
			"buttons" => "magazine_id",
		),
		"name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("��������"),
			"required" => TRUE,
			"size" => "51",
			"field" => "page_name",
		),
		"name_en" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� �� ����������"),
			"size" => "51",
			"field" => "page_name_en",
		),
		"priority" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("���������� ����� � ������"),
			"required" => FALSE,
			"size" => "11",
			"field" => "priority",
		),
		"journame" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� � URL"),
			"required" => FALSE,
			"size" => "51",
			"field" => "page_journame",
			
		),
		"menuname" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� �������"),
			"required" => FALSE,
			"size" => "51",
			"field" => "page_menuname",
		),
		"menuname_en" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("�������� ������� (English)"),
			"required" => FALSE,
			"size" => "51",
			"field" => "page_menuname_en",
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
        "link_en" => array(
            "class" => "base::textbox",
            "prompt" => Dreamedit::translate("������ (English)"),
            "size" => "51",
            "field" => "page_link_en",
            "buttons" => "page_id",
        ),
        "link_false" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("��������� ������ � ����"),
            "value" => "0",
            "options" => "",
            "field" => "link_false",
        ),
		"template" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("������"),
			"options" => site_templates(),
			"field" => "page_template",
		),
		"status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("������������"),
			"value" => "1",
			"options" => "",
			"field" => "page_status",
		),
        "publisher"   => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("��������"),
            "field" => "publisher",
            "cols" => "51",
            "rows" => "5",
        ),
        "publisher_en"   => array(
            "class" => "base::textarea",
            "prompt" => Dreamedit::translate("�������� (English)"),
            "field" => "publisher_en",
            "cols" => "51",
            "rows" => "5",
        ),
        "online_resource" => array(
            "class" => "base::checkbox",
            "prompt" => Dreamedit::translate("����������� ������"),
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
			"prompt" => Dreamedit::translate("����� � eLibrary"),
			"size" => "51",
			"field" => "eLibrary",
		),
		"series" => array(
		     "class" => "base::selecttextbox" ,
			 "prompt" => Dreamedit::translate("�������������"), 
			 "size" =>"1", 
			 "field" => "series", 
			 "texts" => "|����������� ������|�������������� ������|���������|�������������� ���������|���������|������",
		),
		"series_en" => array(
		     "class" => "base::selecttextbox" ,
			 "prompt" => Dreamedit::translate("������������� �� ����"), 
			 "size" =>"1", 
			 "field" => "series_en", 
			 "texts" => "|Monthly|Quarterly|Bulletin|Yearbook|Journal|Quarterly Bulletin",
		),	
		"numbers" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("���������� ������� � ���"),
			"size" => "11",
			"field" => "numbers",
		), 		
		"logo" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("������� 62�"),
			"size" => "51",
			"field" => "logo",
		),
		"info" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("������� ����������"),
			"size" => "51",
			"field" => "info",
		),
		"info_en" => array(
			"class" => "base::editor",
			"type" => "Basic",
			"prompt" => Dreamedit::translate("������� ���������� �� ����������"),
			"size" => "51",
			"field" => "info_en",
		),
        "logo_main" => array(
            "class" => "base::editor",
            "type" => "Basic",
            "prompt" => Dreamedit::translate("������� �� �������"),
            "size" => "51",
            "field" => "logo_main",
        ),
        "logo_main_info" => array(
            "class" => "base::editor",
            "type" => "Full",
            "prompt" => Dreamedit::translate("���������� ��� ��������"),
            "size" => "101",
            "field" => "logo_main_info",
        ),
        "logo_main_info_en" => array(
            "class" => "base::editor",
            "type" => "Full",
            "prompt" => Dreamedit::translate("���������� ��� �������� (En)"),
            "size" => "101",
            "field" => "logo_main_info_en",
        ),
        "logo_slider" => array(
            "class" => "base::editor",
            "type" => "Basic",
            "prompt" => Dreamedit::translate("������� ��� ��������"),
            "size" => "51",
            "field" => "logo_slider",
        ),

	),
);


if($_CONFIG["global"]["general"]["test"])
{
	$mod_array["components"]["dell"] = array(
		"class" => "base::checkbox",
		"prompt" => Dreamedit::translate("����������"),
		"value" => "0",
		"options" => "",
		"field" => "page_dell",
	);
}
?>