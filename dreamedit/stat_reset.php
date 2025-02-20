<?php
//
//$_SERVER["DOCUMENT_ROOT"]='/home/imemon/html';
//
//$_CONFIG = array();
//
//// берем конфиг системы если конфиг не найден - выходим
//$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/../dreamedit/_config.ini", true);
//if(empty($_CONFIG["global"]))
//    die("Файл конфигурации системы не найден");
//// подключаем заголовк?страни?
//include_once dirname(__FILE__)."/../dreamedit/includes/headers.php";
//// подключаем файл соединен? ?базо?
//include_once dirname(__FILE__)."/../dreamedit/includes/connect.php";
//// подключаем файл соединен? ?базо?
//include_once dirname(__FILE__)."/../dreamedit/includes/site.fns.php";
//include_once dirname(__FILE__)."/../dreamedit/includes/class.Statistic.php";
//global $DB;
//
//$DB->query("LOCK TABLES page_rating WRITE,magazine_visits AS mv WRITE,adm_ilines_content AS ac WRITE");
//$DB->query("TRUNCATE TABLE page_rating");
//
//Statistic::saveTopNews("30");
//Statistic::saveTopNews("7");
//Statistic::saveTopNews("0");
//Statistic::saveTopNews("30","-en");
//Statistic::saveTopNews("7","-en");
//Statistic::saveTopNews("0","-en");
//$DB->query("UNLOCK TABLES");
//
//$DB->query("INSERT INTO cron_test(`date`) VALUES (?)",date("Y-m-d H:i:s"));
//
//?>