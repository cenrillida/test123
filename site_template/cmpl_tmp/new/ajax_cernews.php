<?php
global $DB, $_CONFIG;

$ilines = new Ilines();
$ievent = new Events();

$current_number = (int)$_GET['ajax_cernews'];
$otdel = (int)$_GET['ajax_cernews_otdel'];

$rows = $ilines->getCerNews(array('1','15'),$current_number,6,$otdel);

if(!empty($rows))
{
    foreach ($rows as $k => $v) {
        $tpl = new Templater();
        $tpl->appendValues(array("EL_ID" => $v[el_id]));
        $tpl->appendValues(array("LAST_TEXT" => $v["last_text"]));
        $tpl->appendValues(array("MD" => '6'));
        $tpl->appendValues(array("LG" => '4'));
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.cernews_element.html");
    }
}