<?

$result2=$DB->select("


SELECT c.icont_text AS reclama
FROM `adm_ilines_content` AS c
INNER JOIN adm_ilines_content AS s ON s.el_id = c.el_id
AND s.icont_var = 'status'
AND s.icont_text =1
WHERE c.icont_var = 'reclama'
ORDER BY RAND( )
LIMIT 1
");

$row = str_replace('<a', '<a class=smi', $result2[0][reclama]);
$spego=false;


   echo "".$row;




?>