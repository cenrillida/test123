<?php
global $_CONFIG,$DB,$page_content, $site_templater;

$headers = new Headers();

$elements = $headers->getHeaderElements($_TPL_REPLACMENT["RIGHT_COLLUMN"]);
$elements = $headers->appendContent($elements);


if (!empty($elements)) {
    foreach ($elements as $k => $v) {
        $tpl = new Templater();
        $tpl->setValues($v);
        $tpl->setValues($v['content']);
        $tpl->appendValues(array("HEADER_ID_EDIT" => $k));
        if ($v["ctype"] == "Ôèëüòð") {
            $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
            $tpl->appendValues(array("YEARS_ID" => $_TPL_REPLACMENT["YEARS_ID"]));
            $tpl->appendValues(array("ARCHIVE_ID" => $_TPL_REPLACMENT["ARCHIVE_ID"]));
            $tpl->appendValues(array("ART_ARCHIVE_EN_ID" => $_TPL_REPLACMENT["ART_ARCHIVE_EN_ID"]));
            $tpl->appendValues(array("RUBRICS_ID" => $_TPL_REPLACMENT["RUBRICS_ID"]));
            $tpl->appendValues(array("AUTHORS_YEARS_ID" => $_TPL_REPLACMENT["AUTHORS_YEARS_ID"]));
            $tpl->appendValues(array("AUTHORS_ID" => $_TPL_REPLACMENT["AUTHORS_ID"]));
            $tpl->appendValues(array("SEND_ARTICLE_ID" => $_TPL_REPLACMENT["SEND_ARTICLE_ID"]));
            $tpl->appendValues(array("MAIN_JOUR_ID" => $_TPL_REPLACMENT["MAIN_JOUR_ID"]));
            $tpl->appendValues(array("NO_PREFIX" => $_TPL_REPLACMENT["NO_PREFIX"]));
        }
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_right_jour.html");
    }
}