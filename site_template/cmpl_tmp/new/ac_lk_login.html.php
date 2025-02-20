<?php

require_once __DIR__."/../../../dreamedit/includes/AcademicCouncil/class.AcademicCouncilModule.php";

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$academicCouncilModule = AcademicCouncilModule::getInstance();

if($academicCouncilModule->getAcademicCouncilAuthorizationService()->checkLogin() && $_GET['logout']!=1) {
    $pages = new Pages();
    $personalPageId = $pages->getFirstPageIdByTemplate("ac_lk");
    if(!empty($personalPageId)) {
        Dreamedit::sendHeaderByCode(301);
        Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$personalPageId);
        return;
    }
} else {
    if($_GET['logout']==1) {
        $academicCouncilModule->getAcademicCouncilAuthorizationService()->logout();
    }
    $academicCouncilModule->getAcademicCouncilPageBuilderManager()->setPageBuilder("login");
    $academicCouncilModule->getAcademicCouncilPageBuilder()->build();
}