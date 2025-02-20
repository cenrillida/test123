<?

$avt = '';

global $DB,$_CONFIG;



echo "show";
$row0=$DB->select("SELECT * FROM publ WHERE id=".$_GET['id']);
$row=$row0[0];


$i=0;
$avt="";

$avt0=explode("<br>",trim($row[avtor]));

foreach($avt0 as $k=>$avtor)
{

    if (!empty($avtor))
    {
       if (is_numeric($avtor))
        {
    	   $ff=$DB->select("SELECT concat(surname,' ',name,' ',fname) as fio FROM persona WHERE id=".$avtor);
           $avtors[$i]=$ff[0][fio];
        }
        else
        {
            $avtors[$i]=$avtor;
        }
        $avt.=$avtors[$i]."<br>";
        $i++;
     }

}

    $filenames=$row[picsmall];
    $filenameb=$row[picbig];


?>

<b>Просмотр Show</b>
<br><br>
<table width=100% border=0>
 <tr valign=top>
  <td width=240 align=center>
<?
   echo " <img width=240 height=320 src='http://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenameb."' />";

   echo "<br><br>";
    echo " <img width=128 height=148 src='http://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenames."' />";

?>
  </td>
  <td>
   <table width=100% border=1>
    <tr height=20>
     <td width=25%><b>Название</b></td>

<?


   $row[name]=str_replace('"','`',str_replace("'",'`',$row[name]));
   $row[name2]=str_replace('"','`',str_replace("'",'`',$row[name2]));

?>

	 <td width=25%><b><? echo $row[name]; ?></b>&nbsp;<? echo $row[name2]; ?></td>
	 <td width=25%><b>Год</b></td>
	 <td width=25%><? echo $row[year]; ?>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Вид</b></td>

<?

$vid0=$DB->select("SELECT * FROM vid WHERE id=".($row[vid]-1));

?>


	 <td width=25%><? echo $vid0[0][text]; ?>&nbsp;</td>
	 <td width=25%><b>Тип</b></td>

<?


$type0=$DB->select("SELECT * FROM type WHERE id=".($row[tip]-1));

?>


	 <td width=25%><? echo $type0[0][text]; ?>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Авторы</b></td>
	 <td width=25%><? echo $avt; ?><br>
	<? if ($row[`as`] == 'on') echo "<b>Авторы будут скрыты</b>"; ?>&nbsp;</td>
	 <td width=25%><b>Рубрики</b></td>
	 <td width=25%><? echo $row[rubric]; ?>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Размещение на главной странице</b></td>
	 <td width=25%><? if($row['can'] == 'on') echo "Да"; else echo "Нет"; ?></td>
	 <td width=25%><b>Дата размещения на сайте</b></td>
	 <td width=25%><? echo $row['date']; ?></td>
	</tr>
   </table>
   <hr>
   <table width=100% border=1>
<tr>
         <td width=25%><b>ISBN</b></td>
         <td width=75%><? echo $row[izdat]; ?>&nbsp;</td>
        </tr>
<tr>
         <td width=25%><b>Ключевые слова</b></td>
         <td width=75%><? echo $row[keyword]; ?>&nbsp;</td>
        </tr>

    <tr>
	 <td width=25%><b>Аннотация</b></td>
	 <td width=75%><? echo $row[annots]; ?>&nbsp;</td>
	</tr>
	<tr>
	 <td width=25%><b>Ссылка на полный текст</b></td>
	 <td width=75%><? echo $row['link']; ?></td>
	</tr>
   </table>
  </td>
 </tr>
<table>
<br>
<table><tr>
<td width=150><a href=index.php?mod=public&act=edit&id=<?  echo $_GET[id]; ?>>Редактировать</a></td>
<td width=150><a href=index.php?mod=public&act=delask&id=<?  echo $_GET[id]; ?>>Удалить</a></td>
<td width=150><A HREF="javascript:history.back()" onMouseOver="window.status='Назад';return true">НАЗАД</A></td>
</tr></table>
<?

