<?
global $_CONFIG;
?>
<img src="<?=$_CONFIG["global"]["paths"]["skin_path"]?>images/buttons/<?=$btnName?>.jpg" onclick="buttons_<?=$name."_".$btnName?>();" style="CURSOR: hand; CURSOR: pointer;" align="absmiddle" width="17" height="17" alt="<?=Dreamedit::translate("Выбрать страницу")?>" title="<?=Dreamedit::translate("Выбрать страницу")?>" />


<script>
function buttons_<?=$name."_".$btnName?>()
{
	var obj = getObj("<?=$name?>");
	if(!obj)
		return;

	window.open("/<?=$_CONFIG["global"]["paths"]["admin_dir"]?>includes/phorm/templates/buttons/page_id_dialog.php?id=" + parseInt(obj.value) + "&name=<?=$name?>", "<?=$name?>", "width=500, height=600, scrollbars=1, resizable=1, top=" + ((screen.height - 600)  / 2) + ", left=" + ((screen.width - 500)  / 2)).focus();	
}
</script>