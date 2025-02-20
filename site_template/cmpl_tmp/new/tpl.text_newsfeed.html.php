<?
$pg = new Pages();
?>

<div class="col-12 col-md-6 mb-3">
    <div class="p-3 h-100 shadow position-relative" style="background-color: #f7f7f7">
        <div>
        <?php if ($_SESSION[lang]!="/en"): ?>
        <font size="2" class="act-comments-element-date" style="border-bottom: 1px solid #999;border-right: 1px solid #999; padding-right: 4px; padding-bottom: 1px; padding-left: 5px; color: #999;"><?=substr($_TPL_REPLACMENT["DATE"], 0, 10)."</font>&nbsp;&nbsp;<b style=\"font-size: 15px;\">".@$_TPL_REPLACMENT["TITLE"];?></b>
            <?=@$_TPL_REPLACMENT["FULL_TEXT"]?>
            <?
            else:
            ?>
            <font size="2" class="act-comments-element-date" style="border-bottom: 1px solid black;border-right: 1px solid black;padding-right: 4px;padding-bottom: 1px; padding-left: 5px;"><?=substr($_TPL_REPLACMENT["DATE"], 0, 10)."</font>&nbsp;&nbsp;<b style=\"font-size: 15px;\">".@$_TPL_REPLACMENT["TITLE_EN"]?></b>
                <?=@$_TPL_REPLACMENT["FULL_TEXT_EN"]?>
                <?php endif; ?>
        </div>
        <div class="news-upper-link position-absolute click-hand-link"><a href="<?=$_TPL_REPLACMENT["LINK"]?>" target="_blank"><i class="fas fa-hand-pointer"></i></a></div>
        <a href="<?=$_TPL_REPLACMENT["LINK"]?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true" target="_blank"></a>
    </div>
</div>