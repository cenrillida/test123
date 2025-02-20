<?php

include_once dirname(__FILE__)."/_include.php";

$keywords = $DB->select("SELECT id, keyword_en FROM publ");

$keywordsExploded = array();

foreach ($keywords AS $keyword) {
    $keywordExploded = explode(";",$keyword['keyword_en']);
    foreach ($keywordExploded as $value) {
        $keywordTrimmed = ltrim(rtrim($value, " \t\n\r"), " \t\n\r");
        if(strlen($keywordTrimmed)>1) {
            if (substr($keywordTrimmed,0,1) == "«") {
                $keywordTrimmed = mb_strtoupper(substr($keywordTrimmed,0,2),"windows-1251").substr($keywordTrimmed,2);
            } else {
                $keywordTrimmed = mb_strtoupper(substr($keywordTrimmed,0,1),"windows-1251").substr($keywordTrimmed,1);
            }
        }
        if(!empty($keywordTrimmed) && !in_array($keywordTrimmed,$keywordsExploded)) {
            $keywordsExploded[] = $keywordTrimmed;
        }
    }
}
sort($keywordsExploded);

//var_dump($keywordsExploded);

$m = new MongoClient();

// select a database
$visitsDb = $m->imemon;
//$visitsDb->drop();
$collection = $visitsDb->publ_keywords_en;
$collection->drop();


foreach ($keywordsExploded as $keywordExploded) {
    $collection->insert(array("keyword" =>  mb_convert_encoding($keywordExploded,"utf-8","windows-1251")));
}

var_dump($collection->count());

$cursor = $collection->aggregate(
    array('$project' => array('keyword' => '$keyword')),
    array('$match' => array(
    'keyword' => array( '$regex' => "^".mb_convert_encoding("à","utf-8","windows-1251").".*", '$options' => 'i')
    )),
    array('$sort' =>
        array('keyword' => 1)),
    array('$limit' => 15)
    );

//var_dump($cursor);

var_dump(count($cursor['result']));

foreach ($cursor['result'] as $value) {
    var_dump(mb_convert_encoding($value['keyword'],"windows-1251","utf-8"));
}

//$keywords = $DB->select("SELECT id, keyword FROM publ WHERE keyword_en LIKE '%\"%'");
//
//$keywordsExploded = array();
//
//foreach ($keywords AS $keyword) {
//    $keywordExploded = explode(";",$keyword['keyword']);
//    $keywordsExploded[] = $keyword['keyword']." {".$keyword['id']."}";
////    foreach ($keywordExploded as $value) {
////        $keywordsExploded[] = ltrim(rtrim($value," \t\n\r")," \t\n\r")." {".$keyword['id']."}";
////    }
//}
//sort($keywordsExploded);
//
//var_dump($keywordsExploded);
