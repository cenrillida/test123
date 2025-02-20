</div>
</div>
<div class="row shadow border bg-white mt-5">
    <div class="col-12 p-lg-5 p-md-3 py-4">
        <?php

        if($_GET[debug]==2) {
            echo $_TPL_REPLACMENT['NEWSITE_COMMENT'];
        } else {
            include($_TPL_REPLACMENT['NEWSITE_COMMENT']);
        }?>
    </div>
</div>
</div>
</div>
<!-- right column -->
<?php

global $_CONFIG, $DB, $site_templater, $page_content;


if (!empty($_REQUEST[id]) && substr($dd[0][page_template],0,8)=='magazine' && $dd[0][page_template]!='magazine_author')
{
    $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,IFNULL(m.page_name,'') AS mname,IFNULL(m.page_name_en,'') AS mname_en FROM adm_pages AS p 
	 LEFT OUTER JOIN adm_magazine AS m ON m.page_id=".(int)$_REQUEST[id].
        " WHERE p.page_id=".(int)$_REQUEST[page_id]);

}
else
    $pname=$DB->select("SELECT p.page_name,p.page_name_en,p.page_template,p.noright,p.notop,p.rightblock,p.mobile_right_totop
	  FROM adm_pages AS p ".

        " WHERE p.page_id=".(int)$_REQUEST[page_id]);

if($pname[0]['noright'] != '1'):

$headers = new Headers();

if(empty($pname[0]['rightblock']))
    $elements = $headers->getHeaderElements("Текст - Новый сайт Правая колонка");
else
    $elements = $headers->getHeaderElements($pname[0]['rightblock']);



//$sliderMain = $DB->select('');
?>
<div class="col-xl-3 d-block pt-3 pb-3 px-xl-0 right-column<?php if($pname[0]['mobile_right_totop']) echo ' order-first order-xl-last'; ?>">
    <div class="right-column-fake"></div>
    <div class="right-column-stick pr-xl-3">
        <div class="container-fluid">
            <?php
            if($_SESSION[jour_url]!='') {
                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."text_magazine_right");
            }
            elseif(!empty($elements))
            {
                foreach($elements as $k => $v)
                {
                    $tpl = new Templater();
                    $tpl->setValues($v);
                    if($v["ctype"] == "Фильтр")
                        $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
                    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers_right.html");
                }
                if($_GET[publ_smi]==1)
                {
                    $tpl = new Templater();
                    $v["ctype"]="Фильтр";
                    $tpl->setValues($v);
                    $tpl->appendValues(array("FILTERCONTENT" => $page_content["SMI_PUBL"]));
                    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"]."tpl.headers_right.html");
                }
            }

            ?>
        </div>
    </div>
</div>
<?php endif; ?>
</div>
</div>
</section>
<footer>
    <section class="mb-3 mt-0 pt-3 pb-3 bg-color-imemo text-white">
        <div class="container-fluid">
            <!--<div class="row mb-3">
                <div class="col-12">
                    <h2 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION[lang]!="/en") echo 'Система Orphus'; else echo 'Orphus system';?></h2>
                </div>
            </div>-->
            <div class="row">
                <div class="col-12">
                    <div class="w-100 text-center">
                        <?php
                        if($_SESSION[lang]!="/en")
                            echo "Если Вы нашли опечатку, выделите её и кликните кнопки Ctrl+Enter. Спасибо";
                        else
                            echo "If you found a typo, select it and click Ctrl + Enter buttons. Thank you";
                        ?>
                    </div>
                    <div class="w-100 text-center">
                        <a href="http://orphus.ru" id="orphus" target="_blank"><img src="/newsite/img/orphus.gif" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container-fluid">
            <div class="row text-center">

                <div class="col-xl-4 col-xs-12 pb-3 my-auto">
                    <?php
                    if($_SESSION[lang]!="/en") {
                        echo $_TPL_REPLACMENT["FC_FIRST"];
                    } else {
                        echo $_TPL_REPLACMENT["FC_FIRST_EN"];
                    }?>
                </div>
                <div class="col-xl-4 col-xs-12 pb-3 my-auto">
                    <?php
                    if($_SESSION[lang]!="/en") {
                        echo $_TPL_REPLACMENT["FC_SECOND"];
                    } else {
                        echo $_TPL_REPLACMENT["FC_SECOND_EN"];
                    }?>
                </div>
                <div class="col-xl-4 col-xs-12 pb-3 my-auto">
                    <?php
                    if($_SESSION[jour_url]=='') {
                        if ($_SESSION[lang] != "/en") {
                            echo $_TPL_REPLACMENT["FC_THIRD"];
                        } else {
                            echo $_TPL_REPLACMENT["FC_THIRD_EN"];
                        }
                    } else {
                        global $DB;
                        $date = date("Y-m-d");
                        $stats_today = $DB->select("SELECT views, hosts FROM magazine_visits WHERE magazine='".$_SESSION[jour_url]."' AND date='".$date."'");
                        $stats_all = $DB->select("SELECT SUM(views) AS 'views' FROM magazine_visits WHERE magazine='".$_SESSION[jour_url]."'");
                        echo '<div class="text-center">';
                        if($_SESSION[lang]!='/en')
                        {
                            echo "Просмотров сегодня: ".$stats_today[0]['views']."<br>";
                            echo "Уникальных посетителей сегодня: ".$stats_today[0]['hosts']."<br>";
                            echo "Просмотров всего: ".$stats_all[0]['views']."<br>";
                        }
                        else
                        {
                            echo "Views today: ".$stats_today[0]['views']."<br>";
                            echo "Unique users today: ".$stats_today[0]['hosts']."<br>";
                            echo "Total views: ".$stats_all[0]['views']."<br>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
                <div class="col-12">
                    <?php
                    if($_SESSION[lang]!="/en") {
                        echo str_replace("{CURRENT_YEAR}",date('Y'),$_TPL_REPLACMENT["FOOTER_COPYRIGHT"]);
                    } else {
                        echo str_replace("{CURRENT_YEAR}",date('Y'),$_TPL_REPLACMENT["FOOTER_COPYRIGHT_EN"]);
                    }

                    ?>
                </div>
            </div>
        </div>
    </section>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script>site_language = <?php if($_SESSION[lang]=="/en") echo "'en'"; else echo "'ru'";?>;</script>
<script type="text/javascript" src="/newsite/js/dncalendar.js"></script>
<script type="text/javascript" src="/orphus/orphus.js"></script>
<script src="/newsite/js/popper.min.js?ver=2"></script>
<script src="/newsite/js/bootstrap.min.js?v=2"></script>
<script src="/newsite/js/holder.min.js"></script>
<script src="/newsite/js/bs-custom-file-input.min.js"></script>
<?php

if($_REQUEST[page_id]==1 || $_REQUEST[page_id]==923): ?>
    <script src="/newsite/js/jssor.slider.mini.js"></script>
    <script src="/newsite/js/carousel.js"></script>
<?php endif;?>

<script type="text/javascript" src="/pageflip/js/pageflip5-min.js"></script>
<script type="text/javascript" src="/pageflip/js/key.js"></script>

<script src="/newsite/js/main.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/main.js");?>"></script>
<script src="/newsite/js/counter.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/counter.js");?>"></script>
<script>
    Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
    });
</script>
<!--<script type="text/javascript">$("#pageflip").pageflipInit( { Copyright: Key.Copyright, Key: Key.Key } );</script>-->
<script type="text/javascript">
    var $pageflip = $('#pageflip');
    $pageflip.pageflipInit( {
        PageWidth: 1240,
        PageHeight: 1754,
        Margin: 32,
        MarginBottom: 64,
        PerformanceAware: false,
        AutoScale: true,
        FullScale: true,
        HardCover: true,
        HardPages: false,
        RightToLeft: false,
        VerticalMode: false,
        AlwaysOpened: false,
        AutoFlipEnabled: true,
        StartAutoFlip: false,
        AutoFlipLoop: -1,
        DropShadow: true,
        NoFlipShadow: false,
        Emboss: true,
        DropShadowOpacity: 0.2,
        FlipTopShadowOpacity: 0.2,
        FlipShadowOpacity: 0.2,
        HardFlipOpacity: 0.2,
        EmbossOpacity: 0.2,
        HashControl: true,
        PageCache: 5,
        MouseControl: true,
        HotKeys: true,
        ControlbarToFront: false,
        FullScreenEnabled: true,
        Thumbnails: true,
        ThumbnailsHidden: true,
        ThumbnailWidth: 84,
        ThumbnailHeight: 120,
        ThumbnailsToFront: true,
        ThumbnailsAutoHide: 5000,
        ShareLink: window.location.href,
        ShareImageURL: 'pageflipdata/page0.jpg',
        DisableSelection: true,
        CenterSinglePage: true,
        SinglePageMode: false,
        ShowCopyright: false,
        Copyright: Key.Copyright,
        Key: Key.Key
    } );
    var API = $pageflip.pageflip();
    function p( n ) { API.gotoPageLabel( "t"+n, true ); }
    function u( url ) { window.open( url ); }
</script>

</body></html>
