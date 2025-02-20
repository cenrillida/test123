<?

$tpl_vars = array(
	"label"     => array(
		"class"  => "base::header",
		"name" => "search_persona",
		"value" => "��������. C������� ������ ��� �������.",
	),


	"content_header"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("���������"),
		"size" => "51",
		"field" => "content_header",
		"buttons" => "quot",
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
	"keywords"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Keywords"),
		"cols" => "51",
		"rows" => "5",
		"field" => "keywords",
	),
	"description"   => array(
		"class" => "base::textarea",
		"prompt" => Dreamedit::translate("Description"),
		"cols" => "51",
		"rows" => "5",
		"field" => "description",
	),
	"full_id_d"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������������� ������� ����"),
		"size" => "10",
		"field" => "full_id_d",
		"buttons" => "page_id",
	),
	"full_id_s"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������ ����������"),
		"size" => "10",
		"field" => "full_id_s",
		"buttons" => "page_id",
	),
	"full_id_s2"     => array(
		"class" => "base::integer",
		"prompt" => Dreamedit::translate("ID �������� ������ �������"),
		"size" => "10",
		"field" => "full_id_s2",
		"buttons" => "page_id",
	),

	"news_name"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("��� �������� � �������� ���������"),
		"size" => "20",
		"field" => "news_name",
	),
	"news_id"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("ID �������� � �������� ���������"),
		"size" => "10",
		"field" => "news_id",
		"buttons" => "page_id",
	),
	"smi_news_name"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("��� �������� � ������������ � ���"),
		"size" => "20",
		"field" => "smi_name",
	),
	"smi_id"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("ID �������� � ����������� � ���"),
		"size" => "10",
		"field" => "smi_id",
		"buttons" => "page_id",
	),
    "grant_id"     => array(
		"class" => "base::textbox",
		"prompt" => Dreamedit::translate("ID �������� ������ "),
		"size" => "10",
		"field" => "grant_id",
		"buttons" => "page_id",
	),
);

?>