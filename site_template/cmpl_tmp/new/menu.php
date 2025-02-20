<?php
global $DB, $_CONFIG, $site_templater, $page_content;

function addChildElements($elements, $pg, $mobile = false, $level = 0) {
    global $_CONFIG;
    switch($level) {
        case 2:
            if($mobile) {
                $linkPrefix = '<div class="col-12">';
                $linkPostfix = '</div>';
                $classes = 'py-2 d-inline-block w-100 sub-sub-element';
            } else {
                $linkPrefix = '';
                $linkPostfix = '';
                $classes = 'py-2 d-none d-xl-inline-block w-100 sub-sub-element';
            }
            break;
        case 1:
            if($mobile) {
                $linkPrefix = '<div class="col-12">';
                $linkPostfix = '</div>';
                $classes = 'py-2 d-inline-block w-100 sub-element';
            } else {
                $linkPrefix = '';
                $linkPostfix = '';
                $classes = 'py-2 d-none d-xl-inline-block w-100 sub-element';
            }
            break;
        default:
            if($mobile) {
                $linkPrefix = "<div>";
                $linkPostfix = '</div>';
                $classes = 'py-2 d-inline-block w-100';
            } else {
                $linkPrefix = '';
                $linkPostfix = '';
                $classes = 'py-2 d-none d-xl-inline-block w-100';
            }
    }

    foreach ($elements as $menuElementSub):
        if (substr($menuElementSub["page_template"],0,8)=='magazine')
            $prefjour="/jour/".$menuElementSub["page_journame"];
        else
            $prefjour="/index.php?page_id={$menuElementSub['page_id']}";

        if($_SESSION["lang"]!="/en") {
            $menu_element_sub_name = $menuElementSub["page_name"];
        } else {
            $menu_element_sub_name = $menuElementSub["page_name_en"];
        }
        $blank = "";
        if($menuElementSub["blank"]) {
            $blank = ' target="_blank"';
        }
        $style = "";
        if(!empty($menuElementSub["menu_color"])) {
            $style = " style=\"color: ".$menuElementSub["menu_color"]." !important;\"";
        }
        if($menuElementSub["menu_bold"]) {
            $classes .= " font-weight-bold";
        }

        $href = $_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour;
        if($level == 0 && $mobile) {
            $linkPrefix = "<div class=\"col-12 mobile-submenu-element-{$menuElementSub['page_id']}\">";
        }
        ?>
            <?=$linkPrefix?><a<?=$blank?><?=$style?> class="<?=$classes?>" <?php if($menuElementSub['noactivemenulink']) echo "onclick='event.preventDefault();' href='#'"; else echo "href=\"".$href."\"";?> <?php echo ' id="menu__element_'.$menuElementSub['page_id'].'"';?>><?=$menu_element_sub_name?></a><?=$linkPostfix?>
        <?php
        if($level < 2) {
            $menu_element_sub = null;
            if(!$menuElementSub["notshowchilds"]) {
                if ($_SESSION["lang"] != '/en') {
                    $menu_element_sub = $pg->getChildsMenu($menuElementSub["page_id"], 1, null, null, null, 1);
                } else {
                    $menu_element_sub = $pg->getChildsMenuEn($menuElementSub["page_id"], 1, null, null, null, 1);
                }
                addChildElements($menu_element_sub, $pg, $mobile, $level + 1);
            }
        }
    endforeach;
}

function addCollumn($array, $pg) {
    global $_CONFIG;
    addChildElements($array, $pg);
}

function addCollumnMobile($array, $pg) {
    global $_CONFIG;
    echo "<div class='row'>";
    addChildElements($array, $pg, true);
    echo '</div>';
    echo '<hr>';
}

$menu_start=2;
$gray_menu=440;
if(!empty($_TPL_REPLACMENT['MAG_HEADER'])) {
    if(!empty($_TPL_REPLACMENT['MAIN_MENU_ID'])) {
        $menu_start = $_TPL_REPLACMENT['MAIN_MENU_ID'];
    }
    if(!empty($_TPL_REPLACMENT['GRAY_MENU_ID'])) {
        $gray_menu = $_TPL_REPLACMENT['GRAY_MENU_ID'];
    }
}
$pg = new Pages();

if ($_SESSION["lang"]!='/en')
{
    $menuRes = $pg->getChildsJour($menu_start,1,null,null,null,$_SESSION["jour"],1);
}
else
{
    $menuRes = $pg->getChildsJourEn($menu_start, 1,null,null,null,$_SESSION["jour"],1);
}
if ($_SESSION["lang"]!='/en')
{
    $menuGray = $pg->getChildsJour($gray_menu,1,null,null,null,$_SESSION["jour"],1);
}
else
{
    $menuGray = $pg->getChildsJourEn($gray_menu, 1,null,null,null,$_SESSION["jour"],1);
}

$addmenu = array();

$lang_link = "";

if ($_SESSION["lang"]=='/en')
{
    if (!isset($_REQUEST["page"])) {
        if (str_replace("/en", "", $_SERVER["REQUEST_URI"]) == '') {
            $lang_link = "/";
        }
        else {
            $lang_link = substr($_SERVER["REQUEST_URI"],3);
            //$lang_link = str_replace("/en", "", $_SERVER["REQUEST_URI"]);
        }
    }
    else
        $lang_link="/en/index.php?page_id=".$_REQUEST["page_id"];
}
else
{
    if (!isset($_REQUEST["page"]))
        $lang_link = rtrim("/en/".ltrim($_SERVER["REQUEST_URI"],"/"),"/");
    else
        $lang_link = "/en/index.php?page_id=".$_REQUEST["page_id"];
}
if(!empty($_CONFIG['new_prefix']))
    $lang_link = str_replace($_CONFIG['new_prefix'],"",$lang_link);


$langPostFix = "";

if($_SESSION['lang']=="/en") {
    $langPostFix = "_EN";
}

$logoSrc = "";

if (!empty($_TPL_REPLACMENT["MAG_LOGO$langPostFix"])) {
    preg_match_all('@src="([^"]+)"@', $_TPL_REPLACMENT["MAG_LOGO$langPostFix"], $imgSrc);

    $imgSrc = array_pop($imgSrc);
    if(!empty($imgSrc[0])) {
        $logoSrc = $imgSrc[0];
    }
}

$logoSrcWidth = "100";

if (!empty($_TPL_REPLACMENT["MAG_LOGO_WIDTH$langPostFix"])) {
    $logoSrcWidth = $_TPL_REPLACMENT["MAG_LOGO_WIDTH$langPostFix"];
}

$logoSpanStyle = "";

if(!empty($logoSrc)) {
    $logoSpanStyle = " style=\"background-image: url('{$logoSrc}'); width: {$logoSrcWidth}px;\"";
}



$socialDirectories = 26;

if(!empty($_TPL_REPLACMENT['SOCIAL_DIRECTORIES'])) {
    $socialDirectories = $_TPL_REPLACMENT['SOCIAL_DIRECTORIES'];
}

$social_links = $DB->select("SELECT icon.icont_text AS icon, icon_link.icont_text AS icon_link, text.icont_text AS text, link.icont_text AS link FROM adm_directories_content AS ac INNER JOIN adm_directories_element AS ae ON ac.el_id=ae.el_id 
                              INNER JOIN adm_directories_content AS icon ON icon.el_id=ac.el_id AND icon.icont_var='icon' 
                              INNER JOIN adm_directories_content AS text ON text.el_id=ac.el_id AND text.icont_var='text' 
                              INNER JOIN adm_directories_content AS sort ON sort.el_id=ac.el_id AND sort.icont_var='sort' 
                              INNER JOIN adm_directories_content AS link ON link.el_id=ac.el_id AND link.icont_var='link' 
                              LEFT JOIN adm_directories_content AS icon_link ON icon_link.el_id=ac.el_id AND icon_link.icont_var='icon_link' 
                              LEFT JOIN adm_directories_content AS status ON status.el_id=ac.el_id AND status.icont_var='status' 
                              WHERE ae.itype_id=?d AND status.icont_text=1 GROUP BY ac.el_id ORDER BY sort.icont_text",$socialDirectories);

?>
<?php
if($_GET["gray_static"]!=1) {
    echo "<div class='sticky-top top-menu-section'>";
}

if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_REQUEST["page_id"])) {
    $ilinesList = array("NEWS_BLOCK_PAGE","FULL_SMI_ID", "DISSER_FULL_ID", "REC_COM_FULL_ID");
    $publsList = array("PUBL_PAGE");
    $personsList = array("PERSONA_PAGE");


    ?>
    <nav style="background-color: #171c22">
        <div class="container d-flex flex-column flex-md-row justify-content-between nav-menu-container d-none d-lg-block">
            <div class="menu-list-items">
                <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/"><i class="fas fa-tools"></i> Панель администратора</a>
                <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/index.php?mod=pages&action=edit&id=<?=$_REQUEST["page_id"]?>"><i class="fas fa-edit"></i> Редактировать страницу</a>
                <?php
                foreach ($publsList as $publPage) {
                    if($_REQUEST["page_id"]==$_TPL_REPLACMENT[$publPage] && !empty($_REQUEST["id"])) {
                        ?>
                        <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/index.php?mod=public&show=ok&id=<?=$_REQUEST["id"]?>"><i class="fas fa-edit"></i> Редактировать публикацию</a>
                        <?php
                        break;
                    }
                }
                foreach ($ilinesList as $ilinePage) {
                    if($_REQUEST["page_id"]==$_TPL_REPLACMENT[$ilinePage] && !empty($_REQUEST["id"])) {
                        ?>
                        <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/index.php?mod=ilines_year&type=l&action=edit&id=<?=$_REQUEST["id"]?>"><i class="fas fa-edit"></i> Редактировать элемент инф. лент</a>
                        <?php
                        break;
                    }
                }
                foreach ($personsList as $personPage) {
                    if($_REQUEST["page_id"]==$_TPL_REPLACMENT[$personPage] && !empty($_REQUEST["id"])) {
                        ?>
                        <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/index.php?mod=personal&smbl=&oper=show&id=<?=$_REQUEST["id"]?>"><i class="fas fa-edit"></i> Редактировать персону</a>
                        <?php
                        break;
                    }
                }
                if(!empty($_REQUEST['article_id'])) {
                    ?>
                    <a target="_blank" class="text-white p-2 d-none d-xl-inline-block" href="/dreamedit/index.php?mod=articls&action=edit&id=<?=$_REQUEST["article_id"]?>"><i class="fas fa-edit"></i> Редактировать элемент "Статьи в журнале"</a>
                    <?php
                }
                ?>
                <?php if($_REQUEST['onsite_editor_off']!=1):?>
                <a class="text-white p-2 d-none d-xl-inline-block" onclick="event.preventDefault(); setOnAdminEditors();" href="#"><i class="fas fa-screwdriver"></i> Включить редакторы на странице</a>
                <?php endif;?>
            </div>
        </div>
    </nav>
    <?php
}
?>

<nav class="site-header site-header-main <?php if($_GET["gray_static"]==1) echo 'sticky-top';?>">
    <div class="d-xl-none">
        <div class="container flex-column flex-md-row justify-content-between main-menu-block-element main-menu-block-mobile-element site-header-gray container-right-menu">
            <div class="row d-xl-none text-center pb-5">
                <?php
                foreach ($menuRes as $menuElement):
                    if($_SESSION["lang"]!="/en") {
                        $menu_element_name = $menuElement["page_name"];
                    } else {
                        $menu_element_name = $menuElement["page_name_en"];
                    }
                    $menu_element_childs = null;
                    if(!$menuElement["notshowchilds"]) {
                        if ($_SESSION["lang"] != '/en') {
                            $menu_element_childs = $pg->getChildsJour($menuElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                        } else {
                            $menu_element_childs = $pg->getChildsJourEn($menuElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                        }
                    }
                    $blank = "";
                    if($menuElement["blank"]) {
                        $blank = ' target="_blank"';
                    }
                    $style = "";
                    if(!empty($menuElement["menu_color"])) {
                        $style = " style=\"color: ".$menuElement["menu_color"]." !important;\"";
                    }
                    $href=$_CONFIG['new_prefix'].$_SESSION['lang']."/index.php?page_id=".$menuElement['page_id'];
                    $classes = "";
                    if($menuElement["menu_bold"]) {
                        $classes .= " font-weight-bold";
                    }
                    if ($_SESSION["lang"] != '/en') {
                        if (!empty($menuElement['page_link'])) {
                            $href = $menuElement['page_link'];
                            if(substr($menuElement['page_link'],0,1)=='#') {
                                $classes .= " scrollable-link";
                            }
                        }
                    } else {
                        if (!empty($menuElement['page_link_en'])) {
                            $href = $menuElement['page_link_en'];
                            if(substr($menuElement['page_link_en'],0,1)=='#') {
                                $classes .= " scrollable-link";
                            }
                        }
                    }
                    ?>
                    <div class="col-12 mobile-submenu-element-<?=$menuElement['page_id']?>">
                        <a<?=$blank?><?=$style?> class="py-2 d-xl-none d-inline-block<?=$classes?>" <?php if($menuElement['noactivemenulink']) echo "onclick='event.preventDefault();' href='#'"; else echo "href=\"".$href."\"";?>><?=$menu_element_name?></a>
                        <?php if(!empty($menu_element_childs)):?>
                            <a href="#showMobileSubmenu" class="button position-absolute mobile-submenu-button"><i class="fas fa-chevron-down"></i></a>
                            <div class="mobile-submenu">
                                <?php addCollumnMobile($menu_element_childs, $pg);?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endforeach;
                if($_TPL_REPLACMENT['NO_GRAY_MENU']!=1):
                ?>
                <div class="col-12">
                    <hr class="my-2 d-xl-none">
                </div>
                <?php
                foreach ($menuGray as $menuGrayElement):
                    if($_SESSION["lang"]!="/en") {
                        $menu_element_gray_name = $menuGrayElement["page_name"];
                    } else {
                        $menu_element_gray_name = $menuGrayElement["page_name_en"];
                    }
                    $menu_element_childs = null;
                    if(!$menuGrayElement["notshowchilds"]) {
                        if ($_SESSION["lang"] != '/en') {
                            $menu_element_childs = $pg->getChildsJour($menuGrayElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                        } else {
                            $menu_element_childs = $pg->getChildsJourEn($menuGrayElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                        }
                    }
                    $blank = "";
                    if($menuGrayElement["blank"]) {
                        $blank = ' target="_blank"';
                    }
                    $style = "";
                    if(!empty($menuGrayElement["menu_color"])) {
                        $style = " style=\"color: ".$menuGrayElement["menu_color"]." !important;\"";
                    }
                    $href=$_CONFIG['new_prefix'].$_SESSION['lang']."/index.php?page_id=".$menuGrayElement['page_id'];
                    $classes = "";
                    if($menuGrayElement["menu_bold"]) {
                        $classes .= " font-weight-bold";
                    }
                    if ($_SESSION["lang"] != '/en') {
                        if (!empty($menuGrayElement['page_link'])) {
                            $href = $menuGrayElement['page_link'];
                            if(substr($menuGrayElement['page_link'],0,1)=='#') {
                                $classes .= " scrollable-link";
                            }
                        }
                    } else {
                        if (!empty($menuGrayElement['page_link_en'])) {
                            $href = $menuGrayElement['page_link_en'];
                            if(substr($menuGrayElement['page_link_en'],0,1)=='#') {
                                $classes .= " scrollable-link";
                            }
                        }
                    }
                    ?>
                    <div class="col-12 mobile-submenu-element-<?=$menuGrayElement['page_id']?>">
                        <a<?=$blank?><?=$style?> class="py-2 d-inline-block<?=$classes?>" href="<?=$href?>"><?=$menu_element_gray_name?></a>
                        <?php if(!empty($menu_element_childs)):?>
                            <a href="#showMobileSubmenu" class="button position-absolute mobile-submenu-button"><i class="fas fa-chevron-down"></i></a>
                            <div class="mobile-submenu">
                                <?php addCollumnMobile($menu_element_childs, $pg);?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endforeach;
                endif;
                ?>
                <?php if($_TPL_REPLACMENT['MAG_HEADER']!= 1 || !empty($_TPL_REPLACMENT['SEARCH_PAGE_ID'])):
                    if(!empty($_TPL_REPLACMENT['SEARCH_PAGE_ID'])) {
                        $searchPageTxt = "/";
                    } else {
                        $searchPageTxt = "/search.html";
                    }
                    ?>
                <div class="col-12">
                    <hr class="my-2 d-xl-none">
                </div>
                <div class="col-12">
                    <form action="<?=$_SESSION["lang"]?><?=$searchPageTxt?>" method="get" >
                        <?php if(!empty($_TPL_REPLACMENT['SEARCH_PAGE_ID'])):?>
                            <input type="hidden" id="page_id" name="page_id" value="<?=$_TPL_REPLACMENT['SEARCH_PAGE_ID']?>">
                        <?php endif;?>
                        <div class="form-group">
                            <label class="searchFieldLabel text-uppercase" for="searchField"><?php if($_SESSION["lang"]!="/en") echo "Поиск"; else echo "Search";?></label>
                            <input type="text" class="form-control" name="search" id="search" placeholder="<?php if($_SESSION["lang"]!="/en") echo "Введите текст для поиска"; else echo "Search text";?>">
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary imemo-button text-uppercase"><?php if($_SESSION["lang"]!="/en") echo "Искать"; else echo "Search";?></button>
                    </form>
                </div>
                <?php endif;?>
                <div class="col-12">
                    <hr class="my-2 d-xl-none">
                </div>
                <?php if($_TPL_REPLACMENT['ENGLISH_OFF']!=1):?>
                <div class="col-12">
                    <a class="py-2 d-xl-none d-inline-block" href="<?=$_CONFIG['new_prefix'].$lang_link?>"><?php if($_SESSION["lang"]!="/en") echo "English Version"; else echo "Русская Версия";?></a>
                </div>
                <?php endif;?>
                <?php if($_TPL_REPLACMENT['MAG_HEADER']!= 1 || !empty($_TPL_REPLACMENT['SOCIAL_DIRECTORIES'])):?>
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
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="container d-flex flex-row justify-content-between nav-menu-container">
        <div class="d-flex">
            <a class="py-2 menu-logo<?php if ($_SESSION["lang"]=='/en') echo ' menu-logo-en';?><?php if($_TPL_REPLACMENT['MAG_HEADER']== 1) {if ($_SESSION["lang"]=='/en') echo ' menu-logo-en menu-logo-jour-en'; else echo ' menu-logo-jour';}?>" href="<?=$_CONFIG['new_prefix'].$_SESSION["lang"]?>/<?php if(!empty($_TPL_REPLACMENT['MAIN_JOUR_ID'])) echo "index.php?page_id=".$_TPL_REPLACMENT['MAIN_JOUR_ID'];?>">
                <?php if(empty($_GET["logo_test"])): ?>
                <span<?php if(!empty($logoSpanStyle)) echo $logoSpanStyle;?>></span>
                <?php else:?>
                <span style="background-image: url('/newsite/img/logo_widther_var<?=$_GET["logo_test"]?>.png');"></span>
                <?php endif;?>
            </a>
        </div>
        <div class="social-menu d-flex">
            <div class="menu-list-items d-flex">
                <?php
                $currentMenuWidth = 1301;
                foreach ($menuRes as $menuElement):
                    if($_SESSION["lang"]!="/en") {
                        $menu_element_name = $menuElement["page_name"];
                    } else {
                        $menu_element_name = $menuElement["page_name_en"];
                    }
                    $menu_element_childs = null;
                    if(!$menuElement["notshowchilds"]) {
                        if ($_SESSION["lang"] != '/en') {
                            $menu_element_childs = $pg->getChildsJour($menuElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                        } else {
                            $menu_element_childs = $pg->getChildsJourEn($menuElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                        }
                    }
                    $blank = "";
                    if($menuElement["blank"]) {
                        $blank = ' target="_blank"';
                    }
                    $style = "";
                    if(!empty($menuElement["menu_color"])) {
                        $style = " style=\"color: ".$menuElement["menu_color"]." !important;\"";
                    }
                    $href=$_CONFIG['new_prefix'].$_SESSION['lang']."/index.php?page_id=".$menuElement['page_id'];
                    $classes = "";
                    if($menuElement["menu_bold"]) {
                        $classes .= " font-weight-bold";
                    }
                    if ($_SESSION["lang"] != '/en') {
                        if (!empty($menuElement['page_link'])) {
                            $href = $menuElement['page_link'];
                            if(substr($menuElement['page_link'],0,1)=='#') {
                                $classes .= " scrollable-link";
                            }
                        }
                    } else {
                        if (!empty($menuElement['page_link_en'])) {
                            $href = $menuElement['page_link_en'];
                            if(substr($menuElement['page_link_en'],0,1)=='#') {
                                $classes .= " scrollable-link";
                            }
                        }
                    }
                    ?>
                <?php if(!empty($menu_element_childs)):?>
                    <div class="dropdown-block d-xl-inline-block"<?php if($menuElement['addmenu']) echo ' id="menu__element_'.$menuElement['page_id'].'"';?>>
                        <a<?=$blank?><?=$style?> class="py-2 d-none d-xl-inline-block<?php if($_REQUEST["page_id"]==$menuElement['page_id']) echo " active";?><?=$classes?>" <?php if($menuElement['noactivemenulink']) echo "onclick='event.preventDefault();' href='#'"; else echo "href=\"".$href."\"";?>><?=$menu_element_name?></a>
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
                                <?php addCollumn($firstCollumn, $pg);?>
                                </div>
                                <?php if(!empty($secondCollumn)):?>
                                <div class="col-sm">
                                    <?php addCollumn($secondCollumn, $pg);?>
                                </div>
                                <?php endif;?>
                                <?php if(!empty($thirdCollumn)):?>
                                <div class="col-sm">
                                    <?php addCollumn($thirdCollumn, $pg);?>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a<?=$blank?><?=$style?><?php if($menuElement['addmenu']) echo ' id="menu__element_'.$menuElement['page_id'].'"';?> class="py-2 d-none d-xl-inline-block<?php if($_REQUEST["page_id"]==$menuElement['page_id']) echo " active";?><?=$classes?>" href="<?=$href?>"><?=$menu_element_name?></a>
                <?php endif;?>
                <?php if($menuElement['addmenu']):
                    $currentMenuWidth += (strlen($menu_element_name)*10)+30;
                    $menuElement['current_menu_width'] = $currentMenuWidth;
                    $addmenu[] = $menuElement;
                    ?>
                    <style>
                        #menu__element_<?=$menuElement['page_id']?> {
                            display: none !important;
                        }
                        #add_menu__element_<?=$menuElement['page_id']?> {
                            display: block;
                        }

                        @media (min-width: <?=$currentMenuWidth?>px) {
                            #menu__element_<?=$menuElement['page_id']?> {
                                display: inline-block !important;
                            }
                            #add_menu__element_<?=$menuElement['page_id']?> {
                                display: none;
                            }
                            <?php if($menuElement['page_id']=='1333'):?>
                            .notification-menu-button::before {
                                display: none;
                            }
                            <?php endif; ?>
                        }
                    </style>
                <?php endif;?>
                <?php endforeach; ?>
                <?php if($menuElement['addmenu']):?>
                    <style>
                        @media (min-width: <?=$currentMenuWidth?>px) {
                            #add_menu {
                                display: none !important;
                            }
                        }
                    </style>
                <?php endif;?>
            </div>
            <?php if($_TPL_REPLACMENT['ENGLISH_OFF']!=1):?>
            <div class="d-xl-inline-block">
                <a class="py-2 d-none d-xl-inline-block" href="<?=$_CONFIG['new_prefix'].$lang_link?>"><?php if($_SESSION["lang"]!="/en") echo "EN"; else echo "RU";?></a>
                <!--<a class="py-2 d-none d-xl-inline-block" href="#"><img src="img/ru-flag.png" alt=""/></a>-->
            </div>
            <?php endif;?>
            <?php if($_TPL_REPLACMENT['MAG_HEADER']!= 1):?>
            <div class="main-menu-block d-xl-inline-block">
                <a class="py-2 d-none d-xl-inline-block menu-button" href="#"><i class="fas fa-calendar-alt"></i></a>
                <div class="container flex-column flex-md-row justify-content-between main-menu-block-element main-menu-block-element-calendar site-header-gray container-right-menu">
                    <div class="row">
                        <div class="col-sm">
                            <div id="dncalendar-container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php if($_TPL_REPLACMENT['MAG_HEADER']!= 1 || !empty($_TPL_REPLACMENT['SEARCH_PAGE_ID'])):
                if(!empty($_TPL_REPLACMENT['SEARCH_PAGE_ID'])) {
                    $searchPageTxt = "/";
                } else {
                    $searchPageTxt = "/search.html";
                }
                ?>
            <div class="main-menu-block d-xl-inline-block">
                <a class="py-2 d-none d-xl-inline-block menu-button" href="#"><i class="fas fa-search"></i></a>
                <div class="container flex-column flex-md-row justify-content-between main-menu-block-element main-menu-block-element-search site-header-gray container-right-menu">
                    <form action="<?=$_CONFIG['new_prefix']?><?php if($_SESSION["lang"]=="/en") echo "/en";?><?=$searchPageTxt?>" method="get" class="h-100 w-100">
                        <?php if(!empty($_TPL_REPLACMENT['SEARCH_PAGE_ID'])):?>
                            <input type="hidden" id="page_id" name="page_id" value="<?=$_TPL_REPLACMENT['SEARCH_PAGE_ID']?>">
                        <?php endif;?>
                        <input class="w-75 h-100 float-left border-0 p-2" type="text" name="search" id="search" placeholder="<?php if($_SESSION["lang"]=="/en") echo "Search text"; else echo "Введите текст для поиска";?>">
                        <button type="submit" class="w-25 h-100 float-right text-uppercase border-0"><?php if($_SESSION["lang"]=="/en") echo "Search"; else echo "Искать";?></button>
                    </form>
                </div>
            </div>
            <?php endif;?>
            <?php if($_TPL_REPLACMENT['MAG_HEADER']!= 1 || $_TPL_REPLACMENT['ADD_MENU_ON']==1):?>
            <div class="<?php if($_GET["debug"]!=1) echo "main-menu-block"; else echo "dropdown-block"; ?> d-none d-xl-inline-block" id="add_menu">
                <a class="py-2 d-none d-lg-inline-block menu-button add-menu-open-button" href="#"><i class="fas fa-bars"></i></a>
                <div <?php if(!empty($_TPL_REPLACMENT['ADD_MENU_SIZE_W'])) echo 'style="width: '.$_TPL_REPLACMENT['ADD_MENU_SIZE_W'].'px;"';?> class="container flex-column flex-md-row justify-content-between <?php if($_GET["debug"]!=1) echo "main-menu-block-element"; else echo "dropdown-element dropdown-element-left"; ?> site-header-gray <?php if($_GET[debug]!=1) echo "container-right-menu"; else echo ""; ?>">
                    <div class="row">
                        <?php if($_GET["debug"]!=1):?>
                            <div class="col-sm">
                            </div>
                        <?php endif;?>
                        <div class="col-sm">
                            <?php
//                            if($_GET[debug]==1) {
//                                $addmenu_save = $addmenu;
//                                $addmenu = $menuGray;
//                                $menuGray = $addmenu_save;
//                            }

                            if($_GET["debug"]!=1) {

                                foreach ($addmenu as $addmenuElement):
                                    if ($_SESSION["lang"] != "/en") {
                                        $addmenu_element_name = $addmenuElement["page_name"];
                                    } else {
                                        $addmenu_element_name = $addmenuElement["page_name_en"];
                                    }
                                    $addmenu_element_childs = null;
                                    if(!$addmenuElement["notshowchilds"]) {
                                        if ($_SESSION["lang"] != '/en') {
                                            $addmenu_element_childs = $pg->getChildsJour($addmenuElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                                        } else {
                                            $addmenu_element_childs = $pg->getChildsJourEn($addmenuElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                                        }
                                    }
                                    $blank = "";
                                    if($addmenuElement["blank"]) {
                                        $blank = ' target="_blank"';
                                    }
                                    $style = "";
                                    if(!empty($addmenuElement["menu_color"])) {
                                        $style = " style=\"color: ".$addmenuElement["menu_color"]." !important;\"";
                                    }
                                    $classes = "";
                                    if($addmenuElement["menu_bold"]) {
                                        $classes .= " font-weight-bold";
                                    }

                                    ?>
                                    <?php if (!empty($addmenu_element_childs)): ?>
                                    <div class="menu-right-block"<?php if($menuElement['addmenu']) echo ' id="add_menu__element_'.$addmenuElement['page_id'].'"';?>>
                                        <a<?=$blank?><?=$style?> class="py-2 d-none d-xl-inline-block<?=$classes?>"
                                           href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?>/index.php?page_id=<?= $addmenuElement['page_id'] ?>"><?= $addmenu_element_name ?></a>
                                        <div class="menu-right-block-element" style="display: none;<?php if(!empty($_TPL_REPLACMENT['ADD_MENU_LEFT_SIZE_W'])) echo 'width: '.$_TPL_REPLACMENT['ADD_MENU_LEFT_SIZE_W'].'px;'?>">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <?php addCollumn($addmenu_element_childs, $pg); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-right-block-element-arrow">
                                            <div class="py-2 d-none d-xl-inline-block"><i
                                                        class="fas fa-angle-left"></i></div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="w-100"<?php if($menuElement['addmenu']) echo ' id="add_menu__element_'.$addmenuElement['page_id'].'"';?>><a<?=$blank?><?=$style?> class="py-2 d-none d-xl-inline-block<?=$classes?>"
                                       href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?>/index.php?page_id=<?= $addmenuElement['page_id'] ?>"><?= $addmenu_element_name ?></a></div>
                                <?php endif; ?>

                                <?php endforeach;

                            } else {

                                ?>


                                <?php
                                foreach ($addmenu as $menuElement):
                                    if($_SESSION["lang"]!="/en") {
                                        $menu_element_name = $menuElement["page_name"];
                                    } else {
                                        $menu_element_name = $menuElement["page_name_en"];
                                    }
                                    $blank = "";
                                    if($menuElement["blank"]) {
                                        $blank = ' target="_blank"';
                                    }
                                    $style = "";
                                    if(!empty($menuElement["menu_color"])) {
                                        $style = " style=\"color: ".$menuElement["menu_color"]." !important;\"";
                                    }
                                    $classes = "";
                                    if($menuElement["menu_bold"]) {
                                        $classes .= " font-weight-bold";
                                    }
                                    ?>
                                    <div class="col-12">
                                        <a<?=$blank?><?=$style?> class="py-2 d-none d-xl-inline-block w-100<?=$classes?>" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuElement['page_id']?>"><?=$menu_element_name?></a>
                                    </div>
                                <?php endforeach; ?>


                                <?


                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <div class="main-menu-block d-xl-none d-inline-block main-menu-block-mobile">
                <a class="py-2 d-inline-block d-xl-none menu-mobile-button" href="#"><i class="fas fa-bars"></i></a>
            </div>
        </div>
    </div>
</nav>
<?php if($_TPL_REPLACMENT['NO_GRAY_MENU']!=1): ?>
<nav class="site-header site-header-gray site-header-menu-gray">
    <div class="container d-flex flex-row <?php if($_TPL_REPLACMENT['MAG_HEADER']!= 1 || !empty($_TPL_REPLACMENT['SOCIAL_DIRECTORIES'])) echo "justify-content-between "; else echo "justify-content-start ";?>nav-menu-container">
        <div class="<?php if(empty($_TPL_REPLACMENT['SOCIAL_DIRECTORIES'])) echo 'menu-list-items';?>">
            <?php

            foreach ($menuGray as $menuGrayElement):
                if($_SESSION["lang"]!="/en") {
                    $menu_element_gray_name = $menuGrayElement["page_name"];
                } else {
                    $menu_element_gray_name = $menuGrayElement["page_name_en"];
                }
                $blank = "";
                if($menuGrayElement["blank"]) {
                    $blank = ' target="_blank"';
                }
                $style = "";
                if(!empty($menuGrayElement["menu_color"])) {
                    $style = " style=\"color: ".$menuGrayElement["menu_color"]." !important;\"";
                }

                ?>
                <?php if($_GET["debug"]==2):?>
                <a<?=$blank?><?=$style?> class="py-2 d-none d-xl-inline-block" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuGrayElement['page_id']?>"><?=$menu_element_gray_name?></a>
                <? else:

                $menu_element_childs_gray = null;
                if(!$menuGrayElement["notshowchilds"]) {
                    if ($_SESSION["lang"] != '/en') {
                        $menu_element_childs_gray = $pg->getChildsJour($menuGrayElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                    } else {
                        $menu_element_childs_gray = $pg->getChildsJourEn($menuGrayElement["page_id"], 1, null, null, null, $_SESSION["jour"], 1);
                    }
                }
                $href=$_CONFIG['new_prefix'].$_SESSION['lang']."/index.php?page_id=".$menuGrayElement['page_id'];
                $classes = "";
                if($menuGrayElement["menu_bold"]) {
                    $classes .= " font-weight-bold";
                }
                if ($_SESSION["lang"] != '/en') {
                    if (!empty($menuGrayElement['page_link'])) {
                        $href = $menuGrayElement['page_link'];
                        if(substr($menuGrayElement['page_link'],0,1)=='#') {
                            $classes .= " scrollable-link";
                        }
                    }
                } else {
                    if (!empty($menuGrayElement['page_link_en'])) {
                        $href = $menuGrayElement['page_link_en'];
                        if(substr($menuGrayElement['page_link_en'],0,1)=='#') {
                            $classes .= " scrollable-link";
                        }
                    }
                }
                ?>
                <?php if(!empty($menu_element_childs_gray)):?>
                    <div class="dropdown-block d-xl-inline-block" <?php echo ' id="menu__element_'.$menuGrayElement['page_id'].'"';?>>
                        <a<?=$blank?><?=$style?> class="py-2 d-none d-xl-inline-block<?=$classes?>" href="<?=$href?>"><?=$menu_element_gray_name?></a>
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
                                    <?php addCollumn($firstCollumn, $pg);?>
                                </div>
                                <?php if(!empty($secondCollumn)):?>
                                    <div class="col-sm">
                                        <?php addCollumn($secondCollumn, $pg);?>
                                    </div>
                                <?php endif;?>
                                <?php if(!empty($thirdCollumn)):?>
                                    <div class="col-sm">
                                        <?php addCollumn($thirdCollumn, $pg);?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a<?=$blank?><?=$style?> class="py-2 d-none d-xl-inline-block<?=$classes?>" href="<?=$href?>" <?php echo ' id="menu__element_'.$menuGrayElement['page_id'].'"';?>><?=$menu_element_gray_name?></a>
                <?php endif;?>



                <? endif;?>
            <?php endforeach; ?>
        </div>
        <?php if($_TPL_REPLACMENT['MAG_HEADER']!= 1 || !empty($_TPL_REPLACMENT['SOCIAL_DIRECTORIES'])):?>
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
        <?php endif;?>
    </div>
</nav>
<?php
endif;
if($_GET["gray_static"]!=1) {
    echo "</div>";
}
?>