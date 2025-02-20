<?php

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$aspModule = AspModule::getInstance();

if($aspModule->getAspAuthorizationService()->checkLogin() && $_GET['logout']!=1) {
    $pages = new Pages();
    $personalPageId = $pages->getFirstPageIdByTemplate("asp_lk");
    if(!empty($personalPageId)) {
        Dreamedit::sendHeaderByCode(301);
        Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$personalPageId);
        return;
    }
} else {
    if($_GET['logout']==1) {
        $aspModule->getAspAuthorizationService()->logout();
    }
    $aspModule->getAspPageBuilderManager()->setPageBuilder("login");
    $aspModule->getAspPageBuilder()->build();
}