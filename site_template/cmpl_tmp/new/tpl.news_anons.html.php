<?
$pg = new Pages();
?>
<div class="extra-wrap"><table><tbody><tr>
            <?php if($_TPL_REPLACMENT[MESSAGE_ICON] != 'off'): ?>
                    <td valign="top"><i class="fas fa-angle-double-right" style="color: #002c4c; margin-right: 7px; font-size: 19px;"></i>&nbsp;&nbsp;</td>
            <?php endif; ?>
            <td>
<?
    /*if($_GET[debug]==2 && $_TPL_REPLACMENT[ANONS] == 'on'):?>
        <div class="anons-header-type" <? if($_GET['var']==2) echo 'style="margin-bottom: 7px;"';?>>
            <?=$_TPL_REPLACMENT[EVENT_TEXT]?>
        </div>
        <? if($_GET['var']==2):?>
        <br>
    <? endif;
    endif;*/

    if ($_TPL_REPLACMENT[ANONS] == 'on')
        echo "<div style='color: darkgreen'>" . $_TPL_REPLACMENT["DATE"] . " | <i class=\"far fa-clock\"></i> " . $_TPL_REPLACMENT["TIME"] . "</div>";


?>
<?=@$_TPL_REPLACMENT["PREV_TEXT"]?>
<?
if($_TPL_REPLACMENT["GO"])
{
	if($_SESSION[lang]!='/en')
	{
	?>
	<a href="<?=$pg->getPageUrl($_TPL_REPLACMENT["FULL_ID"], array("id" => $_TPL_REPLACMENT["ID"], "p" => @$_REQUEST["p"]))?>">подробнее...</a>
	<?
	}
	else
	{
	?>
	<a href="/en<?=$pg->getPageUrl($_TPL_REPLACMENT["FULL_ID"], array("id" => $_TPL_REPLACMENT["ID"], "p" => @$_REQUEST["p"]))?>">more...</a>
	<?
	}	
}?>
</td></tr></tbody></table></div>