<?
global $_CONFIG;

if($_GET[debug]==5) {
    var_dump($generate_fields);
}

echo "<img src=\"".$_CONFIG["global"]["paths"]["skin_path"]."images/buttons/".$btnName.".png\" onclick=\"buttons_".$name."_".$btnName."()\" style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" alt=\"".Dreamedit::translate("Выбор цвета")."\" title=\"".Dreamedit::translate("Выбор цвета")."\" width=\"16\" height=\"16\" />";
?>

<script>
function buttons_<?=$name."_".$btnName?>()
{

    if(getObj('<?=$name?>').type=='text') {
        getObj('<?=$name?>').type = 'color';
    } else {
        getObj('<?=$name?>').type = 'text';
    }

}
</script>