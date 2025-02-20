<?php


//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

include_once __DIR__."/../../../dreamedit/includes/class.XMLWriter.php";
include_once __DIR__."/../../../dreamedit/includes/RomanNumber.php";
include_once __DIR__."/../../../dreamedit/includes/connect_afjournal.php";
require_once __DIR__."/../../../dreamedit/includes/Crossref/Autoloader.php";

global $DB,$DB_AFJOURNAL,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$crossref = \Crossref\Crossref::getInstance();

if($crossref->getAuthorizationService()->checkLogin()) {
    $crossref->getAccountService()->setBuilderWithMode($_GET['mode']);
    $crossref->getPageBuilder()->build();
} else {
    $pages = new Pages();
    $loginPageId = $pages->getFirstPageIdByTemplate("crossref_lk_login");
    if(!empty($loginPageId)) {
        Dreamedit::sendHeaderByCode(301);
        Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION[lang]."/index.php?page_id=".$loginPageId);
        return;
    }
}