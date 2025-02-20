<?php

$photogalaryid=$_TPL_REPLACMENT['ILINE_ID'];

$ilines = new Ilines();

if($_SESSION[lang]!="/en")
    $sliderMain = $ilines->getLimitedElementsMultiSort($photogalaryid, 9999, "date","DATE", "DESC", "status");
else
    $sliderMain = $ilines->getLimitedElementsMultiSort($photogalaryid, 9999, "date","DATE", "DESC", "status_en");
$sliderMain = $ilines->appendContent($sliderMain);
if(!empty($sliderMain)) {
    echo '<div class="container-fluid"><div class="row justify-content-center">';
    ?>

            <?php $first = true;
            $count = 1;
            $modalSize = "";
            switch ($_TPL_REPLACMENT['MODAL_SIZE']) {
                case 'Маленькое':
                    $modalSize = "modal-sm";
                    break;
                case 'Среднее':
                    $modalSize = "modal-lg";
                    break;
                case 'Большое':
                    $modalSize = "modal-xl";
                    break;
                default:
                    $modalSize = "";
            }
            foreach ($sliderMain as $sliderElement):
                preg_match_all( '@src="([^"]+)"@' , $sliderElement['content']['PHOTO'], $imgSrc );
                preg_match_all( '@alt="([^"]+)"@' , $sliderElement['content']['PHOTO'], $imgAlt );
                $imgSrc = array_pop($imgSrc);
                $imgAlt = array_pop($imgAlt);
                if($_SESSION['lang']!="/en") {
                    $title = $sliderElement['content']['TITLE'];
                    $link = $sliderElement['content']['URL'];
                    $modalText = $sliderElement['content']['MODAL_TEXT'];
                } else {
                    $title = $sliderElement['content']['TITLE_EN'];
                    $link = $sliderElement['content']['URL_EN'];
                    $modalText = $sliderElement['content']['MODAL_TEXT_EN'];
                }
                if(!empty($link)) {
                    $content = "<a href=\"{$link}\"><img src=\"{$imgSrc[0]}\" alt=\"{$imgAlt[0]}\"></a>";
                } else {
                    $elementModal = new ModalWindow(
                        "<img src=\"{$imgSrc[0]}\" alt=\"{$imgAlt[0]}\">",
                        "modalElement".$_TPL_REPLACMENT["SORT"].$count,
                        $title,
                        $modalText,
                        "modal_element_id".$_TPL_REPLACMENT["SORT"].$count,
                        ""
                    );
                    if(!empty($modalText)) {
                        $elementModal->echoModalWindow($modalSize);
                    }
                }

                ?>
                <div class="col-4 col-md-2 col-lg-1d5 mb-3 my-md-auto pb-3">
                    <div class="align-bottom text-center position-relative shelf-book hover-highlight hover-highlight-center-dark">
                        <div class="book shadow mx-auto" data-toggle="tooltip" data-placement="top" data-html="true" title="<?=$title?>">
                            <?php if(!empty($link)):?>
                                <?=$content?>
                            <?php else:?>
                                <?php $elementModal->echoButton($_TPL_REPLACMENT["SORT"].$count,"");?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>

            <?php $count++; endforeach; ?>

<?php
    echo '</div></div>';
}