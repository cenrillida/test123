<?//Список публикаций
global $DB;

$rows_count = $DB->select("SELECT publ.id,publ.name,publ.avtor,publ.year,publ.vid_inion AS privat,publ.izdat AS isbn,
       d2.icont_text AS vid,d1.icont_text AS type,rinc
     FROM publ 
     LEFT OUTER JOIN adm_directories_content AS d1 ON d1.el_id=publ.vid AND d1.icont_var='text'
     LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=publ.tip AND d2.icont_var='text'
     WHERE publ.status=1
     ORDER BY publ.year DESC,d2.icont_text,publ.name
");
$rows_count = count($rows_count);
$pages_count = ceil($rows_count/1000);

if(empty($_GET[page]))
  $current_page=1;
else
  $current_page=$_GET[page];

echo "Страницы: ";
for ($i=1; $i <= $pages_count ; $i++) { 
  if($i==$current_page)
    echo "<b>".$i."</b> ";
  else
    echo "<a href=index.php?mod=public&act=set&page=".$i.">".$i."</a> ";
}

$start_row=1000*($current_page-1);

$rows=$DB->select("SELECT publ.id,publ.name,publ.avtor,publ.year,publ.vid_inion AS privat,publ.izdat AS isbn,
       d2.icont_text AS vid,d1.icont_text AS type,rinc
	   FROM publ 
	   LEFT OUTER JOIN adm_directories_content AS d1 ON d1.el_id=publ.vid AND d1.icont_var='text'
	   LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=publ.tip AND d2.icont_var='text'
	   WHERE publ.status=1
	   ORDER BY publ.year DESC,d2.icont_text,publ.name
     LIMIT ".$start_row.",1000
");
$year=0;$type='';
echo "<table border=1>";
echo "<tr><th>Название</th><th>Авторы</th><th>ISBN</th><th>РИНЦ</th><th>Ссылка</th></tr>";
foreach($rows as $row)
{
  echo "<tr>";
  if ($year!=$row[year])
  {
     echo "<td colspan=5 style='border:1px solid gray;' valign=top><b>".$row[year]."</b></td>";
	 $year=$row[year];$type='';
	 echo "</tr><tr>";
	 
  }
  if ($type!=$row[type])
  {
     echo "<td colspan=5  style='border:1px solid gray;' valign=top><b>".$row[type]."</b></td>";
	 $type=$row[type];
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
  echo "<td style='border:1px solid gray;' valign=top>".$row[name]."</td><td style='border:1px solid gray;' valign=top>".$avt_list."</td><td style='border:1px solid gray;' valign=top>".$row[isbn]."</td>";
  if ($row[rinc]!='0')
	echo "<td style='border:1px solid gray;' valign=top>".$row[rinc]."</td>";	 
else echo "<td style='border:1px solid gray;' valign=top></td>";	
  echo "<td style='border:1px solid gray;' valign=top>".
       "https://www.imemo.ru/index.php?page_id=645&id=".$row[id]."</td>";
      
//  else echo "<td>&nbsp;</td>";
  echo "</tr>";
}
echo "</table>";
echo "Страницы: ";
for ($i=1; $i <= $pages_count ; $i++) { 
  if($i==$current_page)
    echo "<b>".$i."</b> ";
  else
    echo "<a href=index.php?mod=public&act=set&page=".$i.">".$i."</a> ";
}
?>
