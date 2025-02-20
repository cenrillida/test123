<?php
global $DB, $_CONFIG, $site_templater, $page_content;

function addCollumn($array,$pagej,$prefjour) {
    global $_CONFIG;
    $pg = new Pages();
    foreach ($array as $menuElementChild):
        if($_SESSION[lang]!="/en") {
            $menu_element_child_name = $menuElementChild["page_name"];
        } else {
            $menu_element_child_name = $menuElementChild["page_name_en"];
        }
        if ($_SESSION[jour]=='/jour' && ($menuElementChild[page_template]=='text' || $menuElementChild[page_template]=='magazine_page_archive'))
            $page=$pagej; else $page="";
        ?>
        <a class="py-2 d-none d-xl-inline-block w-100" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour?>/index.php?page_id=<?=$page.$menuElementChild['page_id']?>"><?=$menu_element_child_name?></a>
        <?php
        if ($_SESSION[lang]!='/en')
        {
            $menu_element_sub = $pg->getChildsJour($menuElementChild["page_id"],1,null,null,null,$_SESSION[jour]);
        }
        else
        {
            $menu_element_sub = $pg->getChildsJourEn($menuElementChild["page_id"], 1,null,null,null,$_SESSION[jour]);
        }
        foreach ($menu_element_sub as $menuElementSub):
            if($_SESSION[lang]!="/en") {
                $menu_element_sub_name = $menuElementSub["page_name"];
            } else {
                $menu_element_sub_name = $menuElementSub["page_name_en"];
            }
            if ($_SESSION[jour]=='/jour' && ($menuElementSub[page_template]=='text' || $menuElementSub[page_template]=='magazine_page_archive'))
                $page=$pagej; else $page="";
            ?>
            <a class="py-2 d-none d-xl-inline-block w-100 sub-element" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour?>/index.php?page_id=<?=$page.$menuElementSub['page_id']?>"><?=$menu_element_sub_name?></a>
        <?php endforeach;
    endforeach;
}

function addCollumnMobile($array,$pagej,$prefjour) {
    global $_CONFIG;
    $pg = new Pages();
    echo "<div class='row'>";
    foreach ($array as $menuElementChild):
        if($_SESSION[lang]!="/en") {
            $menu_element_child_name = $menuElementChild["page_name"];
        } else {
            $menu_element_child_name = $menuElementChild["page_name_en"];
        }
        if ($_SESSION[jour]=='/jour' && ($menuElementChild[page_template]=='text' || $menuElementChild[page_template]=='magazine_page_archive'))
            $page=$pagej; else $page="";
        ?>
            <div class="col-12"><a class="py-2 d-inline-block w-100" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour?>/index.php?page_id=<?=$page.$menuElementChild['page_id']?>"><?=$menu_element_child_name?></a></div>
        <?php
        if ($_SESSION[lang]!='/en')
        {
            $menu_element_sub = $pg->getChildsJour($menuElementChild["page_id"],1,null,null,null,$_SESSION[jour]);
        }
        else
        {
            $menu_element_sub = $pg->getChildsJourEn($menuElementChild["page_id"], 1,null,null,null,$_SESSION[jour]);
        }
        foreach ($menu_element_sub as $menuElementSub):
            if($_SESSION[lang]!="/en") {
                $menu_element_sub_name = $menuElementSub["page_name"];
            } else {
                $menu_element_sub_name = $menuElementSub["page_name_en"];
            }
            if ($_SESSION[jour]=='/jour' && ($menuElementSub[page_template]=='text' || $menuElementSub[page_template]=='magazine_page_archive'))
                $page=$pagej; else $page="";
            ?>
            <div class="col-12"><a class="py-2 d-inline-block w-100 sub-element" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour?>/index.php?page_id=<?=$page.$menuElementSub['page_id']?>"><?=$menu_element_sub_name?></a></div>
        <?php endforeach;
    endforeach;
    echo '</div>';
    echo '<hr>';
}

$param="";
$menu_start=$_SESSION[jour_id];
$param.='/jour';
if ($_SESSION[lang]=='/en')
{
//  $menu_start= 2;
    $param.="/en/";
    $_REQUEST[en]=true;
}
else
{
    $param.="";
//  $menu_start=2;
}

$gray_menu=922;

$pid=array();
$jourId=$DB->select("SELECT p.page_id AS page_start,pc2.page_id AS 'text_page' 
                       FROM adm_pages_content AS pc 
					   INNER JOIN adm_pages AS p ON p.page_id=pc.page_id AND p.page_template='magazine'
					   INNER JOIN adm_pages_content AS pc2 ON pc2.cv_name='itype_jour' AND pc2.cv_text=?
					  INNER JOIN adm_pages AS p2 ON p2.page_id=pc2.page_id AND p2.page_template='magazine_full' 
					   WHERE pc.cv_name='itype_jour' AND pc.cv_text=?",$_SESSION[jour_id],$_SESSION[jour_id]	);


$page_start=$jourId[0][page_start];
$text_page=$jourId[0][text_page];

$prefjour="/jour/".$_SESSION[jour_url];

$pg = new Pages();

if ($_SESSION[jour]=='/jour')
    $pagej=$text_page."&id=";
else $pagej="";

$pageid=$pg->getBranch($page_start);

foreach($pageid as $pp)
{

    if (substr($pp[page_template],0,8)=='magazine')
    {
        $pid[$pp[page_template]][page_id]=$pp[page_id];
        $pid[$pp[page_template]][page_name]=$pp[page_name];
        $pid[$pp[page_template]][page_name_en]=$pp[page_name_en];

    }

}


if ($_SESSION[lang]!='/en')
{
    $menuRes = $pg->getChildsJour($menu_start,1,null,null,null,$_SESSION[jour]);
}
else
{
    $menuRes = $pg->getChildsJourEn($menu_start, 1,null,null,null,$_SESSION[jour]);
}
if ($_SESSION[lang]!='/en')
{
    $menuGray = $pg->getChildsJour($gray_menu,1);
}
else
{
    $menuGray = $pg->getChildsJourEn($gray_menu, 1);
}

// Текущий номер
if($_SESSION[jour_url]!='god_planety')
{
$ppp=$pid[magazine_page][page_id];
$menuRes[$ppp][page_id]=$pid[magazine_page][page_id];
$menuRes[$ppp][page_name]="Текущий номер";
$menuRes[$ppp][page_name_en]="Current Issue";
// Архив
$ppp=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_id]=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_name]="Архив";
$menuRes[$ppp][page_name_en]="Archive";
}
else
{
$ppp=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_id]=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_name]="Архив";
$menuRes[$ppp][page_name_en]="Archive";
}

if($_SESSION[jour_url] != 'REB-2' && $_SESSION[jour_url] != 'Russia-n-World') {
// Авторский указатель
    $ppp = $pid[magazine_authors_index][page_id];
    $menuRes[$ppp][page_id] = $pid[magazine_authors_index][page_id];
    $menuRes[$ppp][page_name] = "Авторский указатель";
    $menuRes[$ppp][page_name_en] = "Authors Index";
    $menuRes = $pg->appendContent($menuRes);
}

$addmenu = array();

$lang_link = "";

$lang_subpage_id = "";

if(!empty($_GET[id])) {
    $lang_subpage_id = "&id".$_GET[id];
}

if ($_SESSION[lang]=='/en')
{
    if (!isset($_REQUEST[page])) {
        if (str_replace("/en", "", $_SERVER["REQUEST_URI"]) == '') {
            $lang_link = "/";
        } else {
            $lang_link = substr($_SERVER["REQUEST_URI"], 3);
            //$lang_link = str_replace("/en", "", $_SERVER["REQUEST_URI"]);
        }
    }
    else
        $lang_link="/en".$prefjour."/index.php?page_id=".$_REQUEST[page_id].$lang_subpage_id;
}
else
{
    if (!isset($_REQUEST[page]))
        $lang_link = rtrim("/en/".ltrim($_SERVER["REQUEST_URI"],"/"),"/");
    else
        $lang_link = "/en".$prefjour."/index.php?page_id=".$_REQUEST[page_id].$lang_subpage_id;
}
if(!empty($_CONFIG['new_prefix']))
    $lang_link = str_replace($_CONFIG['new_prefix'],"",$lang_link);

?>

<nav class="site-header sticky-top">
    <div class="d-xl-none">
        <div class="container flex-column flex-md-row justify-content-between main-menu-block-element main-menu-block-mobile-element site-header-gray container-right-menu">
            <div class="row d-xl-none text-center">
                <?php
                foreach ($menuRes as $menuElement):
                    if($_SESSION[lang]!="/en") {
                        $menu_element_name = $menuElement["page_name"];
                    } else {
                        $menu_element_name = $menuElement["page_name_en"];
                    }
                    if ($_SESSION[lang]!='/en')
                    {
                        $menu_element_childs = $pg->getChildsJour($menuElement["page_id"],1,null,null,null,$_SESSION[jour]);
                    }
                    else
                    {
                        $menu_element_childs = $pg->getChildsJourEn($menuElement["page_id"], 1,null,null,null,$_SESSION[jour]);
                    }
                    if ($_SESSION[jour]=='/jour' && ($menuElement[page_template]=='text' || $menuElement[page_template]=='magazine_page_archive'))
                        $page=$pagej; else $page="";

                    $pagejTemp = $pagej;

                    if($pid[magazine_archive][page_id]==$menuElement[page_id] && $_SESSION[jour_url]=="PMB") {
                        $menu_element_childs[0] = $pg->getPageById("1648");
                        $menu_element_childs[1] = $pg->getPageById("1548");
                        $pagejTemp = "";
                    }
                    if($menuElement[page_id]==154 && $_SESSION[jour_url]=="PMB") {
                        $menu_element_childs[10] = $pg->getPageById("1632");
                    }
                    ?>
                    <div class="col-12">
                        <a class="py-2 d-xl-none d-inline-block" <?php if($menuElement['link_false']) echo "onclick='event.preventDefault();' href='#'"; else echo "href=\"".$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour."/index.php?page_id=".$page.$menuElement['page_id']."\"";?>><?=$menu_element_name?></a>
                        <?php if(!empty($menu_element_childs)):?>
                            <a href="#showMobileSubmenu" class="button position-absolute mobile-submenu-button"><i class="fas fa-chevron-down"></i></a>
                            <div class="mobile-submenu">
                                <?php addCollumnMobile($menu_element_childs,$pagejTemp,$prefjour);?>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endforeach; ?>
                <div class="col-12">
                    <hr class="my-2 d-xl-none">
                </div>
                <div class="col-12">
                    <a class="py-2 d-xl-none d-inline-block" href="<?=$_CONFIG['new_prefix'].$lang_link?>"><?php if($_SESSION[lang]!="/en") echo "English Version"; else echo "Русская Версия";?></a>
                </div>
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
                    ?>
                <div class="col-12">
                    <a class="py-2 d-inline-block" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuGrayElement['page_id']?>"><?=$menu_element_gray_name?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container d-flex flex-row justify-content-between nav-menu-container">
        <div class="d-flex">
            <a class="py-2 menu-logo<?php if ($_SESSION[lang]=='/en') echo ' menu-logo-en menu-logo-jour-en'; else echo ' menu-logo-jour';?>" href="<?=$_CONFIG['new_prefix'].$_SESSION[lang].$prefjour?>/">
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
                    if ($_SESSION[lang]!='/en')
                    {
                        $menu_element_childs = $pg->getChildsJour($menuElement["page_id"],1,null,null,null,$_SESSION[jour]);
                    }
                    else
                    {
                        $menu_element_childs = $pg->getChildsJourEn($menuElement["page_id"], 1,null,null,null,$_SESSION[jour]);
                    }
                    if ($_SESSION[jour]=='/jour' && ($menuElement[page_template]=='text' || $menuElement[page_template]=='magazine_page_archive'))
                        $page=$pagej; else $page="";
                        $pagejTemp = $pagej;

                        if($pid[magazine_archive][page_id]==$menuElement[page_id] && $_SESSION[jour_url]=="PMB") {
                            $menu_element_childs[0] = $pg->getPageById("1648");
                            $menu_element_childs[1] = $pg->getPageById("1548");
                            $pagejTemp = "";
                        }
                        if($menuElement[page_id]==154 && $_SESSION[jour_url]=="PMB") {
                            $menu_element_childs[10] = $pg->getPageById("1632");
                        }
                    ?>

                    <?php if(!empty($menu_element_childs)):
                    ?>
                    <div class="dropdown-block d-xl-inline-block">
                        <a class="py-2 d-none d-xl-inline-block<?php if($_REQUEST[page_id]==$menuElement['page_id']) echo " active";?>" <?php if($menuElement['link_false']) echo "onclick='event.preventDefault();' href='#'"; else echo "href=\"".$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour."/index.php?page_id=".$page.$menuElement['page_id']."\"";?>><?=$menu_element_name?></a>
                        <div class="container flex-column flex-md-row justify-content-between dropdown-element<?php echo ' dropdown-element-left';?> site-header-gray"<?php echo ' style="width: 400px;"';?>>
                            <div class="row">
                                <?php
                                $firstCollumn = array();
                                $secondCollumn = array();
                                $thirdCollumn = array();
                                foreach ($menu_element_childs as $menuElementChild) {
                                    $firstCollumn[] = $menuElementChild;
                                }

                                ?>
                                <div class="col-sm">
                                    <?php addCollumn($firstCollumn,$pagejTemp,$prefjour);?>
                                </div>
                                <?php if(!empty($secondCollumn)):?>
                                    <div class="col-sm">
                                        <?php addCollumn($secondCollumn,$pagejTemp,$prefjour);?>
                                    </div>
                                <?php endif;?>
                                <?php if(!empty($thirdCollumn)):?>
                                    <div class="col-sm">
                                        <?php addCollumn($thirdCollumn,$pagejTemp,$prefjour);?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="py-2 d-none d-xl-inline-block<?php if($_REQUEST[page_id]==$menuElement['page_id']) echo " active";?>" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang'].$prefjour?>/index.php?page_id=<?=$page.$menuElement['page_id']?>"><?=$menu_element_name?></a>
                <?php endif;?>
                <?php endforeach; ?>
            </div>
            <div class="d-xl-inline-block">
                <a class="py-2 d-none d-xl-inline-block" href="<?=$_CONFIG['new_prefix'].$lang_link?>"><?php if($_SESSION["lang"]!="/en") echo "EN"; else echo "RU";?></a>
                <!--<a class="py-2 d-none d-xl-inline-block" href="#"><img src="img/ru-flag.png" alt=""/></a>-->
            </div>
            <div class="main-menu-block d-xl-inline-block">
                <a class="py-2 d-none d-xl-inline-block menu-button" href="#"><i class="fas fa-search"></i></a>
                <div class="container flex-column flex-md-row justify-content-between main-menu-block-element main-menu-block-element-search site-header-gray container-right-menu">
                    <form action="<?=$_CONFIG['new_prefix']?><?php if($_SESSION[lang]=="/en") echo "/en";?>/search.html" method="get" class="h-100 w-100">
                        <input class="w-75 h-100 float-left border-0 p-2" type="text" name="search" id="search" placeholder="<?php if($_SESSION[lang]=="/en") echo "Search text"; else echo "Введите текст для поиска";?>">
                        <button type="submit" class="w-25 h-100 float-right text-uppercase border-0"><?php if($_SESSION[lang]=="/en") echo "Search"; else echo "Искать";?></button>
                    </form>
                </div>
            </div>
            <div class="main-menu-block d-xl-none d-inline-block">
                <a class="py-2 d-inline-block d-xl-none menu-mobile-button" href="#"><i class="fas fa-bars"></i></a>
            </div>
        </div>
    </div>
</nav>
<nav class="site-header site-header-gray site-header-menu-gray">
    <div class="container d-flex flex-column flex-md-row justify-content-start nav-menu-container">
        <div class="menu-list-items">
            <?php
            foreach ($menuGray as $menuGrayElement):
                if($_SESSION[lang]!="/en") {
                    $menu_element_gray_name = $menuGrayElement["page_name"];
                } else {
                    $menu_element_gray_name = $menuGrayElement["page_name_en"];
                }
                ?>
                <a class="py-2 d-none d-xl-inline-block" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=<?=$menuGrayElement['page_id']?>"><?=$menu_element_gray_name?></a>
            <?php endforeach;

            if($_SESSION[jour_url]=='meimo' && $_SESSION[lang]=="/en") {

                    if($_REQUEST[userid_meimo_secure]=='38FH$*8h4' && $_REQUEST[userid_meimo]==1)
                        echo '<a class="py-2 d-none d-xl-inline-block" style="cursor:hand;cursor:pointer;font-weight: bold;" onClick=exitMain('.$_REQUEST[page_id].',\'userid_meimo\')>Logout</a>';
                    else
                        echo '<a class="py-2 d-none d-xl-inline-block" style="font-weight: bold;" href="/en/jour/meimo/index.php?page_id=1183">Login</a>';
            }

            ?>
        </div>
    </div>
</nav>
