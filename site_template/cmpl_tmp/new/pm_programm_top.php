<section<?php if($_GET[debug]==3) echo ' class="bg-pm-cht"';?>>
    <section class="pt-3 pb-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-xs-12 pt-3 pb-3 pr-xl-4 text-center">
                    <?php
                    if($_SESSION[lang]!="/en") {
                        preg_match_all('@src="([^"]+)"@', $parent_page["LOGO"], $imgSrc);
                        preg_match_all('@alt="([^"]+)"@', $parent_page["LOGO"], $imgAlt);
                    } else {
                        preg_match_all('@src="([^"]+)"@', $parent_page["LOGO_EN"], $imgSrc);
                        preg_match_all('@alt="([^"]+)"@', $parent_page["LOGO_EN"], $imgAlt);
                    }
                    $imgSrc = array_pop($imgSrc);
                    $imgAlt = array_pop($imgAlt);
                    ?>
                    <img src="<?=$imgSrc[0]?>" alt="<?=$imgAlt[0]?>">
                </div>
            </div>
        </div>
    </section>
    <section class="pt-2 pb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-xs-12 pt-3 pb-3 pr-xl-4">
                    <div class="container-fluid">
                        <nav>
                            <div class="container row justify-content-center nav-menu-container">
                                <?php foreach ($menu_elements_pages as $menu_element_page):
                                    if($_SESSION[lang]!="/en") {
                                        $menu_page_name = $menu_element_page['page_name'];
                                    } else {
                                        $menu_page_name = $menu_element_page['page_name_en'];
                                    }
                                    $programm_current = "";
                                    if($menu_element_page['page_id']==$_REQUEST['page_id']) {
                                        $programm_current = " programm-menu-element-hover-current";
                                    }
                                    ?>
                                    <div class="py-3 px-2 mx-3 col-auto text-uppercase programm-menu-element position-relative">
                                        <a href="<?=$_SESSION['lang']?>/index.php?page_id=<?=$menu_element_page['page_id']?>"><?=$menu_page_name?></a>
                                        <a href="<?=$_SESSION['lang']?>/index.php?page_id=<?=$menu_element_page['page_id']?>" class="position-absolute overlay-top-left-null h-100 w-100 programm-menu-element-hover<?=$programm_current?>"></a>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>