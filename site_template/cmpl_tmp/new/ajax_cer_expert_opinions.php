<?php
global $DB, $_CONFIG;

$ilines = new Ilines();

$current_number = (int)$_GET['ajax_cer_expert_opinions'];
$otdel = (int)$_GET['ajax_cer_expert_opinions_otdel'];

$result = $ilines->getCerNews(array('3','16'),$current_number,6, $otdel);

if(!empty($result))
{
    foreach($result as $rows)
    {
        if(isset($rows["date"]))
        {
            preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $rows["date"], $matches);
            $rows["date"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
            $rows["date"] = date("d.m.Y", $rows["date"]);
        }

        $pos = strrpos($rows["prev_text"], "</p>");

        $full_text = "";
        $more = "";
        if (!empty($rows[full_text]))
            $more = "&nbsp; &nbsp; &nbsp; &nbsp;<a target='_blank' href=/index.php?page_id=1594&id=".$rows[id].">подробнее...</a>";

        if($pos !== false)
        {
            $full_text = substr_replace($rows["prev_text"], " ".$more."</p>", $pos, strlen("</p>"));
        } else {
            $full_text = $rows["prev_text"].$more;
        }

        $tpl = new Templater();
        $tpl->appendValues(array("EL_ID" => $rows[el_id]));
        $tpl->appendValues(array("FULL_TEXT" => $full_text));
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.cer_expert_opinion_element.html");

    }
}