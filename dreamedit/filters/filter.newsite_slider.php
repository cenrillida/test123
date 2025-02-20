<?
global $DB,$_CONFIG;
$ilines = new Ilines();

if($_SESSION[lang]!="/en")
    $sliderMain = $ilines->getLimitedElementsMultiSort(25, 6, "date","DATE", "DESC", "status");
else
    $sliderMain = $ilines->getLimitedElementsMultiSort(25, 6, "date","DATE", "DESC", "status_en");
$sliderMain = $ilines->appendContent($sliderMain);

if ($_TPL_REPLACMENT["INDEX_VIDEO_EMBED_STATUS"] == 1) {
    ?>
    <div style="position: relative;	padding-bottom: 56.25%; padding-top: 25px; height: 0;">
        <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                src="https://<?=$_TPL_REPLACMENT['INDEX_VIDEO_EMBED_URL']?>?autoplay=1&rel=0" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>

    <?php
}
elseif ($_GET['live_video_iframe']==1) {
    ?>
    <div style="position: relative;	padding-bottom: 56.25%; padding-top: 25px; height: 0;">
        <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                src="https://playercdn.cdnvideo.ru/aloha/players/mid_player_html5_org.html?autoplay=1&rel=0" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>

    <?php
}
elseif ($_GET['live_video']==1) {
    ?>
    <div style="position: relative;	padding-bottom: 56.25%; height: 0;">
        <div style="position: absolute; width: 100%; height: 100%">
            <div style="position: relative;	padding-bottom: 100%; height: 0;">
                <video style="width: 100%; height: 56.25%; position: absolute" controls="true" autoplay><source src="http://live.mid.cdnvideo.ru/mid/mid.hd/playlist.m3u8" type="video/mp4" /> </video>
            </div>
        </div>
    </div>

    <?php
}
elseif ($_GET['live_video2']==1) {
    ?>

    <div style="position: relative;	padding-bottom: 56.25%; height: 0;">
        <div style="position: absolute; width: 100%; height: 100%">
            <div style="position: relative;	padding-bottom: 100%; height: 0;">
                <video id='hls-example' class="video-js vjs-default-skin" style="width: 100%; height: 56.25%; position: absolute" controls="true" autoplay><source src="https://live-mid.cdnvideo.ru/mid/mid.org/playlist.m3u8" type="video/mp4" /> </video>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://playercdn.cdnvideo.ru/aloha/clappr/clappr4.min.js"></script>
    <script type="text/javascript" src="https://playercdn.cdnvideo.ru/aloha/clappr/level-selector.min.js"></script>
    <script type="text/javascript" src="https://playercdn.cdnvideo.ru/aloha/clappr/clappr-error-handler.min.js"></script>

    <script>
        document.write('<div id="player"></div>');


        var player = new Clappr.Player({
            language: 'en-EN',
            parentId: "#player",
            source: "//live-mid.cdnvideo.ru/mid/mid.org/playlist.m3u8",
            width: '100%',
            height: '56.25%',                                                                                                                                                                                                                                                                                                                                                                                                                                    mediacontrol: {
            },
            plugins: [
                LevelSelector,
                ClapprErrorHandler,
            ],
            playback: {
            },
            levelSelectorConfig: {
                labelCallback: function(playbackLevel) {
                    return playbackLevel.level.height+'p';
                }
            },
            clapprErrorHandler: {
                text: 'There is no broadcast now. Please come back later.',											},
        });
    </script>
    <?php
}
elseif ($_TPL_REPLACMENT["INDEX_VIDEO_PL_EMBED_STATUS"] == 1) {
    if(empty($_TPL_REPLACMENT["INDEX_VIDEO_PL_HEIGHT"])) {
        $_TPL_REPLACMENT["INDEX_VIDEO_PL_HEIGHT"] = "56.25%";
    }
    ?>

    <style>
        [data-player] {
            position: absolute;
        }
        <?php
    preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT["INDEX_VIDEO_PL_BANNER"], $imgSrc);
    $imgSrc = array_pop($imgSrc);
    if (!empty($imgSrc)) {
        ?>
        .player-poster[data-poster] {
            background-image: url('<?=$imgSrc[0]?>');
        }
        <?php

    }
    ?>
    </style>

    <div style="position: relative;	padding-bottom: <?=$_TPL_REPLACMENT["INDEX_VIDEO_PL_HEIGHT"]?>; height: 0;">
        <div style="position: absolute; width: 100%; height: 100%">
            <div style="position: relative;	padding-bottom: 100%; height: 0;">
                <div id="player" style="padding-bottom: 100%;"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://playercdn.cdnvideo.ru/aloha/clappr/clappr4.min.js"></script>
    <script type="text/javascript" src="https://playercdn.cdnvideo.ru/aloha/clappr/level-selector.min.js"></script>
    <script type="text/javascript" src="https://playercdn.cdnvideo.ru/aloha/clappr/clappr-error-handler.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr-google-ima-html5-preroll-plugin@latest/dist/clappr-google-ima-html5-preroll-plugin.min.js"></script>

    <script>
        $(document).ready(function() {
            var player = new Clappr.Player({
                language: 'en-EN',
                parentId: "#player",
                source: "<?=$_TPL_REPLACMENT["INDEX_VIDEO_PL_EMBED_URL"]?>",
                width: '100%',
                autoPlay: true,
                mute: true,
                height: '<?=$_TPL_REPLACMENT["INDEX_VIDEO_PL_HEIGHT"]?>', mediacontrol: {},
                plugins: [
                    LevelSelector,
                    ClapprErrorHandler,
                ],
                playback: {},
                levelSelectorConfig: {
                    labelCallback: function (playbackLevel) {
                        return playbackLevel.level.height + 'p';
                    }
                },
                clapprErrorHandler: {
                    text: 'There is no broadcast now. Please come back later.',
                },
            });
        });
    </script>
    <?php
}
else {

    if (!empty($sliderMain)):?>
        <div id="carouselSlider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators main-carousel-indicators">
                <?php for ($i = 0; $i < count($sliderMain); $i++): ?>
                    <li data-target="#carouselSlider"
                        data-slide-to="<?= $i ?>"<?php if ($i == 0) echo ' class="active"'; ?>></li>
                <?php endfor; ?>
            </ol>
            <div class="carousel-inner">
                <?php $first = true;
                foreach ($sliderMain as $sliderElement):
                    preg_match_all('@src="([^"]+)"@', $sliderElement["content"]['PHOTO'], $imgSrc);
                    preg_match_all('@alt="([^"]+)"@', $sliderElement["content"]['PHOTO'], $imgAlt);
                    $imgSrc = array_pop($imgSrc);
                    if (empty($imgSrc))
                        continue;
                    $imgAlt = array_pop($imgAlt);
                    ?>
                    <div class="carousel-item<?php if ($first) {
                        echo " active";
                        $first = false;
                    } ?>">
                        <div>
                            <img class="d-block w-100 position-absolute overlay-bottom-null"
                                 src="<?= $imgSrc[0] ?>?auto=yes&bg=666&fg=444&text=Third slide"<?php if (!empty($imgAlt)) echo ' alt="' . $imgAlt[0] . '"'; ?>>
                            <img class="d-block w-100"
                                 src="<?= $imgSrc[0] ?>?auto=yes&bg=666&fg=444&text=Third slide"<?php if (!empty($imgAlt)) echo ' alt="' . $imgAlt[0] . '"'; ?>>
                            <div class="position-absolute img-ton img-ton-lighter">
                                <a href="<?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["URL"]; else echo $sliderElement['content']["URL_EN"] ?>"
                                   class="w-100 h-100 position-absolute"></a>
                            </div>
                        </div>
                        <div class="carousel-caption main-carousel-caption d-block">
                            <a class="text-white"
                               href="<?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["URL"]; else echo $sliderElement['content']["URL_EN"] ?>">
                                <h3 class="font-weight-bold"><?php if ($_SESSION[lang] != "/en") echo $sliderElement['content']["TITLE"]; else echo $sliderElement['content']["TITLE_EN"] ?></h3>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev main-carousel-control-prev" href="#carouselSlider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next main-carousel-control-next" href="#carouselSlider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <?php if($_GET[newyear]==1):?>
            <style>
                .snow {
                    width: 7px;
                    height: 7px;
                }
            </style>
            <div class="position-absolute w-100 h-100 overlay-top-left-null overflow-hidden">
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                    <div class="snow"></div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif;
}

?>
