<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "pers_print",
		"value" => "������ �������� ������ �������� � �������",
	),

	"title"      => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("Title"),
		"size" => "51",
		"field" => "title",
		"buttons" => "quot",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"field" => "description",
		"cols" => "51",
		"rows" => "5",
	),
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),

     "publ_id"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID ���������� �������"),
		"size" => "10",
		"field" => "publ_id",
		"buttons" => "page_id",
        ),
       "perss_page" => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("�������� � ������� �� ����� "),
		"size" => "10",
		"field" => "perss_page",
		"buttons" => "page_id",
	 ),
	 "content"    => array(
		"class" => "base::editor",
		"prompt" => Dreamedit::translate("�����"),
		"field" => "content",
	 ),
);

?>