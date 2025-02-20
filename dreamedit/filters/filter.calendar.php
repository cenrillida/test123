<link rel="stylesheet" type="text/css" href="/calendar/super_calendar_style.css" />


<?

// Список файлов


global $DB,$_CONFIG, $page_id, $_TPL_REPLACMENT,$page_content;
$_REQUEST[td1]=$DB->cleanuserinput($_REQUEST[td1]);
$_REQUEST[td2]=$DB->cleanuserinput($_REQUEST[td2]);
//$event=new Events;

//$dd0=$event->getDatesByMonthYearAllLines("2,17,14,3,16","11","2008","dat");
$_GET[td1]=$DB->cleanuserinput($_GET[td1]);
$_GET[td2]=$DB->cleanuserinput($_GET[td2]);


$sp=$page_content["ILINE_SPISOK"]; //"2,17,14,3,16";
if (empty($sp))
   $sp="2,3,14,15";
if (isset($_REQUEST[td1]))
{
    $tmonth=substr($_REQUEST[td1],5,2);
    $tyear=substr($_REQUEST[td1],0,4);
}
if(empty($_REQUEST[td1]))
{
   $tmonth=date("m");
   $tyear=date("Y");
}


?>
<div id="callback" style='text-align:left;' >
	<div id="calendar" ></div>
</div>
<?

if ($_SESSION[lang]!="/en")
{
?>
<script type="text/javascript">
	navigate('<?=$tmonth?>','<?=$tyear?>','','<?=$_CONFIG["global"]["paths"]["site"]?>',
	'',
	'',
	'',
	'<?=$sp?>',
	'<?=$page_content[CALENDAR_ID]?>'

	);
</script>
<?
}
else
{
?>
<script type="text/javascript">

	navigate_en('<?=$tmonth?>','<?=$tyear?>','','<?=$_CONFIG["global"]["paths"]["site"]?>',
	'',
	'',
	'',
	'<?=$sp?>',
	'<?=$page_content[CALENDAR_ID]?>'

	);
</script>
<?
}
?>