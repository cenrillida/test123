<?

if($_GET['action'] == 'add') include 'action.php';
 else
if($_GET['action'] == 'save') include 'save.php';
 else
if($_GET['show'] == 'ok') include 'show.php';
 else
if($_GET['act'] == 'search') include 'search.php';
 else
if($_GET['act'] == 'del') include 'delete.php';
 else
if($_GET['act'] == 'edit') include 'edit.php';
 else
if($_GET['act'] == 'set') include 'set.php';
 else
if($_GET['act'] == 'delask') include 'delask.php';
 //else
//if($_GET['shw']) include 'delask.php';

?>



<?
if ((!$_GET['action'])&&(!$_GET['show'])&&(!$_GET['act'])) {
echo "Имеются следующие записи :<br><br>";
$wow = array ();
global $_CONFIG;
mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

$rows_count = mysql_query("select id,name,name2,picsmall,picbig,tip,vid,year,status,link from publ WHERE name <> ''");
$rows_count = mysql_num_rows($rows_count);
$pages_count = ceil($rows_count/1000);

if(empty($_GET[page]))
  $current_page=1;
else
  $current_page=$_GET[page];

if(!empty($_GET[shw]))
  $shw_str="&shw=".$_GET[shw];
else
  $shw_str="";

if($_GET[shw]=="all" || empty($_GET[shw])) {

echo "Страницы: ";
for ($i=1; $i <= $pages_count ; $i++) { 
  if($i==$current_page)
    echo "<b>".$i."</b> ";
  else
    echo "<a href=index.php?mod=public".$shw_str."&page=".$i.">".$i."</a> ";
}
}

$start_row=1000*($current_page-1);

if ($_GET['shw'] != 'all')
 $result =  mysql_query("select id,name,name2,picsmall,picbig,tip,vid,year,status,link from publ WHERE name <> '' order by id desc LIMIT ".$start_row.",1000");
else
 $result =  mysql_query("select id,name,name2,picsmall,picbig,tip,vid,year,status,link from publ WHERE name <> '' order by name LIMIT ".$start_row.",1000");

if($_GET['shw'] == 'null') {
    $result =  mysql_query("select id,name,name2,picsmall,picbig,tip,vid,year,status,link from publ WHERE `date` IS NULL order by name LIMIT ".$start_row.",1000");
}


$num = 0;
$i=0;
echo "<table border='1'>";
while($row = mysql_fetch_array($result))
{

 $wow[$i] = $row;
 $i++;
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
    if ($row[picsmall]=="ebooksmall.jpg")
        echo "<td>"."<img src='mod/public/ebook_logo.jpg' />". "</td>";
    else
        if ($row[picsmall]=="logo_polis_small.jpg")
           echo "<td>"."<img src='mod/public/logo_polis_icon.jpg' />". "</td>";
        else
        echo "<td>&nbsp;-&nbsp;</td>";
 if(strpos($row['link'],'pdf')!=0)
       echo "<td>"."<img src='/files/Image/pdf.gif' width=16px height=16px />". "</td>";
 else
        echo "<td>&nbsp;-&nbsp;</td>";

 if ($row[status]==0)
 {
   $font="<font color=#b0b0b0>";
   $font2="</font>";
 }
 else
 {
    $font="";
    $font2="";
 }

 echo "<td>".$font.$row[year]." <a href=index.php?mod=public&show=ok&id=".$row[id].">".$font.$row[name].$row[name2]."</font></a></font></td>";
 echo "</tr>";
 $num++;
 if ($_GET['shw'] != 'all')
 if ($num == $_GET['shw']) break;
}
mysql_close();
echo "</table>";
if($_GET[shw]=="all" || empty($_GET[shw])) {

echo "Страницы: ";
for ($i=1; $i <= $pages_count ; $i++) { 
  if($i==$current_page)
    echo "<b>".$i."</b> ";
  else
    echo "<a href=index.php?mod=public".$shw_str."&page=".$i.">".$i."</a> ";
}
}
// print_r($row);
//for($i=0; $i<count($wow); $i++)
 //for ($k=0; $k<strlen($wow[$i][10]); $k++)
  //echo 1;

}
?>
