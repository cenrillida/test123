<?php
global $DB, $_CONFIG;

$ilines = new Ilines();
$ievent = new Events();

$ilineCount = $_SESSION['lang'] == "/en" ? $_TPL_REPLACMENT['ILINE_COUNT_EN'] : $_TPL_REPLACMENT['ILINE_COUNT'];

$rows = $ilines->getNewsByTids(array($_TPL_REPLACMENT['ILINE_ID']),0,$ilineCount);

$morePageId = $_TPL_REPLACMENT['ILINE_PAGE_ID'];

if(empty($morePageId)) {
    $morePageId = 502;
}
$colSize = 12;
$colSizeMd = 6;
$colSizeLg = 4;

if(!empty($_TPL_REPLACMENT['COL_SIZE'])) {
    $colSize = $_TPL_REPLACMENT['COL_SIZE'];
}
if(!empty($_TPL_REPLACMENT['COL_SIZE_MD'])) {
    $colSizeMd = $_TPL_REPLACMENT['COL_SIZE_MD'];
}
if(!empty($_TPL_REPLACMENT['COL_SIZE_LG'])) {
    $colSizeLg = $_TPL_REPLACMENT['COL_SIZE_LG'];
}

if(!empty($rows))
{
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <?php
            foreach ($rows as $k => $v) {
                $moreId = "";
                if(!$_TPL_REPLACMENT['ILINE_PAGE_ID_LIST']) {
                    $moreId = "&id={$v['el_id']}";
                }
                $dt = DateTime::createFromFormat("Y.m.d H:i",$v['date']);
                ?>
                <div class="col-<?=$colSize?> col-md-<?=$colSizeMd?> col-lg-<?=$colSizeLg?> pb-3">
                    <div class="shadow bg-white p-3 h-100 position-relative">
                        <div class="row">
                            <div class="col-12">
                                <div class="news-element">
                                    <span class="date"><b><?=$dt->format("d.m.Y")?><?php if($_SESSION['lang']!="/en") echo ' г.';?></b><br></span>
                                    <?php if($_SESSION['lang']!="/en"):?>
                                        <?= $v["last_text"] ?>
                                        <p><a target="_blank" href="/index.php?page_id=<?=$morePageId.$moreId?>">подробнее...</a></p>
                                    <?php else:?>
                                        <?= $v["last_text_en"] ?>
                                        <p><a target="_blank" href="/en/index.php?page_id=<?=$morePageId.$moreId?>">more...</a></p>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <a href="<?=$_SESSION['lang']?>/index.php?page_id=<?=$morePageId.$moreId?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}?>