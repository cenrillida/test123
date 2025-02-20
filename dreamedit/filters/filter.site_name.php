<?
global $_CONFIG, $DB;
    if($_SESSION[lang] == "")
		$lang_suf = "_ru";
	else
		$lang_suf = "_en";

	$rows = $DB->select("SELECT cv_text FROM ?_pages_content WHERE cv_name = 'site_title".$lang_suf."'");

	print_r($rows[0]["cv_text"]);
?>