<?
global $_CONFIG;

echo "<img src=\"".$_CONFIG["global"]["paths"]["skin_path"]."images/buttons/".$btnName.".jpg\" onclick=\"buttons_".$name."_".$btnName."()\" style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" alt=\"".Dreamedit::translate("—генерировать пароль")."\" title=\"".Dreamedit::translate("—генерировать пароль")."\" width=\"17\" height=\"17\" />";
?>

<script>
function buttons_<?=$name."_".$btnName?>()
{
	var letNum = 8; // кол-во символов в пароле
	var letters = "qwertyuiopasdfghjklzxcvbnm1234567890"; // символы дл€ генерации парол€

	var obj0 = getObj("<?=$name?>");
	if(!obj0)
		return;
	
	var retPass = "";
	for(var i = 0; i < letNum; i++)
		retPass += letters.charAt(Math.floor(Math.random() * letters.length));

	obj0.value = retPass;

	var obj2 = getObj("<?=$name?>_1");
	if(obj2)
		obj2.value = retPass;
}
</script>