<div class="col-12 col-md-<?= $_TPL_REPLACMENT["MD"] ?> col-lg-<?= $_TPL_REPLACMENT["LG"] ?> pb-3">
    <div class="shadow bg-white p-3 h-100 position-relative">
        <?php if($_TPL_REPLACMENT['DATE_SHOW']):?>
            <div class="row">
                <div class="col-12 text-right">
                    <div style="color: darkgrey;"><?=substr($_TPL_REPLACMENT['DATE_SHOW'],8,2).'.'.substr($_TPL_REPLACMENT['DATE_SHOW'],5,2).'.'.substr($_TPL_REPLACMENT['DATE_SHOW'],0,4).' г.'?></div>
                </div>
            </div>
        <?php endif;?>
        <div class="row">
            <div class="col-12">
                <div class="news-element">
                    <?= $_TPL_REPLACMENT["LAST_TEXT"] ?>
                    <p><a target="_blank" href="/index.php?page_id=502&amp;id=<?=$_TPL_REPLACMENT["EL_ID"] ?>">подробнее...</a></p>
                </div>
            </div>
        </div>
        <a target="_blank" href="/index.php?page_id=502&amp;id=<?=$_TPL_REPLACMENT["EL_ID"] ?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
    </div>
</div>