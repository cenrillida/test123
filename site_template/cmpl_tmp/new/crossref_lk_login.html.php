<?php

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);


require_once __DIR__."/../../../dreamedit/includes/Crossref/Autoloader.php";



global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$crossref = \Crossref\Crossref::getInstance();



if($crossref->getAuthorizationService()->checkLogin() && $_GET['logout']!=1) {
    $pages = new Pages();
    $personalPageId = $pages->getFirstPageIdByTemplate("crossref_lk");
    if(!empty($personalPageId)) {
        Dreamedit::sendHeaderByCode(301);
        Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$personalPageId);
        return;
    }
} else {

    if($_GET['logout']==1) {
        $crossref->getAuthorizationService()->logout();
    }
    $crossref->getPageBuilderManager()->setPageBuilder("login");
    $crossref->getPageBuilder()->build();
}