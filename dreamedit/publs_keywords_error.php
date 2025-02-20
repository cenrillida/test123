<?php

include_once dirname(__FILE__)."/_include.php";

$keywords = $DB->select("SELECT id, keyword AS keyword FROM publ WHERE keyword LIKE '%,%'");

$keywordsExploded = array();

foreach ($keywords AS $keyword) {
    $keywordExploded = explode(";",$keyword['keyword']);
    //$keywordsExploded[] = $keyword['keyword']." {".$keyword['id']."}";

    foreach ($keywordExploded as $value) {
        if(strpos($value,",")!==false) {
            $keywordTrimmed = ltrim(rtrim($value, " \t\n\r"), " \t\n\r");
            if(!in_array($keywordTrimmed,$keywordsExploded)) {
                $keywordsExploded[] = $keywordTrimmed;
            }
        }
    }
}
sort($keywordsExploded);

var_dump($keywordsExploded);
