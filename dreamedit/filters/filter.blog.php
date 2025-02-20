<?
// Текст к блогам
global $DB,$_CONFIG;

$str=$DB->select("SELECT h1.icont_text AS head FROM adm_headers_content AS h1 
                 INNER JOIN adm_headers_content AS h2 ON h2.el_id=h1.el_id
	    	 AND h2.icont_text='blog' AND h2.icont_var='value' 
		 WHERE h1.icont_var='text'
                ");
//$str=str_replace("</p>","",str_replace("<p>","",$str[0]['head']));		
echo "<br />";
$str=$str[0]['head'];
echo $str; 

?>
