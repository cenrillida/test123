<?php

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

require_once __DIR__."/../../../dreamedit/includes/DissertationCouncils/Autoloader.php";

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$dissertationCouncils = \DissertationCouncils\DissertationCouncils::getInstance();

$dissertationCouncils->getAccountService()->setBuilderWithMode($_GET['mode']);
$dissertationCouncils->getPageBuilder()->build();