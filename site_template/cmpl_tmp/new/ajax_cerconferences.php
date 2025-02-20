<?php
global $DB, $_CONFIG;

$ilines = new Ilines();
$ievent = new Events();

$current_number = (int)$_GET['ajax_cerconferences'];
$otdel = (int)$_GET['ajax_cerconferences_otdel'];

$rows = $ilines->getCerNews(array('4','18'),$current_number,8,$otdel);

if(!empty($rows))
{
    foreach ($rows as $k => $v) {
        $tpl = new Templater();
        $tpl->appendValues(array("EL_ID" => $v[el_id]));
        $tpl->appendValues(array("LAST_TEXT" => $v["last_text"]));
        $tpl->appendValues(array("MD" => '12'));
        $tpl->appendValues(array("LG" => '6'));
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.cernews_element.html");
    }
}