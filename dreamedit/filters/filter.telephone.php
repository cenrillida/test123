<?
global $_CONFIG, $DB;


	$rows = $DB->select("SELECT cv_text FROM ?_pages_content WHERE cv_name = 'site_telephone'");

	print_r($rows[0]["cv_text"]);
?>