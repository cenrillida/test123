<?
global $_CONFIG;

echo "<img src=\"".$_CONFIG["global"]["paths"]["skin_path"]."images/buttons/".$btnName.".jpg\" onclick=\"buttons_".$name."_".$btnName."()\" style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" width=\"17\" height=\"17\" alt=\"".Dreamedit::translate("Вставить кавычки")."\" title=\"".Dreamedit::translate("Вставить кавычки")."\" />";
?>

<script>
function buttons_<?=$name."_".$btnName?>()
{
	var obj = getObj("<?=$name?>");
	if(!obj)
		return;

	obj.focus();	
	var range = get_selection(window);
	range.text = String.fromCharCode(171) + range.text + String.fromCharCode(187);
	range.select();
}
</script>