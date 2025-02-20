<?php
ini_set('memory_limit', '256M');
include_once dirname(__FILE__)."/_include.php";
header("Content-type: application/json");
$term = mb_convert_encoding($_GET['term'], 'windows-1251', 'utf-8');
//$term = htmlentities($_GET['term'],ENT_COMPAT, "UTF-8");
//$term = $_GET['term'];
//$term = mb_convert_encoding($_GET['term'], 'HTML-ENTITIES', 'utf-8');
//$term = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $term);
$elmnts = array();
$rows = $DB->select("SELECT id,name FROM publ WHERE name LIKE '".$term."%' ORDER BY name LIMIT 20");
$count=0;
$used_ids = array();
foreach($rows as $k => $v) {
    $elmnts[$count]['label'] = html_entity_decode(normJsonStr($v['name']), null, "utf-8");
    $elmnts[$count]['id'] = $v['id'];
    $used_ids[] = $v['id'];
    $count++;
}

if($_GET[debug]==1) {
    var_dump($_GET['term'],$rows,$term);
}

$rows = $DB->select("SELECT id,name FROM publ WHERE name LIKE '%".$term."%' ORDER BY name LIMIT 20");
foreach($rows as $k => $v) {
    if($count>=20)
        break;
    if(in_array($v['id'],$used_ids))
        break;
    $elmnts[$count]['label'] = html_entity_decode(normJsonStr($v['name']), null, "utf-8");
    $elmnts[$count]['id'] = $v['id'];
    $count++;
}
if($_GET[debug]==1) {
    var_dump($rows);
}

echo json_encode($elmnts);

function normJsonStr($str){
    $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}
?>