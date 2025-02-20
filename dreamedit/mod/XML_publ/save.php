<?
echo "<br /><b>SAVE from XML</b> ".$_REQUEST[mode];
print_r($_POST);
$pdate = date('d.m.y');


if ($_POST[status]=='on') $_POST[status]=1;
else $_POST[status]=0;
if ($_POST[r1]=='on' && !empty($_POST[rubric2])) $_POST[rubric2]="r".$_POST[rubric2];
if ($_POST[r2]=='on' && !empty($_POST[rubric2d])) $_POST[rubric2d]="r".$_POST[rubric2d];
if ($_POST[r3]=='on' && !empty($_POST[rubric2_3])) $_POST[rubric2_3]="r".$_POST[rubric2_3];
if ($_POST[r4]=='on' && !empty($_POST[rubric2_4])) $_POST[rubric2_4]="r".$_POST[rubric2_4];
if ($_POST[r5]=='on' && !empty($_POST[rubric2_5])) $_POST[rubric2_5]="r".$_POST[rubric2_5];

if (empty($_POST[matrix]))
{
	for($i=0;$i<count($_POST);$i++)
	{
	   if (!isset($_POST["ffio".$i])) break;

	   if (!empty($_POST["ffio".$i])) $_POST[matrix].=$_POST["ffio".$i]."<br>";
	}

}


if ($_POST[formain]=='on') $_POST[formain]=1;

if (!empty($_POST[eid]) ||  $_POST[eid]=='')
{


$request = "INSERT INTO publ
		(id,name,year,vid,vid_inion,tip,avtor,rubric,annots,annots_en,link,link_en,date,keyword,keyword_en,izdat,
		formain,name2,hide_autor,picsmall,picbig,status,rubric2,rubric2d,rubric2_3,rubric2_4,rubric2_5,picmain,
		format,date_fact,pages)
		VALUES (".
		0 . ", '".
		$_POST['name']. "', '".
		$_POST['date']. "', '".
		$_POST['vid']. "', '".
		$_POST['vid_inion']. "', '".
		$_POST['tip']. "', '".
		$_POST['matrix']. "', '".
		$_POST['returns']. "', '".
		$_POST['annots']. "', '".
		$_POST['annots_en']. "', '".
		$_POST['plink']. "', '".
		$_POST['plink_en']. "', '".
		$pdate. "', '".
		$_POST['keyword']. "', '".
		$_POST['keyword_en']. "', '".
		$_POST['izdat']. "', '".
		$_POST['formain']. "', '".
		$_POST['name2']	."', '".
		$_POST['hide_autor'] ."', '".
		$_POST['pic1']."', '".
		$_POST['pic2']."', ".
		"'".$_POST[status]."',".
		"'".$_POST[rubric2]."',".
		"'".$_POST[rubric2d]."',".
		"'".$_POST[rubric2_3]."',".
		"'".$_POST[rubric2_4]."',".
		"'".$_POST[rubric2_5]."',".
		"'".$_POST['pic3']."', ".
		"'".$_POST['format']."', ".
		"'".$_POST['date_fact']."', ".
		"'".$_POST['pages']."' ".
		" ) ";



}
else
{

$request = "UPDATE publ SET ".
		"name= '". $_POST['name']. "', ".
		"year='". $_POST['date']. "', ".
		"vid='".$_POST['vid']. "', ".
		"vid_inion='".$_POST['vid_inion']. "', ".
		"tip='".$_POST['tip']. "', ".
		"avtor='".$_POST['matrix']. "', ".
		"rubric='".$_POST['returns']. "', ".
		"annots='".$_POST['annots']. "', ".
		"annots_en='".$_POST['annots_en']. "', ".
		"link='".$_POST['plink']. "', ".
		"link_en='".$_POST['plink_en']. "', ".
		"date='".$pdate. "', ".
		"keyword='".$_POST['keyword']. "', ".
		"keyword_en='".$_POST['keyword_en']. "', ".
		"izdat='".$_POST['izdat']. "', ".
		"formain='".$_POST['formain']. "', ".
		"name2='".$_POST['name2']	."', ".
		"`hide_autor`='".$_POST['hide_autor'] ."', ".
		"picsmall='".$_POST['pic1']."', ".
		"picbig='".$_POST['pic2']."',".
		"picmain='".$_POST['pic3']."',".
		"status='".$_POST['status']."',".
		"rubric2='".$_POST['rubric2']."',".
		"rubric2d='".$_POST['rubric2d']."',".
		"rubric2_3='".$_POST['rubric2_3']."',".
		"rubric2_4='".$_POST['rubric2_4']."',".
		"rubric2_5='".$_POST['rubric2_5']."',".
		"format=".$_POST['format'].",".
		"date_fact='".$_POST['date_fact']."'".
		" WHERE id=".$_POST[eid]
		  ;


}



global $_CONFIG;
mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

mysql_query($request);
$tid0 = mysql_query("SELECT LAST_INSERT_ID()");
$tid=mysql_fetch_array($tid0);
mysql_close();


if ($tid[0]==0) $tid[0]=$_POST[eid];

?>

ѕубликаци€ сохранена. id= <? echo $tid[0] ?>

<br>
¬ы будете перенаправлены на главную страницу через 3 секунды

<meta http-equiv=refresh content="30; url=index.php?mod=XML_publ">

