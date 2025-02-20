<?php
global $DB, $_CONFIG, $site_templater, $page_content;

function addCollumn($array) {
    global $_CONFIG;
    $pg = new Pages();
        foreach ($array as $menuElementChild):
        if($_SESSION[lang]!="/en") {
            $menu_element_child_name = $menuElementChild["page_name"];
        } else {
            $menu_element_child_name = $menuElementChild["page_name_en"];
        }
        ?>
        <a class="py-2 d-none d-xl-inline-block w-100" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElementChild['page_id']?>"><?=$menu_element_child_name?></a>
    <?php
        $menu_element_sub = null;
        if(!$menuElementChild["notshowchilds"]) {
            if ($_SESSION[lang] != '/en') {
                //$menu_element_sub = $pg->getChildsJour($menuElementChild["page_id"],1,null,null,null,$_SESSION[jour],1);
                $menu_element_sub = $pg->getChildsMenu($menuElementChild[page_id], 1, null, null, null, 1);
            } else {
                //$menu_element_sub = $pg->getChildsJourEn($menuElementChild["page_id"], 1,null,null,null,$_SESSION[jour],1);
                $menu_element_sub = $pg->getChildsMenuEn($menuElementChild[page_id], 1, null, null, null, 1);
            }
        }
        foreach ($menu_element_sub as $menuElementSub):
            if (substr($menuElementSub[page_template],0,8)=='magazine')
                $prefjour="/jour/".$menuElementSub[page_journame];
            else
                $prefjour="";
            if($_SESSION[lang]!="/en") {
                $menu_element_sub_name = $menuElementSub["page_name"];
            } else {
                $menu_element_sub_name = $menuElementSub["page_name_en"];
            }
            if($prefjour==""):
        ?>
            <a class="py-2 d-none d-xl-inline-block w-100 sub-element" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElementSub['page_id']?>"><?=$menu_element_sub_name?></a>
        <?php else: ?>
                <a class="py-2 d-none d-xl-inline-block w-100 sub-element" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour?>"><?=$menu_element_sub_name?></a>
            <?php endif; endforeach;
        endforeach;
}

function addCollumnMobile($array) {
    global $_CONFIG;
    $pg = new Pages();
    echo "<div class='row'>";
    foreach ($array as $menuElementChild):
        if($_SESSION[lang]!="/en") {
            $menu_element_child_name = $menuElementChild["page_name"];
        } else {
            $menu_element_child_name = $menuElementChild["page_name_en"];
        }
        ?>
        <div class="col-12"><a class="py-2 d-inline-block w-100" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElementChild['page_id']?>"><?=$menu_element_child_name?></a></div>
        <?php
        $menu_element_sub = null;
        if(!$menuElementChild["notshowchilds"]) {
            if ($_SESSION[lang] != '/en') {
                //$menu_element_sub = $pg->getChildsJour($menuElementChild["page_id"],1,null,null,null,$_SESSION[jour],1);
                $menu_element_sub = $pg->getChildsMenu($menuElementChild[page_id], 1, null, null, null, 1);
            } else {
                //$menu_element_sub = $pg->getChildsJourEn($menuElementChild["page_id"], 1,null,null,null,$_SESSION[jour],1);
                $menu_element_sub = $pg->getChildsMenuEn($menuElementChild[page_id], 1, null, null, null, 1);
            }
        }
        foreach ($menu_element_sub as $menuElementSub):
            if (substr($menuElementSub[page_template],0,8)=='magazine')
                $prefjour="/jour/".$menuElementSub[page_journame];
            else
                $prefjour="";
            if($_SESSION[lang]!="/en") {
                $menu_element_sub_name = $menuElementSub["page_name"];
            } else {
                $menu_element_sub_name = $menuElementSub["page_name_en"];
            }
            if($prefjour==""):
                ?>
                <div class="col-12"><a class="py-2 d-inline-block w-100 sub-element" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElementSub['page_id']?>"><?=$menu_element_sub_name?></a></div>
            <?php else: ?>
                <div class="col-12"><a class="py-2 d-inline-block w-100 sub-element" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour?>"><?=$menu_element_sub_name?></a></div>
            <?php endif; endforeach;
    endforeach;
    echo '</div>';
    echo '<hr>';
}

$menu_start=1007;
$gray_menu=1549;
$pg = new Pages();

if ($_SESSION[lang]!='/en')
{
    $menuRes = $pg->getChildsJour($menu_start,1,null,null,null,$_SESSION[jour],1);
}
else
{
    $menuRes = $pg->getChildsJourEn($menu_start, 1,null,null,null,$_SESSION[jour],1);
}
if ($_SESSION[lang]!='/en')
{
    $menuGray = $pg->getChildsJour($gray_menu,1,null,null,null,$_SESSION[jour],1);
}
else
{
    $menuGray = $pg->getChildsJourEn($gray_menu, 1,null,null,null,$_SESSION[jour],1);
}

$addmenu = array();

$lang_link = "";

if ($_SESSION[lang]=='/en')
{
    if (!isset($_REQUEST[page]))
        if (str_replace("/en","",$_SERVER["REQUEST_URI"])=='') $lang_link="/";else $lang_link=str_replace("/en","",$_SERVER["REQUEST_URI"]);
    else
        $lang_link="/en/index.php?page_id=".$_REQUEST[page_id];
}
else
{
    if (!isset($_REQUEST[page]))
        $lang_link = rtrim("/en/".ltrim($_SERVER["REQUEST_URI"],"/"),"/");
    else
        $lang_link = "/en/index.php?page_id=".$_REQUEST[page_id];
}
if(!empty($_CONFIG['new_prefix']))
    $lang_link = str_replace($_CONFIG['new_prefix'],"",$lang_link);

$social_links = $DB->select("SELECT icon.icont_text AS icon, icon_link.icont_text AS icon_link, text.icont_text AS text, link.icont_text AS link FROM adm_directories_content AS ac INNER JOIN adm_directories_element AS ae ON ac.el_id=ae.el_id 
                              INNER JOIN adm_directories_content AS icon ON icon.el_id=ac.el_id AND icon.icont_var='icon' 
                              INNER JOIN adm_directories_content AS text ON text.el_id=ac.el_id AND text.icont_var='text' 
                              INNER JOIN adm_directories_content AS sort ON sort.el_id=ac.el_id AND sort.icont_var='sort' 
                              INNER JOIN adm_directories_content AS link ON link.el_id=ac.el_id AND link.icont_var='link' 
                              LEFT JOIN adm_directories_content AS icon_link ON icon_link.el_id=ac.el_id AND icon_link.icont_var='icon_link' 
                              LEFT JOIN adm_directories_content AS status ON status.el_id=ac.el_id AND status.icont_var='status' 
                              WHERE ae.itype_id=26 AND status.icont_text=1 GROUP BY ac.el_id ORDER BY sort.icont_text");

?>
<?php
if($_GET[gray_static]!=1) {
    echo "<div class='sticky-top'>";
}

if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_REQUEST[page_id])) {
    ?>
    <nav style="background-color: #171c22">
        <div class="container d-flex flex-column flex-md-row justify-content-between nav-menu-container d-none d-lg-block">
            <div class="menu-list-items">
                <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/"><i class="fas fa-tools"></i> Панель администратора</a>
                <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/index.php?mod=pages&action=edit&id=<?=$_REQUEST[page_id]?>"><i class="fas fa-edit"></i> Редактировать страницу</a>
            </div>
        </div>
    </nav>
    <?php
}
?>

<nav class="site-header <?php if($_GET[gray_static]==1) echo 'sticky-top';?>">
    <div class="d-xl-none">
        <div class="container flex-column flex-md-row justify-content-between main-menu-block-element main-menu-block-mobile-element site-header-gray container-right-menu">
            <div class="row d-xl-none text-center pb-5">
                <?php
                foreach ($menuRes as $menuElement):
                    if($_SESSION[lang]!="/en") {
                        $menu_element_name = $menuElement["page_name"];
                    } else {
                        $menu_element_name = $menuElement["page_name_en"];
                    }
                    $menu_element_childs = null;
                    if(!$menuElement["notshowchilds"]) {
                        if ($_SESSION[lang] != '/en') {
                            $menu_element_childs = $pg->getChildsJour($menuElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                        } else {
                            $menu_element_childs = $pg->getChildsJourEn($menuElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                        }
                    }
                    ?>
                    <div class="col-12">
                        <a class="py-2 d-xl-none d-inline-block" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElement['page_id']?>"><?=$menu_element_name?></a>
                        <?php if(!empty($menu_element_childs)):?>
                            <a href="#showMobileSubmenu" class="button position-absolute mobile-submenu-button"><i class="fas fa-chevron-down"></i></a>
                            <div class="mobile-submenu">
                                <?php addCollumnMobile($menu_element_childs);?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endforeach; ?>
                <div class="col-12">
                    <hr class="my-2 d-xl-none">
                </div>
                <?php
                foreach ($menuGray as $menuGrayElement):
                    if($_SESSION[lang]!="/en") {
                        $menu_element_gray_name = $menuGrayElement["page_name"];
                    } else {
                        $menu_element_gray_name = $menuGrayElement["page_name_en"];
                    }
                    $menu_element_childs = null;
                    if(!$menuGrayElement["notshowchilds"]) {
                        if ($_SESSION[lang] != '/en') {
                            $menu_element_childs = $pg->getChildsJour($menuGrayElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                        } else {
                            $menu_element_childs = $pg->getChildsJourEn($menuGrayElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                        }
                    }
                    $blank = "";
                    if($menuGrayElement["blank"]) {
                        $blank = ' target="_blank"';
                    }
                    ?>
                    <div class="col-12">
                        <a<?=$blank?> class="py-2 d-inline-block" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuGrayElement['page_id']?>"><?=$menu_element_gray_name?></a>
                        <?php if(!empty($menu_element_childs)):?>
                            <a<?=$blank?> href="#showMobileSubmenu" class="button position-absolute mobile-submenu-button"><i class="fas fa-chevron-down"></i></a>
                            <div class="mobile-submenu">
                                <?php addCollumnMobile($menu_element_childs);?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endforeach; ?>
                <div class="col-12">
                    <hr class="my-2 d-xl-none">
                </div>
                <div class="col-12">
                    <div class="social-menu pt-3 justify-content-center">
                        <?php
                        foreach ($social_links as $social_link):?>
                            <?php if($social_link['icon_link']!=1):?>
                                <a class="py-2 d-inline-flex" href="<?=$social_link['link']?>"><i class="<?=$social_link['icon']?>"></i></a>
                            <?php else:?>
                                <a class="py-2 d-inline-flex" href="<?=$social_link['link']?>"><img src="<?=$social_link['icon']?>" alt="" style="max-height: 15px;" /></a>
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex flex-row justify-content-between nav-menu-container">
        <div class="d-flex">
            <a class="py-2 menu-logo menu-logo-presscenter<?php if ($_SESSION[lang]=='/en') echo ' menu-logo-presscenter-en';?>" href="<?=$_CONFIG['new_prefix'].$_SESSION[lang]?>/index.php?page_id=1006">
                <span></span>
            </a>
        </div>
        <div class="social-menu d-flex">
            <div class="menu-list-items d-flex">
                <?php
                foreach ($menuRes as $menuElement):
                    if($menuElement['addmenu']) {
                        $addmenu[] = $menuElement;
                        continue;
                    }
                    if($_SESSION[lang]!="/en") {
                        $menu_element_name = $menuElement["page_name"];
                    } else {
                        $menu_element_name = $menuElement["page_name_en"];
                    }
                    $menu_element_childs = null;
                    if(!$menuElement["notshowchilds"]) {
                        if ($_SESSION[lang] != '/en') {
                            $menu_element_childs = $pg->getChildsJour($menuElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                        } else {
                            $menu_element_childs = $pg->getChildsJourEn($menuElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                        }
                    }
                    ?>
                <?php if(!empty($menu_element_childs)):?>
                    <div class="dropdown-block d-xl-inline-block">
                        <a class="py-2 d-none d-xl-inline-block<?php if($_REQUEST[page_id]==$menuElement['page_id']) echo " active";?>" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElement['page_id']?>"><?=$menu_element_name?></a>
                        <div class="container flex-column flex-md-row justify-content-between dropdown-element<?php if($menuElement['addmenuleft']) echo ' dropdown-element-left';?> site-header-gray"<?php if($menuElement['addmenusize']!=0) echo ' style="width: '.$menuElement['addmenusize'].'px;"';?>>
                            <div class="row">
                                <?php
                                $firstCollumn = array();
                                $secondCollumn = array();
                                $thirdCollumn = array();
                                foreach ($menu_element_childs as $menuElementChild) {
                                    if($menuElementChild['addmenucollumn']==1)
                                        $firstCollumn[] = $menuElementChild;
                                    if($menuElementChild['addmenucollumn']==2)
                                        $secondCollumn[] = $menuElementChild;
                                    if($menuElementChild['addmenucollumn']==3)
                                        $thirdCollumn[] = $menuElementChild;
                                }

                                ?>
                                <div class="col-sm">
                                <?php addCollumn($firstCollumn);?>
                                </div>
                                <?php if(!empty($secondCollumn)):?>
                                <div class="col-sm">
                                    <?php addCollumn($secondCollumn);?>
                                </div>
                                <?php endif;?>
                                <?php if(!empty($thirdCollumn)):?>
                                <div class="col-sm">
                                    <?php addCollumn($thirdCollumn);?>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="py-2 d-none d-xl-inline-block<?php if($_REQUEST[page_id]==$menuElement['page_id']) echo " active";?>" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElement['page_id']?>"><?=$menu_element_name?></a>
                <?php endif;?>
                <?php endforeach; ?>
            </div>
            <!--<div class="d-xl-inline-block">
                <a class="py-2 d-none d-xl-inline-block" href="<?=$_CONFIG['new_prefix'].$lang_link?>"><img src="<?php if($_SESSION[lang]!="/en") echo "/newsite/img/en-flag.png"; else echo "/newsite/img/ru-flag.png";?>" alt=""/></a>
            </div>-->
            <div class="main-menu-block d-xl-none d-inline-block main-menu-block-mobile">
                <a class="py-2 d-inline-block d-xl-none menu-mobile-button" href="#"><i class="fas fa-bars"></i></a>
            </div>
        </div>
    </div>
</nav>
<nav class="site-header site-header-gray site-header-menu-gray">
    <div class="container d-flex flex-column flex-md-row justify-content-between nav-menu-container">
        <div>
            <?php

            foreach ($menuGray as $menuGrayElement):
                if($_SESSION[lang]!="/en") {
                    $menu_element_gray_name = $menuGrayElement["page_name"];
                } else {
                    $menu_element_gray_name = $menuGrayElement["page_name_en"];
                }
                $blank = "";
                if($menuGrayElement["blank"]) {
                    $blank = ' target="_blank"';
                }
                ?>
                <?php if($_GET[debug]==2):?>
                <a<?=$blank?> class="py-2 d-none d-xl-inline-block" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuGrayElement['page_id']?>"><?=$menu_element_gray_name?></a>
            <? else:

                $menu_element_childs_gray = null;
                if(!$menuGrayElement["notshowchilds"]) {
                    if ($_SESSION[lang] != '/en') {
                        $menu_element_childs_gray = $pg->getChildsJour($menuGrayElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                    } else {
                        $menu_element_childs_gray = $pg->getChildsJourEn($menuGrayElement["page_id"], 1, null, null, null, $_SESSION[jour], 1);
                    }
                }

                ?>
                <?php if(!empty($menu_element_childs_gray)):?>
                <div class="dropdown-block d-xl-inline-block">
                    <a class="py-2 d-none d-xl-inline-block<?php if($_REQUEST[page_id]==$menuGrayElement['page_id']) echo "";?>" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuGrayElement['page_id']?>"><?=$menu_element_gray_name?></a>
                    <div class="container flex-column flex-md-row justify-content-between dropdown-element<?php if($menuGrayElement['addmenuleft']) echo ' dropdown-element-left';?> site-header-gray"<?php if($menuGrayElement['addmenusize']!=0) echo ' style="width: '.$menuGrayElement['addmenusize'].'px;"';?>>
                        <div class="row">
                            <?php
                            $firstCollumn = array();
                            $secondCollumn = array();
                            $thirdCollumn = array();
                            foreach ($menu_element_childs_gray as $menuElementChildGray) {
                                if($menuElementChildGray['addmenucollumn']==1)
                                    $firstCollumn[] = $menuElementChildGray;
                                if($menuElementChildGray['addmenucollumn']==2)
                                    $secondCollumn[] = $menuElementChildGray;
                                if($menuElementChildGray['addmenucollumn']==3)
                                    $thirdCollumn[] = $menuElementChildGray;
                            }

                            ?>
                            <div class="col-sm">
                                <?php addCollumn($firstCollumn);?>
                            </div>
                            <?php if(!empty($secondCollumn)):?>
                                <div class="col-sm">
                                    <?php addCollumn($secondCollumn);?>
                                </div>
                            <?php endif;?>
                            <?php if(!empty($thirdCollumn)):?>
                                <div class="col-sm">
                                    <?php addCollumn($thirdCollumn);?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a<?=$blank?> class="py-2 d-none d-xl-inline-block<?php if($_REQUEST[page_id]==$menuGrayElement['page_id']) echo "";?>" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuGrayElement['page_id']?>"><?=$menu_element_gray_name?></a>
            <?php endif;?>



            <? endif;?>
            <?php endforeach; ?>
        </div>
        <div class="social-menu">
            <?php
            foreach ($social_links as $social_link):?>
                <?php if($social_link['icon_link']!=1):?>
                    <a class="py-2 d-none d-xl-flex" href="<?=$social_link['link']?>"><i class="<?=$social_link['icon']?>"></i></a>
                <?php else:?>
                    <a class="py-2 d-none d-xl-flex" href="<?=$social_link['link']?>"><img src="<?=$social_link['icon']?>" alt="" style="max-height: 21px;" /></a>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</nav>
<?php
if($_GET[gray_static]!=1) {
    echo "</div>";
}
?>