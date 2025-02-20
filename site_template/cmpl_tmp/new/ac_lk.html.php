<?php
//
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

require_once __DIR__."/../../../dreamedit/includes/AcademicCouncilModule/Autoloader.php";

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$academicCouncilModule = \AcademicCouncilModule\AcademicCouncilModule::getInstance();

$academicCouncilModule->getAccountService()->setBuilderWithMode($_GET['mode']);
$academicCouncilModule->getPageBuilder()->build();