<?
//Страницы истории

global $DB,$_CONFIG;

$str=$DB->select("SELECT a.icont_text AS text
				 FROM adm_ilines_content AS a
				 INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='status'
				 INNER JOIN adm_ilines_element AS e ON e.el_id=a.el_id AND e.itype_id=2
				 WHERE a.icont_var='text' AND s.icont_text=1
                 ORDER BY RAND() LIMIT 1
                ");

echo $str[0][text];

?>