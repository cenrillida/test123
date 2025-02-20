<?php

require_once __DIR__."/../../../dreamedit/includes/AcademicCouncilModule/Autoloader.php";

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$academicCouncilModule = \AcademicCouncilModule\AcademicCouncilModule::getInstance();

$academicCouncilModule->getPageBuilderManager()->setPageBuilder("questionnaire");
$academicCouncilModule->getPageBuilder()->build();