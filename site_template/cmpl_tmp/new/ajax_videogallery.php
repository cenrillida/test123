<?php
global $_CONFIG, $site_templater;

$current_number = (int)$_GET['ajax_videogallery'];

$videoGallery = new Videogallery();
if(!empty($_GET['videoperson'])) {
    $videoElements = $videoGallery->getVideosByPerson((int)$_GET['videoperson'],10, $current_number, 8);
} else {
    $videoElements = $videoGallery->getVideos(10, $current_number, 8);
}

foreach ($videoElements as $videoElement) {
    $tpl = new Templater();
    $tpl->appendValues(array("ID" => $videoElement->getId()));
    $tpl->appendValues(array("PHOTO_STOP" => $videoElement->getPhotoStop()));
    $tpl->appendValues(array("YOUTUBE_URL" => $videoElement->getYoutubeUrl()));
    $tpl->appendValues(array("DATE" => $videoElement->getDate()));
    $tpl->appendValues(array("PARAMS" => $videoElement->getParams()));
    $tpl->appendValues(array("TEMPL" => $_TPL_REPLACMENT["TEMPL"]));
    $tpl->appendValues(array("PAR" => $videoElement->getParamsActive()));
    if($_SESSION[lang]!="/en") {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitle()));
    } else {
        $tpl->appendValues(array("TITLE" => $videoElement->getTitleEn()));
    }
    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "tpl.video_element.html");
}