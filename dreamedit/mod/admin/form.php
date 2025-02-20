<?

$mod_array = array (
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "",
	"components"	=> array (
		"id" => array(
			"class" => "base::hidden",
			"field" => "a_id",
		),
		"name" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Имя"),
			"required" => TRUE,
			"size" => "51",
			"field" => "a_name",
		),
		"mail" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("E-mail"),
			"required" => TRUE,
			"validate" => "email",
			"size" => "51",
			"field" => "a_mail",
		),
		"login" => array(
			"class" => "base::textbox",
			"prompt" => Dreamedit::translate("Логин"),
			"required" => TRUE,
			"size" => "51",
			"field" => "a_login",
		),
		"pass" => array(
			"class" => "base::password",
			"prompt" => array(Dreamedit::translate("Пароль"), Dreamedit::translate("Повторите пароль")),
			"size" => "51",
			"field" => "a_pass",
		),
		"hach" => array(
			"class" => "base::hidden",
			"prompt" => Dreamedit::translate("hash"),
			"size" => "200",
			"field" => "a_hach",
		),
		"skin" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("Скин"),
			"options" => getSkins(),
			"field" => "a_skin",
		),
		"lang" => array(
			"class" => "base::selectbox",
			"prompt" => Dreamedit::translate("Язык"),
			"options" => getLangs(),
			"field" => "a_lang",
		),
		"status" => array(
			"class" => "base::checkbox",
			"prompt" => Dreamedit::translate("Статус"),
			"help" => Dreamedit::translate("Статус активности администратора"),
			"value" => "1",
			"options" => "",
			"field" => "a_status",
		),
	),
);
 

?>