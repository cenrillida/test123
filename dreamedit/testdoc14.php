<?php
////$uid = mt_rand(10000000,99999999);
////echo $uid;
//
//include_once dirname(__FILE__)."/_include.php";
//include_once dirname(__FILE__)."/includes/AspModule/Services/UserService.php";
//
//$userService = new \AspModule\Services\UserService(null);
//
//$DB->query("LOCK TABLES asp_users as t2 READ, asp_users WRITE");
//
//$code = $userService->tryToGenerateUidCode();
//
//$DB->query('INSERT INTO asp_users(special_code) VALUES(?)',$code);
//
//$DB->query("UNLOCK TABLES");
//
//echo $code;