<?php
if($_COOKIE[userid_meimo_edit_secure]=='f2fsd!@sfsF3wd' && $_COOKIE[userid_meimo_edit]==1) {


header("Content-type: application/json");
global $_CONFIG, $DB;

$filter_rez = (int)$_GET['rez'];
$filter_publ = (int)$_GET['publ'];

$where="";
if($filter_rez) {
    $where = " AND date_rez<>''";
}
if($filter_publ) {
    $where = " AND date_publ<>''";
}

$rows = $DB->select("
SELECT 
id, 
CONCAT('<div class=\"del-button\"><a href=\"#\" onclick=\"deleteLogin(',id,');\"><i class=\"dxi dxi-close\"></i></a></div>') AS del, 
CONCAT(name,'<br />',name_en) AS name, 
CONCAT(fio,'<br />',fio_en) AS fio, 
CONCAT(affiliation,'<br />',affiliation_en) AS affl, 
rubric, 
CONCAT('<a href=mailto:',email,'>',email,'</a>') AS email, 
IF (file<>'',	CONCAT('<div class=\"cell-button\"><a href=\"email.php?file=/article_bank/',file,'&email=',email,'&name=',REPLACE(name,'\"',''),'&fio=',REPLACE(fio,'\"',''),'\"><i class=\"dxi dxi-download\"></i></a></div>'),' ') AS file, 
date AS added, 
date_rez AS review, 
IF(rez_type IS NULL,0,rez_type) AS check1, 
IF(primech_rez IS NULL,'',primech_rez) AS notes1, 
date_publ AS publdate, 
IF(publ_type IS NULL,0,publ_type) AS check2, 
IF(primech IS NULL,'',primech) AS notes2, 
telephone, 
text 
FROM article_send
WHERE del='' AND journal=49".$where."
ORDER BY date DESC,time DESC
");

foreach ($rows as $k=>$v) {
	$rows[$k]['name'] = normJsonStr($v['name']);
	$rows[$k]['fio'] = normJsonStr($v['fio']);
	$rows[$k]['affl'] = normJsonStr($v['affl']);
	$rows[$k]['rubric'] = normJsonStr($v['rubric']);
	$rows[$k]['notes1'] = normJsonStr($v['notes1']);
	$rows[$k]['notes2'] = normJsonStr($v['notes2']);
	$rows[$k]['file'] = normJsonStr($v['file']);
    $rows[$k]['telephone'] = normJsonStr($v['telephone']);
    $rows[$k]['comment'] = normJsonStr(htmlspecialchars($v['text']));
    if(!empty($rows[$k]['comment'])) {
        $rows[$k]['comment'] = str_replace("\r\n","<br>",$rows[$k]['comment']);
        $rows[$k]['comment'] = str_replace("\n","<br>",$rows[$k]['comment']);
        $rows[$k]['comment'] = "<div class=\"cell-button\"><div class='popup-content'>".$rows[$k]['comment']."</div><a href=\"#\" onclick=\"openComment($(this));\"><i class=\"dxi dxi-eye\"></i></a></div>";
    }
	if($v['check1']==1) {
		$rows[$k]['check1'] = true;
	} else {
		$rows[$k]['check1'] = false;
	}
	if($v['check2']==1) {
		$rows[$k]['check2'] = true;
	} else {
		$rows[$k]['check2'] = false;
	}
}

echo json_encode($rows);

}
function normJsonStr($str){
	$str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
	return iconv('cp1251', 'utf-8', $str);
}