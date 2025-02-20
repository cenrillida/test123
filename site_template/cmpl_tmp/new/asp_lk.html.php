<?php

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

require_once __DIR__."/../../../dreamedit/includes/AspModule/Autoloader.php";

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$aspModule = \AspModule\AspModule::getInstance();

$aspModule->getAccountService()->setBuilderWithMode($_GET['mode']);
$aspModule->getPageBuilder()->build();