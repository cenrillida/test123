<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" lang="ru-ru" dir="ltr" >
<head>
	<meta name="robots" content="index, follow" />
	<?php if ($_SESSION[lang]!="/en"): ?>
		<title><?=mb_convert_encoding($_TPL_REPLACMENT["TITLE"], "utf-8", "windows-1251")?></title>	
	<?php else: ?>
		<?php if ($_TPL_REPLACMENT["TITLE_EN"]!=""): ?>
			<title><?=@$_TPL_REPLACMENT["TITLE_EN"]?></title>	
		<?php else: ?>
			<title><?=mb_convert_encoding($_TPL_REPLACMENT["TITLE"], "utf-8", "windows-1251")?></title>	
		<?php endif ?>
	<?php endif ?>
	<?php header("Content-Type: text/html; charset=utf-8");?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="keywords" content="<?=@$_TPL_REPLACMENT["KEYWORDS"]?>">
	<meta name="description" content="<?=@$_TPL_REPLACMENT["DESCRIPTION"]?>">
<?
$pref='/';
   if ($_SESSION[lang]=="/en") $pref.="../"; 
   if ($_SESSION[jour]=="/jour" || $_SESSION[jour]=="/jour_cut") $pref.="../../"; 
  ?>	
	<link type="text/css" href="<?=@$pref?>css/style.css?ver=<?php echo filemtime($pref."css/style.css");?>" rel="stylesheet"/>
	<link type="text/css" href="<?=@$pref?>css/menu.css" rel="stylesheet"/>
	<link type="text/css" href="<?=@$pref?>css/jcarousel.connected-carousels.css" rel="stylesheet"/>
	
	
	<script type='text/javascript' src='/js/jquery.js?ver=1.8.3'></script>
	<script type="text/javascript" src="/js/custom.js"></script> 

	<script type="text/javascript" src="/js/jcarousel2.js"></script> 
	<script type="text/javascript" src="/js/jquery.jcarousel.min.js"></script> 
	<script type="text/javascript" src="/js/jcarousel.connected-carousels.js"></script> 
	
	<!--<script type="text/javascript" src="/js/jquery.snow.min.1.0.js"></script>
	<script>
		jQuery(document).ready( function(){
		    jQuery.fn.snow({ minSize: 5, maxSize: 50, newOn: 300, flakeColor: '#FFFFFF' });
		});
	</script>
	<?php if ($_GET[snow]==2): ?>
	<script type="text/javascript" src="/js/jquery.snow.js"></script>
	<script>
		jQuery(document).ready( function(){
		    jQuery.fn.snow({ minSize: 5, maxSize: 50, newOn: 300, flakeColor: '#FFFFFF' });
		});
	</script>
	<?php endif ?> -->
<?	
	if(!$_SESSION[lang]=="/en")
{
?>

<script type="text/javascript" src="./js/super_calendar.js"></script>
<?
}
else
{
?>   
   <script type="text/javascript" src="../js/super_calendar_en.js"></script>
<?
  }
?>
	
	<!--[if IE 7.0]>
	<link rel="stylesheet" type="text/css" href="css/style_ie7.css" />
	<![endif]-->
	
	</head>
<body class="home blog">