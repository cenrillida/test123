<?
$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "index.php?mod=flickrmain&action=save",
	"components"	=> array (
		"flickr_link" => array(
			"class" => "base::textbox",
            "size" => "101",
			"prompt" => Dreamedit::translate("Ссылка на альбом Flickr"),
            "help" => "Пример: https://www.flickr.com/photos/imemoras/albums/72157699121747590",
			"field" => "flickr_link",
			"required" => true,
		),
		'submit'		=> array (
			'class'				=> 'base::button',
			'type'				=> 'submit',
			'value'				=> 'Загрузить',
		),
	),
);

?>