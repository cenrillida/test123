<?php
global $DB, $_CONFIG;

$ilines = new Ilines();
$ievent = new Events();

$rows = $ilines->getLimitedElementsMultiSortMainNewFunc($page_content["NEWS_BLOCK_LINE"], 12, 1, "DATE", "DESC", "status",492,408);

if(!empty($rows))
{
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            foreach ($rows as $k => $v) {
            ?>
            <div class="col-12 col-md-6 col-lg-4 pb-3">
                <div class="shadow bg-white p-3 h-100 position-relative">
                    <div class="row">
                        <div class="col-12">
                            <div class="news-element">
                                <?= $v["final_text"] ?>
                                <p><a target="_blank" href="/index.php?page_id=502&amp;id=<?=$v[el_id]?>">подробнее...</a></p>
                            </div>
                        </div>
                    </div>
                    <a target="_blank" href="/index.php?page_id=502&amp;id=<?=$v[el_id]?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                </div>
            </div>
                <?php
            }
                ?>
        </div>
    </div>
    <?php
}?>