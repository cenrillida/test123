<section class="pt-5 pb-5 bg-color-lightergray">
<?php
if($_TPL_REPLACMENT["FOOTER_SLIDER_OFF"] != 1) {
    include($_TPL_REPLACMENT['NEWSITE_SLIDER_PHOTO']);
}
?>
</section>

<footer>
    <section class="mb-0 mt-0 pt-3 pb-3 bg-color-imemo text-white">
        <div class="container-fluid">
            <!--<div class="row mb-3">
                <div class="col-12">
                    <h2 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION[lang]!="/en") echo 'Система Orphus'; else echo 'Orphus system';?></h2>
                </div>
            </div>-->
            <div class="row">
                <div class="col-12 col-xl-3">

                </div>
                <div class="col-12 col-xl-6">
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
                <div class="col-12 col-xl-3 pt-3 pt-xl-0">
                    <div class="w-100 text-center text-xl-right">
                        <i class="fas fa-envelope-square"></i> <b><a href="mailto:presscenter@imemo.ru" class="text-white">presscenter@imemo.ru</a></b>
                    </div>
                    <div class="w-100 text-center text-xl-right">
                        <i class="fas fa-phone-square"></i> <b><a href="tel:+74991284644" class="text-white">+7 (499) 128-46-44</a></b>
                    </div>
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
    <script src="/newsite/js/jssor.slider.mini.js"></script>
    <script src="/newsite/js/carousel.js"></script>
<script src="/newsite/js/main.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/main.js");?>"></script>
<script src="/newsite/js/counter.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/counter.js");?>"></script>
<?php if($_TPL_REPLACMENT["WIDE_SECTIONS"]):?>
<script src="/newsite/js/presscenter.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/presscenter.js");?>"></script>
<?php else:?>
<script>
    function collumns_scroll() {

    }
</script>
<?php endif;?>
<?php
Statistic::ajaxCounter("all");
?>
<script>
    Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
    });
</script>
<script type="text/javascript">
    (function(d, t, p) {
        var j = d.createElement(t); j.async = true; j.type = "text/javascript";
        j.src = ("https:" == p ? "https:" : "http:") + "//stat.sputnik.ru/cnt.js";
        var s = d.getElementsByTagName(t)[0]; s.parentNode.insertBefore(j, s);
    })(document, "script", document.location.protocol);
</script>


</body></html>
