<?

 $avt = '';

 include_once substr($_CONFIG["global"]["paths"]['admin_path'],0,-10)."classes/guid/guid.php";
 global $DB,$_CONFIG;
 mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
 mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

 $temp = $_POST['matrix'];

echo "<br/> Preview  ";
$i=0;
$avt="";

$avt0=explode("<br>",trim($temp));

foreach($avt0 as $k=>$avtor)
{

    if (!empty($avtor))
    {

    	   $ff=explode(' ',trim($avtor));
    	   $ff0=$DB->select("SELECT id FROM persona WHERE surname='".$ff[0]."' AND name='".$ff[1]."' AND fname='".$ff[2]."'");
           if (isset($ff0[0][id]))
              $avtors[$i]=$ff0[0][id];
           else
              $avtors[$i]=$avtor;
           $avt.=$avtors[$i]."<br>";
           $i++;
     }
}

// Картинки
if (!empty($_POST[eid]))
{
   $pic00=$DB->select("SELECT picsmall,picbig FROM publ WHERE id =".$_POST[eid]);
   $filenames=$pic00[0][picsmall];
   $filenameb=$pic00[0][picbig];

}
else
{
   $filenames="";
   $filenameb="";
}
if ($_FILES[pic1][tmp_name]<> "")
{

  $guid=new guid();
  if (empty($filenames)) $filenames=str_replace("-","_",$guid->tostring())."_s.jpg";
  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";

  move_uploaded_file($_FILES['pic1']['tmp_name'], $uploaddir.$filenames) ;


}


if ($_FILES[pic2][tmp_name]<>"")
{
  $guid=new guid();
  if (empty($filenameb)) $filenameb=str_replace("-","_",$guid->tostring())."_b.jpg";

  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";

  move_uploaded_file($_FILES['pic2']['tmp_name'], $uploaddir.$filenameb) ;
}






echo "id у нас равен $id <br>";

?>


<b>Предпросмотр</b>
<br><br>
<table width=100% border=0>
 <tr valign=top>
  <td width=240 align=center>
<?
   echo " <img width=240 height=320 src='http://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenameb."' />";


echo "   <br><br>" ;
echo " <img width=128 height=148 src='http://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenames."' />";
?>
  </td>
  <td>
   <table width=100% border=1>
    <tr height=20>

<?

   $row[1] = $_POST['name'];
   $row[13] = $_POST['name2'];
/*
   for ($i=0; $i<strlen($row[1]); $i++)
       if (($row[1][$i] == '"') || ($row[1][$i] == "'"))
            $row[1][$i] = '`';
       for ($i=0; $i<strlen($row[13]); $i++)
            if (($row[13][$i] == '"') || ($row[13][$i] == "'"))
                $row[13][$i] = '`';
*/

   $row[name]=str_replace('"','`',str_replace("'",'`',$row[name]));
   $row[name2]=str_replace('"','`',str_replace("'",'`',$row[name2]));

?>


     <td width=25%><b>Название</b></td>
	 <td width=25%><b><? echo $row[name]; ?></b>&nbsp;<? echo $row[name2]; ?></td>
	 <td width=25%><b>Год</b></td>
	 <td width=25%><? echo $_POST['date']; ?>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Вид</b></td>



<?


// Читаем виды публикаций

$vid0=$DB->select("SELECT * FROM vid WHERE id=".($_POST[vid]-1));
$type0= $DB->select("SELECT * FROM type WHERE id=".($_POST[tip]-1));


?>


	 <td width=25%><? echo $vid0[0][text]; ?>&nbsp;</td>
	 <td width=25%><b>Тип</b></td>




	 <td width=25%><? echo $type0[0][text]; ?>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Авторы</b></td>
	 <td width=25%><? echo $_POST['matrix']; ?><br>
	<? if ($_POST['as']) echo "Авторы будут скрыты"; ?>
	&nbsp;</td>
	 <td width=25%><b>Рубрики</b></td>
	 <td width=25%><? echo $_POST['returns']; ?>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Размещение на главной странице</b></td>
	 <td width=25%><? if($_POST['can'] == 'on') echo "Да"; else echo "Нет"; ?></td>
	 <td width=25%><b>Дата размещения на сайте</b></td>
	 <td width=25%><? echo "spe"; ?></td>
	</tr>
   </table>
   <hr>
   <table width=100% border=1>
<tr>
         <td width=25%><b>ISBN</b></td>
         <td width=75%><? echo $_POST['izdat']; ?>&nbsp;</td>
        </tr>
<tr>
         <td width=25%><b>Ключевые слова</b></td>
         <td width=75%><? echo $_POST['keyword']; ?>&nbsp;</td>
        </tr>

    <tr>
	 <td width=25%><b>Аннотация</b></td>
	 <td width=75%><? echo $_POST['annots']; ?>&nbsp;</td>
	</tr>
	<tr>
	 <td width=25%><b>Полный текст</b></td>
	 <td width=75%><? echo$_POST['plink']; ?></td>
	</tr>
   </table>
  </td>
 </tr>
<table>
<br>
<?



?>
<form method=post action=index.php?mod=public&action=save>
 <input type=hidden name=puid value='<? echo $id; ?>'>
 <input type=hidden name=name value='<? echo $_POST['name']; ?>'>
 <input type=hidden name=date value='<? echo $_POST['date']; ?>'>
 <input type=hidden name=vid value='<? echo $_POST['vid']; ?>'>
 <input type=hidden name=tip value='<? echo $_POST['tip']; ?>'>
 <input type=hidden name=matrix value='<? echo $avt; ?>'>
 <input type=hidden name=returns value='<? echo $_POST['returns']; ?>'>
 <input type=hidden name=annots value='<? echo $_POST['annots']; ?>'>
 <input type=hidden name=plink value='<? echo $_POST['plink']; ?>'>
 <input type=hidden name=can value='<? echo $_POST['can']; ?>'>
 <input type=hidden name=sdata value='<? echo "spe"; ?>'>
 <input type=hidden name=keyword value='<? echo $_POST['keyword']; ?>'>
 <input type=hidden name=izdat value='<? echo $_POST['izdat']; ?>'>
 <input type=hidden name=name2 value='<? echo $_POST['name2']; ?>'>
 <input type=hidden name=as value='<? echo $_POST['as']; ?>'>
 <input type=hidden name=imp value='<? echo $_POST['imp']; ?>'>

 <input type=hidden name=pic1 value='<? echo $filenames; ?>'>
 <input type=hidden name=pic2 value='<? echo $filenameb; ?>'>
 <input type=submit value='Сохранить в БД'>&nbsp;<A HREF="javascript:history.back()" onMouseOver="window.status='Назад';return true">НАЗАД</A>
 <?
 if($_POST['eid'])
 {
  echo "<input type=hidden name=eid value=".$_POST['eid'].">";
 }
 ?>


</form>


