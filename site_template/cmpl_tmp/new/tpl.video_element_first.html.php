<div class="col-12 pb-3">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="mx-auto p-3 text-left container-fluid shadow bg-white mb-3 position-relative h-100">
                <div class="row">
                    <div class="col-12">
                        <div class="img-block position-relative">
                            <img src="<?= $_TPL_REPLACMENT['PHOTO_STOP'] ?>" alt=""
                                 class="w-100 box-img-100">
                            <div class="video-iframe-button-div">
                                <button class="btn btn-<?php if($_TPL_REPLACMENT['TEMPL']=="red") echo "danger"; else echo "secondary";?>" type="button"
                                        onclick="javascript:doPopup('<?php if (substr($_TPL_REPLACMENT['YOUTUBE_URL'], 0, 5) == "http:") {
                                            echo "http://";
                                            $_TPL_REPLACMENT['YOUTUBE_URL'] = str_replace("http://", "", $_TPL_REPLACMENT['YOUTUBE_URL']);
                                        } else echo "//"; ?><?= $_TPL_REPLACMENT['YOUTUBE_URL'] . $_TPL_REPLACMENT["PARAMS"] ?>', <?= $_TPL_REPLACMENT["PAR"] ?>)">
                                    <i class="fas fa-video"></i> <?php if($_SESSION[lang]!="/en") echo "Смотреть"; else echo "Watch";?>
                                </button>
                            </div>
                        </div>
                        <div class="text-video-classic text-video-100"><?= $_TPL_REPLACMENT["DATE"] ?>
                            - <?=$_TPL_REPLACMENT["TITLE"]?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>