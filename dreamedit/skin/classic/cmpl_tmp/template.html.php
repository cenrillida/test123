<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=@$_TPL_REPLACMENT["TITLE"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=@$_TPL_REPLACMENT["CHARSET"]?>"> 
<meta name="robots" content="noindex,nofollow">
<base href="https://<?=@$_TPL_REPLACMENT["SITE"]?><?=@$_TPL_REPLACMENT["ADMIN_DIR"]?>" />
<meta name="keywords" content="" />
<meta name="description" content="<?=@$_TPL_REPLACMENT["DESCRIPTION"]?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />

<link rel="stylesheet" type="text/css" href="<?=@$_TPL_REPLACMENT["SKIN_PATH"]?>de_style.css" />

<?=@$_TPL_REPLACMENT["CSS"]?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
<script type="text/javascript" src="js/de_action.js?v=3"></script>
<script type="text/javascript" src="js/de_default.js"></script>
<script type="text/javascript" src="js/de_menu.js"></script>
    <?php if($_GET[debug]!=1): ?>
<script type="text/javascript" src="includes/FCKEditor/fckeditor.js"></script>
        <?=@$_TPL_REPLACMENT["JSCRIPT"]?>
    <?php endif;?>

    <script type="text/javascript" src="includes/ckeditor/ckeditor.js"></script>
</head>

<!-- функция setSize() может принимать в кач-ве параметра ширину левого рабочего блока для удобства отображения информации в нем. Впоследствии может потребоваться для некоторых модулей -->
<body onload="setSize(<?=@$_TPL_REPLACMENT["LEFT_WIDTH"]?>); activateActionPanel(); loading();" onresize="setSize(<?=@$_TPL_REPLACMENT["LEFT_WIDTH"]?>);">
<div class="loading" style="DISPLAY: block;" id="loading"><br /><?=Dreamedit::translate("Загрузка...");?></div>
<table width="100%">
	<tr valign="top" class="top_row">
		<td><div style="WIDTH: 10px; FONT-SIZE: 1px;"></div></td>
		
		<td><div style="WIDTH: 5px; FONT-SIZE: 1px;"></div></td>
		
		<td>
			<div style="WIDTH: 200px;">
				<a href="<?=@$_TPL_REPLACMENT["DE_LINK"]?>" title="<?=@$_TPL_REPLACMENT["TITLE"]?>" target="_blank"><img src="<?=@$_TPL_REPLACMENT["SKIN_PATH"]?>images/<?=@$_TPL_REPLACMENT["LOGO_IMG"]?>" width="107" height="49" class="logo" alt="<?=@$_TPL_REPLACMENT["TITLE"]?>" title="<?=@$_TPL_REPLACMENT["TITLE"]?>" /></a>
				<div><?=@$_TPL_REPLACMENT["VERINFO"]?></div>
			</div>
		</td>
		
		<td><div style="WIDTH: 5px; FONT-SIZE: 1px;"></div></td>

		<td width="100%">
			<div class="button_block" id="button_block">
				<!-- место расположения кнопок-действий модулей -->
				<?=@$_TPL_REPLACMENT["BUTTON_BLOCK"]?>
			</div>
		</td>

		<td><div style="WIDTH: 5px; FONT-SIZE: 1px;"></div></td>
	</tr>

	<tr><td colspan="6"><div style="HEIGHT: 5px; FONT-SIZE: 1px;"></div></td></tr>
</table>

<table width="100%">
	<tr valign="top">
		<!--td>
			<div class="menu_block" id="menu_block"><img src="<?=@$_TPL_REPLACMENT["SKIN_PATH"]?>images/menu_top.gif" width="45" height="6" /><br /-->
				
				<!-- место расположение меню -->
				<!--a href=""><img src="<?=@$_TPL_REPLACMENT["SKIN_PATH"]?>images/action/set_de.gif" width="32" height="32" /></a>
				<a href=""><img src="<?=@$_TPL_REPLACMENT["SKIN_PATH"]?>images/action/set_db.gif" width="32" height="32" /></a-->
				<!--br /><br /><br />

			<img src="<?=@$_TPL_REPLACMENT["SKIN_PATH"]?>images/menu_bottom.gif" width="45" height="6" /></div>
			<div style="WIDTH: 10px; FONT-SIZE: 1px;"></div-->
		</td>
		
		<td><div style="WIDTH: 5px; FONT-SIZE: 1px;"></div></td>
		
		<td height="100%">
			<h2><?=@$_TPL_REPLACMENT["TITLE"]?></h2>
			<div class="left_block" id="left_block">
				<!-- левый рабочий блок -->
				<?=@$_TPL_REPLACMENT["LEFT_BLOCK"]?>
			</div>
		</td>
		

		<td><div style="WIDTH: 5px; FONT-SIZE: 1px;"></div></td>
		
		<td>
			<h2><?=@$_TPL_REPLACMENT["ACTION_TITLE"]?></h2>
			<div class="right_block" id="right_block">
				<!-- правый (основной) рабочий блок -->
				<?=@$_TPL_REPLACMENT["RIGHT_BLOCK"]?>
			</div>
		</td>
		
		<td><div style="WIDTH: 5px; FONT-SIZE: 1px;"></div></td>
	</tr>

	<tr><td colspan="6"><div style="HEIGHT: 5px; FONT-SIZE: 1px;"></div></td></tr>

</table>

</body>
</html>
				