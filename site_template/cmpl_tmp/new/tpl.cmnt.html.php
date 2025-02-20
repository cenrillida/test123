<?
$pg = new Pages();
//echo "____";

if (!empty($_TPL_REPLACMENT[AVATAR]))
{
?>
<img src=<?=@$_TPL_REPLACMENT[AVATAR]?> align='left'  />
<?
}
?>
<b> <?=@$_TPL_REPLACMENT["USER"]?></b>&nbsp;&nbsp;&nbsp;<span class="date"><?=@$_TPL_REPLACMENT["DATE"]?></span>

<br /><?=@$_TPL_REPLACMENT["TEXT"]?>
<?
if($_TPL_REPLACMENT["GO"])
{
?>
<a href="<?=$pg->getPageUrl($_TPL_REPLACMENT["FULL_ID"], array("id" => $_TPL_REPLACMENT["ID"], "p" => @$_REQUEST["p"]))?>">подробнее...</a>
<?
}?>
<br clear="all" /><br />&nbsp; <br />
