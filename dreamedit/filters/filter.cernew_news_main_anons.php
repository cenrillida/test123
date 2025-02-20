<?php
global $DB, $_CONFIG;

$ilines = new Ilines();
$ievent = new Events();

$otdel = (int)$_TPL_REPLACMENT['OTDEL'];

$rows = $ilines->getCerNews(array('4','18'),0,3, $otdel);

if(!empty($rows))
{
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            foreach ($rows as $k => $v) {
                $tpl = new Templater();
                $tpl->appendValues(array("EL_ID" => $v[el_id]));
                $tpl->appendValues(array("LAST_TEXT" => $v["last_text"]));
                $tpl->appendValues(array("MD" => '12'));
                $tpl->appendValues(array("LG" => '12'));
                $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.cernews_element.html");
            }
            ?>
        </div>
    </div>
    <script src="/newsite/js/holder.min.js"></script>
    <?php
}?>