Результаты поиска
<br><br>
<?

global $DB,$_CONFIG;


mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

//$result = mysql_query("select * from publ where name like '%".$_POST['s-name']."%' or name2 like '%".$_POST['s-name']."%' order by name");

//mysql_close();

//while($row = mysql_fetch_array($result)) {

$str="";
$str_temp="";
$str_final="";
//$temp2=0;
if ($_POST["s-name"]!="") {

	 
	 $str_temp=$_POST["s-name"];
	 
	 //$temp2=strlen($str_temp);
	 //for($i=0;$i<$temp2;$i++)
	//{
	//	if($str_temp[$i]=='\'')
	//	{
	//		$str_final.=;
	//		$str_final.=substr($str_temp, $i, 1);
	//	}
	//	else
	//	{
	//		$str_final.=substr($str_temp, $i, 1);
	//	}
	//}
	$str_final=addslashes($str_temp);
   $str=" (name like '%".$str_final."%' or name2 like '%".$str_final."%') and  ";
   
   
   
}
if ($_POST["syear"]!="") {
   $str.=" year=".$_POST['syear']." and ";
}
if (isset($_POST["smain"])) {
   $str.=" can = 'on' and ";
}
if ($_POST[search_fio]=="") $str=substr($str,0,-5);

if (isset($_POST[search_fio])) $str.="(".$_POST[search_fio].")";
 if ($str=="") $str="1";
 

 
// $temp1=count($str);

 

 
  //echo "<a hidden=true href=aaa>".$str_final."</a>";

$result= $DB->select(
    "SELECT * FROM publ WHERE ".$str." ORDER BY name");
 echo "<table border='1'";
 foreach($result as $k=>$row)
 {
 	//echo "<a href=index.php?mod=public&show=ok&id=".$row[id].">".$row[name]."</a><br><hr>";

 // print_r($row);
    echo "<tr border='1'>";
  if ($row[can]=="on")
     echo "<td><img src='mod/public/zv.gif' /></td>";
 else
     echo "<td>&nbsp;&nbsp;&nbsp;</td>";
     if ($row[tip] == '1' && $row[vid]!='4' && $row[vid] !='9')
 {
    if ($row[picsmall] <> "" || $row[picbig] <> "" )
        echo "<td>"."<img src='mod/public/book1.gif' />". "</td>";
    else
        echo "<td>"."<img src='mod/public/book2.gif' />"."</td>";

 }
 else
    echo "<td>&nbsp;-&nbsp;</td>";


 echo "<td>".$row[year]." <a href=index.php?mod=public&show=ok&id=".$row[id].">".$row[name]."</a></td>";
 echo "</tr>";
 }
 echo "</table>";
?>
