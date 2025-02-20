<?//Список мероприятий
global $DB;
$rows=$DB->select("SESELECT c.el_id AS id,c.icont_text AS name,d.icont_text AS date,nn.icont_text AS type
	   FROM adm_ilines_content AS c
	   INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND e.itype_id=4 
	   INNER JOIN adm_ilines_content AS d ON d.el_id=c.el_id AND d.icont_var='date' 
	   INNER JOIN adm_ilines_content AS v ON v.el_id=c.el_id AND v.icont_var='sem'
       INNER JOIN adm_directories_content AS tt ON tt.el_id=v.icont_text AS tt.icont_var='text' 	   
	   
	   WHERE c.icont_var='title'
	   ORDER BY d.icont_text DESC
");
$year=0;$type='';
echo "<table border=1>";
echo "<tr><th>Дата</th><th>Вид мероприятия</th><th>Название</th><th>Ссылка</th></tr>";
foreach($rows as $row)
{
  echo "<tr>";
  if ($year!=substr($row[year],0,4))
  {
     echo "<td colspan=4 style='border:1px solid gray;' valign=top><b>".$row[year]."</b></td>";
	 $year=substr($row[year],0,4);$type='';
	 echo "</tr><tr>";
	 
  }
 /*
  echo "<td style='border:1px solid gray;' valign=top>".substr($row['date'],8,2).".".substr($row['date'],5,2),".".substr($row['date'],0,4)."<td>".
  "<td style='border:1px solid gray;' valign=top>".$row['type']."</td>".
  "<td style='border:1px solid gray;' valign=top>"$row[name]."</td><td style='border:1px solid gray;' valign=top>".
       "https://www.imemo.ru/index.php?page_id=506&id=".$row[id]."</td>";
  echo "</tr>";
 */ 
}
echo "</table>";
?>
