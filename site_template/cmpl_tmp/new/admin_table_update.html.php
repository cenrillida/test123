<?php
global $DB,$_CONFIG, $site_templater;
$path = str_replace('dreamedit/','',$_CONFIG['global']['paths']['admin_path']);
require_once($path."/js/dhtmlx/dhtmlxConnector/codebase/config.php");
require_once($path."/js/dhtmlx/dhtmlxConnector/codebase/grid_connector.php");

//error_reporting(E_ALL ^ E_NOTICE);
//print_r($_POST);

$id = (int)$_POST["ids"];

if ($_GET["c1"]!='1') $_GET["c5"]=0;

if($_GET["custom_act"] == "delete")
{
	$sql = 	"UPDATE article_send SET del='".date('Ymd')."' WHERE id = ".(int)$_GET["gr_id"];
	echo $sql;
	
	$res = mysql_query($sql);
	
	echo $res;
} 

IF (!empty($_POST[$id."_c8"]))
	{
	$sql = 	"UPDATE article_send SET  date_rez='".$_POST[$id."_c8"]."'
			WHERE  id=".$id;
	//echo $sql;
		
	$res = mysql_query($sql);
	}
//IF (!empty($_POST[$id."_c8"]))
IF ($_POST[$id."_c9"]!='')
	{
	
	$sql = 	"UPDATE article_send SET  rez_type='".$_POST[$id."_c9"]."'
			WHERE  id=".$id;
	//echo $sql;
		
	$res = mysql_query($sql);
	}	
	
	

IF (!empty($_POST[$id."_c11"]))
	{
	$sql = 	"UPDATE article_send SET  date_publ='".$_POST[$id."_c11"]."'
			WHERE  id=".$id;


	$res = mysql_query($sql);

	}	
	IF ($_POST[$id."_c9"]!='')
	{
	$sql = 	"UPDATE article_send SET  publ_type='".$_POST[$id."_c12"]."'
			WHERE  id=".$id;
	//echo $sql;
		
	$res = mysql_query($sql);
	}	
	
	
	
	//mysql_query('SET NAMES UTF-8');
	
	$test = $_POST[$id."_c10"];
    $test2 = iconv("UTF-8","cp1251",$test);
	
	
	$sql = 	"UPDATE article_send SET  primech_rez='".$test2."'
			WHERE  id=".$id;
	$res = mysql_query($sql);
	
	//echo $sql;
	
	$test = $_POST[$id."_c13"];
    $test2 = iconv("UTF-8","cp1251",$test);
	
	$sql = 	"UPDATE article_send SET  primech='".$test2."'
			WHERE  id=".$id;
	//echo $sql;


	$res = mysql_query($sql);
	
header("Content-Type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>
<data>
  <action sid="'.$id.'" tid="'.$id.'" type="updated"/>
</data>';
			
	


 
?>   