<?//Список публикаций
global $DB;
$rows=$DB->select("SELECT c.el_id AS id,c.icont_text AS name,v.icont_text AS avtor,d.icont_text AS date
	   FROM adm_ilines_content AS c
	   INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND e.itype_id=3 
	   INNER JOIN adm_ilines_content AS d ON d.el_id=c.el_id AND d.icont_var='date' 
	   INNER JOIN adm_ilines_content AS v ON v.el_id=c.el_id AND v.icont_var='people' 
	   
	   WHERE c.icont_var='title'
	   ORDER BY d.icont_text DESC
");
//print_r($rows);
$year=0;$type='';
echo "<table border=1>";
echo "<tr><th>Дата</th><th>Название</th><th>Автор</th><th>Ссылка</th></tr>";
foreach($rows as $row)
{
  
  echo "<tr>";
  if ($year!=substr($row[year],0,4))
  {
     echo "<td colspan=4 style='border:1px solid gray;' valign=top><b>".$row[year]."</b></td>";
	 $year=substr($row[year],0,4);$type='';
	 echo "</tr><tr>";
	 
  }
 
  $avt=explode("<br>",$row[avtor]);
  $avt_list="";
  foreach($avt as $a)
  {
     if (!empty($a))
	 {
	    
		if (is_numeric($a))
		{
		   $ff=$DB->select("SELECT CONCAT(surname,' ',substring(name,1,1),'. ',substring(fname,1,1),'.') AS fio FROM persons WHERE id=".$a); 
		   $avt_list.=$ff[0][fio]." ";
		}
	   else 		$avt_list.=$a." ";
	 }
  
  }
  echo "<td style='border:1px solid gray;' valign=top>".substr($row['date'],8,2).".".substr($row['date'],5,2),".".substr($row['date'],0,4)."</td>";
  echo "<td style='border:1px solid gray;' valign=top>".$row[name]."</td><td style='border:1px solid gray;' valign=top>".$avt_list."</td><td style='border:1px solid gray;' valign=top>".
       "https://www.imemo.ru/index.php?page_id=502&id=".$row[id]."</td>";
  echo "</tr>";
}
echo "</table>";
?>
