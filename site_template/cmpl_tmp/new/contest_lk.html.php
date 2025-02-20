<?php

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

require_once __DIR__."/../../../dreamedit/includes/Contest/Autoloader.php";

global $DB,$_CONFIG, $site_templater;

session_start();
$_SESSION['lang'] = $_REQUEST['lang'];

$contest = \Contest\Contest::getInstance();

$contest->getAccountService()->setBuilderWithMode($_GET['mode']);
$contest->getPageBuilder()->build();