<?php
//
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
//set_time_limit ( 0 );
////ini_set('max_execution_time', '0');
//ini_set('memory_limit', '512M');
//
//include_once dirname(__FILE__)."/_include.php";
//
//global $DB;
//
////$visitsArray = $DB->select("SELECT * FROM publ_stat LIMIT 200000,100000");
//
////$visitsArray = $DB->select("SELECT * FROM magazine_visits_month WHERE id=5403");
//
//
////$arr = array();
////
////for ($i=1;$i<=6000;$i++) {
////    $arr[] = $i;
////}
////
////$testArr = $DB->select("SELECT * FROM publ WHERE id IN (?a)", $arr);
////
////var_dump(count($testArr));
//
//// connect
//$m = new MongoClient();
//
//// select a database
//$visitsDb = $m->imemon;
////$visitsDb->drop();
//$collection = $visitsDb->publ_stat;
//
//$res = $collection->findOne(array("year" => (int)date('Y'), "month" => (int)date('m'), "publ_id" => 9301, "module" => 'article'));
//
//var_dump($res);
//
//
////$sss = $collection->findOne(array("year" => "2020", "month" => "08"));
////
////var_dump($sss);
//
////foreach ($visitsArray as $visitElement) {
////    $collection->insert(array("publ_id" => (int)$visitElement['publ_id'], "date" => $visitElement['date'], "year" => (int)$visitElement['year'],"month" => (int)$visitElement['month'],"publ_count" => (int)$visitElement['publ_count'],"pdf_count" => (int)$visitElement["pdf_count"],"module" => mb_convert_encoding($visitElement["module"],"utf-8","windows-1251")));
////}
//
//var_dump($collection->count());
//
//
//
////$cursor = $collection->aggregate(array('$group' => array( '_id' => '$publ_id', 'pdf_count_sum' => array('$sum' => '$pdf_count'))), array('$project' => array('module' => '$module')),
////    array('$match' => array(
////    'module' => 'publ'
////)));
//
////$cursor = $collection->aggregate(
////    array('$project' =>
////        array('month_s' => array('$substr' => array('$month',0,-1)), 'year_s' => array('$substr' => array('$year',0,-1)))
////    ),
////    array('$project' =>
////        array('month_year' => array('$concat' => array('$year_s','$month_s')))
////    ));
//
////$cursor = $collection->aggregate(
////    array('$project' =>
////        array('month_s' => array('$substr' => array('$month',0,-1)), 'year_s' => array('$substr' => array('$year',0,-1)))
////    ),
////    array('$project' =>
////        array('month_year' => array('$concat' => array('$year_s','$month_s')))
////    ),
////    array('$match' =>
////        array('module' =>
////            array('$in' =>
////                array('publ', '')), 'month_year' => '202008')),
////    array('$group' =>
////        array( '_id' => '$publ_id', 'pdf_count_sum' =>
////            array('$sum' => '$pdf_count'), 'publ_count_sum' =>
////            array('$sum' => '$publ_count'))),
////    array('$sort' =>
////        array('pdf_count_sum' => -1)),
////    array('$limit' => 100));
//
//$cursor = $collection->aggregate(
//    array('$project' =>
//        array('module' => 1, 'month' => 1, 'year'=> 1, 'publ_id' => 1, 'pdf_count' => 1, 'publ_count' => 1,'month_s' => array('$add' => array(100,'$month')))
//    ),
//    array('$project' =>
//        array('module' => 1, 'month' => 1, 'year'=> 1, 'publ_id' => 1, 'pdf_count' => 1, 'publ_count' => 1,'month_s' => array('$substr' => array('$month_s',1,-1)), 'year_s' => array('$substr' => array('$year',0,-1)))
//    ),
//    array('$project' =>
//        array('module' => 1, 'month' => 1, 'year'=> 1, 'publ_id' => 1, 'pdf_count' => 1, 'publ_count' => 1,'month_year' => array('$concat' => array('$year_s','$month_s')))
//    ),
//    array('$project' =>
//        array('module' => 1, 'month' => 1, 'year'=> 1, 'publ_id' => 1, 'pdf_count' => 1, 'publ_count' => 1,'my_more_than' => array('$gte' => array('$month_year','202008')),'my_less_than' => array('$lte' => array('$month_year','202008')))
//    ),
//    array('$match' =>
//        array('module' =>
//            array('$in' =>
//                array('publ', '')), 'my_more_than' => true, 'my_less_than' => true)),
//    array('$group' =>
//        array( '_id' => '$publ_id', 'pdf_count_sum' =>
//            array('$sum' => '$pdf_count'), 'publ_count_sum' =>
//            array('$sum' => '$publ_count'))),
//    array('$sort' =>
//        array('pdf_count_sum' => -1)),
//    array('$limit' => 100));
//var_dump($cursor);
////
////foreach ($cursor as $el) {
////    var_dump($el);
////    exit;
////}
//
////
////$cursor = $collection->find();
////
////foreach ($cursor as $document) {
////    $collection->update(array("_id" => $document['_id']),array("year" => $document['year'], "month" => $document['month'], "magazine" => $document['magazine'], "hosts" => (int)$document['hosts'], "views" => (int)$document['views']));
////}
////var_dump(1);
//
//
////$visitsDb->drop();
//
////$document = array( "title" => "XKCD", "online" => true );
////
////$collection->insert($document);
////
////var_dump($collection->count(array("title" => array( '$regex' => "XK.*"))));
//
////// select a collection (analogous to a relational database's table)
////$collection = $db->cartoons;
////
////// add a record
////$document = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
////$collection->insert($document);
////
////// add another record, with a different "shape"
////$document = array( "title" => "XKCD", "online" => true );
////$collection->insert($document);
////
////$collection->update(array("title" => "XKCD"),array("title"=>"XKCDF"));
////
////// find everything in the collection
////$cursor = $collection->find();
////
////var_dump($cursor);
////
////// iterate through the results
////foreach ($cursor as $document) {
////    var_dump($document);
////}