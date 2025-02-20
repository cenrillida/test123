<?

$pdate = date('d').'.'.date('m').'.'.date('y');

if (!isset($_POST[eid]) )
{

$request = "insert into publ values (".
		0 . ", '".
		$_POST['name']. "', '".
		$_POST['date']. "', '".
		$_POST['vid']. "', '".
		$_POST['tip']. "', '".
		$_POST['matrix']. "', '".
		$_POST['returns']. "', '".
		$_POST['annots']. "', '".
		$_POST['plink']. "', '".
		$_POST['can']. "', '".
		$pdate. "', '".
		$_POST['keyword']. "', '".
		$_POST['izdat']. "', '".
		$_POST['name2']	."', '".
		$_POST['as'] ."', '".
		$_POST['imp'] ."', '".
		$_POST['pic1']."', '".
		$_POST['pic2']."' ) ;";
}
else
{


$request = "UPDATE publ SET ".
		"name= '". $_POST['name']. "', ".
		"year='". $_POST['date']. "', ".
		"vid='".$_POST['vid']. "', ".
		"tip='".$_POST['tip']. "', ".
		"avtor='".$_POST['matrix']. "', ".
		"rubric='".$_POST['returns']. "', ".
		"annots='".$_POST['annots']. "', ".
		"link='".$_POST['plink']. "', ".
		"can='".$_POST['can']. "', ".
		"date='".$pdate. "', ".
		"keyword='".$_POST['keyword']. "', ".
		"izdat='".$_POST['izdat']. "', ".
		"name2='".$_POST['name2']	."', ".
		"`as`='".$_POST['as'] ."', ".
		"imp='".$_POST['imp'] ."', ".
		"picsmall='".$_POST['pic1']."', ".
		"picbig='".$_POST['pic2']."'".
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

<meta http-equiv=refresh content="3; url=index.php?mod=public">

