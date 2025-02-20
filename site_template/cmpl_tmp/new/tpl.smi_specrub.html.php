<?
if($_SESSION['lang']!='/en') {
    $newText = "Новое";
} else {
    $newText = "New";
}
$pg = new Pages();
?>

<div class="<?php if($_TPL_REPLACMENT["ROW_COUNT"]!=1) echo 'col-lg-4 col-md-6';?> col-12 p-2">
    <div class="bg-color-lightgray h-100 p-3 img-in-text-margin"<?php if(!empty($_TPL_REPLACMENT["COMMENT_COLOR"])) echo ' style="background-color: '.$_TPL_REPLACMENT["COMMENT_COLOR"].' !important;"'?>>
        <?php if($_TPL_REPLACMENT['NEW']==1):?>
            <div class="new-badge"><?=$newText?></div>
        <?php endif;?>

        <?php if ($_SESSION[lang]!="/en"): ?>
        <p><span class="act-comments-element-date" style="font-size: 13px; border-bottom: 1px solid #999;border-right: 1px solid #999; padding-right: 4px; padding-bottom: 1px; padding-left: 5px; color: #999;"><?=substr($_TPL_REPLACMENT["DATE"], 0, 10)."</span>&nbsp;&nbsp;<b style=\"font-size: 15px;\">"?><?php if(!empty($_TPL_REPLACMENT['PDF_FILE'])) echo "<a href=\"".$_TPL_REPLACMENT['PDF_FILE']."\" target=\"_blank\">".$_TPL_REPLACMENT["TITLE"]."</a>"; else echo @$_TPL_REPLACMENT["TITLE"];?></b></p>
            <?=@$_TPL_REPLACMENT["PREV_TEXT"]?>
            <?
            else:
            ?>
        <p><span class="act-comments-element-date" style="font-size: 13px; border-bottom: 1px solid black;border-right: 1px solid black;padding-right: 4px;padding-bottom: 1px; padding-left: 5px;"><?=substr($_TPL_REPLACMENT["DATE"], 0, 10)."</span>&nbsp;&nbsp;<b style=\"font-size: 15px;\">".@$_TPL_REPLACMENT["TITLE_EN"]?></b></p>
                <?=@$_TPL_REPLACMENT["PREV_TEXT_EN"]?>
                <?php endif; ?>

                <?
                if($_TPL_REPLACMENT["GO"])
                {
                    if($_SESSION[lang]!="/en"):
                        ?>
                        <a href="<?=$pg->getPageUrl($_TPL_REPLACMENT["FULL_ID"], array("id" => $_TPL_REPLACMENT["ID"]))?>">подробнее...</a>
                    <?
                    else:
                        ?>
                        <a href="/en<?=$pg->getPageUrl($_TPL_REPLACMENT["FULL_ID"], array("id" => $_TPL_REPLACMENT["ID"]))?>">more...</a>
                    <?
                    endif;
                }?>
    </div>
</div>