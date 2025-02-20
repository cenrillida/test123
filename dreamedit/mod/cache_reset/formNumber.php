<?
$mod_array = array(
	"name"			=> "data_form",
	"template_dir"	=> "plain_table",
	"language"		=> "ru",
	"action"		=> "index.php?mod=cache_reset&action=save",
	"components"	=> array (
		'submit'		=> array (
			'class'				=> 'base::button',
			'type'				=> 'submit',
			'value'				=> 'Очистить',
		),
	),
);

?>