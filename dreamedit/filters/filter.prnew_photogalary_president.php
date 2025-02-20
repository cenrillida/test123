<?php
global $DB, $_CONFIG;

if(true) {
    $ilines = new Ilines();

    if($_SESSION[lang]!="/en")
        $sliderMain = $ilines->getLimitedElementsMultiSort(12, 6, "date","DATE", "DESC", "status");
    else
        $sliderMain = $ilines->getLimitedElementsMultiSort(12, 6, "date","DATE", "DESC", "status_en");
    $sliderMain = $ilines->appendContent($sliderMain);
if(!empty($sliderMain)) {
    ?>

    <div class="col-12">
        <div class="shadow border bg-white p-3 h-100">
            <div class="row">
                <div class="col-12">

                    <div id="carouselSlider" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $first = true;
                            foreach ($sliderMain as $sliderElement):
                                ?>
                                <div class="carousel-item<?php if ($first) {
                                    echo " active";
                                    $first = false;
                                } ?>">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-8 my-auto">
                                                <img class="d-block w-100"
                                                     src="<?= $sliderElement["content"]['PHOTO_H'] ?>?auto=yes&bg=666&fg=444&text=Third slide"<?php if (!empty($imgAlt)) echo ' alt="' . $imgAlt[0] . '"'; ?>>
                                            </div>
                                            <div class="col-4 my-auto">
                                                <img class="d-block w-100"
                                                     src="<?= $sliderElement["content"]['PHOTO_V'] ?>?auto=yes&bg=666&fg=444&text=Third slide"<?php if (!empty($imgAlt)) echo ' alt="' . $imgAlt[0] . '"'; ?>>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="pr-photo-text"></div>
                                            <div class="col-12 my-auto text-center">
                                                <?php if(!empty($sliderElement['content']["URL"])): ?>
                                                    <a target="_blank" class=""
                                                       href="<?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["URL"]; else echo $sliderElement['content']["URL_EN"] ?>">
                                                        <h5 class="font-weight-bold"><?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["TITLE"]; else echo $sliderElement['content']["TITLE_EN"] ?></h5>
                                                    </a>
                                                <?php else: ?>
                                                    <h5 class="font-weight-bold"><?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["TITLE"]; else echo $sliderElement['content']["TITLE_EN"] ?></h5>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselSlider" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselSlider" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

<!--                    <div class="red-pl">Фоторепортаж</div>-->
                </div>
            </div>
        </div>
    </div>

    <?php
}
}



?>