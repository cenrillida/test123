<?

$avt = '';

global $DB,$_CONFIG;



echo "show";
$row0=$DB->select("SELECT * FROM publ WHERE id=".$_GET['id']." AND name<>''" );
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
    	   $ff=$DB->select("SELECT concat(surname,' ',name,' ',fname) as fio FROM persons WHERE id=".$avtor);
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
    $filenamem=$row[picmain];

if (($filenames== "" ||  $filenameb) && $_POST[ebook]=='on')
{
    $filenames="ebooksmall.jpg";
    $filenameb="ebook.jpg";
}
if (($filenames== "" ||  $filenameb) && $_POST[epolis]=='on')
{
    $filenames="logo_polis_small.jpg";
    $filenameb="logo_polis_big.jpg";
}
?>

<b>Просмотр Show</b>
<br><br>
<table width=100% border=0>
 <tr valign=top>
  <td width=180 align=center>
<?
   echo " <img  src='https://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenameb."' />";

   echo "<br><br>";
    echo " <img src='https://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenames."' />";
    echo "<br><br>";
    echo " <img src='https://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenamem."' />";

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

$strwhere="";$retro='';
if(!empty($row[rubric2])) if(substr($row[rubric2],0,1)=='r') $strwhere.=substr($row[rubric2],1)." OR "; else $strwhere.=$row[rubric2]." OR ";
if(!empty($row[rubric2d])) if(substr($row[rubric2d],0,1)=='r') $strwhere.=substr($row[rubric2d],1)." OR "; else $strwhere.=$row[rubric2d]." OR ";
if(!empty($row[rubric2_3])) if(substr($row[rubric2_3],0,1)=='r') $strwhere.=substr($row[rubric2_3],1)." OR ";else $strwhere.=$row[rubric2_3]." OR ";
if(!empty($row[rubric2_4])) if(substr($row[rubric2_4],0,1)=='r') $strwhere.=substr($row[rubric2_4],1)." OR ";else $strwhere.=$row[rubric2_4]." OR ";
if(!empty($row[rubric2_5])) if(substr($row[rubric2_5],0,1)=='r') $strwhere.=substr($row[rubric2_5],1)." OR ";else $strwhere.=$row[rubric2_5]." OR ";
$strwhere=substr($strwhere,0,-4);
if (substr($row[rubric2],0,1)=='r' || substr($row[rubric2d],0,1)=='r' ||
substr($row[rubric2_3],0,1)=='r' || substr($row[rubric2_4],0,1)=='r' || substr($row[rubric2_5],0,1)=='r')
$retro="Ретроспектива";
if(!empty($strwhere)) $strwhere= ' AND (el_id='.$strwhere.')';

$type0=$DB->select("SELECT * FROM type WHERE id=".($row[tip]-1));
$rub0=$DB->select("SELECT icont_text AS rub FROM adm_directories_content WHERE icont_var='text' ".
       $strwhere);
$rubs="";
foreach($rub0 as $rub)
{
   $rubs.=$rub[rub]." ";
}
?>


	 <td width=25%><? echo $type0[0][text]; ?>&nbsp;</td>
	</tr>
	<tr>
         <td width=25%><b>&nbsp;</b></td>
         <td><? echo $row[izdat]; ?>&nbsp;</td>
         <td><? echo $row[copyright]; ?>&nbsp;</td>
        </tr>
    <tr>
	<tr height=20>
     <td width=25%><b>Авторы</b></td>
	 <td width=25%><? echo $avt; ?><br>
	<? if ($row[`as`] == 'on') echo "<b>Авторы будут скрыты</b>"; ?>&nbsp;</td>
	 <td width=25%><b>Рубрики</b></td>
	 <td width=25%><? echo $rubs; ?>&nbsp;
     <br /><?=@$retro?>
	 </td>
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
 	</tr>
	<tr><td colspan='2'>
<?
    if ($row[status]==1 || $row[status]=='on')
        echo "<b>Публикация будет выведена на сайте</b>";
    else
        echo "<b>Публикация НЕ показывается на сайте</b>";
?>
<table>
<br>
<table><tr>
<td width=150><a href=index.php?mod=public&act=edit&id=<?  echo $_GET[id]; ?>>Редактировать</a></td>
<td width=150><a href=index.php?mod=public&act=delask&id=<?  echo $_GET[id]; ?>>Удалить</a></td>
<td width=150><A HREF="javascript:history.back()" onMouseOver="window.status='Назад';return true">НАЗАД</A></td>
</tr></table>
<?

