<?
echo "<b>PREVIEW</b>";
//print_r($_POST);
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
    	   $ff0=$DB->select("SELECT id FROM persons WHERE surname='".$ff[0]."' AND name='".$ff[1]."' AND fname='".$ff[2]."'");
           if (isset($ff0[0][id]))
              $avtors[$i]=$ff0[0][id];
           else
              $avtors[$i]=$avtor;
           $avt.=$avtors[$i]."<br>";
           $i++;
     }
}

$temp = $_POST['matrix2'];

echo "<br/> Preview  ";
$i=0;
$avt2="";

$avt0=explode("<br>",trim($temp));

foreach($avt0 as $k=>$avtor)
{

    if (!empty($avtor))
    {

        $ff=explode(' ',trim($avtor));
        $ff0=$DB->select("SELECT id FROM persons WHERE surname='".$ff[0]."' AND name='".$ff[1]."' AND fname='".$ff[2]."'");
        if (isset($ff0[0][id]))
            $avtors[$i]=$ff0[0][id];
        else
            $avtors[$i]=$avtor;
        $avt2.=$avtors[$i]."<br>";
        $i++;
    }
}

// Картинки



if (!empty($_POST[eid]))
{
   $pic00=$DB->select("SELECT picsmall,picbig,picmain FROM publ WHERE id =".$_POST[eid]);
   $filenames=$pic00[0][picsmall];
   $filenameb=$pic00[0][picbig];
   $filenamem=$pic00[0][picmain];
   if (($filenames=="" || $filenameb=="") && $_POST[ebook] == "on")
   {
   	  $filenames="ebooksmall.jpg";
      $filenameb="ebook.jpg";
   }

}
else
{
   if (!empty($_POST[ebook]))
   if (!empty($_POST[ebook]))
   {
   	  $filenames="ebooksmall.jpg";
      $filenameb="ebook.jpg";
   }

   else
   {
      $filenames="";
      $filenameb="";
   }
}




if ($_FILES[pic1][tmp_name]<> "")
{

  $guid=new guid();
  if (empty($filenames)) $filenames=str_replace("-","_",$guid->tostring())."_s.jpg";
  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";
  if($filenames!="ebooksmall.jpg")
  move_uploaded_file($_FILES['pic1']['tmp_name'], $uploaddir.$filenames) ;


}


if ($_FILES[pic2][tmp_name]<>"")
{
  $guid=new guid();
  if (empty($filenameb)) $filenameb=str_replace("-","_",$guid->tostring())."_b.jpg";

  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";
  if ($filenameb!="ebook.jpg")
  move_uploaded_file($_FILES['pic2']['tmp_name'], $uploaddir.$filenameb) ;
}

if ($_FILES[pic3][tmp_name]<>"")
{
  $guid=new guid();
  if (empty($filenamem)) $filenamem=str_replace("-","_",$guid->tostring())."_m.jpg";

  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";

  move_uploaded_file($_FILES['pic3']['tmp_name'], $uploaddir.$filenamem) ;
}
//echo "id у нас равен $id <br>";

?>


<b>Предпросмотр</b>
<br><br>
<table width=100% border=0>
 <tr valign=top>
  <td width=180 align=center>
<?
   echo " <img width=180 height=240 src='https://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenameb."' />";


echo "   <br><br>" ;
echo " <img src='https://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenames."' />";

echo "   <br><br>" ;
echo " <img src='https://".$_CONFIG['global']['paths'][site].$_CONFIG['global']['paths']['admin_dir']."pfoto/".$filenamem."' />";

?>
  </td>
  <td>
   <table width=100% border=1>
    <tr height=20>

<?



   $row[name] = $_POST['name'];
   $row[name2] = $_POST['name2'];

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

$vid0=$DB->select("SELECT * FROM vid WHERE id=".($_POST[vid]));
$type0= $DB->select("SELECT * FROM type WHERE id=".($_POST[tip]));
$vidi0= $DB->select("SELECT * FROM vid_inion WHERE id=".($_POST[vid_inion]));

$_POST[keyword]=str_replace('|','<br>',$_POST[keyword]);

?>
	 <td width=25%><? echo $vid0[0][text]; ?>&nbsp;</td>
	 <td width=25%><b>Тип</b></td>
	 <td width=25%><? echo $type0[0][text]; ?>&nbsp;</td>
	</tr><tr>
	 <td><b>ИНИОН</b></td>	 <td colspan='3'><? echo $vidi0[0][text]; ?>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td><?=$_POST[izdat]?></td>
	<td><?=$_POST[copyright]?></td>

	<td>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Авторы</b></td>
	 <td width=25%><? echo $_POST['matrix']; ?><br>
	<? if ($_POST['hide_autor']) echo "Авторы будут скрыты"; ?>
	&nbsp;</td>
	 <td width=25%><b>Рубрики</b></td>
	 <td width=25%><? echo $_POST['returns']; ?>&nbsp;</td>
	</tr>
	<tr height=20>
     <td width=25%><b>Дата размещения на сайте</b></td>
	 <td width=25%><? echo "spe"; ?></td>
	 <td>&nbsp;</td>
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
	 <td width=25%><b>Ссылка на полный текст</b></td>
	 <td width=75%><? echo $_POST['plink']; ?></td>
	</tr>

	<tr><td colspan='2'>
<?
    if ($_POST[formain]==1 || $_POST[formain]=='on')
        echo "<b>Публикация будет показана на главной странице</b><br />";


    if ($_POST[status]==1 || $_POST[status]=='on')
        echo "<b>Публикация будет выведена на сайте</b>";
    else
        echo "<b>Публикация НЕ показывается на сайте</b>";
?>
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
  <input type=hidden name=name value='<? echo $_POST['name_title']; ?>'>
 <input type=hidden name=date value='<? echo $_POST['date']; ?>'>
 <input type=hidden name=date_fact value='<? echo $_POST['date_fact']; ?>'>
 <input type=hidden name=vid value='<? echo $_POST['vid']; ?>'>
 <input type=hidden name=vid_inion value='<? echo $_POST['vid_inion']; ?>'>
 <input type=hidden name=tip value='<? echo $_POST['tip']; ?>'>
 <input type=hidden name=format value='<? echo $_POST['format']; ?>'>
 <input type=hidden name=matrix value='<? echo $avt; ?>'>
    <input type=hidden name=matrix2 value='<? echo $avt2; ?>'>
 <input type=hidden name=returns value='<? echo $_POST['returns']; ?>'>
 <input type=hidden name=annots value='<? echo $_POST['annots']; ?>'>
  <input type=hidden name=annots_en value='<? echo $_POST['annots_en']; ?>'>
 <input type=hidden name=plink value='<? echo $_POST['plink']; ?>'>
 <input type=hidden name=plink_en value='<? echo $_POST['plink_en']; ?>'>
 <input type=hidden name=sdata value='<? echo "spe"; ?>'>
 <input type=hidden name=keyword value='<? echo $_POST['keyword']; ?>'>
 <input type=hidden name=keyword_en value='<? echo $_POST['keyword_en']; ?>'>
 <input type=hidden name=izdat value='<? echo $_POST['izdat']; ?>'>
 <input type=hidden name=doi value='<? echo $_POST['doi']; ?>'>
 <input type=hidden name=formain value='<? echo $_POST['formain']; ?>'>
 <input type=hidden name=name2 value='<? echo $_POST['name2']; ?>'>
 <input type=hidden name=hide_autor value='<? echo $_POST['hide_autor']; ?>'>
 <input type=hidden name=rinc value='<? echo $_POST['rinc']; ?>'>
 <input type=hidden name=ebook value='<? echo $_POST['ebook']; ?>'>
 <input type=hidden name=pic1 value='<? echo $filenames; ?>'>
 <input type=hidden name=pic2 value='<? echo $filenameb; ?>'>
 <input type=hidden name=pic3 value='<? echo $filenamem; ?>'>
 <input type=hidden name=status value='<? echo $_POST[status]; ?>'>
 <input type=hidden name=out_from_print value='<? echo $_POST[out_from_print]; ?>'>
<input type=hidden name=no_publ_ofp value='<? echo $_POST[no_publ_ofp]; ?>'>
<input type=hidden name=dynkin_piar value='<? echo $_POST[dynkin_piar]; ?>'>
 <input type=hidden name=rubric2 value='<? echo $_POST[rubric2]; ?>'>
 <input type=hidden name=rubric2d value='<? echo $_POST[rubric2d]; ?>'>
 <input type=hidden name=rubric2_3 value='<? echo $_POST[rubric2_3]; ?>'>
 <input type=hidden name=rubric2_4 value='<? echo $_POST[rubric2_4]; ?>'>
 <input type=hidden name=rubric2_5 value='<? echo $_POST[rubric2_5]; ?>'>
 <input type=hidden name=elogo value='<? echo $_POST[elogo]; ?>'>
 <input type=hidden name=r1 value='<? echo $_POST[r1]; ?>'>
 <input type=hidden name=r2 value='<? echo $_POST[r2]; ?>'>
 <input type=hidden name=r3 value='<? echo $_POST[r3]; ?>'>
 <input type=hidden name=r4 value='<? echo $_POST[r4]; ?>'>
 <input type=hidden name=r5 value='<? echo $_POST[r5]; ?>'>
 <input type=hidden name=land value='<? echo $_POST[land]; ?>'>
 <input type=edit name='parent_id' value='<? echo $_POST[parent_id]; ?>'>
 <input type=edit name='page_beg' value='<? echo $_POST[page_beg]; ?>'>

 <input type=submit value='Сохранить в БД'>&nbsp;<A HREF="javascript:history.back()" onMouseOver="window.status='Назад';return true">НАЗАД</A>

 <?
 if($_POST['eid'])
 {
  echo "<input type=hidden name=eid value=".$_POST['eid'].">";
 }
 ?>


</form>


