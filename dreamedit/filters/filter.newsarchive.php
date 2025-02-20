<?
global $DB,$page_content;
// Архив новостей
$headers = new Headers();
$where="";
//print_r($page_content);
if (!empty($page_content[ILINE_SPISOK]))
{
$iline=explode(",",$page_content[ILINE_SPISOK]);
foreach($iline as $il)
{
   $where.=" e.itype_id=".$il." OR ";
}
if (!empty($where)) $where="(".substr($where,0,-4).")";
$rows=$DB->select("SELECT DISTINCT substring(c.icont_text,1,4) AS year
                  FROM adm_ilines_content AS c
				  INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND ".$where.
				 " WHERE (c.icont_var='date' OR c.icont_var='date2')
				  ORDER BY substring(c.icont_text,1,4) DESC
				 ");
$num=count($rows);
$i=0;
$language="";
if ($_SESSION[lang]=='/en')
	$language="en/";
foreach($rows as $row)
{
   echo "<div class=\"arch-node\"><a href=/".$language."index.php?page_id=498&td1=".$row[year].".01.01&td2=".$row[year].".12.31>".$row[year]."</a></div>";
}
}
?>
