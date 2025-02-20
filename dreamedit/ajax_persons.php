<?php
ini_set('memory_limit', '256M');
include_once dirname(__FILE__)."/_include.php";
header("Content-type: application/json");
$term = mb_convert_encoding($_GET['term'], 'windows-1251', 'utf-8');
$elmnts = array();
$rows = $DB->select("SELECT id,CONCAT(surname, ' ', name, ' ', fname) AS person_name FROM persons WHERE CONCAT(persons.surname, ' ', persons.name, ' ', persons.fname) LIKE '".$term."%' ORDER BY surname LIMIT 20");
$count=0;
$used_ids = array();
foreach($rows as $k => $v) {
    $elmnts[$count]['label'] = normJsonStr($v['person_name']);
    $elmnts[$count]['id'] = $v['id'];
    $used_ids[] = $v['id'];
    $count++;
}
$rows = $DB->select("SELECT id,CONCAT(surname, ' ', name, ' ', fname) AS person_name FROM persons WHERE CONCAT(persons.surname, ' ', persons.name, ' ', persons.fname) LIKE '%".$term."%' ORDER BY surname LIMIT 20");
foreach($rows as $k => $v) {
    if($count>=20)
        break;
    if(in_array($v['id'],$used_ids))
        break;
    $elmnts[$count]['label'] = normJsonStr($v['person_name']);
    $elmnts[$count]['id'] = $v['id'];
    $count++;
}

echo json_encode($elmnts);

function normJsonStr($str){
    $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}
?>