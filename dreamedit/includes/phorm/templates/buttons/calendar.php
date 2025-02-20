<?
global $_CONFIG;
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/jscalendar/calendar.inc.php";

echo "<img src=\"".$_CONFIG["global"]["paths"]["skin_path"]."images/buttons/".$btnName.".jpg\" id=\"button_".$btnName."_".$name."\" style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" width=\"17\" height=\"17\" alt=\"".Dreamedit::translate("Выбрать дату")."\" title=\"".Dreamedit::translate("Выбрать дату")."\" />";
?>

<script>
    Calendar.setup({
        inputField     :    "<?=$name?>",
        ifFormat       :    "%Y.%m.%d %H:%M",
        button         :    "button_<?=$btnName?>_<?=$name?>",
        showsTime      :    true,
        align          :    "br"
    });
</script>