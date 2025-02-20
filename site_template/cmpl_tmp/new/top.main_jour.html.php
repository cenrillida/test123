<?php
global $_CONFIG, $site_templater;
$headers = new Headers();
$mainbanner = $headers->getJourBanner();
?>
<section class="pt-3 pb-0 bg-color-lightergray">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-8 col-xs-12 pt-3 pb-3 pr-xl-4">
                <div class="h-100 container-fluid left-column-container">
                    <div class="h-100 row shadow border bg-white printables">
                        <div class="col-12 pt-3 pb-3">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 py-3">
                                        <h3><?php if($_SESSION[lang]!="/en") echo $mainbanner[0]["page_name"]; else echo $mainbanner[0]["page_name_en"];?></h3>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <?php
                                        preg_match_all( '@src="([^"]+)"@' , $mainbanner[0]['logo_main'], $imgSrc );
                                        preg_match_all( '@alt="([^"]+)"@' , $mainbanner[0]['logo_main'], $imgAlt );
                                        $imgSrc = array_pop($imgSrc);
                                        $imgAlt = array_pop($imgAlt);
                                        $alt_str = "";
                                        if(!empty($imgAlt))
                                            $alt_str = ' alt="'.$imgAlt[0].'"';
                                        ?>
                                        <?php if(!empty($imgSrc)):?>
                                        <img class="border" src="<?=$imgSrc[0]?>" alt="<?=$alt_str?>">
                                        <?php endif;?>
                                    </div>
                                    <div class="col-12 col-sm-8">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if($_SESSION[lang]!="/en") echo $mainbanner[0]["logo_main_info"]; else echo $mainbanner[0]["logo_main_info_en"];?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-none d-xl-block pt-3 pb-3 px-xl-0 right-column">
                <div class="h-100 pr-3">
                    <div class="h-100 container-fluid">
                        <div class="h-100 row shadow border bg-white mb-3">
                            <div class="col-12 pt-5 pb-3">
                                <div class="box" id="quickPosts">
                                    <?
                                    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."last_number");
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
