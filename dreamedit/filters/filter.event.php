
<?

$result2=$DB->select("
         SELECT c.el_id,t.icont_text AS title, f.icont_text AS full_text
	 FROM adm_ilines_content AS c
         INNER JOIN adm_ilines_content AS t ON t.el_id=c.el_id AND t.icont_var='prev_text'
         INNER JOIN adm_ilines_content AS f ON f.el_id=c.el_id AND f.icont_var='full_text'
         INNER JOIN adm_ilines_content AS d ON d.el_id=c.el_id AND d.icont_var='date'
            AND
	 CONCAT(substring(d.icont_text,1,4),substring(d.icont_text,6,2),substring(d.icont_text,9,2)) <= ".(date(Ymd)).
         " INNER JOIN adm_ilines_content AS s ON s.el_id=c.el_id AND s.icont_var='status'
	     AND s.icont_text='1'
	 INNER JOIN adm_ilines_element as e ON (e.el_id=c.el_id)
	 	      AND e.itype_id=15
	 WHERE c.icont_var='daten' AND
	 CONCAT(substring(c.icont_text,1,4),substring(c.icont_text,6,2),substring(c.icont_text,9,2)) >= ".(date(Ymd)).
	 " ORDER BY c.icont_text desc  LIMIT 1"
	 );

if (!empty($result2)){
//<tr valign='top'><td background='/img/publicbg_red.png' align='center'>
//!!! поставить постфикс red в строку img
echo "<table border=0 cellspacing='0' cellpadding='0'>
   <tr valign='top'><td background='/img/publicbg_red.png' align='center'>

   <img src='/img/public_red.png'/>
   <table cellspacing='0' cellpadding='0' border='0' width=160>
   <tr valign=top><td align='left'>

  <br>
  <table width=100% border=0><tr><td>";


   echo "<b>".str_replace("<a","<a style= 'color:yellow'",$result2[0][title])."</b>";
   echo "<font color=white>".str_replace("<a","<a class='smi'",$result2[0][full_text])."</font>";


   echo "
        </font>
        </td></tr></table>
        <br><br>

        </td></tr>
        </table>
        </td></tr>
        </table>";
}

else // Последняя публикация в СМИ
{
//Заголовок блока
$head=$DB->select("
SELECT h1.icont_text AS head FROM adm_headers_content AS h1
     INNER JOIN adm_headers_content AS h2 ON h2.el_id = h1.el_id AND h2.icont_var='value'
           AND h2.icont_text='SMI'
     WHERE h1.icont_var='text'
");

$result2= $DB->select("
SELECT c.el_id, cdn.icont_text AS title, c.icont_text AS frontpage_text
      FROM adm_ilines_element e
         INNER JOIN adm_ilines_content c ON e.el_id = c.el_id
              AND c.icont_var = 'frontpage_text'
         INNER JOIN adm_ilines_content cdn ON cdn.el_id = e.el_id
              AND cdn.icont_var = 'title'
         INNER JOIN adm_ilines_content cdd ON cdd.el_id = e.el_id
             AND cdd.icont_var='date'
         INNER JOIN adm_ilines_content cds ON cds.el_id=e.el_id
             AND cds.icont_var='status'
         WHERE e.itype_id =3
             AND cds.icont_text='1'


         ORDER BY cdd.icont_text desc, cdn.icont_text, c.el_id
         LIMIT 0 , 1
");

$row = str_replace('<a', '<a class=smi', $result2[0][frontpage_text]);
$spego=false;
echo "<table border=0 cellspacing='0' cellpadding='0'>
   <tr valign='top'><td background='/img/publicbg.png' align='center'>

   <img src='/img/public.png'/>
   <table cellspacing='0' cellpadding='0' border='0' width=160>
   <tr valign=top><td align='left'>

  <br>
  <table width=100% border=0><tr><td>";

   echo str_replace('<a','<a class=smi',$head[0][head]);
   echo "<b><font color= white>",$result2[0][title]."</font></b>";
   echo "<font face=Arial size=2 color=white>".$row;


   echo "
        </font>
        </td></tr></table>
        <br><br>

        </td></tr>
        </table>
        </td></tr>
        </table>";

}
?>