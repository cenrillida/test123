<?php
if(!empty($_TPL_REPLACMENT['BOTTOM_ID_LINK'])) {
    $pg = new Pages();
    $content = $pg->getContentByPageId($_TPL_REPLACMENT['BOTTOM_ID_LINK']);
    $_TPL_REPLACMENT["FC_FIRST"] = $content['FC_FIRST'];
    $_TPL_REPLACMENT["FC_FIRST_EN"] = $content['FC_FIRST_EN'];
    $_TPL_REPLACMENT["FC_SECOND"] = $content['FC_SECOND'];
    $_TPL_REPLACMENT["FC_SECOND_EN"] = $content['FC_SECOND_EN'];
    $_TPL_REPLACMENT["FC_THIRD"] = $content['FC_THIRD'];
    $_TPL_REPLACMENT["FC_THIRD_EN"] = $content['FC_THIRD_EN'];
    $_TPL_REPLACMENT["FOOTER_COPYRIGHT"] = $content['FOOTER_COPYRIGHT'];
    $_TPL_REPLACMENT["FOOTER_COPYRIGHT_EN"] = $content['FOOTER_COPYRIGHT_EN'];
}

?>

<footer>
    <section class="mb-3 mt-0 pt-3 pb-3 bg-color-imemo text-white">
        <div class="container-fluid">
            <!--<div class="row mb-3">
                <div class="col-12">
                    <h2 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION["lang"]!="/en") echo 'Система Orphus'; else echo 'Orphus system';?></h2>
                </div>
            </div>-->
            <div class="row">
                <div class="col-12">
                    <div class="w-100 text-center">
                        <?php
                        if($_SESSION["lang"]!="/en")
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
            <div class="row text-center justify-content-center">

                <div class="col-xl-4 col-xs-12 pb-3 my-auto">
                    <?php
                    if($_SESSION["lang"]!="/en") {
                        echo $_TPL_REPLACMENT["FC_FIRST"];
                    } else {
                        echo $_TPL_REPLACMENT["FC_FIRST_EN"];
                    }?>
                </div>
                <div class="col-xl-4 col-xs-12 pb-3 my-auto">
                    <?php
                    if($_SESSION["lang"]!="/en") {
                        echo $_TPL_REPLACMENT["FC_SECOND"];
                    } else {
                        echo $_TPL_REPLACMENT["FC_SECOND_EN"];
                    }?>
                </div>
                <div class="col-xl-4 col-xs-12 pb-3 my-auto<?php if(empty($_TPL_REPLACMENT["JOUR_COUNTER"])) echo ' d-none';?>">
                    <?php
                    if($_SESSION["jour_url"]=='') {
                        if(!empty($_TPL_REPLACMENT["JOUR_COUNTER"])) {
                            Statistic::theStatJour($_TPL_REPLACMENT["JOUR_COUNTER"]);
                            Statistic::ajaxCounter("jour",$_TPL_REPLACMENT["JOUR_COUNTER"]);
                        } else {
                            if ($_SESSION["lang"] != "/en") {
                                echo $_TPL_REPLACMENT["FC_THIRD"];
                            } else {
                                echo $_TPL_REPLACMENT["FC_THIRD_EN"];
                            }
                        }
                    } else {
                        Statistic::theStatJour();
                        Statistic::ajaxCounter("jour",$_SESSION["jour_url"]);
                    }
                    ?>
                </div>
                <div class="col-12">
                    <?php
                    if($_SESSION["lang"]!="/en") {
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
<script>site_language = <?php if($_SESSION["lang"]=="/en") echo "'en'"; else echo "'ru'";?>;</script>
<script type="text/javascript" src="/newsite/js/dncalendar.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/dncalendar.js");?>"></script>
<script type="text/javascript" src="/orphus/orphus.js"></script>
<script src="/newsite/js/popper.min.js?ver=2"></script>
<script src="/newsite/js/bootstrap.min.js?v=2"></script>
<script src="/newsite/js/holder.min.js"></script>
<script src="/newsite/js/bs-custom-file-input.min.js"></script>
<?php


if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"])) {
    ?>
    <script>
        admin_editors = [];

        function setOnAdminEditors() {
            admin_editors.forEach(function(editor) {
                $('#'+editor).attr("contenteditable","true");
                CKEDITOR.disableAutoInline = true;
                var editInstance = CKEDITOR.inline( editor, {
                    on: {
                        paste: function(e) {
                            if (e.data.dataValue !== 'undefined')
                                e.data.dataValue = e.data.dataValue.replace(/(\<br ?\/?\>)+/gi, '<p>');
                        }
                    },
                    filebrowserBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html?Type=Images',
                    filebrowserUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserWindowWidth : '1000',
                    filebrowserWindowHeight : '700',
                    extraPlugins: 'autogrow,cmsperson,cmslinks,cleantags,citefooter,indentt,indenttext,ckeditorfa,sourcedialog,save',
                } );
                editInstance.on( 'blur', function( evt ) {
                    $.ajax({
                        method: "POST",
                        url: "/",
                        data: { htmlData: evt.editor.getData(), mode: "edit-page", page_edit_id: editor, edit_lang: "<?=$_SESSION["lang"]?>" }
                    })
                        .done(function( msg ) {
                            console.log(msg);
                            alert( "Сохранено." );
                        });
                });
            });
        }
    </script>
    <script src="/dreamedit/includes/ckeditor/ckeditor.js"></script>
    <?php
}

if($_GET['copy_test']==1) {
    ?>
    <script>
        document.addEventListener('copy', (event) => {
            const pagelink = '\n\n© ИМЭМО РАН';
        event.clipboardData.setData('text', document.getSelection() + pagelink);
        event.preventDefault();
        });
    </script>
    <?php
}
?>
<script>
    lang_global = '<?=$_SESSION["lang"]?>';
</script>
<script src="/newsite/js/swiper-bundle.min.js"></script>
<script src="/newsite/photoswipe/photoswipe.min.js"></script>
<script src="/newsite/photoswipe/photoswipe-ui-default.min.js"></script>

<script src="/newsite/js/main.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/main.js");?>"></script>
<script src="/newsite/js/counter.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/counter.js");?>"></script>
<?php
Statistic::ajaxCounter("all");

?>
<script src="/newsite/js/notifications.js?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/js/notifications.js");?>"></script>
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
<?php if($_GET['newyear']==1): ?>
    <script src="/newsite/js/script.js"></script>
<?php endif;?>


</body></html>
